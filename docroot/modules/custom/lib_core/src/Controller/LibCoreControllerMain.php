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
        $client->post(
            '/webform_rest/submit?_format=json',
            $body,
            $options
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
                'verify' => false
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
=======
use Drupal\liberty_claims\Controller\ClaimNotificationController;
use Drupal\webform\Entity\Webform;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Controller routines for lib_core module.
 */
class LibCoreControllerMain extends ControllerBase {

  /**
   * El servicio de claims.
   *
   * @var \Drupal\liberty_claims\Controller\ClaimNotificationController
   */
  protected $claimNotificationController;

  /**
   * Constructs a new object.
   */
  public function __construct(ClaimNotificationController $claimNotificationController) {
    $this->claimNotificationController = $claimNotificationController;
  }

  /**
   * SinistersCitiesSelect.
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
   * SinistersVehiclesBrandsSelect.
   *
   * @return array
   *   An array of vehicle brands.
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
   *
   * @param string $webform_id
   *   ID webform.
   * @param array $values
   *   Values from form.
   *
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   *   A redirect response.
   */
  public function webformRestPost(string $webform_id, array $values) {

    $config = \Drupal::config('lib_core.environmentvars.settings');

    // Data send an email for a stolen car report.
    if ($values['00N4A00000FkWpu'] == "Hurto de su vehículo.") {
      $data['plate'] = $values['00NG000000998UR'];
      $data['date'] = $values['00N4A00000FkjTs'];
      $data['whereAddress'] = $values['00N4A00000FkWrC'];
      $data['description'] = $values['00N4A00000FkWr7'];
      $data['name'] = $values['00N4A00000FkWq9'];
      $data['phone'] = $values['00N4A00000FkWqO'];
      $data['PhoneFijo'] = $values['00N4A00000FkWqJ'];

      $data['isDriver'] = $values['00NG000000998UJ'] == $values['00N4A00000FkWq9'] ? TRUE : FALSE;
      $data['driverName'] = $values['00NG000000998UJ'];
      $data['driverPhone'] = $values['00N4A00000FkhdH'];

      $data['isDeclarant'] = $values['00NG000000998UJ'] == $values['00N4A00000FkWqd'] ? TRUE : FALSE;
      $data['declarantName'] = $values['00N4A00000FkWqd'];
      $data['declarantPhone'] = $values['00N4A00000FkWqs'];
      $data['driverPhoneFijo'] = $values['00N4A00000FkWqn'];
      $this->claimNotificationController->sendEmailAutoEmail($data);
    }

    // Post to SalesForce.
    $client = new Client();

    $urlApi = $config->get('ENDPOINT_SALESFORCE') ?? '';

    $sf = $client->request(
      'POST',
      $urlApi,
      [
        'headers' => [
          'Content-Type' => 'application/x-www-form-urlencoded',
        ],
        'form_params' => $values,
      ]
    );

    $response = $sf->getBody()->getContents();

    \Drupal::logger('salesforce_logger')->notice('Respuesta de Salesforce: @response', ['@response' => strip_tags($response)]);

    $url = $values['retURL'];
    $webform = Webform::load($webform_id);
    $values = [
      'webform_id' => $webform->id(),
      'data' => $values,
    ];
    lib_core_createsubmit($values);
    $response = new RedirectResponse($url);
    return $response->send();
  }

>>>>>>> main
}
