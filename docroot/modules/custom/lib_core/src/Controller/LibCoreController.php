<?php

namespace Drupal\lib_core\Controller;

use Drupal\Component\Serialization\Yaml;
use Drupal\Core\Controller\ControllerBase;
use Guzzle\Http\Exception\RequestException;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Lib core controller.
 */
class LibCoreController extends ControllerBase {

  /**
   * Sinisters Cities Select.
   *
   * @param bool $is_sinister
   *   Load cities for sinister.
   * @return array
   *   Cities list.
   */
  public function sinistersCitiesSelect(bool $is_sinister = FALSE):array {
    $opts = [];

    $cities_file = '/data/ciudades-liberty.yaml';
    if ($is_sinister) {
      $cities_file = '/data/ciudades-liberty-siniestros.yaml';
    }

    $path_lib_core_module = drupal_get_path('module', 'lib_core');
    $cities_decode = Yaml::decode(file_get_contents($path_lib_core_module . $cities_file));
    if (!empty($cities_decode)) {
      foreach ($cities_decode as $key => $value) {
        $opts[$key] = $value;
      }
    }

    return $opts;
  }

  /**
   * Sinisters Vehicles Brands Select.
   */
  public function sinistersVehiclesBrandsSelect() {
    $opts = [];
    $path_lib_core_module = drupal_get_path('module', 'lib_core');
    $brand_vehicles = Yaml::decode(file_get_contents($path_lib_core_module . '/data/marca_vehiculos_liberty.yaml'));
    if (!empty($brand_vehicles)) {
      foreach ($brand_vehicles as $value) {
        $opts[$value] = $value;
      }
    }
    return $opts;
  }

  /**
   * Post custom form to webforms.
   */
  public function webformRestPost(string $webform_id, array $values) {
    $config = \Drupal::config('lib_core.environmentvars.settings');
    try {
      $base_uri = \Drupal::request()->getHost();
      $client = new Client([
        'base_uri' => 'https://' . $base_uri,
        'verify' => FALSE,
      ]);

      $csrfToken = $client->get('/session/token', [
        'headers' => ['Content-Type' => "application/json"],
        'verify' => FALSE,
      ])->getBody()->getContents();

      $new_values = [];
      foreach ($values as $k => $v) {
        if ($k === '00NG000000FWynb') {
          $k .= '_email';
        }
        if ($k === '00N4w00000Fv3cp') {
          $k .= '_condicion';
        }

        $field_name = strtolower($k);
        $new_values[$field_name] = $v;
      }
      $new_values['webform_id'] = $webform_id;
      $new_values['entity_type'] = NULL;
      $new_values['entity_id'] = NULL;
      $new_values['in_draft'] = FALSE;

      // Webform submit.
      $body = [
        'headers' => [
          'Content-Type' => "application/json",
          'X-CSRF-Token' => $csrfToken,
        ],
        'body' => (json_encode($new_values)),
      ];

      $options = [
        'verify' => FALSE,
      ];

      $client->post(
        '/webform_rest/submit?_format=json',
        $body,
        $options
      );

      $sfUrl = $config->get('ENDPOINT_SALESFORCE');

      \Drupal::logger('lib_pqr')->info(json_encode($sfUrl));
      \Drupal::logger('lib_pqr')->debug(json_encode($values));

      try {
        $client = new Client([
          'verify' => FALSE,
        ]);
        $sf = $client->request(
          'POST',
          $sfUrl,
          [
            'headers' => [
              'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => $values,
            'verify' => FALSE,
          ]
        );
        $response = $sf->getBody()->getContents();
        \Drupal::logger('lib_pqr')->notice($response);
      }
      catch (\Exception $e) {
        \Drupal::logger('lib_pqr')->error(json_encode($sf));
      }

      $response = new RedirectResponse($values['retURL']);
      return $response->send();

    }
    catch (RequestException $e) {
      $response = new RedirectResponse($values['retURL']);
      \Drupal::logger('lib_pqr')->error(
        'Error en la solicitud a Salesforce: @message',
        ['@message' => $e->getMessage()]
      );
      return $response->send();
    }
  }

}
