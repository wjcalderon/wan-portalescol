<?php

namespace Drupal\Tests\sftp_client\Unit;

use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Logger\LoggerChannel;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Site\Settings;
use Drupal\key\KeyInterface;
use Drupal\key\KeyRepositoryInterface;
use Drupal\sftp_client\Exception\SftpLoginException;
use Drupal\sftp_client\SftpClient;
use Drupal\Tests\UnitTestCase;
use phpseclib\Crypt\RSA;
use PHPUnit\Framework\Error\Notice;

/**
 * Tests the SFTP client.
 *
 * @group sftp_client
 * @coversDefaultClass \Drupal\sftp_client\SftpClient
 */
class SftpClientTest extends UnitTestCase {

  /**
   * The logger.
   *
   * @var \Drupal\Tests\sftp_client\Unit\InMemoryTestLogger
   */
  protected $logger;

  /**
   * The mock of "file_system" service.
   *
   * @var \PHPUnit\Framework\MockObject\MockObject|\Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * The mock of "key.repository" service.
   *
   * @var \PHPUnit\Framework\MockObject\MockObject|\Drupal\key\KeyRepositoryInterface
   */
  protected $keyRepository;

  /**
   * The mock of "logger.factory" service.
   *
   * @var \PHPUnit\Framework\MockObject\MockObject|\Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $loggerChannelFactory;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $this->logger = new InMemoryTestLogger();

    $logger_channel = new LoggerChannel('sftp.client.test');
    $logger_channel->addLogger($this->logger);

    $this->fileSystem = $this
      ->getMockBuilder(FileSystemInterface::class)
      ->getMock();

    $this->keyRepository = $this
      ->getMockBuilder(KeyRepositoryInterface::class)
      ->getMock();

    $this->loggerChannelFactory = $this
      ->getMockBuilder(LoggerChannelFactoryInterface::class)
      ->getMock();

    $this->loggerChannelFactory
      ->method('get')
      ->willReturn($logger_channel);
  }

  /**
   * Returns the instance of SFTP client.
   *
   * @param \Drupal\Core\Site\Settings $settings
   *   The site settings.
   * @param \PHPUnit\Framework\MockObject\MockObject|\Drupal\key\KeyInterface|null $key
   *   The optional RSA key to use.
   *
   * @return \Drupal\sftp_client\SftpClient
   *   The instance of SFTP client.
   */
  protected function getSftpClient(Settings $settings, $key = NULL): SftpClient {
    $this->keyRepository
      ->method('getKey')
      ->willReturn($key ?? $this->getMockBuilder(KeyInterface::class)->getMock());

    $sftp_client = new SftpClient(
      $settings,
      $this->fileSystem,
      $this->loggerChannelFactory,
      $this->keyRepository,
    );

    // Ensure default structure is correct.
    static::assertSame([
      // Will be `22` if not set.
      'port' => 22,
      // Must be defined.
      'server' => NULL,
      // Must be defined.
      'username' => NULL,
      // Must be defined if `key_id` is not, will be `FALSE` if not set.
      'password' => FALSE,
      // Must be defined if `password` is not, will be `FALSE` if not set.
      'key_id' => FALSE,
    ], static::getNonPublicAttribute($sftp_client, 'settings'));

    // The `currentConnectionId` isn't set before `setSettings()` is called.
    static::assertCurrentConnectionId($sftp_client, NULL);

    return $sftp_client;
  }

  /**
   * Asserts the current connections ID.
   *
   * @param \Drupal\sftp_client\SftpClient $sftp_client
   *   The SFTP client.
   * @param string|null $connection_id
   *   The connection ID.
   */
  protected static function assertCurrentConnectionId(SftpClient $sftp_client, ?string $connection_id): void {
    static::assertSame($connection_id, static::getNonPublicAttribute($sftp_client, 'currentConnectionId'));
  }

  /**
   * Returns the value of a non-public object member.
   *
   * @param object $object
   *   The object to read the attribute of.
   * @param string $name
   *   The attribute name.
   *
   * @return mixed
   *   The value.
   *
   * @throws \ReflectionException
   */
  protected static function getNonPublicAttribute(object $object, string $name) {
    $reflection = new \ReflectionProperty($object, $name);
    $reflection->setAccessible(TRUE);
    $value = $reflection->getValue($object);
    $reflection->setAccessible(FALSE);

    return $value;
  }

  /**
   * Returns the SFTP connection info.
   *
   * @return array
   *   The SFTP connection info.
   *
   * @example
   * Set valid credentials for SFTP connection before running this test.
   * This can be done directly in PHP, `phpunit.xml` or CLI.
   * @code
   * putenv('SFTP_CLIENT_TEST_PORT=2201');
   * putenv('SFTP_CLIENT_TEST_SERVER=example.com');
   * putenv('SFTP_CLIENT_TEST_USERNAME=BR0kEN');
   * putenv('SFTP_CLIENT_TEST_PASSWORD=super-secured-pass');
   * @endcode
   */
  protected function getConnectionInfo(): array {
    $settings = [
      'port' => \getenv('SFTP_CLIENT_TEST_PORT'),
      'server' => \getenv('SFTP_CLIENT_TEST_SERVER'),
      'username' => \getenv('SFTP_CLIENT_TEST_USERNAME'),
      'password' => \getenv('SFTP_CLIENT_TEST_PASSWORD'),
    ];

    if (\count(\array_filter($settings)) < 4) {
      $this->expectException(\RuntimeException::class);

      throw new \RuntimeException('No need to run the test because valid credentials for SFTP connection was not provided.');
    }

    return $settings;
  }

  /**
   * Tests the SFTP client.
   */
  public function test(): void {
    $settings = $this->getConnectionInfo();
    $sftp_client = $this->getSftpClient(new Settings(['sftp' => ['my-custom-conn' => $settings]]));
    $connection_id = sprintf('%s:%s:%s', $settings['server'], $settings['port'], $settings['username']);
    $original_location = '/tmp/' . date('Y-m-d') . '/my-test-file.txt';
    $move_location = '/tmp/my-test-file1.txt';
    $original_dir = dirname($original_location);

    $sftp_client->setSettings('my-custom-conn');

    static::assertCurrentConnectionId($sftp_client, $connection_id);

    static::assertEmpty(iterator_to_array($sftp_client->listDirs('/bla')));
    $this->logger->assertCount(1);
    $this->logger->assertContainsSubstring("[$connection_id]: Unable to access the \"/bla\" remote directory.");

    static::assertFalse($sftp_client->ensureDir('/etc/asdas'));
    $this->logger->assertCount(2);
    $this->logger->assertContainsSubstring("[$connection_id]: Unable to create the \"/etc/asdas\" remote directory.");

    static::assertTrue($sftp_client->createFile($original_location, 'test'));
    static::assertTrue($sftp_client->isDir($original_dir));
    static::assertSame('test', $sftp_client->readFile($original_location));

    static::assertSame(
      [$original_location => [$original_location, FALSE]],
      iterator_to_array($sftp_client->downloadFiles($original_dir, $original_dir)),
    );
    $this->logger->assertCount(3);
    $this->logger->assertContainsSubstring("[$connection_id]: Unable to create the \"$original_dir\" local directory.");

    static::assertTrue($sftp_client->moveFile($original_location, $move_location));

    static::assertFalse($sftp_client->downloadFile($move_location, '/etc'));
    $this->logger->assertCount(4);
    $this->logger->assertContainsSubstring("[$connection_id]: Unable to write to the \"/etc\" local file.");

    static::assertTrue($sftp_client->downloadFile($move_location, $move_location));
    static::assertSame('test', file_get_contents($move_location));
    static::assertSame(12, file_put_contents($move_location, 'test-updated'));
    static::assertTrue($sftp_client->uploadFile($original_location, $move_location));
    static::assertSame('test-updated', $sftp_client->readFile($original_location));
    static::assertTrue($sftp_client->isFile($original_location));
    static::assertTrue($sftp_client->removeFile($original_location));

    static::assertNull($sftp_client->readFile('/basasas'));
    $this->logger->assertCount(5);
    $this->logger->assertContainsSubstring("[$connection_id]: Unable to read the \"/basasas\" remote file.");

    static::assertFalse($sftp_client->createFile('/basasas', '1'));
    $this->logger->assertCount(6);
    $this->logger->assertContainsSubstring("[$connection_id]: Unable to write to the \"/basasas\" remote file.");

    foreach ($sftp_client->listDirs(dirname($original_dir)) as $path => $resource) {
      if (\DateTime::createFromFormat('Y-m-d', $resource->getFilename()) !== FALSE) {
        $original_dir_removed = $sftp_client->removeDir($path);
      }
    }

    static::assertFalse(empty($original_dir_removed));
  }

  /**
   * Tests the SFTP client constructor.
   */
  public function testWithoutKeyRepository(): void {
    $this->expectException(\LogicException::class);
    $this->expectExceptionMessage('The following SFTP connections require the "key" Drupal module to be installed and enabled to use RSA key for authorization: "sftp", "my_con".');

    new SftpClient(
      new Settings([
        'sftp' => [
          'sftp' => [
            'port' => 2202,
            'server' => 'propeople.com.ua',
            'username' => 'propeople',
            'key_id' => 'the_key1',
          ],
          'my_con' => [
            'port' => 2202,
            'server' => 'propeople.com.ua',
            'username' => 'propeople',
            'key_id' => 'the_key2',
          ],
        ],
      ]),
      $this->fileSystem,
      $this->loggerChannelFactory,
      NULL,
    );
  }

  /**
   * Tests directory removal.
   *
   * @covers ::removeDir
   */
  public function testRemoveDir(): void {
    $settings = $this->getConnectionInfo();
    $sftp_client = $this->getSftpClient(new Settings(['sftp' => ['my-custom-conn' => $settings]]));
    $sftp_client->setSettings('my-custom-conn');

    static::assertTrue($sftp_client->createFile('/tmp/sftp-remove-dir-test/1/2/file1.txt', 'test1'));
    static::assertTrue($sftp_client->createFile('/tmp/sftp-remove-dir-test/1/2/file2.txt', 'test2'));
    static::assertSame('test1', $sftp_client->readFile('/tmp/sftp-remove-dir-test/1/2/file1.txt'));
    static::assertSame('test2', $sftp_client->readFile('/tmp/sftp-remove-dir-test/1/2/file2.txt'));
    static::assertTrue($sftp_client->removeDir('/tmp/sftp-remove-dir-test/1'));
    static::assertFalse($sftp_client->listDirs('/tmp/sftp-remove-dir-test')->valid());
    static::assertTrue($sftp_client->removeDir('/tmp/sftp-remove-dir-test'));
  }

  /**
   * Tests incorrect connection attempts.
   *
   * @throws \Exception
   */
  public function testConnectFlow(): void {
    $sftp_client = $this->getSftpClient(new Settings([
      'sftp' => [
        'sftp' => [
          'port' => 4000,
          'server' => 'my-server',
          'username' => 'BR0kEN',
          'password' => 'sesurity',
        ],
        'another-conn' => [
          'port' => 2202,
          'server' => 'propeople.com.ua',
          'username' => 'propeople',
          'password' => 'wrong-pass',
        ],
      ],
    ]));

    try {
      $sftp_client->removeFile('/tmp/missing-file.txt');
      static::fail('The SFTP connection must not be established due to credentials incorrectness.');
    }
    catch (Notice $e) {
      static::assertSame('Cannot connect to my-server:4000. Error 0. php_network_getaddresses: getaddrinfo failed: Name or service not known', $e->getMessage());
    }

    // The `delete()` should have been call `connect()` that must
    // call `setSettings()`.
    static::assertCurrentConnectionId($sftp_client, 'my-server:4000:BR0kEN');

    try {
      $sftp_client->setSettings('another-conn');
      $sftp_client->removeFile('/tmp/missing-file.txt');
      static::fail('The SFTP connection must not be established due to credentials incorrectness.');
    }
    catch (SftpLoginException $e) {
      static::assertSame('[propeople.com.ua:2202:propeople]: Cannot connect to SFTP server with the given credentials.', $e->getMessage());
    }

    static::assertCurrentConnectionId($sftp_client, NULL);
  }

  /**
   * Tests settings configuration.
   */
  public function testSetSettings(): void {
    $settings = [
      'port' => 2200,
      'server' => 'my-server',
      'username' => 'BR0kEN',
      'password' => 'sesurity',
      'key_id' => 'my-key',
    ];

    $sftp_client = $this->getSftpClient(new Settings(['sftp' => ['test-con' => $settings]]));
    $sftp_client->setSettings('test-con');

    static::assertCurrentConnectionId($sftp_client, 'my-server:2200:BR0kEN');

    $instance_settings = static::getNonPublicAttribute($sftp_client, 'settings');

    static::assertInstanceOf(RSA::class, $instance_settings['password']);
    static::assertSame($settings['password'], $instance_settings['password']->password);

    // Validate all settings except password.
    unset($settings['password']);

    foreach ($settings as $key => $value) {
      static::assertSame($value, $instance_settings[$key]);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function providerSetSettingsErrors(): array {
    return [
      [
        1,
        "The value of \$settings['sftp']['1']['server'] must not be empty!",
        [],
      ],
      [
        'a',
        "The value of \$settings['sftp']['a']['username'] must not be empty!",
        [
          'server' => 'bla',
        ],
      ],
      [
        'b',
        "Either \$settings['sftp']['b']['password'] or \$settings['sftp']['b']['key_id'] must not be empty.",
        [
          'server' => 'bla',
          'username' => 'user1',
        ],
      ],
      [
        'c',
        "The value of \$settings['sftp']['c']['port'] must be scalar!",
        [
          'port' => ['22'],
        ],
      ],
      [
        'd',
        "The value of \$settings['sftp']['d']['server'] must be scalar!",
        [
          'server' => ['bla'],
        ],
      ],
    ];
  }

  /**
   * Tests retrying of operation execution.
   *
   * @param int $attempts
   *   The number of attempts.
   * @param int $expected
   *   The number of a successful attempt.
   * @param callable $callback
   *   The operation to run.
   *
   * @dataProvider providerRetry
   */
  public function testRetry(int $attempts, int $expected, callable $callback): void {
    $counter = 0;

    $this->getSftpClient(new Settings([]))->retry($attempts, function (...$args) use (&$counter, $callback) {
      $counter++;
      return \call_user_func_array($callback, $args);
    });

    static::assertSame($expected, $counter);
  }

  /**
   * {@inheritdoc}
   */
  public function providerRetry(): array {
    return [
      [
        5,
        5,
        function (int $attempt): ?bool {
          // Test returning `null` and `false`.
          return $attempt % 2 ? NULL : FALSE;
        },
      ],
      [
        5,
        1,
        function (int $attempt): bool {
          return $attempt === 1;
        },
      ],
      [
        5,
        3,
        function (int $attempt): ?string {
          return $attempt === 3 ? 'success' : NULL;
        },
      ],
    ];
  }

}
