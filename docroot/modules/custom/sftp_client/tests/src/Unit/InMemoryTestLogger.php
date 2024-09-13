<?php

namespace Drupal\Tests\sftp_client\Unit;

use Drupal\Component\Render\FormattableMarkup;
use PHPUnit\Framework\Assert;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

/**
 * Logs messages to RAM.
 */
class InMemoryTestLogger implements LoggerInterface {

  use LoggerTrait;

  /**
   * {@inheritdoc}
   */
  private $storage = [];

  /**
   * {@inheritdoc}
   */
  public function log($level, $message, array $context = []): void {
    $this->storage[] = (string) new FormattableMarkup($message, $context);
  }

  /**
   * {@inheritdoc}
   */
  public function assertContains(string $message): void {
    Assert::assertContains($message, $this->storage);
  }

  /**
   * {@inheritdoc}
   */
  public function assertContainsSubstring(string $substring): void {
    $contains = FALSE;

    foreach ($this->storage as $message) {
      if (\mb_stripos($message, $substring) !== FALSE) {
        $contains = TRUE;
        break;
      }
    }

    Assert::assertTrue($contains, \sprintf('The logged messages have no "%s" substring.', $substring));
  }

  /**
   * {@inheritdoc}
   */
  public function assertCount(int $count): void {
    Assert::assertCount($count, $this->storage);
  }

}
