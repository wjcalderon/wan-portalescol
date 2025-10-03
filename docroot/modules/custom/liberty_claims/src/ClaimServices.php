<?php

namespace Drupal\liberty_claims;

use Drupal\Component\Serialization\Yaml;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\liberty_claims\traits\ErrorEmails;
use Drupal\liberty_claims\traits\GetTokens;
use Drupal\liberty_claims\traits\ReplaceData;
use Drupal\liberty_claims\traits\ValidatePolicy;
use Drupal\oauth2_client\Service\Oauth2ClientServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Request;
use Drupal\taxonomy\Entity\Term;

/**
 * Class Claims Services.
 */
class ClaimServices
{
  const CLAIM_TYPE_PTH = 'ASEGURADO_PTH';
  const CLAIM_TYPE_PPH = 'ASEGURADO_PPH';
  const CLAIM_TYPE_PPD = 'ASEGURADO_PPD';
  const CLAIM_TYPE_LR = 'ASEGURADO_LLANTAS';
  const CLAIM_TYPE_AC = 'ASEGURADO_ACCESORIOS';
  const CLAIM_TYPE_CL = 'COBERTURA_LLAVES';
  const DATE_FORMAT = 'Y-m-d\TH:i:s';
  const BEARER = 'Bearer ';
  const CONTENT_TYPE = 'application/json';

  use GetTokens, ValidatePolicy, ErrorEmails, ReplaceData;

  /**
   * The mail manager.
   *
   * @var \Drupal\Core\Mail\MailManagerInterface
   */
  protected $mailManager;

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Drupal\oauth2_client\Service\Oauth2ClientServiceInterface definition.
   *
   * @var \Drupal\oauth2_client\Service\Oauth2ClientServiceInterface
   */
  protected $oauth2ClientService;

  /**
   * Drupal\Core\Extension\ModuleHandlerInterface definition.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Drupal\Core\Cache\CacheBackendInterface definition.
   *
   * @var \Drupal\Core\Cache\CacheBackendInterface
   */
  protected $cacheManager;

  /**
   * Drupal\Core\Logger\LoggerChannelFactoryInterface definition.
   *
   * @var LoggerServiceInterface
   */
  protected LoggerServiceInterface $logger;

  /**
   * DrupalLogger.
   *
   * @var LoggerChannelInterface
   */
  protected LoggerChannelInterface $drupalLogger;

  /**
   * Token log custom.
   *
   * @var string
   */
  protected string $tokenLog;

  /**
   * The file system service.
   *
   * @var FileSystemInterface
   */
  protected FileSystemInterface $fileSystem;

  /**
   * Services Claim.
   *
   * @var string|ClaimServices
   */
  protected string|ClaimServices $claimServices;

  /**
   * {@inheritdoc}
   */
  public function __construct(
    MailManagerInterface          $mail_manager,
    ConfigFactoryInterface        $config_factory,
    Oauth2ClientServiceInterface  $oauth2_client_service,
    ModuleHandlerInterface        $module_handler,
    CacheBackendInterface         $cache,
    LoggerServiceInterface        $liberty_logger,
    LoggerChannelFactoryInterface $drupal_logger,
    FileSystemInterface           $file_system
  )
  {
    $this->claimServices = $this;
    $this->mailManager = $mail_manager;
    $this->configFactory = $config_factory;
    $this->oauth2ClientService = $oauth2_client_service;
    $this->moduleHandler = $module_handler;
    $this->cacheManager = $cache;
    $this->logger = $liberty_logger;
    $this->drupalLogger = $drupal_logger->get('claims');
    $this->fileSystem = $file_system;
  }

  /**
   * Gets car shops list.
   *
   * @param int $city
   *   The filter of city.
   * @param string $brand
   *   The filter of brand.
   * @param int $model
   *   The filter of model.
   * @param int $type
   *   The filter of type.
   *
   * @return array
   *   List of carshop by filter
   */
  public function car_shops($city, $brand, $model, $type): array
  {
    $brand = str_replace('--', ' ', $brand);
    $brand = str_replace('++', '/', $brand);

    $parameters = [
      'http_errors' => TRUE,
      'headers' => [
        'Content-Type' => self::CONTENT_TYPE,
        'country' => '1',
        'cesvi-authorization' => $this->getCesviToken(),
        'Authorization' => self::BEARER . $this->getMainToken(),
      ],
      'query' => [
        'ciudad' => str_pad($city, 5, "0", STR_PAD_LEFT),
        'modelo' => $model,
        'marca' => $brand,
        strtolower($type) . ($type == 'Moto' ? 's' : '') => 'TRUE',
      ],
    ];

    $carshops = $this->car_shops_service($parameters);

    $parameters['query']['concesionario'] = 'TRUE';
    $carshops = array_merge($carshops, $this->car_shops_service($parameters));

    $filterCS = array_filter($carshops, function ($v) {
      return !str_contains($v->nombre, 'INACTIVO)') &&
        !str_contains($v->nombre, 'Taller para PTH') &&
        !str_contains($v->nombre, 'Taller para RCDBT') &&
        !str_contains($v->nombre, 'Taller para Arreglo Directo');
    });

    if (!$filterCS) {
      $config = $this->configFactory->get('liberty_claims.settings');
      $cities = $config->get('third_party_cities_carshops');
      $cities = Yaml::decode($cities);

      $capital = array_filter($cities,
        function ($v) use ($city) {
          return isset($v['CAPITAL']) && $v['COD'] == $city;
        },
        ARRAY_FILTER_USE_BOTH
      );

      if ($capital) {
        $capital = reset($capital);

        if (is_array($capital['CAPITAL'])) {
          foreach ($capital['CAPITAL'] as $cap) {
            $carshops = array_merge(
              $carshops,
              $this->get_car_shops_by_capital(
                $cap,
                $cities,
                $parameters
              ));
          }
        } else {
          $carshops = array_merge(
            $carshops,
            $this->get_car_shops_by_capital(
              $capital['CAPITAL'],
              $cities,
              $parameters
            ));
        }
      }
    }

    return $carshops;
  }

  /**
   * Gets the workshops by capital cities.
   */
  private function get_car_shops_by_capital($capital, $cities, $parameters)
  {
    $parameters['query']['ciudad'] = $capital;
    $capital_name = array_filter($cities,
      function ($v) use ($capital) {
        return isset($v['COD']) && $v['COD'] == $capital;
      },
      ARRAY_FILTER_USE_BOTH
    );

    $capital_name = ucfirst(\strtolower(key($capital_name)));

    $carshops = $this->car_shops_service($parameters);
    unset($parameters['query']['concesionario']);
    $carshops = array_merge($carshops, $this->car_shops_service($parameters));

    foreach ($carshops as &$carshop) {
      $carshop->external = $capital_name;
      $carshop->codExternal = $capital;
    }

    return $carshops;
  }

  /**
   * Gets the car shops from service.
   *
   * @param array $parameters
   *   HTTP Parameters for the service.
   *
   * @return array
   *   Carshops list.
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  private function car_shops_service(array $parameters = [])
  {
    $client = new Client([
      'base_uri' => $this->get_connection_data('base_uri'),
    ]);

    $parameters = array_merge($parameters, [
      'headers' => [
        'Content-Type' => self::CONTENT_TYPE,
        'Authorization' => self::BEARER . $this->getMainToken(),
        'country' => '1',
        'cesvi-authorization' => $this->getCesviToken(),
      ],
    ]);

    try {
      $response = $client->request('GET', '/fnol/consultaTalleres', $parameters);
      $body = $response->getBody()->getContents();
      $carshops = $body ? json_decode($body) : [];
    } catch (\Exception $e) {
      $carshops = [];
      $this->drupalLogger->error($e->getMessage());
    } finally {
      return $carshops;
    }
  }

  /**
   * Method to post in IAXIS.
   *
   * @param string $json
   *   Data for the service.
   * @param string $token
   *   Unique token of the claim.
   *
   * @return array
   *   Response.
   */
  public function post_iaxis(string $json, string $token)
  {
    $data = json_decode($json, TRUE);

    if ($data && isset($data['tellus'])) {
      // Gets samples yml data to creates a JSON request.
      $config = $this->configFactory->get('liberty_claims.settings');
      $samples = $config->get('samples');

      $common = Yaml::decode($samples['common']['data']);
      $type = Yaml::decode($samples[$data['tellus']]['data']);
      $data = $this->get_extra_data($data);

      // Creates a unique array from the YML decode data.
      $request = array_merge($common, $type);

      if (is_array($request) && !empty($request)) {
        // Replace each token text of type @[name] to complete the request.
        $request = json_encode($request, JSON_PRETTY_PRINT);
        $request = $this->iaxis_complete_data($request, $data);

        $this->logger->set('request_iaxis', $request, $token);

        $client = new Client([
          'base_uri' => $this->get_connection_data('base_uri'),
        ]);

        $body = NULL;

        try {
          $response = $client->request(
            'POST',
            '/fnol/radicacionSiniestro',
            [
              'http_errors' => TRUE,
              'headers' => [
                'Content-Type' => self::CONTENT_TYPE,
                'Authorization' =>
                  self::BEARER . $this->getMainToken(),
                'country' => '1',
              ],
              'body' => $request,
            ]
          );

          $body = $response->getBody()->getContents();

          $this->logger->setMultiple(
            [
              'response_iaxis' => $body,
              'status' => 2,
            ], $token);
        } catch (RequestException $e) {
          if ($e->hasResponse()) {
            $response = $e->getResponse();
            $error = $response->getBody()->getContents();
            $this->drupalLogger->error($error);
            $this->logger->set('response_iaxis', $error, $token);
          }
          $this->sendEmailErrorIaxis($data, $error);
          unset($_SESSION['GMFChevrolet'], $_SESSION['RCINissan'], $_SESSION['RCIRenault']);
        }

        return json_decode($body ?? '{}', TRUE);
      }
    }

    return ['error' => 'no-data'];
  }

  /**
   * Method to post in SIPO.
   *
   * @param string $json
   *   Data for the service.
   * @param string $iaxis_id
   *   IAXIS id.
   * @param string $token
   *   Unique token of the claim.
   *
   * @return array|null
   *   Response.
   */
  public function post_sipo(string $json, string $iaxis_id, string $token): array|null
  {
    $data = json_decode($json, TRUE);
    $config = $this->configFactory->get('liberty_claims.settings');

    $data_taller = $data['nombre'];

    if ($data['tellus'] == 'THIRD_PARTY') {
      $data['policy'] = 'no-data';
      $data['iAxis'] = 0;
      $sipo_sample = $config->get('sipo_third_party');
    } else {
      $data = $this->get_extra_data($data);
      $data['iAxis'] = $iaxis_id;
      $sipo_sample = $config->get('sipo_sample');
    }

    $sipo_sample = $this->sipo_complete_data($sipo_sample, $data);

    $request = Yaml::decode($sipo_sample);

    if ($request['vehiculo']['taller'] === NULL) {
      $request['vehiculo']['taller'] = 0;
    }

    $brand = $request['vehiculo']['marca'];
    if (str_contains($brand, 'GREAT WALL MOTOR')) {
      $request['vehiculo']['marca'] = 'GREAT WALL';
    }

    $this->logger->set('request_sipo', json_encode($request, JSON_UNESCAPED_UNICODE), $token);

    $client = new Client([
      'base_uri' => $this->get_connection_data('base_uri'),
      'timeout' => 360
    ]);

    $body = NULL;

    try {
      $response = $client->request('POST', '/fnol/asignacionCaso', [
        'http_errors' => TRUE,
        'headers' => [
          'Content-Type' => self::CONTENT_TYPE,
          'Authorization' => self::BEARER . $this->getMainToken(),
          'cesvi-authorization' => $this->getCesviToken(),
          'country' => '1',
        ],
        'body' => json_encode($request, JSON_UNESCAPED_UNICODE),
      ]);

      $body = $response->getBody()->getContents();

      $this->logger->setMultiple(
        [
          'response_sipo' => $body,
          'iaxis_id' => $iaxis_id,
          'status' => 3,
        ],
        $token
      );
      unset($_SESSION['GMFChevrolet'], $_SESSION['RCINissan'], $_SESSION['RCIRenault'], $_SESSION['RCIChevrolet']);
    } catch (RequestException $e) {
      if ($e->hasResponse()) {
        $error = (string)$e->getResponse()->getBody();
        $this->drupalLogger->error($error);
        $this->logger->set('response_sipo', $error, $token);
      }

      $this->sendEmailErrorSipo($request, $data_taller, $error);
      unset($_SESSION['GMFChevrolet'], $_SESSION['RCINissan'], $_SESSION['RCIRenault'], $_SESSION['RCIChevrolet']);
    }

    $body = json_decode($body, TRUE);
    if (isset($body['numeroCaso'])) {
      $this->post_files($json, $body['numeroCaso']);
    }

    return $body;
  }

  private function wsl_params ($header_token) {
    $opts = [
      'http' => [
        'user_agent' => 'PHPSoapClient',
        'header' => $header_token,
      ],
    ];

    $context = stream_context_create($opts);
    return [
      'stream_context' => $context,
      'cache_wsdl' => WSDL_CACHE_NONE,
      'encoding' => 'UTF-8',
      'verifypeer' => FALSE,
      'verifyhost' => FALSE,
      'soap_version' => SOAP_1_1,
      'trace' => 1,
      'exceptions' => 1,
      'connection_timeout' => 180,
    ];
  }

  /**
   * Method to validate plate of the vehicle.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   Request from the app.
   * @param string $plate
   *   Vehicle plate.
   * @param string $type
   *   Policy type.
   * @param string $date
   *   Claim date.
   *
   * @return array
   *   Return json array.
   */
  public function validate_plate(Request $request, string $plate, string $type, $date): array|string
  {
    // Prepare config and request body.
    $config = $this->configFactory->get('liberty_claims.settings');
    $bodyYaml = $this->plate_request_complete_data(
      $request,
      $config->get('policy_request'),
      strtoupper($plate)
    );
    $body = Yaml::decode($bodyYaml);

    $api_endpoint_base = $this->get_connection_data('base_uri');
    $currentToken = $this->get_connection_data('api_key') ?? '';
    $api_endpoint = $api_endpoint_base . '/fnol/consultaspolizas';
    $header_token = "x-api-key: $currentToken \n Country: 1";
    $this->tokenLog = $request->headers->get('token') . $plate;
    ini_set('soap.wsdl_cache_enabled', '0');
    $params = $this->wsl_params($header_token);

    // Log request payload.
    $this->logger->set('data', json_encode([
      'consultaPolizaRequestDate' => date(self::DATE_FORMAT),
      'consultaPolizaRequest' => $body,
    ]), $this->tokenLog);

    try {
      $extensionPath = \Drupal::service('extension.list.module')->getPath('liberty_claims');
      $wsdlPath = $extensionPath . '/data/consulta_placa.wsdl';
      $soapClient = new \SoapClient($wsdlPath, $params);
      $soapClient->__setLocation($api_endpoint);

      $response = $soapClient->__soapCall('consultarPolizas', $body);

      // Log raw SOAP response for audit.
      $this->logger->set('consulta_placa', json_encode([
        'consultaPolizaResponseDATA' => [
          'consultaPolizaResponseDate' => date(self::DATE_FORMAT),
          'consultaPolizaResponse' => $response,
        ],
      ]), $this->tokenLog);

      if (!$response || !\property_exists($response, 'numeroRegistros') || !\property_exists($response, 'polizas')) {
        $this->log_resultado_operacion('no-data', 'no hay datos de la placa');
        return 'no-data';
      }

      $jsonString = json_encode($response);
      $response_array = json_decode($jsonString, TRUE);
      $polizas = $this->normalize_polizas_array($response_array);

      [$aseguradoVigente, $index_vigencia] = $this->poliza_vigente($polizas, $date);

      $product = $polizas[$index_vigencia]['codigoProducto'] ?? NULL;
      if ($product !== NULL) {
        $ramo_by_product = Yaml::decode($config->get('policy_ramos'));
        if (isset($ramo_by_product[$product])) {
          $ramo = $ramo_by_product[$product];
          $ramos_enable = $config->get('ramo_' . $ramo);
          if (isset($ramos_enable[$type]) && $ramos_enable[$type] === 0) {
            return 'error';
          }
        }
      }

      if (!$response->numeroRegistros) {
        $this->log_resultado_operacion('invalid', 'no hay registros para la placa');
        return 'invalid';
      }

      if ($aseguradoVigente) {
        return $this->validate_policy($polizas, $index_vigencia, $type);
      }

      $this->log_resultado_operacion('not-in-time', 'fecha de seguro vencida y/o no vigente');
      return 'not-in-time';

    } catch (\Throwable $th) {
      $this->logger->set('consulta_placa', json_encode([
        'resultadoOperacion' => [
          'date' => date(self::DATE_FORMAT),
          'message' => $th,
          'estado' => 'error',
        ],
      ]), $this->tokenLog);
      $this->drupalLogger->error($th->getMessage());
      error_log($th->getMessage());

      return 'error';
    }
  }

  private function indices_consecutivos(array $polizas): bool {
    $expectedIndex = 0;
    foreach ($polizas as $key => $_) {
      if ($key !== $expectedIndex) {
        return FALSE;
      }
      $expectedIndex++;
    }
    return TRUE;
  }

  private function normalize_polizas_array(array $response_array): array {
    $polizas = [];
    if (!isset($response_array['polizas'])) {
      return $polizas;
    }

    if ($this->indices_consecutivos($response_array['polizas'])) {
      foreach ($response_array['polizas'] as $value) {
        $polizas[] = $value;
      }

      usort($polizas, function ($a, $b) {
        $dateA = new DrupalDateTime($a['fechaExpedicion']);
        $dateB = new DrupalDateTime($b['fechaExpedicion']);
        return $dateA->getTimestamp() <=> $dateB->getTimestamp();
      });
    }
    else {
      $polizas[] = $response_array['polizas'];
    }

    return $polizas;
  }

  private function poliza_vigente(array $polizas, $date): array {
    $aseguradoVigente = FALSE;
    $index_vigencia = 0;
    $dateToCheckObj = new DrupalDateTime($date);

    foreach ($polizas as $key => $poliza) {
      $policy_start_date = new DrupalDateTime($poliza['fechaExpedicion']);
      $policy_end_date = new DrupalDateTime($poliza['fechaCartera']);

      if (
        $dateToCheckObj >= $policy_start_date &&
        $dateToCheckObj <= $policy_end_date &&
        ($poliza['estadoPoliza'] ?? NULL) === 'Vigente'
      ) {
        $aseguradoVigente = TRUE;
        $index_vigencia = $key;
      }
    }

    return [$aseguradoVigente, $index_vigencia];
  }

  private function log_resultado_operacion(string $estado, string $message): void {
    $this->logger->set('consulta_placa', json_encode([
      'resultadoOperacion' => [
        'date' => date(self::DATE_FORMAT),
        'message' => $message,
        'estado' => $estado,
      ],
    ]), $this->tokenLog);
  }

  /**
   * Method to get connection data as from site mode.
   *
   * @param string $item
   *   Item key.
   *
   * @return string
   *   Value of the parameter.
   */
  private function get_connection_data($item = NULL): array|string
  {
    $config = $this->configFactory->get('liberty_claims.settings');
    $mode = $config->get('mode');

    if ($item === NULL) {
      return $config->get($mode);
    }

    return $config->get($mode)[$item];
  }

  /**
   * Method to match values from the ymls data.
   *
   * @param array $resource
   *   Resource from the service.
   * @param array $data
   *   Data from the app.
   *
   * @return array
   *   Resource matched.
   */
  private function match_values(array $resource, array $data): array
  {
    foreach ($resource as $k => $value) {
      if (is_array($value)) {
        $new = $this->match_values($value, $data);
        $resource[$k] = $new;
      } elseif (is_string($value)) {
        if (str_starts_with($value, '_#@')) {
          $input = str_replace('_#@', '', $value);
          if (isset($data[$input])) {
            $resource[$k] = $data[$input];
          }
        }
      }
    }

    return $resource;
  }

  /**
   * Method to complete data from the app request.
   *
   * @param Symfony\Component\HttpFoundation\Request $request
   *   Request from the app.
   * @param string $data
   *   Data from the app.
   * @param string $plate
   *   Plate number.
   *
   * @return string
   *   Return text for plate request.
   */
  private function plate_request_complete_data(Request $request, $data, $plate): string
  {
    $data = str_replace('_#@plate', $plate, $data);
    $data = str_replace('_#@date', date(self::DATE_FORMAT), $data);
    $data = str_replace('_#@ip', $request->getClientIp(), $data);
    return $data;
  }

  /**
   * Method to complete data from the app request.
   *
   * @param string $data
   *   Data from the app.
   * @param array $source
   *   Input to check out.
   *
   * @return string
   *   Data for IAXIS request.
   */
  private function iaxis_complete_data(string $data, array $source): string
  {
    $data = $this->replaceBasicData($data, $source);

    if ($source['damages']) {
      $source['_damages'] = $this->damages($source);
    }

    $data_to_array = json_decode($data, TRUE);

    if ($source['withInjured'] || $source['withDeaths']) {
      $data_to_array['garantias'][] = $this->withDeathsInjuries($source);
    }

    $data_to_array = $this->match_values($data_to_array, $source);

    $preguntasExtraGarantia = $this->withDeathsInjuries($source);

    if ($data_to_array['numeroProducto'] == '900753') {
      foreach ($data_to_array['preguntasAsociadasAGarantia'] as $key => $question) {
        $numeroPregunta = $question['preguntaAsociadaAGarantia']['numeroPregunta'] ?? NULL;

        if ($numeroPregunta == 9096 || $numeroPregunta == 9097) {
          unset($data_to_array['preguntasAsociadasAGarantia'][$key]);
        } elseif ($numeroPregunta == 9069 && $source['withInjured'] || $numeroPregunta == 9070 && $source['withDeaths']) {
          $data_to_array['preguntasAsociadasAGarantia'][$key]['respuestasAPreguntasAsociadasAGarantia'][0] = [
            'descripcionRespuestaAPreguntaAsociadaAGarantia' => 'si',
            'numeroRespuestaAPreguntaAsociadaAGarantia' => '1',
          ];
        }
      }
    }

    $data_to_array['preguntasAsociadasAGarantia'] = array_values(
      $data_to_array['preguntasAsociadasAGarantia']
    );

    $data_to_array['preguntasAsociadasAGarantia'] = array_merge(
      $data_to_array['preguntasAsociadasAGarantia'],
      $preguntasExtraGarantia
    );

    return json_encode($data_to_array, JSON_PRETTY_PRINT);
  }

  /**
   * Method to complete data from the app request.
   *
   * @param string $data
   *   Data from the app.
   * @param array $source
   *   Source where check.
   */
  protected function sipo_complete_data($data, $source)
  {
    $config = $this->configFactory->get('liberty_claims.settings');
    $protections = Yaml::decode($config->get('sipo_protection'));

    if ($source['tellus'] == 'THIRD_PARTY' || $source['tellus'] == 'CLAIM_TYPE_PTH') {
      $carshops_by_city = Yaml::decode($config->get('third_party_cities_carshops'));
      $city = array_search(
        $source['city'],
        array_combine(
          array_keys($carshops_by_city),
          array_column($carshops_by_city, 'COD')
        )
      );

      $index = $source['tellus'] == 'THIRD_PARTY' ? 'RCDBT' : 'PTH';

      $data = str_replace('_#@codTaller', $carshops_by_city[$city][$index], $data);
    }

    $date = strtotime($source['date']);
    $input = date('Y-m-d\TH:i:s.\Z', $date);
    $data = str_replace('_#@_dateISO', $input, $data);

    $input = substr($source['vehicleType'], 0, 1);
    $data = str_replace('_#@_vehicleType', $input, $data);

    $input = $source['tellus'] != 'THIRD_PARTY' ? 'Asegurado' : 'Tercero';
    $data = str_replace('_#@_form', $input, $data);

    $input = array_key_exists($source['tellus'], $protections)
      ? $protections[$source['tellus']]
      : '';
    $data = str_replace('_#@_type', $input, $data);

    $input = substr($source['city'], 2, 3);
    $data = str_replace('_#@_city', $input, $data);

    $input = substr($source['city'], 0, 2);
    $data = str_replace('_#@_provcode', $input, $data);

    $input = date('Y-m-d\TH:i:s.\Z', time());
    $data = str_replace('_#@_currentDateISO', $input, $data);

    $data = str_replace('_#@_previusPolicy', $source['previusPolicy'], $data);

    $matches = [];
    preg_match('/(.*)(?=_#@_description)/i', $data, $matches, PREG_OFFSET_CAPTURE);
    $source['description'] = str_replace("\n", "\n" . $matches[0][0], trim($source['description']));
    $input = wordwrap($source['description'], 50, "\n" . $matches[0][0]);
    $data = str_replace('_#@_description', $input, $data);

    foreach ($source as $key => $value) {
      if (strpos($data, '_#@' . $key) && is_string($value) || is_int($value)) {
        $data = str_replace('_#@' . $key, $value, $data);
      }
    }

    $replace = preg_replace('/_#@+\w*/i', '', $data);

    return $replace ?? $data;
  }

  /**
   * Get extra data method.
   *
   * @param array $data
   *   Extract data from the request.
   *
   * @return array
   *   Data extracted.
   */
  protected function get_extra_data(array $data)
  {
    $config = $this->configFactory->get('liberty_claims.settings');
    $ramos = Yaml::decode($config->get('policy_ramos'));
    $sipo_ramos = Yaml::decode($config->get('sipo_ramos'));

    $policy = $this->crypt($data['policy'], 'de');
    unset($data['policy']);
    $policy = explode('|', $policy);
    $data['productNumber'] = $policy[0] ?? 0;
    $data['secureNumber'] = $policy[1] ?? 0;
    $data['policyNumber'] = $policy[2] ?? 0;
    $data['ramo'] = array_key_exists((int)$data['productNumber'], $ramos)
      ? $ramos[(int)$data['productNumber']]
      : 0;
    $data['sipoRamo'] = array_key_exists((int)$data['productNumber'], $sipo_ramos)
      ? $sipo_ramos[(int)$data['productNumber']]
      : 0;
    return $data;
  }

  /**
   * Method to encrypt and decrypt response data.
   *
   * @param string $string
   *   String to encrypt or decrypt.
   * @param string $action
   *   Option 'en' for encrypt, 'de' for decrypt.
   *
   * @return string
   *   String processed.
   */
  private function crypt($string, $action = 'en')
  {
    $secret_key = 'L!b3rTy';
    $secret_iv = 'Cl41m.';

    $encrypt_method = 'AES-256-CBC';
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'de') {
      return openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
  }

  /**
   * Send files.
   *
   * @param string $json
   *   Json data.
   * @param int $sipo_id
   *   SIPO Id.
   *
   * @return string
   *   JSON obejct
   */
  public function post_files(string $json, $sipo_id): string
  {
    if (!$sipo_id) {
      return json_encode(['errorFileUplaod' => 'No sipo_id provided'], TRUE);
    }

    $data = json_decode($json);
    $file_path = 'public://claimfiles/' . $data->documentId;
    $body = [];
    $file_list = [];

    if (!is_dir($file_path)) {
      return json_encode(['errorFileUplaod' => 'Folder not exist.'], TRUE);
    }

    if (is_dir($file_path)) {
      $file_list = array_diff(scandir($file_path), ['..', '.']);
    }

    if (count($file_list) > 0) {
      foreach ($file_list as $file) {
        $client = new Client([
          'base_uri' => $this->get_connection_data('base_uri'),
        ]);
        $file_name = \explode('.', $file);

        $body_request['Imagen'] = [
          'Clave' => $sipo_id,
          'Placa' =>
            $data->tellus === 'THIRD_PARTY'
              ? $data->plateAffected
              : $data->plate,
          'NombreArchivo' => $file_name[0],
          'TipoArchivo' => strtolower(end($file_name)),
          'Archivo' => \base64_encode(\file_get_contents($file_path . '/' . $file)),
        ];

        try {
          $response = $client->request(
            'POST',
            '/fnol/cargarImagen',
            [
              'http_errors' => TRUE,
              'headers' => [
                'Content-Type' => self::CONTENT_TYPE,
                'Authorization' =>
                  self::BEARER . $this->getMainToken(),
                'cesvi-authorization' => $this->getCesviToken(),
                'country' => '1',
              ],
              'body' => json_encode($body_request),
            ]
          );

          $body = $response->getBody()->getContents();
          $this->drupalLogger->notice($body);
        } catch (\Exception $e) {
          $this->drupalLogger->error($e->getMessage());
          $this->fileSystem->deleteRecursive($file_path);
        }
      }
    }

    $this->fileSystem->deleteRecursive($file_path);

    return json_encode($body, TRUE);
  }

  /**
   * Validate CodigoBroker is in Talleres Renault Taxonomy.
   *
   * @param string $codigo_broker
   *   codigoBroker data.
   *
   * @return bool
   *   Boolean TRUE or FALSE
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function validate_broker_in_taxonomy(string $codigo_broker, string $brand): bool
  {
    $search_fields = [
      'vid' => 'talleres_renault',
      'field' => 'field_clave_renault'
    ];

    if ($brand === 'CHEVROLET') {
      $search_fields = [
        'vid' => 'talleres_chevrolet',
        'field' => 'field_clave_chevyseguros'
      ];
    }

    $term_storage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');
    $terms = $term_storage->loadByProperties(['vid' => $search_fields['vid']]);

    foreach ($terms as $term) {
      $field_clave = $term->get($search_fields['field'])->value;

      if ($codigo_broker == $field_clave) {
        return TRUE;
      }
    }

    return FALSE;
  }

}
