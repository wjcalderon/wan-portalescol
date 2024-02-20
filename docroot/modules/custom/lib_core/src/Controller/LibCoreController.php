<?php
<<<<<<< HEAD
=======

>>>>>>> main
namespace Drupal\lib_core\Controller;

use Drupal\Component\Serialization\Yaml;
use Drupal\Core\Controller\ControllerBase;
<<<<<<< HEAD
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class LibCoreController extends ControllerBase
{

    /**
     * sinisters_cities_select
     * @return [type] [description]
     */
    public function sinisters_cities_select()
    {
        $opts = array();
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
     * sinisters_vehicles_brands_select
     * @return [type] [description]
     */
    public function sinisters_vehicles_brands_select()
    {
        $opts = array();
        $path_lib_core_module = drupal_get_path('module', 'lib_core');
        $brand_vehicles = Yaml::decode(file_get_contents($path_lib_core_module . '/data/marca_vehiculos_liberty.yaml'));
        if (!empty($brand_vehicles)) {
            foreach ($brand_vehicles as $key => $value) {
                $opts[$value] = $value;
            }
        }
        return $opts;
    }

    /*public function sinisters_cities_autocomplete($name_city) {
    $opts = array();
    $path_lib_core_module = drupal_get_path('module', 'lib_core');
    $cities_decode = Yaml::decode(file_get_contents($path_lib_core_module . '/data/ciudades-liberty.yaml'));
    if (!empty($cities_decode)) {
    $cont = 0;
    foreach ($cities_decode as $key => $value) {
    if ($cont < 10) {
    if (stripos($value, $name_city) === 0) {
    $opts[] = array(
    'label' => $value,
    'id' => $key
    );
    $cont++;
    }
    }
    else {
    break;
    }
    }
    }
    return new JsonResponse($opts);
    }*/

    /**
     * Post custom form to webforms
     * @param $webform_id string ID webform
     * @param $values     array  Values from form
     */
    public function webformRestPost(string $webform_id, array $values)
    {
        // Post to SalesForce
        $client = new Client();

        $base_uri = \Drupal::request()->getHost();
        $client = new Client([
            'base_uri' => 'http://'.$base_uri,
        ]);

        // Get csrfToken
        $csrfToken = $client->get('/session/token',
            [
                'headers' => ['Content-Type' => "application/json"],
                'verify' => false
            ])
            ->getBody()
            ->getContents();

        // Change field names case
        $new_values = [];
        foreach ($values as $k => $v) {
            $new_values[strtolower($k)] = $v;
        }

        $new_values['webform_id'] = $webform_id;
        $new_values['entity_type'] = null;
        $new_values['entity_id'] = null;
        $new_values['in_draft'] = false;

        // Webform submit
        $body = [
            'headers' => [
                'Content-Type' => "application/json",
                'X-CSRF-Token' => $csrfToken,
            ],
            'body' => (json_encode($new_values)),
        ];

        $options = [
            'verify' => false // Habilitar verificación SSL
         ];

        // Post to webform
        $webform = $client->post(
            '/webform_rest/submit?_format=json',
            $body,
            $options
        );
        // \Drupal::logger('lib_pqr')->error($webform);

        //id from environment

        $values_env["orgid"] = $_ENV['PQRorgId'];

        if ($_ENV['AH_SITE_ENVIRONMENT'] != 'prod') {
            $values_env["orgid"] = $_ENV['PQRorgId'];

            $values_env["debugEmail"] = $values['debugEmail'];

        }
        $values_env[$_ENV['PQRRegistroWebToCase']] = $values[$_ENV['PQRRegistroWebToCase']];
        $values_env['00N4A00000G91wx'] = $values['00N4A00000G91wx'];
        $values_env['retURL'] = $values['retURL'];
        $values_env[$_ENV['PQRPaisEvento']] = $values['pais'];
        $values_env[$_ENV['PQRreplica']] = $values['00ng000000fwyn9'];
        $values_env[$_ENV['PQRNumeroCaso']] = $values['00n4a00000fkikp'];
        $values_env[$_ENV['PQRNombre']] = $values['00n4a00000fkiko'];
        $values_env[$_ENV['PQRTipoIdentidad']] = $values['00ng000000fwyow'];
        $values_env[$_ENV['PQRNumeroIdentificacion']] = $values['00ng000000fwyoi'];
        $values_env[$_ENV['PQREmail']] = $values['mail'];
        $values_env[$_ENV['PQRCiudadEvento']] = $values['00ng000000fwynf'];
        $values_env[$_ENV['PQRDireccion']] = $values['00ng000000fwynx'];
        $values_env[$_ENV['PQRTelefonoFijo']] = $values['00NG000000FWyoU'];
        $values_env[$_ENV['PQRCelular']] = $values['00NG000000FWynB'];
        $values_env[$_ENV['PQRGenero']] = $values['00n05000000xuss'];
        $values_env[$_ENV['PQRAutorizacionDatosPersonales']] = $values['00n05000001ccds'];
        $values_env[$_ENV['PQRLGBTIQ']] = $values['00n05000000y1hp'];
        $values_env[$_ENV['PQRCondicionEspecial']] = $values['00n05000000y11p'];
        $values_env[$_ENV['PQRTieneCondicionEspecial']] = $values['cond_especial'];
        $values_env[$_ENV['PQRDescription']] = $values['description'];
        $values_env[$_ENV['PQRProducto']] = $values['00N4A00000FkiL2'];
        $values_env[$_ENV['PQRPlaca']] = $values['00NG000000998UR'];
        $values_env[$_ENV['PQRMotivoSFC']] = $values['00n05000001bn7q'];
        $values_env[$_ENV['PQRMedioEnvio']] = $values['00ng000000fwynl'];
        $values_env[$_ENV['PQREntidadVigilada']] = $values['00N04000000j8M2'];
        $values_env[$_ENV['PQRCanal']] = $values['00N04000000j8Ly'];
        $values_env[$_ENV['PQRStatusSFC']] = $values['00N04000000jZQi'];

        $values_env['adjuntar_archivos'] = $values['adjuntar_archivos'];

        $values_env['send'] = $values['send'];
        $values_env['form_build_id'] = $values['form_build_id'];
        $values_env['form_token'] = $values['form_token'];
        $values_env['form_id'] = $values['form_id'];
        $values_env['next'] = $values['next'];

        $sfUrl = $_ENV['ENDPOINT_SALESFORCE'];

        \Drupal::logger('lib_pqr')->error(json_encode($sfUrl));
        \Drupal::logger('lib_pqr')->error(json_encode($values_env));

        $sf = $client->request(
            'POST',
            $sfUrl,
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => $values_env,
                'verify' => false
            ]
        );
        \Drupal::logger('lib_pqr')->error(json_encode($sf));

        // // Redirect url
        $response = new RedirectResponse($values['retURL']);
        return $response->send();
    }
=======
use Guzzle\Http\Exception\RequestException;
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
        $values_env["debug"] = $values['debug'];
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

      \Drupal::logger('lib_pqr')->notice(json_encode($sfUrl));
      \Drupal::logger('lib_pqr')->notice(json_encode($values_env));

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
            'form_params' => $values_env,
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
      \Drupal::logger('lib_pqr')->error('Error en la solicitud a Salesforce: @message', ['@message' => $e->getMessage()]);
      return $response->send();
    }
  }

>>>>>>> main
}
