<?php

namespace Drupal\lib_red_medica\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 * id = "medical_network_block",
 * admin_label = @Translation("Medical network form"),
 * )
 */
class MedicalNetworkBlock extends BlockBase implements
  ContainerFactoryPluginInterface {
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
   * {@inheritdoc}
   */
  public static function create(
        ContainerInterface $container,
        array $configuration,
        $plugin_id,
        $plugin_definition
    ) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->configFactory = $container->get('config.factory');
    $instance->session = $container->get('session');
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
    \Drupal::service('page_cache_kill_switch')->trigger();

    $config = $this->getConfig();
    $token = $this->session->getId();

    $currentPath = \Drupal::request()->getSchemeAndHttpHost();

    return [
      '#theme' => 'medical_network',
      '#attached' => [
        'library' => ['lib_red_medica/main'],
        'drupalSettings' => [
          'medicalNetwork' => [
            'dataBasePath' => $currentPath,
            'token' => $token,
            'plan_list' => $config['plan_list'],
            'max_distance' => $config['max_distance'],
            'preferential' => [
              'title' => $config['preferential_title'],
              'description' =>
              $config['preferential_description'],
            ],
            'maps_api' => $config['maps_api'],
                      // 'personal_data_url' => $config['personal_data_url'],
            'personal_data_url' =>
            'https://hdiseguros.com.co/terminos-de-uso-y-privacidad',
          ],
        ],
      ],
    ];
  }

  /**
   * Create an array with module configuration.
   */
  private function getConfig() {
    // Get module settings.
    $config = $this->configFactory->get('lib_red_medica.settings');
    $configuration = [];

    $i = 0;
    foreach ($config->get('plan_list') as $plan_tid) {
      // Get plan tid.
      $configuration['plan_list'][$i]['id'] = $plan_tid;

      // Get description.
      $description = $config->get('description_' . $plan_tid);
      $configuration['plan_list'][$i]['description'] = $description;
      $i++;
    }
    $configuration['max_distance'] = $config->get('map_distance');

    // Preferential network data.
    $configuration['preferential_title'] = $config->get(
          'preferential_title'
      );
    $configuration['preferential_description'] = $config->get(
          'preferential_description'
      );

    // Additional.
    $configuration['personal_data_url'] = $config->get('personal_data_url');

    // Read Google maps API key.
    $config = $this->configFactory->get('geolocation_google_maps.settings');
    $configuration['maps_api'] = $config->get('google_map_api_key');

    return $configuration;
  }

}
