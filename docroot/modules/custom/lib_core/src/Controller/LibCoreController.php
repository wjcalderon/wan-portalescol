<?php

namespace Drupal\lib_core\Controller;

use Drupal\Component\Serialization\Yaml;
use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Lib core controller.
 */
class LibCoreController extends ControllerBase {

  /**
   * Sinisters Cities Select.
   */
  public function sinistersCitiesSelect() {
    $opts = [];
    $path_lib_core_module = drupal_get_path('module', 'lib_core');
    $cities_decode = Yaml::decode(file_get_contents($path_lib_core_module . '/data/ciudades-liberty.yaml'));
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

    $base_uri = \Drupal::request()->getHost();
    $client = new Client([
      'base_uri' => 'https://' . $base_uri,
      'verify' => FALSE,
    ]);

    try {
      $csrfToken = $client->get('/session/token', [
        'headers' => ['Content-Type' => "application/json"],
        'verify' => FALSE,
      ])->getBody()->getContents();

      $new_values = [];
      foreach ($values as $k => $v) {
        $new_values[strtolower($k)] = $v;
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

      // Post to webform.
      $client->post(
          '/webform_rest/submit?_format=json',
          $body,
          $options
      );

      // Id from environment.
      $values_env["orgid"] = $config->get('PQRorgId') ?? '';

      $pqrRegistroWebToCase = $config->get('PQRRegistroWebToCase') ?? '';
      $pqrPaisEvento = $config->get('PQRPaisEvento') ?? '';
      $pqrreplica = $config->get('PQRreplica') ?? '';
      $pqrNumeroCaso = $config->get('PQRNumeroCaso') ?? '';
      $pqrNombre = $config->get('PQRNombre') ?? '';
      $pqrTipoIdentidad = $config->get('PQRTipoIdentidad') ?? '';
      $pqrNumeroIdentificacion = $config->get('PQRNumeroIdentificacion') ?? '';
      $pqrEmail = $config->get('PQREmail') ?? '';
      $pqrCiudadEvento = $config->get('PQRCiudadEvento') ?? '';
      $pqrDireccion = $config->get('PQRDireccion') ?? '';
      $pqrTelefonoFijo = $config->get('PQRTelefonoFijo') ?? '';
      $pqrCelular = $config->get('PQRCelular') ?? '';
      $pqrGenero = $config->get('PQRGenero') ?? '';
      $pqrAutorizacionDatosPersonales = $config->get('PQRAutorizacionDatosPersonales') ?? '';
      $pqrLGBTIQ = $config->get('PQRLGBTIQ') ?? '';
      $pqrCondicionEspecial = $config->get('PQRCondicionEspecial') ?? '';
      $pqrTieneCondicionEspecial = $config->get('PQRTieneCondicionEspecial') ?? '';
      $pqrDescription = $config->get('PQRDescription') ?? '';
      $pqrProducto = $config->get('PQRProducto') ?? '';
      $pqrPlaca = $config->get('PQRPlaca') ?? '';
      $pqrMotivoSFC = $config->get('PQRMotivoSFC') ?? '';
      $pqrMedioEnvio = $config->get('PQRMedioEnvio') ?? '';
      $pqrEntidadVigilada = $config->get('PQREntidadVigilada') ?? '';
      $pqrCanal = $config->get('PQRCanal') ?? '';
      $pqrStatusSFC = $config->get('PQRStatusSFC') ?? '';

      if ($_ENV['AH_SITE_ENVIRONMENT'] != 'prod') {
        $values_env["orgid"] = $config->get('PQRorgId') ?? '';
        $values_env["debugEmail"] = $values['debugEmail'];
      }

      $values_env[$pqrRegistroWebToCase] = $values[$pqrRegistroWebToCase];
      $values_env['00N4A00000G91wx'] = $values['00N4A00000G91wx'];
      $values_env['retURL'] = $values['retURL'];
      $values_env[$pqrPaisEvento] = $values['pais'];
      $values_env[$pqrreplica] = $values['00ng000000fwyn9'];
      $values_env[$pqrNumeroCaso] = $values['00n4a00000fkikp'];
      $values_env[$pqrNombre] = $values['00n4a00000fkiko'];
      $values_env[$pqrTipoIdentidad] = $values['00ng000000fwyow'];
      $values_env[$pqrNumeroIdentificacion] = $values['00ng000000fwyoi'];
      $values_env[$pqrEmail] = $values['mail'];
      $values_env[$pqrCiudadEvento] = $values['00ng000000fwynf'];
      $values_env[$pqrDireccion] = $values['00ng000000fwynx'];
      $values_env[$pqrTelefonoFijo] = $values['00NG000000FWyoU'];
      $values_env[$pqrCelular] = $values['00NG000000FWynB'];
      $values_env[$pqrGenero] = $values['00n05000000xuss'];
      $values_env[$pqrAutorizacionDatosPersonales] = $values['00n05000001ccds'];
      $values_env[$pqrLGBTIQ] = $values['00n05000000y1hp'];
      $values_env[$pqrCondicionEspecial] = $values['00n05000000y11p'];
      $values_env[$pqrTieneCondicionEspecial] = $values['cond_especial'];
      $values_env[$pqrDescription] = $values['description'];
      $values_env[$pqrProducto] = $values['00N4A00000FkiL2'];
      $values_env[$pqrPlaca] = $values['00NG000000998UR'];
      $values_env[$pqrMotivoSFC] = $values['00n05000001bn7q'];
      $values_env[$pqrMedioEnvio] = $values['00ng000000fwynl'];
      $values_env[$pqrEntidadVigilada] = $values['00N04000000j8M2'];
      $values_env[$pqrCanal] = $values['00N04000000j8Ly'];
      $values_env[$pqrStatusSFC] = $values['00N04000000jZQi'];

      $values_env['adjuntar_archivos'] = $values['adjuntar_archivos'];

      $values_env['send'] = $values['send'];
      $values_env['form_build_id'] = $values['form_build_id'];
      $values_env['form_token'] = $values['form_token'];
      $values_env['form_id'] = $values['form_id'];
      $values_env['next'] = $values['next'];

      $sfUrl = $config->get('ENDPOINT_SALESFORCE') ?? '';

      \Drupal::logger('lib_pqr')->error(json_encode($sfUrl));
      \Drupal::logger('lib_pqr')->error(json_encode($values_env));

      try {
        $sf = $client->request(
          'POST',
          $sfUrl,
          [
            'headers' => [
              'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => $values_env,
            'verify' => FALSE,
          ]
        );
      }
      catch (\Exception $e) {
        \Drupal::logger('lib_pqr')->error(json_encode($sf));
      }

      // Redirect back to the specified URL after form submission.
      $response = new RedirectResponse($values['retURL']);
      return $response->send();

    }
    catch (RequestException $e) {
      $response = new RedirectResponse($values['retURL']);
      \Drupal::logger('lib_pqr')->error('Error en la solicitud a Salesforce: @message', ['@message' => $e->getMessage()]);
      return $response->send();
    }
  }

}
