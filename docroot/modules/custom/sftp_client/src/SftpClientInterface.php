<?php

namespace Drupal\sftp_client;

/**
 * The description of the SFTP client.
 */
interface SftpClientInterface {

  /**
   * The name of a key within the Drupal `$settings`.
   */
  public const SETTING = 'sftp';

  /**
   * Sets SFTP connection settings.
   *
   * @param string $connection
   *   The name of a SFTP connection ($settings[static::SETTING][$connection]).
   *
   * @throws \Drupal\sftp_client\Exception\SftpException
   *   When `$settings[static::SETTING][$connection]` has invalid setting.
   * @throws \Drupal\sftp_client\Exception\SftpLoginException
   *   When the connection to SFTP server cannot be established.
   */
  public function setSettings(string $connection = self::SETTING): void;

  /**
   * Ensures a local directory exists.
   *
   * @param string $path_to_dir
   *   The path to a directory.
   *
   * @return bool
   *   The state of whether a directory exists or was created successfully.
   */
  public function ensureLocalDir(string $path_to_dir): bool;

  /**
   * Creates a local file with the given content.
   *
   * @param string $path_local
   *   The path to a local file.
   * @param string $data
   *   The data to write to a file.
   *
   * @return bool
   *   The state of whether a file was successfully written.
   */
  public function createLocalFile(string $path_local, string $data): bool;

  /**
   * Ensures a remote directory exists.
   *
   * @param string $path_to_dir
   *   The path to a directory.
   *
   * @return bool
   *   The state of whether a directory exists or was created successfully.
   *
   * @throws \Drupal\sftp_client\Exception\SftpLoginException
   *   When the connection to SFTP server cannot be established.
   */
  public function ensureDir(string $path_to_dir): bool;

  /**
   * Creates a remote file with the given content.
   *
   * @param string $path_remote
   *   The path to a remote file.
   * @param string $data
   *   The data to write to a file.
   *
   * @return bool
   *   The state of whether a file was successfully written.
   *
   * @throws \Drupal\sftp_client\Exception\SftpLoginException
   *   When the connection to SFTP server cannot be established.
   */
  public function createFile(string $path_remote, string $data): bool;

  /**
   * Reads a remote file and returns its content.
   *
   * @param string $path_remote
   *   The path to a remote file.
   *
   * @return string|null
   *   The content of a file or NULL if it cannot be read.
   *
   * @throws \Drupal\sftp_client\Exception\SftpLoginException
   *   When the connection to SFTP server cannot be established.
   */
  public function readFile(string $path_remote): ?string;

  /**
   * Downloads a file from the SFTP server and stores it locally.
   *
   * @param string $path_remote
   *   The path to a remote file.
   * @param string $path_local
   *   The path to a local file.
   *
   * @return bool
   *   The state of whether a file was successfully saved locally.
   *
   * @throws \Drupal\sftp_client\Exception\SftpLoginException
   *   When the connection to SFTP server cannot be established.
   */
  public function downloadFile(string $path_remote, string $path_local): bool;

  /**
   * Downloads all files from the directory on the SFTP server.
   *
   * NOTE: the downloading is not recursive, therefore only top-level
   *       files will be downloaded.
   *
   * @param string $path_remote
   *   The path to a remote directory.
   * @param string $path_local
   *   The path to a local directory.
   *
   * @return \Generator
   *   - The key is a path to a remote file.
   *   - The value is an array with a path to a local file and a state
   *     of downloading.
   *
   * @throws \Drupal\sftp_client\Exception\SftpLoginException
   *   When the connection to SFTP server cannot be established.
   *
   * @example
   * @code
   * $files = [];
   *
   * foreach ($sftp->downloadFiles('/path/to/dir', '/tmp/my-files') as $source => [$destination, $success]) {
   *   if ($success) {
   *     $files[] = $destination;
   *   }
   *   else {
   *     \Drupal::logger('my-logger')->error('Unable to download %file', ['%file' => $destination]);
   *   }
   * }
   * @endcode
   */
  public function downloadFiles(string $path_remote, string $path_local): \Generator;

  /**
   * Uploads a file to the SFTP server.
   *
   * @param string $path_remote
   *   The path to a remote file.
   * @param string $path_local
   *   The path to a local file.
   *
   * @return bool
   *   The state of whether a file was successfully uploaded.
   *
   * @throws \Drupal\sftp_client\Exception\SftpLoginException
   *   When the connection to SFTP server cannot be established.
   */
  public function uploadFile(string $path_remote, string $path_local): bool;

  /**
   * Moves a remote file from one location to another.
   *
   * @param string $source
   *   The path to a remote file.
   * @param string $destination
   *   The path to a new location of a remote file.
   * @param int $replace
   *   Replace behavior when the destination file already exists:
   *   - {@see FileSystemInterface::EXISTS_REPLACE};
   *   - {@see FileSystemInterface::EXISTS_RENAME};
   *   - {@see FileSystemInterface::EXISTS_ERROR}.
   *
   * @return bool
   *   The state of whether a file was successfully moved.
   *
   * @throws \Drupal\sftp_client\Exception\SftpLoginException
   *   When the connection to SFTP server cannot be established.
   *
   * @see \Drupal\Core\File\FileSystemInterface
   */
  public function moveFile(string $source, string $destination, int $replace): bool;

  /**
   * Removes a remote file.
   *
   * @param string $path_remote
   *   The path to a remote file.
   *
   * @return bool
   *   The state of whether a file was successfully removed.
   *
   * @throws \Drupal\sftp_client\Exception\SftpLoginException
   *   When the connection to SFTP server cannot be established.
   */
  public function removeFile(string $path_remote): bool;

  /**
   * Removes a remote directory.
   *
   * @param string $path_remote
   *   The path to a remote directory.
   *
   * @return bool
   *   The state of whether a directory was successfully removed.
   *
   * @throws \Drupal\sftp_client\Exception\SftpLoginException
   *   When the connection to SFTP server cannot be established.
   */
  public function removeDir(string $path_remote): bool;

  /**
   * Returns the list of files within a remote directory.
   *
   * @param string $path_remote
   *   The path to a remote directory.
   *
   * @return \Drupal\sftp_client\SftpResource[]|\Generator
   *   The list of files within a directory.
   *
   * @throws \Drupal\sftp_client\Exception\SftpLoginException
   *   When the connection to SFTP server cannot be established.
   *
   * @example
   * @code
   * foreach ($sftp->listFiles('/path/to/dir') as $path => $resource) {
   *   // The `$path` here is the `/path/to/dir` + the name of a file.
   * }
   * @endcode
   */
  public function listFiles(string $path_remote): \Generator;

  /**
   * Returns the list of directories within a remote directory.
   *
   * @param string $path_remote
   *   The path to a remote directory.
   *
   * @return \Drupal\sftp_client\SftpResource[]|\Generator
   *   The list of directories within a directory.
   *
   * @throws \Drupal\sftp_client\Exception\SftpLoginException
   *   When the connection to SFTP server cannot be established.
   *
   * @example
   * @code
   * foreach ($sftp->listDirs('/path/to/dir') as $path => $resource) {
   *   // The `$path` here is the `/path/to/dir` + the name of a directory.
   * }
   * @endcode
   */
  public function listDirs(string $path_remote): \Generator;

  /**
   * Returns the state of whether a resource is a file.
   *
   * @param string $path_remote
   *   The path to a remote resource.
   *
   * @return bool
   *   The state of a check.
   *
   * @throws \Drupal\sftp_client\Exception\SftpLoginException
   *   When the connection to SFTP server cannot be established.
   */
  public function isFile(string $path_remote): bool;

  /**
   * Returns the state of whether a resource is a directory.
   *
   * @param string $path_remote
   *   The path to a remote resource.
   *
   * @return bool
   *   The state of a check.
   *
   * @throws \Drupal\sftp_client\Exception\SftpLoginException
   *   When the connection to SFTP server cannot be established.
   */
  public function isDir(string $path_remote): bool;

  /**
   * Allows retrying an operation after reconnection.
   *
   * @param int $attempts
   *   The number of attempts for running an operation.
   * @param callable $callback
   *   The operation to run.
   *
   * @return mixed
   *   The result of the executed operation.
   *
   * @example
   * The retry happens when the `$callback` returns `null` or `false`.
   * @code
   * $this->retry(3, function (int $attempt) use ($source, $destination): bool {
   *   \Drupal::logger('my-logger-channel')->info('[Attempt #@attempt]: Trying to move `@source` to `@destination` on SFTP.', [
   *     '@source' => $source,
   *     '@attempt' => $attempt,
   *     '@destination' => $destination,
   *   ]);
   *
   *   return $this->moveFile($source, $destination);
   * });
   * @endcode
   */
  public function retry(int $attempts, callable $callback);

}
