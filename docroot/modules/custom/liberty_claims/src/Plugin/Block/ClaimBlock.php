<?php

namespace Drupal\liberty_claims\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Access\CsrfTokenGenerator;

/**
 * Provides a 'ClaimBlock' block.
 *
 * @Block(
 *  id = "claim_block",
 *  admin_label = @Translation("Claim block"),
 * )
 */
class ClaimBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\liberty_claims\LoggerServiceInterface definition.
   *
   * @var \Drupal\liberty_claims\LoggerServiceInterface
   */
  protected $libertyLogger;

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
   * Drupal\Core\Extension\ModuleHandlerInterface definition.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->libertyLogger = $container->get('liberty.logger');
    $instance->configFactory = $container->get('config.factory');
    $instance->csrfToken = $container->get('csrf_token');
    $instance->moduleHandler = $container->get('module_handler');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->configFactory->get('liberty_claims.settings');
    $token = $this->csrfToken->get();

    return [
      '#type' => 'markup',
      '#markup' => '<h1 class="title-prin">Avisa de tu siniestro</h1>
      <p class="lead-prin">Aquí podrás realizar el aviso de tu siniestro en tres simples pasos.</p>
      <div id="coveredApp"></div>',
      '#attached' => [
        'library' => ['liberty_claims/forms'],
        'drupalSettings' => [
          'claimSettings' => [
            'dataBasePath' => '/claim-data',
            'assetsPath' => $this->moduleHandler->getModule('liberty_claims')->getPath() . '/vuejs/src/assets/',
            'token' => $token,
            'imageSize' => $config->get('image_size'),
            'documentSize' => $config->get('document_size'),
            'types' => $config->get('types'),
            'lastModel' => $config->get('last_model'),
          ],
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
