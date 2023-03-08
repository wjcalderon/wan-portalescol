<?php

namespace Drupal\liberty_claims;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;

/**
 * Class LoggerService.
 */
class LoggerService implements LoggerServiceInterface {
  /**
   * Drupal\Core\Logger\LoggerChannelFactoryInterface definition.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $drupal_logger;

  /**
   * Monolog object
   *
   * @var Monolog\Logger
   */
  protected $logger;

  /**
   * Constructs a new LoggerService object.
   */
  public function __construct(LoggerChannelFactoryInterface $drupal_logger) {
    $this->drupal_logger = $drupal_logger->get('claims_log');
    $this->logger = new Logger('liberty_claims');

    $path = \Drupal::service('file_system')->realpath(\Drupal::config('system.file')->get('default_scheme') . "://");
    $path = $path . '/claims_logs/';

    if (!is_dir($path)) {
      mkdir($path);
    }

    $handler = new RotatingFileHandler(
      $path . '/claims_log.log',
      30,
      Logger::DEBUG
    );

    $this->logger->pushHandler($handler);
  }

  /**
   * {@inheritdoc}
   */
  public function logActivity(string $plate, string $token) {
    try {
      $this->logger->info(json_encode([
          'token' => $token . $plate,
          'plate' => $plate,
          'has_files' => 0,
          'status' => 1,
          'timestamp' => time()
        ])
      );
    }
    catch (\Exception $e) {

    }
  }

  /**
   * {@inheritdoc}
   */
  public function set(string $field, string $value, $token) {
    try {
      $this->logger->debug(json_encode([
          $field => $value,
          'timestamp' => time(),
          'token' => $token
        ])
      );
    }
    catch (\Exception $e) {
      $this->drupal_logger->error($e->getMessage());
    }
  }


  public function get(string $field, $token) {
    try {
      $result = $this->database->select('liberty_log', 'l')
        ->fields('l', [$field])
        ->condition('token', $token)
        ->execute()->fetchAll();

        return $result[0];
    }
    catch (\Exception $e) {
      $this->drupal_logger->error($e->getMessage());
    }
  }

  /**
   * {@inheritdoc}
   */
  public function setMultiple(array $fields, string $token) {
    try {
      $fields['timestamp'] = time();
      $fields['token'] = $token;

      $this->logger->debug(json_encode($fields));
    }
    catch (\Exception $e) {
      $this->drupal_logger->error($e->getMessage());
    }
  }

}
