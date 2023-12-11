<?php

namespace Drupal\lib_quoting\Controller;

use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Controller with queries of vehicles quoting.
 */
class QuotingApi extends ControllerBase {

  /**
   * Api configuration.
   */
  const SETTINGS = 'lib_quoting.settings';

  /**
   * Api configuration settings.
   *
   * @var array
   */
  private $settings;

  /**
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
  private $accessTokenPelh;

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
    return [
      'form_params' => [
        'client_id' => $this->settings->get('config.api.client_id'),
        'client_secret' => $this->settings->get('config.api.client_secret'),
        'grant_type' => 'client_credentials',
      ],
    ];
  }

  /**
   * Body for SISA token request.
   */
  private function requestBodyTokenSisa() {
    return [
      'form_params' => [
        'client_id' => $this->settings->get('config.sisa.client_id'),
        'client_secret' => $this->settings->get('config.sisa.client_secret'),
        'grant_type' => 'client_credentials',
      ],
    ];
  }

  /**
   * Body for PELHRating token request.
   */
  private function requestBodyTokenPelhRating() {
    return [
      'form_params' => [
        'client_id' => $this->settings->get('config.perlrating.client_id'),
        'client_secret' => $this->settings->get('config.perlrating.client_secret'),
        'grant_type' => 'client_credentials',
      ],
    ];
  }

  /**
   * Body for query person request.
   */
  private function requestBodyPerson(array $data) {
    return [
      'headers' => [
        'Content-Type' => "application/json",
        'Authorization' => 'Bearer ' . $this->accessToken,
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
            'codigo' => $data['document_type'],
          ],
          'numeroDocumento' => $data['document_number'],
          'consultarCreditScore' => 'true',
        ],
      ])),
    ];
  }

  /**
   * Body for query auto request.
   */
  private function requestBodyAuto($data) {
    return [
      'headers' => [
        'Content-Type' => "application/json",
        'Authorization' => 'Bearer ' . $this->accessToken,
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
   * Body for SISA query auto request.
   */
  private function requestBodySisaAuto($data) {
    return [
      'headers' => [
        'Content-Type' => "application/json",
        'Authorization' => 'Bearer ' . $this->accessTokenSisa,
        'Usario' => '90608600399880',
        'Clave' => '456954',
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
      }
    }
    return $term_data;
  }

  /**
   * Body for policy quoting.
   */
  private function requestBodyPolicy($data) {
    // Actual date.
    $date = date('c');

    // Validate product.
    $producto = ((int) $data['vehicle_com_value'] > 85000000) ? 'AL' : 'AU';

    // DPNR Values.
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

    // City.
    $department_id = 11;
    $city_id = 1;
    if (!empty($data['city_code'])) {
      $department_id = substr($data['city_code'], 0, 2);
      $city_id = substr($data['city_code'], 2, 5);
    }

    return [
      'headers' => [
        'Content-Type' => "application/json",
        'Authorization' => 'Bearer ' . $this->$accessTokenPelh,
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
              'antiguedadConductor' => !empty($data['experience']) ? $data['experience'] : NULL,
              'ocupacion' => !empty($data['ocupation']) ? $data['ocupation'] : NULL,
              'siniestro' => FALSE,
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
              'tieneAccesorios' => FALSE,
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
              'amparos' => $this->getProtections(
                (int) $data['vehicle_com_value'],
                'Coberturas'
              ),
              'amparosAdicionales' => $this->getProtections(
                (int) $data['vehicle_com_value'],
                'Asistencias'
              ),
            ],
          ],
        ])),
    ];
  }

  /**
   * Make Api request with the specified data.
   */
  private function apiCall(string $type, array $data = []) {
    $fields_reponse = [];

    switch ($type) {
      default:
      case 'access_token':
        $request = [
          'path' => '/oauth/access-token',
          'body' => $this->requestBodyToken(),
        ];
        $fields = [
          'access_token',
        ];
        break;
      case 'access_token_sisa':
        $request = [
          'path' => '/oauth/access-token',
          'body' => $this->requestBodyTokenSisa(),
        ];
        $fields = [
          'access_token',
        ];
        break;

      case 'access_token_perlrating':
        $request = [
          'path' => '/oauth/access-token',
          'body' => $this->requestBodyTokenPelhRating(),
        ];
        $fields = [
          'access_token',
        ];
        break;

      case 'query_person':
        $request = [
          'path' => $this->settings->get('config.general_services_basepath') .
          '/consultarpersona',
          'body' => $this->requestBodyPerson($data),
        ];
        $fields = [
          'personaEncontradaIAXIS',
          'personaRestringida',
          'scoreEncontradoIAXIS',
          'persona',
          'informacionAniosExperiencia',
          'informacionExperian',
        ];
        break;

      case 'query_auto':
        $request = [
          'path' => $this->settings->get('config.general_services_basepath') .
          '/consultarvehiculo',
          'body' => $this->requestBodyAuto($data),
        ];
        $fields = [
          'vehiculoEncontradoIAXIS',
          'vehiculoActivoIAXIS',
          'vehiculoRestringido',
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
        ];
        $fields = [
          'results',
        ];
        break;
    }
    // Set the base uri for requests.
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

    // Make the actual request.
    $response = $client->post($request['path'], $request['body']);

    // Decode response.
    $response_content = json_decode($response->getBody()->getContents());

    // Fill the return array with the fields set for the type of request.
    foreach ($fields as $field) {
      if ($type == 'query_person') {
        $fields_reponse[$field] = $response_content->consultarPersonaRs->$field;
      }
      elseif ($type == 'query_auto') {
        $fields_reponse[$field] = $response_content->consultarVehiculoRs->$field;
      }
      elseif ($type == 'query_auto_sisa') {
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
   * Get the person info.
   */
  public function queryPerson() {
    $request = \Drupal::requestStack()->getCurrentRequest();

    $formData = $request->request->all();

    $data['person_info'] = $this->apiCall('query_person', $formData);
    return new JsonResponse($data);
  }

  /**
   * Get the auto info.
   */
  public function queryAuto(RequestStack $requestStack) {
    $request = $requestStack->getCurrentRequest();
    $formData = $request->request->all();

    $data['vehicle_info'] = $this->apiCall('query_auto', $formData);
    return new JsonResponse($data);
  }

  /**
   * Get the auto info from SISA.
   */
  public function queryAutoSisa(RequestStack $requestStack) {
    $request = $requestStack->getCurrentRequest();
    $formData = $request->request->all();

    $data['vehicle_info'] = $this->apiCall('query_auto_sisa', $formData);
    return new JsonResponse($data);
  }

  /**
   * Get quoting values.
   */
  public function queryPolicy(RequestStack $requestStack) {
    $request = $requestStack->getCurrentRequest();
    $formData = $request->request->all();

    $data['policy_info'] = $this->apiCall('query_policy', $formData);
    return new JsonResponse($data);
  }

}
