<?php
namespace Drupal\lib_core\Controller;

use Drupal\Component\Serialization\Yaml;
use Drupal\Core\Controller\ControllerBase;
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

        $base_uri = \Drupal::request()->getSchemeAndHttpHost();
        $client = new Client([
            'base_uri' => $base_uri,
        ]);

        // Get csrfToken
        $csrfToken = $client->get('/session/token',
            ['headers' => ['Content-Type' => "application/json"]])
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

        // Post to webform
        $webform = $client->post(
            '/webform_rest/submit?_format=json',
            $body
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
            ]
        );
        \Drupal::logger('lib_pqr')->error(json_encode($sf));

        // // Redirect url
        $response = new RedirectResponse($values['retURL']);
        return $response->send();
    }
}
