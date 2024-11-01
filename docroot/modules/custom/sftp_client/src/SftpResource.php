<?php

namespace Drupal\sftp_client;

/**
 * Describes the SFTP resource.
 */
class SftpResource {

  /**
   * The size of a resource in bytes.
   *
   * @var int
   */
  protected $size;

  /**
   * The type of a resource.
   *
   * @var string
   *
   * All available values listed within the "$this->file_types" at
   * the {@see \phpseclib\Net\SFTP::__construct()}.
   */
  protected $type;

  /**
   * The timestamp of the last access.
   *
   * @var int
   */
  protected $atime;

  /**
   * The timestamp of the last modification.
   *
   * @var int
   */
  protected $mtime;

  /**
   * The name of a resource.
   *
   * @var string
   */
  protected $filename;

  /**
   * The decimal notation of permissions.
   *
   * @var int
   *
   * @see \decoct()
   */
  protected $permissions;

  /**
   * Constructs the SFTP resource.
   *
   * @param array $data
   *   The data to create a resource.
   */
  public function __construct(array $data) {
    foreach ($this as $key => $value) {
      if (!isset($data[$key])) {
        throw new \InvalidArgumentException(\sprintf('The "%s" must exist in a resource definition!', $key));
      }

      $this->{$key} = $data[$key];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function isSymlink(): bool {
    return $this->type === \constant('NET_SFTP_TYPE_SYMLINK');
  }

  /**
   * {@inheritdoc}
   */
  public function isFile(): bool {
    return $this->type === \constant('NET_SFTP_TYPE_REGULAR');
  }

  /**
   * {@inheritdoc}
   */
  public function isDir(): bool {
    return $this->type === \constant('NET_SFTP_TYPE_DIRECTORY');
  }

  /**
   * {@inheritdoc}
   */
  public function getSize(): int {
    return $this->size;
  }

  /**
   * {@inheritdoc}
   */
  public function getAccessTime(): int {
    return $this->atime;
  }

  /**
   * {@inheritdoc}
   */
  public function getModificationTime(): int {
    return $this->mtime;
  }

  /**
   * {@inheritdoc}
   */
  public function getPermissions(): int {
    return $this->permissions;
  }

  /**
   * {@inheritdoc}
   */
  public function getFilename(): string {
    return $this->filename;
  }

}
