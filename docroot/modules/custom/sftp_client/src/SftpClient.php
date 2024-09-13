<?php

namespace Drupal\sftp_client;

use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Site\Settings;
use Drupal\key\KeyRepositoryInterface;
use Drupal\sftp_client\Exception\SftpException;
use Drupal\sftp_client\Exception\SftpLoginException;
use phpseclib\Crypt\RSA;
use phpseclib\Net\SFTP;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;

/**
 * Defines the SFTP client.
 */
class SftpClient implements SftpClientInterface {

  /**
   * The list of opened SFTP connections.
   *
   * @var \phpseclib\Net\SFTP[]
   */
  protected static $connections = [];

  /**
   * The ID of an SFTP connection being used.
   *
   * @var string|null
   */
  private $currentConnectionId;

  /**
   * The set of settings for a SFTP connection.
   *
   * @var array
   */
  protected $settings = [
    'port' => 22,
    'server' => NULL,
    'username' => NULL,
    'password' => FALSE,
    'key_id' => FALSE,
  ];

  /**
   * All SFTP connections, configured in `$settings[static::SETTING]`.
   *
   * @var array[]
   */
  protected $sftpSettings = [];

  /**
   * An instance of the "file_system" service.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * An instance of the "key.repository" service.
   *
   * @var \Drupal\Core\File\FileSystemInterface|null
   */
  protected $keyRepository;

  /**
   * A logger channel.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $loggerChannel;

  /**
   * Constructs the SFTP client.
   *
   * @param \Drupal\Core\Site\Settings $settings
   *   An instance of the "settings" service.
   * @param \Drupal\Core\File\FileSystemInterface $file_system
   *   An instance of the "file_system" service.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger_factory
   *   An instance of the "logger.factory" service.
   * @param \Drupal\key\KeyRepositoryInterface|null $key_repository
   *   An instance of the "key.repository" service.
   */
  public function __construct(
    Settings $settings,
    FileSystemInterface $file_system,
    LoggerChannelFactoryInterface $logger_factory,
    ?KeyRepositoryInterface $key_repository
  ) {
    $this->fileSystem = $file_system;
    $this->sftpSettings = $settings::get(static::SETTING, []);
    $this->keyRepository = $key_repository;
    $this->loggerChannel = new class($logger_factory->get(static::SETTING)) implements LoggerInterface {

      use LoggerTrait;

      /**
       * A logger channel.
       *
       * @var \Drupal\Core\Logger\LoggerChannelInterface
       */
      private $loggerChannel;

      /**
       * The ID of SFTP connection.
       *
       * @var string
       */
      private $connectionId = '';

      /**
       * The current SFTP connection.
       *
       * @var \phpseclib\Net\SFTP|null
       */
      private $connection;

      /**
       * Constructs the logger channel decorator.
       *
       * @param \Drupal\Core\Logger\LoggerChannelInterface $logger_channel
       *   The logger channel to decorate.
       */
      public function __construct(LoggerChannelInterface $logger_channel) {
        $this->loggerChannel = $logger_channel;
      }

      /**
       * Sets the connection ID.
       *
       * @param string $connection_id
       *   The connection ID.
       */
      public function setConnectionId(string $connection_id): void {
        $this->connectionId = $connection_id;
      }

      /**
       * Sets the SFTP connection.
       *
       * @param \phpseclib\Net\SFTP $connection
       *   The SFTP connection.
       */
      public function setConnection(SFTP $connection): void {
        $this->connection = $connection;
      }

      /**
       * {@inheritdoc}
       */
      public function log($level, $message, array $context = []): void {
        // Extend error logging by providing as much as possible information
        // on each `->error()` call.
        if ($level === LogLevel::ERROR) {
          $message = [$message];

          if ($error = \error_get_last()) {
            $message[] = '- error_get_last(): @error_get_last';
            $context['@error_get_last'] = \var_export($error, TRUE);
            \error_clear_last();
          }

          if ($this->connection !== NULL && $error = $this->connection->getLastSFTPError()) {
            $message[] = '- phpseclib error: @phpseclib_error';
            $context['@phpseclib_error'] = $error;
          }

          $message = \implode(PHP_EOL, $message);
        }

        $this->loggerChannel->log($level, \sprintf('[%s]: %s', $this->connectionId, $message), $context);
      }

    };

    // Make sure there are no connections that require the `key` module.
    if ($this->keyRepository === NULL) {
      $connections = [];

      foreach ($this->sftpSettings as $connection_id => $params) {
        if (!empty($params['key_id'])) {
          $connections[] = $connection_id;
        }
      }

      if (!empty($connections)) {
        throw new \LogicException(\sprintf(
          'The following SFTP connections require the "key" Drupal module to be installed and enabled to use RSA key for authorization: "%s".',
          \implode('", "', $connections),
        ));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function setSettings(string $connection = self::SETTING): void {
    $this->currentConnectionId = NULL;
    $key = static function (...$parents) use ($connection): string {
      \array_unshift($parents, "\$settings['" . static::SETTING, $connection);

      return \implode("']['", $parents) . "']";
    };

    foreach ($this->settings as $parameter => $default_value) {
      $value = $this->sftpSettings[$connection][$parameter] ?? NULL;

      if (!empty($value)) {
        if (!\is_scalar($value)) {
          throw new SftpException("The value of {$key($parameter)} must be scalar!");
        }

        $this->settings[$parameter] = $value;
      }
      elseif ($default_value === NULL) {
        throw new SftpException("The value of {$key($parameter)} must not be empty!");
      }
    }

    if ($this->settings['key_id'] !== FALSE) {
      $rsa = new RSA();
      $rsa->loadKey($this->keyRepository->getKey($this->settings['key_id'])->getKeyValue());
      $rsa->setPassword($this->settings['password']);

      // Convert the password to RSA key.
      /* @see \phpseclib\Net\SFTP::_login_helper() */
      /* @see \phpseclib\Net\SFTP::_privatekey_login() */
      $this->settings['password'] = $rsa;
    }
    elseif ($this->settings['password'] === FALSE) {
      throw new SftpException("Either {$key('password')} or {$key('key_id')} must not be empty.");
    }

    $this->currentConnectionId = \sprintf('%s:%s:%s', $this->settings['server'], $this->settings['port'], $this->settings['username']);
    $this->loggerChannel->setConnectionId($this->currentConnectionId);
  }

  /**
   * Returns the SFTP connection.
   *
   * @return \phpseclib\Net\SFTP
   *   The SFTP connection.
   *
   * @throws \Drupal\sftp_client\Exception\SftpLoginException
   */
  protected function connect(): SFTP {
    // Initialize defaults if nothing explicitly set.
    if ($this->currentConnectionId === NULL) {
      $this->setSettings();
    }

    // We see if a connection for the given settings key is already created.
    // This avoids creating multiple parallel connections to the same server.
    if (!isset(static::$connections[$this->currentConnectionId])) {
      $connection = new SFTP($this->settings['server'], $this->settings['port']);

      if (!$connection->login($this->settings['username'], $this->settings['password'])) {
        $current_connection_id = $this->currentConnectionId;
        $this->currentConnectionId = NULL;

        throw new SftpLoginException(\sprintf('[%s]: Cannot connect to SFTP server with the given credentials.', $current_connection_id));
      }

      $this->loggerChannel->setConnection($connection);

      // If the connection does not exist, we create it and cache it.
      static::$connections[$this->currentConnectionId] = $connection;
    }

    // Return the connection corresponding to the SFTP settings key.
    return static::$connections[$this->currentConnectionId];
  }

  /**
   * {@inheritdoc}
   */
  public function ensureLocalDir(string $path_to_dir): bool {
    if (\is_dir($path_to_dir) || $this->fileSystem->mkdir($path_to_dir, NULL, TRUE)) {
      return TRUE;
    }

    $this->loggerChannel->error('Unable to create the "@path_to_dir" local directory.', [
      '@path_to_dir' => $path_to_dir,
    ]);

    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function createLocalFile(string $path_local, string $data): bool {
    if ($this->ensureLocalDir(\dirname($path_local))) {
      if (@\file_put_contents($path_local, $data) !== FALSE) {
        return TRUE;
      }

      $this->loggerChannel->error('Unable to write to the "@path_local" local file.', [
        '@path_local' => $path_local,
      ]);
    }

    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function ensureDir(string $path_to_dir): bool {
    $connection = $this->connect();

    if ($connection->is_dir($path_to_dir) || $connection->mkdir($path_to_dir, -1, TRUE)) {
      return TRUE;
    }

    $this->loggerChannel->error('Unable to create the "@path_to_dir" remote directory.', [
      '@path_to_dir' => $path_to_dir,
    ]);

    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function createFile(string $path_remote, string $data): bool {
    if ($this->ensureDir(\dirname($path_remote))) {
      if ($this->connect()->put($path_remote, $data, SFTP::SOURCE_STRING)) {
        return TRUE;
      }

      $this->loggerChannel->error('Unable to write to the "@path_remote" remote file.', [
        '@path_remote' => $path_remote,
      ]);
    }

    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function readFile(string $path_remote): ?string {
    if ($content = $this->connect()->get($path_remote)) {
      return $content;
    }

    $this->loggerChannel->error('Unable to read the "@path_remote" remote file.', [
      '@path_remote' => $path_remote,
    ]);

    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function downloadFile(string $path_remote, string $path_local): bool {
    return ($data = $this->readFile($path_remote)) && $this->createLocalFile($path_local, $data);
  }

  /**
   * {@inheritdoc}
   */
  public function downloadFiles(string $path_remote, string $path_local): \Generator {
    foreach ($this->listFiles($path_remote) as $source => $resource) {
      $dest = $path_local . '/' . $resource->getFilename();

      yield $source => [$dest, $this->downloadFile($source, $dest)];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function uploadFile(string $path_remote, string $path_local): bool {
    return $this->ensureDir(\dirname($path_remote)) && $this->connect()->put($path_remote, $path_local, SFTP::SOURCE_LOCAL_FILE);
  }

  /**
   * {@inheritdoc}
   */
  public function moveFile(string $source, string $destination, int $replace = FileSystemInterface::EXISTS_ERROR): bool {
    switch ($replace) {
      case FileSystemInterface::EXISTS_RENAME:
        $new_destination = $destination;
        $counter = 0;

        while ($this->isFile($new_destination)) {
          $new_destination = $destination . '_' . $counter++;
        }

        $destination = $new_destination;
        break;

      case FileSystemInterface::EXISTS_REPLACE:
        if ($this->isFile($destination)) {
          $this->removeFile($destination);
        }
        break;
    }

    if ($this->ensureDir(\dirname($destination)) && $this->connect()->rename($source, $destination)) {
      return TRUE;
    }

    $this->loggerChannel->error('Unable to move "@source" to "@destination".', [
      '@source' => $source,
      '@destination' => $destination,
    ]);

    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function removeFile(string $path_remote): bool {
    return $this->connect()->delete($path_remote, FALSE);
  }

  /**
   * {@inheritdoc}
   */
  public function removeDir(string $path_remote): bool {
    $connection = $this->connect();

    foreach ($this->listItems($path_remote) as $path => $resource) {
      if ($resource->isDir() ? !$this->removeDir($path) : !$connection->delete($path)) {
        return FALSE;
      }
    }

    return $connection->rmdir($path_remote);
  }

  /**
   * {@inheritdoc}
   */
  public function listFiles(string $path_remote): \Generator {
    yield from $this->listItems($path_remote, 'NET_SFTP_TYPE_REGULAR');
  }

  /**
   * {@inheritdoc}
   */
  public function listDirs(string $path_remote): \Generator {
    yield from $this->listItems($path_remote, 'NET_SFTP_TYPE_DIRECTORY');
  }

  /**
   * {@inheritdoc}
   */
  public function isFile(string $path_remote): bool {
    return $this->connect()->is_file($path_remote);
  }

  /**
   * {@inheritdoc}
   */
  public function isDir(string $path_remote): bool {
    return $this->connect()->is_dir($path_remote);
  }

  /**
   * {@inheritdoc}
   */
  public function retry(int $attempts, callable $callback) {
    if ($attempts < 2) {
      throw new \InvalidArgumentException('The call to retry is useless without specifying at least one extra attempt.');
    }

    $attempt = 1;

    do {
      $result = $callback($attempt);

      if ($result !== NULL && $result !== FALSE) {
        break;
      }

      // Reset connection so the call to `connect()` establish it again.
      unset(static::$connections[$this->currentConnectionId]);
    } while (++$attempt <= $attempts);

    return $result;
  }

  /**
   * Returns the list of entities within a remote directory.
   *
   * @param string $path_remote
   *   The path to a remote directory.
   * @param string|null $type_constant
   *   The type of entities to narrow the list to. The constant cannot be
   *   used here since it's defined dynamically in {@see SFTP} constructor, so
   *   will be undefined until `new SFTP()` is called. Therefore, use names
   *   only. All available values listed within the `$this->file_types` at
   *   the {@see \phpseclib\Net\SFTP::__construct()}.
   * @param bool $skip_dots
   *   The state of whether to skip dot files or not.
   *
   * @return \Drupal\sftp_client\SftpResource[]|\Generator
   *   The list of entities within a directory.
   *
   * @throws \Drupal\sftp_client\Exception\SftpLoginException
   *   When the connection to SFTP server cannot be established.
   *
   * @link https://www.php.net/manual/en/class.filesystemiterator.php#filesystemiterator.constants.skip-dots
   */
  protected function listItems(string $path_remote, string $type_constant = NULL, bool $skip_dots = TRUE): \Generator {
    $list = $this->connect()->rawlist($path_remote);

    if (\is_array($list)) {
      $path_remote = \rtrim($path_remote, \DIRECTORY_SEPARATOR);

      foreach ($list as $path => $info) {
        if (($type_constant === NULL || $info['type'] === \constant($type_constant)) && (!$skip_dots || \trim($path, '.') !== '')) {
          yield $path_remote . \DIRECTORY_SEPARATOR . $path => new SftpResource($info);
        }
      }
    }
    else {
      $this->loggerChannel->error('Unable to access the "@path_remote" remote directory.', [
        '@path_remote' => $path_remote,
      ]);
    }
  }

}
