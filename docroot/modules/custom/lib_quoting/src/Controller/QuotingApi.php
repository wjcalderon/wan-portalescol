<?php

namespace Drupal\lib_quoting\Controller;

use Drupal\Core\Controller\ControllerBase;
<<<<<<< HEAD
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation;
use GuzzleHttp\Client;

/**
 * Controller with queries of vehicles quoting
=======
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Controller with queries of vehicles quoting.
>>>>>>> main
 */
class QuotingApi extends ControllerBase {

  /**
<<<<<<< HEAD
   * Api configuration
=======
   * Api configuration.
>>>>>>> main
   */
  const SETTINGS = 'lib_quoting.settings';

  /**
<<<<<<< HEAD
   * Api configuration settings
=======
   * Api configuration settings.
   *
>>>>>>> main
   * @var array
   */
  private $settings;

  /**
<<<<<<< HEAD
   * Access token for general api
   * @var string
   */
  private $access_token;

  /**
   * Access token for SISA
   * @var string
   */
  private $access_token_sisa;

  /**
   * Access token for Quoting
   * @var string
   */
  private $access_token_pelh;

  /**
   * Read settings
   * @return void
   */
  public function __construct()
  {
    $this->settings = \Drupal::config(static::SETTINGS);
    $this->access_token = $this->_apiCall('access_token')[0];
    $this->access_token_sisa = $this->_apiCall('access_token_sisa')[0];
    $this->access_token_pelh = $this->_apiCall('access_token_perlrating')[0];
  }

  /**
   * Body for token request
   * @return array
   */
  private function _requestBodyToken() {
=======
   * Access token for general api.
   *
   * @var string
   */
  private $accessToken;

  /**
   * Access token for SISA.
   *
   * @var string
   */
  private $accessTokenSisa;

  /**
   * Access token for Quoting.
   *
   * @var string
   */
  public $accessTokenPelh;

  /**
   * Read settings.
   *
   * @return void
   */
  public function __construct() {
    $this->settings = \Drupal::config(static::SETTINGS);
    $this->accessToken = $this->apiCall('access_token')[0];
    $this->accessTokenSisa = $this->apiCall('access_token_sisa')[0];
    $this->$accessTokenPelh = $this->apiCall('access_token_perlrating')[0];
  }

  /**
   * Body for token request.
   */
  private function requestBodyToken() {
>>>>>>> main
    return [
      'form_params' => [
        'client_id' => $this->settings->get('config.api.client_id'),
        'client_secret' => $this->settings->get('config.api.client_secret'),
        'grant_type' => 'client_credentials',
      ],
    ];
  }

  /**
<<<<<<< HEAD
   * Body for SISA token request
   * @return array
   */
  private function _requestBodyTokenSisa() {
=======
   * Body for SISA token request.
   */
  private function requestBodyTokenSisa() {
>>>>>>> main
    return [
      'form_params' => [
        'client_id' => $this->settings->get('config.sisa.client_id'),
        'client_secret' => $this->settings->get('config.sisa.client_secret'),
        'grant_type' => 'client_credentials',
      ],
    ];
  }

  /**
<<<<<<< HEAD
   * Body for PELHRating token request
   * @return array
   */
  private function _requestBodyTokenPELHRating() {
=======
   * Body for PELHRating token request.
   */
  private function requestBodyTokenPelhRating() {
>>>>>>> main
    return [
      'form_params' => [
        'client_id' => $this->settings->get('config.perlrating.client_id'),
        'client_secret' => $this->settings->get('config.perlrating.client_secret'),
        'grant_type' => 'client_credentials',
      ],
    ];
  }

  /**
<<<<<<< HEAD
   * Body for query person request
   * @return array
   */
  private function _requestBodyPerson(array $data) {
    return [
      'headers' => [
        'Content-Type' => "application/json",
        'Authorization' => 'Bearer ' . $this->access_token,
=======
   * Body for query person request.
   */
  private function requestBodyPerson(array $data) {
    return [
      'headers' => [
        'Content-Type' => "application/json",
        'Authorization' => 'Bearer ' . $this->accessToken,
>>>>>>> main
      ],
      'body' => (json_encode([
        'consultarPersonaRq' => [
          'infoRequest' => [
            'requestID' => bin2hex(random_bytes(3)),
            'fecha' => date('c'),
            'aplicacionCliente' => 'liberty_portal',
            'terminal' => '1',
            'ip' => \Drupal::request()->getClientIp(),
          ],
          'tipoDocumento' => [
<<<<<<< HEAD
            'codigo' =>  $data['document_type'],
=======
            'codigo' => $data['document_type'],
>>>>>>> main
          ],
          'numeroDocumento' => $data['document_number'],
          'consultarCreditScore' => 'true',
        ],
      ])),
    ];
  }

  /**
<<<<<<< HEAD
   * Body for query auto request
   * @return array
   */
  private function _requestBodyAuto($data) {
    return [
      'headers' => [
        'Content-Type' => "application/json",
        'Authorization' => 'Bearer ' . $this->access_token,
=======
   * Body for query auto request.
   */
  private function requestBodyAuto($data) {
    return [
      'headers' => [
        'Content-Type' => "application/json",
        'Authorization' => 'Bearer ' . $this->accessToken,
>>>>>>> main
      ],
      'body' => (json_encode([
        'consultarVehiculoRq' => [
          'infoRequest' => [
            'requestID' => bin2hex(random_bytes(3)),
            'fecha' => date('c'),
            'aplicacionCliente' => 'liberty_portal',
            'terminal' => '1',
            'ip' => \Drupal::request()->getClientIp(),
          ],
          'vehiculo' => [
            'placa' => [
              'placa' => $data['plate'],
              'tipoPlaca' => [
                'codigo' => $data['type_plate'],
              ],
            ],
          ],
        ],
      ])),
    ];
  }

  /**
<<<<<<< HEAD
   * Body for SISA query auto request
   * @return array
   */
  private function _requestBodySisaAuto($data) {
    return [
      'headers' => [
        'Content-Type' => "application/json",
        'Authorization' => 'Bearer ' . $this->access_token_sisa,
        'Usario' => '90608600399880',
        'Clave' => '456954'
=======
   * Body for SISA query auto request.
   */
  private function requestBodySisaAuto($data) {
    return [
      'headers' => [
        'Content-Type' => "application/json",
        'Authorization' => 'Bearer ' . $this->accessTokenSisa,
        'Usario' => '90608600399880',
        'Clave' => '456954',
>>>>>>> main
      ],
      'body' => (json_encode([
        'HistoricoPolizas' => [
          'placa' => $data['plate'],
          'motor' => '',
          'chasis' => '',
        ],
      ])),
    ];
  }

  /**
<<<<<<< HEAD
   * Get Protections list ans values
   * @param int $value Vehicle value
   * @return array
   */
  private function _getProtections(int $value, $type) {
    $vid = 'policy';
    $terms =\Drupal::entityTypeManager()
      ->getStorage('taxonomy_term')
      ->loadTree($vid, 0, null, true);
    foreach ($terms as $term) {
      if ($term->field_type->value === $type) {
          $term_data[] = [
            'codigo' => $term->field_code->value,
            'descripcion' => $term->name->value,
            'valorAseguradoGar' => (
              $term->field_insured_value->value === null ? $value : $term->field_insured_value->value
            ),
            'porcentajeDeducible' => $term->field_deductible_percentage->value,
            'salariosDeducible' => $term->field_deductible_salary->value,
            'primaDtoComercial' => 0,
            'contratado' => true,
          ];
=======
   * Get Protections list ans values.
   */
  private function getProtections(int $value, $type) {
    $vid = 'policy';
    $terms = \Drupal::entityTypeManager()
      ->getStorage('taxonomy_term')
      ->loadTree($vid, 0, NULL, TRUE);
    foreach ($terms as $term) {
      if ($term->field_type->value === $type) {
        $term_data[] = [
          'codigo' => $term->field_code->value,
          'descripcion' => $term->name->value,
          'valorAseguradoGar' => (
              $term->field_insured_value->value ?? $value
          ),
          'porcentajeDeducible' => $term->field_deductible_percentage->value,
          'salariosDeducible' => $term->field_deductible_salary->value,
          'primaDtoComercial' => 0,
          'contratado' => TRUE,
        ];
>>>>>>> main
      }
    }
    return $term_data;
  }

  /**
<<<<<<< HEAD
   * Body for policy quoting
   * @param  array $data Data from quoting form
   * @return array
   */
  private function _requestBodyPolicy($data) {
    // Actual date
    $date = date('c');

    // Validate product
    $producto = ((int) $data['vehicle_com_value'] > 85000000) ? 'AL' : 'AU';

    // DPNR Values
=======
   * Body for policy quoting.
   */
  private function requestBodyPolicy($data) {
    // Actual date.
    $date = date('c');

    // Validate product.
    $producto = ((int) $data['vehicle_com_value'] > 85000000) ? 'AL' : 'AU';

    // DPNR Values.
>>>>>>> main
    $dpnr_values = [
      0 => 0,
      1 => 20,
      2 => 30,
      3 => 40,
      4 => 50,
    ];
    $dpnr = 0;
    if (!empty($data['experience'])) {
      if ($data['experience'] > 4) {
        $dpnr = $dpnr_values[4];
      }
      else {
        $dpnr = $dpnr_values[$data['experience']];
      }
    }

<<<<<<< HEAD
    // City
=======
    // City.
>>>>>>> main
    $department_id = 11;
    $city_id = 1;
    if (!empty($data['city_code'])) {
      $department_id = substr($data['city_code'], 0, 2);
      $city_id = substr($data['city_code'], 2, 5);
    }

    return [
      'headers' => [
        'Content-Type' => "application/json",
<<<<<<< HEAD
        'Authorization' => 'Bearer ' . $this->access_token_pelh,
=======
        'Authorization' => 'Bearer ' . $this->$accessTokenPelh,
>>>>>>> main
      ],
      'body' => (json_encode(
        [
          'runtimeContext' =>
          [
            'currentDate' => $date,
            'requestDate' => $date,
            'lob' => 'string',
            'nature' => 'string',
            'usState' => 'AL',
            'country' => 'AL',
            'usRegion' => 'MW',
            'currency' => 'ALL',
            'lang' => 'ALB',
            'region' => 'NCSA',
            'caProvince' => 'AB',
            'caRegion' => 'QC',
          ],
          'poliza' =>
          [
            'tipoNegocio' => 'Nuevo',
            'canal' => 'Tradicional',
            'formaPagoPol' => 'Anual',
            'descuentoComercial' => 0,
            'producto' => $producto,
            'conductor' =>
            [
              'documento' => $data['num_doc'],
              'genero' => $data['gender'],
              'edadConductor' => $data['age'],
<<<<<<< HEAD
              'antiguedadConductor' => !empty($data['experience']) ? $data['experience'] : null,
              'ocupacion' => !empty($data['ocupation']) ? $data['ocupation'] : null,
              'siniestro' => false,
=======
              'antiguedadConductor' => !empty($data['experience']) ? $data['experience'] : NULL,
              'ocupacion' => !empty($data['ocupation']) ? $data['ocupation'] : NULL,
              'siniestro' => FALSE,
>>>>>>> main
              'departamento' => (int) $department_id,
              'ciudad' => (int) $city_id,
              'acierta' => $data['experian'],
              'dpnr' => $dpnr,
            ],
            'vehiculo' =>
            [
              'marca' => $data['vehicle_marc'],
              'clase' => $data['vehicle_class'],
              'agrupadorVehiculo' => $data['vehicle_grouper'],
              'antiguedadVehiculo' => $data['vehicle_age'],
              'cilindraje' => $data['vehicle_cc'],
              'combustible' => $data['vehicle_fuel'],
<<<<<<< HEAD
              'tieneAccesorios' => false,
=======
              'tieneAccesorios' => FALSE,
>>>>>>> main
              'pesoVehiculo' => $data['vehicle_weight'],
              'tipoCaja' => $data['vehicle_gearbox'],
              'transmision' => $data['vehicle_transmition'],
              'puertas' => $data['vehicle_doors'],
              'dispositivoSeguridad' => 'NO APLICA',
              'valorAseguradoVeh' => $data['vehicle_com_value'],
              'uso' => $data['vehicle_use'] === '3' ? 'A' : 'B',
              'transporteConbustible' => $data['vehicle_fuel_transport'],
              'servicio' => $data['vehicle_service'],
              'factorTasaMaxima' => 0,
              'vinculacion' => 0,
<<<<<<< HEAD
              'amparos' => $this->_getProtections(
                (int) $data['vehicle_com_value'],
                'Coberturas'
              ),
              'amparosAdicionales' => $this->_getProtections(
=======
              'amparos' => $this->getProtections(
                (int) $data['vehicle_com_value'],
                'Coberturas'
              ),
              'amparosAdicionales' => $this->getProtections(
>>>>>>> main
                (int) $data['vehicle_com_value'],
                'Asistencias'
              ),
            ],
          ],
        ])),
    ];
  }

  /**
<<<<<<< HEAD
   * Make Api request with the specified data
   * @param  string $type Request type
   * @param  array  $data Data to make the request
   * @return array
   */
  private function _apiCall(string $type, array $data = []) {
=======
   * Make Api request with the specified data.
   */
  private function apiCall(string $type, array $data = []) {
>>>>>>> main
    $fields_reponse = [];

    switch ($type) {
      default:
      case 'access_token':
        $request = [
          'path' => '/oauth/access-token',
<<<<<<< HEAD
          'body' => $this->_requestBodyToken(),
=======
          'body' => $this->requestBodyToken(),
>>>>>>> main
        ];
        $fields = [
          'access_token',
        ];
        break;
      case 'access_token_sisa':
        $request = [
          'path' => '/oauth/access-token',
<<<<<<< HEAD
          'body' => $this->_requestBodyTokenSisa(),
=======
          'body' => $this->requestBodyTokenSisa(),
>>>>>>> main
        ];
        $fields = [
          'access_token',
        ];
        break;
<<<<<<< HEAD
      case 'access_token_perlrating':
        $request = [
          'path' => '/oauth/access-token',
          'body' => $this->_requestBodyTokenPELHRating(),
=======

      case 'access_token_perlrating':
        $request = [
          'path' => '/oauth/access-token',
          'body' => $this->requestBodyTokenPelhRating(),
>>>>>>> main
        ];
        $fields = [
          'access_token',
        ];
        break;
<<<<<<< HEAD
      case 'query_person':
        $request = [
          'path' => $this->settings->get('config.general_services_basepath') .
            '/consultarpersona',
          'body' => $this->_requestBodyPerson($data),
=======

      case 'query_person':
        $request = [
          'path' => $this->settings->get('config.general_services_basepath') .
          '/consultarpersona',
          'body' => $this->requestBodyPerson($data),
>>>>>>> main
        ];
        $fields = [
          'personaEncontradaIAXIS',
          'personaRestringida',
          'scoreEncontradoIAXIS',
          'persona',
          'informacionAniosExperiencia',
<<<<<<< HEAD
          'informacionExperian'
        ];
        break;
      case 'query_auto':
        $request = [
          'path' => $this->settings->get('config.general_services_basepath') .
            '/consultarvehiculo',
          'body' => $this->_requestBodyAuto($data),
=======
          'informacionExperian',
        ];
        break;

      case 'query_auto':
        $request = [
          'path' => $this->settings->get('config.general_services_basepath') .
          '/consultarvehiculo',
          'body' => $this->requestBodyAuto($data),
>>>>>>> main
        ];
        $fields = [
          'vehiculoEncontradoIAXIS',
          'vehiculoActivoIAXIS',
          'vehiculoRestringido',
<<<<<<< HEAD
          'datosVehiculo'
        ];
        break;
      case 'query_auto_sisa':
        $request = [
          'path' => '/sisa/historicopolizas',
          'body' => $this->_requestBodySisaAuto($data),
        ];
        $fields = [
          'HistoricoPolizaSisa'
        ];
        break;
      case 'query_policy':
        $request = [
          'path' => '/PELHRating/DeterminePolizaPrima',
          'body' => $this->_requestBodyPolicy($data),
=======
          'datosVehiculo',
        ];
        break;

      case 'query_auto_sisa':
        $request = [
          'path' => '/sisa/historicopolizas',
          'body' => $this->requestBodySisaAuto($data),
        ];
        $fields = [
          'HistoricoPolizaSisa',
        ];
        break;

      case 'query_policy':
        $request = [
          'path' => '/PELHRating/DeterminePolizaPrima',
          'body' => $this->requestBodyPolicy($data),
>>>>>>> main
        ];
        $fields = [
          'results',
        ];
        break;
    }
<<<<<<< HEAD
    // Set the base uri for requests
=======
    // Set the base uri for requests.
>>>>>>> main
    if ($type === 'query_policy' || $type === 'access_token_perlrating') {
      $client = new Client([
        'base_uri' => "https://test-apis.libertymutual.com",
        'timeout'  => 60.0,
      ]);
    }
    else {
      $client = new Client([
        'base_uri' => "https://" . $this->settings->get('config.apigee_url'),
        'timeout'  => 60.0,
      ]);
    }

<<<<<<< HEAD
    // Make the actual request
    $response = $client->post($request['path'], $request['body']);

    // Decode response
    $response_content = json_decode($response->getBody()->getContents());

    // Fill the return array with the fields set for the type of request
=======
    // Make the actual request.
    $response = $client->post($request['path'], $request['body']);

    // Decode response.
    $response_content = json_decode($response->getBody()->getContents());

    // Fill the return array with the fields set for the type of request.
>>>>>>> main
    foreach ($fields as $field) {
      if ($type == 'query_person') {
        $fields_reponse[$field] = $response_content->consultarPersonaRs->$field;
      }
<<<<<<< HEAD
      else if ($type == 'query_auto') {
        $fields_reponse[$field] = $response_content->consultarVehiculoRs->$field;
      }
      else if ($type == 'query_auto_sisa') {
=======
      elseif ($type == 'query_auto') {
        $fields_reponse[$field] = $response_content->consultarVehiculoRs->$field;
      }
      elseif ($type == 'query_auto_sisa') {
>>>>>>> main
        $fields_reponse[$field] = $response_content
          ->HistoricoPolizasResponse
          ->HistoricoPolizasResult
          ->$field;
      }
      else {
        $fields_reponse[] = $response_content->$field;
      }
    }

    return $fields_reponse;
  }

  /**
<<<<<<< HEAD
   * Get the person info
   * @return string
   */
  public function query_person() {
    $data['person_info'] = $this->_apiCall('query_person', $_POST);
=======
   * Get the person info.
   */
  public function queryPerson() {
    $request = \Drupal::requestStack()->getCurrentRequest();

    $formData = $request->request->all();

    $data['person_info'] = $this->apiCall('query_person', $formData);
>>>>>>> main
    return new JsonResponse($data);
  }

  /**
<<<<<<< HEAD
   * Get the auto info
   * @return string
   */
  public function query_auto() {
    $data['vehicle_info'] = $this->_apiCall('query_auto', $_POST);
=======
   * Get the auto info.
   */
  public function queryAuto(RequestStack $requestStack) {
    $request = $requestStack->getCurrentRequest();
    $formData = $request->request->all();

    $data['vehicle_info'] = $this->apiCall('query_auto', $formData);
>>>>>>> main
    return new JsonResponse($data);
  }

  /**
<<<<<<< HEAD
   * Get the auto info from SISA
   * @return string
   */
  public function query_auto_sisa() {
    $form = \Drupal::request()->request->all();
    $data['vehicle_info'] = $this->_apiCall('query_auto_sisa', $form);
=======
   * Get the auto info from SISA.
   */
  public function queryAutoSisa(RequestStack $requestStack) {
    $request = $requestStack->getCurrentRequest();
    $formData = $request->request->all();

    $data['vehicle_info'] = $this->apiCall('query_auto_sisa', $formData);
>>>>>>> main
    return new JsonResponse($data);
  }

  /**
<<<<<<< HEAD
   * Get quoting values
   * @return string
   */
  public function query_policy() {
    $form = \Drupal::request()->request->all();
    $data['policy_info'] = $this->_apiCall('query_policy', $form);
    return new JsonResponse($data);
  }
=======
   * Get quoting values.
   */
  public function queryPolicy(RequestStack $requestStack) {
    $request = $requestStack->getCurrentRequest();
    $formData = $request->request->all();

    $data['policy_info'] = $this->apiCall('query_policy', $formData);
    return new JsonResponse($data);
  }

>>>>>>> main
}
