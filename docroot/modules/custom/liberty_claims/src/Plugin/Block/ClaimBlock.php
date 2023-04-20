<?php

namespace Drupal\liberty_claims\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
   * Symfony\Component\HttpFoundation\Session\SessionInterface definition.
   *
   * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
   */
  protected $session;

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
    $instance->session = $container->get('session');
    $instance->moduleHandler = $container->get('module_handler');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->configFactory->get('liberty_claims.settings');
    $token = $this->session->getId();

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
