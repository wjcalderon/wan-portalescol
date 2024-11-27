<?php

namespace Drupal\hdi_pqr_salesforce\Controller;

use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Controller\ControllerBase;
use Drupal\hdi_pqr_salesforce\traits\PqrSalesforce;
use Drupal\hdi_pqr_salesforce\traits\PqrWebform;
use GuzzleHttp\ClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Handle PQR form submit.
 */
final class PqrApiController extends ControllerBase {

  use PqrWebform, PqrSalesforce;

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * An http client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * The plugin_id for the plugin instance.
   *
   * @param mixed $config_factory
   *   The plugin implementation definition.
   * @param \GuzzleHttp\ClientInterface $http_client
   *   An HTTP client.
   */
  public function __construct(ConfigFactory $config_factory, ClientInterface $http_client) {
    $this->configFactory = $config_factory;
    $this->httpClient = $http_client;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('http_client'),
    );
  }

  /**
   * Submit the form data to webform and Salesforce.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   Form data from react app.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   Response from Salesforce API.
   */
  public function submitForm(Request $request): JsonResponse {
    $request_data = $request->getContent();
    $form_data = json_decode($request_data, TRUE);

    // Submit to webform
    $this->submitWebform($form_data);

    // Submit to salesforce
    return new JsonResponse($this->submitDataSalesforce($form_data));
  }

}
