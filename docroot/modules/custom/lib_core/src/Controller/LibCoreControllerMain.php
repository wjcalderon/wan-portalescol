<?php
namespace Drupal\lib_core\Controller;

use Drupal\Component\Serialization\Yaml;
use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class LibCoreControllerMain extends ControllerBase
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

        // Post to webform
        $client->post(
            '/webform_rest/submit?_format=json',
            $body
        );
        // https://libertysegurosandinomarket--smartsuper.my.salesforce.com/
        // SalesForce endpoint
        // $sfUrl = 'https://libertysegurosandinomarket--qa.my.salesforce.com/servlet/servlet.WebToCase?encoding=UTF-8';
        // if ($_ENV['AH_SITE_ENVIRONMENT'] === 'prod') {
        //   $sfUrl = 'https://webto.salesforce.com/servlet/servlet.WebToCase?encoding=UTF-8';
        // }

        $sfUrl = $_ENV['ENDPOINT_SALESFORCE'];

        // \Drupal::logger('lib_core')->error($sfUrl);

        $sf = $client->request(
            'POST',
            $sfUrl,
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => $values,
            ]
        );
        // \Drupal::logger('lib_core')->error($sf);

        // \Drupal::logger('lib_core')->error('hola '. print_r($sf));
        // var_dump($sfUrl);
        // var_dump($sf);
        // exit();
        // // Redirect url
        $response = new RedirectResponse($values['retURL']);
        return $response->send();
    }
}
