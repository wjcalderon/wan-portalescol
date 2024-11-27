<?php

namespace Drupal\hdi_pqr_salesforce\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 * id = "pqr-salesforce",
 * admin_label = @Translation("Pqr Salesforce form"),
 * )
 */
final class PqrSalesforceBlock extends BlockBase implements
  ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Drupal\Core\Access\CsrfTokenGenerator definition.
   *
   * @var \Drupal\Core\Access\CsrfTokenGenerator
   */
  protected $csrfToken;

  /**
   * {@inheritdoc}
   */
  public static function create(
    ContainerInterface $container,
    array $configuration,
    $plugin_id,
    $plugin_definition,
  ) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->configFactory = $container->get('config.factory');
    $instance->csrfToken = $container->get('csrf_token');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['label_display' => FALSE];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $renderable = [
      '#theme' => 'pqr_salesforce',
      '#attached' => [
        'library' => ['hdi_pqr_salesforce/pqrsalesforce-form'],
        'drupalSettings' => [
          'pqrSalesforce' => [
            'recaptchaKey' => $this->recaptchaKey(),
            'token' => $this->userToken(),
            'showRecaptcha' => $this->showRecaptcha(),
          ],
        ],
      ],
    ];

    return $renderable;
  }

  /**
   * Get recaptcha key.
   *
   * @return string
   *   Site key from recaptcha module.
   */
  private function recaptchaKey(): string {
    $config = $this->configFactory->get('recaptcha.settings');

    return $config->get('site_key');
  }

  /**
   * User form token.
   *
   * @return string
   *   Token used for save form data.
   */
  private function userToken(): string {
    return $this->csrfToken->get();
  }

  /**
   * Show / hide recaptcha..
   *
   * @return bool
   *   Module configuration.
   */
  private function showRecaptcha(): bool {
    $config = $this->configFactory->get('pqrsalesforce.settings');

    return $config->get('use_recaptcha');
  }

}
