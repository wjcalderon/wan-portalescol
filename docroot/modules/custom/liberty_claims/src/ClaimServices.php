<?php

namespace Drupal\liberty_claims;

use Drupal\Component\Serialization\Yaml;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\oauth2_client\Service\Oauth2ClientServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Claims Services.
 */
class ClaimServices {
  const CLAIM_TYPE_PTH = 'ASEGURADO_PTH';
  const CLAIM_TYPE_PPH = 'ASEGURADO_PPH';
  const CLAIM_TYPE_PPD = 'ASEGURADO_PPD';
  const CLAIM_TYPE_PL = 'ASEGURADO_LLAVES';
  const CLAIM_TYPE_LR = 'ASEGURADO_LLANTAS';
  const CLAIM_TYPE_AC = 'ASEGURADO_ACCESORIOS';

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
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $logger;

  /**
   * DrupalLogger.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $drupalLogger;

  /**
   * Token log custom.
   *
   * @var anycustom
   */
  protected $tokenLog;

  /**
   * The file system service.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * {@inheritdoc}
   */
  public function __construct(
    MailManagerInterface $mail_manager,
    ConfigFactoryInterface $config_factory,
    Oauth2ClientServiceInterface $oauth2_client_service,
    ModuleHandlerInterface $module_handler,
    CacheBackendInterface $cache,
    LoggerServiceInterface $liberty_logger,
    LoggerChannelFactoryInterface $drupal_logger,
    FileSystemInterface $file_system
    ) {
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
   * Verify date range is correct.
   */
  public function checkInRange($fecha_inicio, $fecha_fin, $fecha) {
    $fecha_inicio = strtotime($fecha_inicio);
    $fecha_fin = strtotime($fecha_fin);
    $fecha = strtotime($fecha);
    $value = FALSE;

    if ($fecha >= $fecha_inicio && $fecha <= $fecha_fin) {
      $value = TRUE;
    }
    else {
      $value = FALSE;
    }

    return $value;
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
   * @return JSON
   *   List of carshop by filter
   */
  public function carShops($city, $brand, $model, $type) {
    $brand = str_replace('--', ' ', $brand);
    $brand = str_replace('++', '/', $brand);
    $parameters = [
      'http_errors' => TRUE,
      'headers' => [
        'Content-Type' => 'application/json',
        'country' => '1',
        'cesvi-authorization' => $this->getCesviToken(),
        'Authorization' => 'Bearer ' . $this->getMainToken(),
      ],
      'query' => [
        'ciudad' => $city,
        'modelo' => $model,
        'marca' => $brand,
        strtolower($type) . ($type == 'Moto' ? 's' : '') => 'TRUE',
      ],
    ];
    $carshops = [];
    $carshops = $this->carShopsService($parameters);

    $parameters['query']['concesionario'] = 'TRUE';
    $carshops = array_merge($carshops, $this->carShopsService($parameters));

    $filterCS = array_filter($carshops, function ($v) {
        return strpos($v->nombre, 'INACTIVO)') === FALSE &&
            strpos($v->nombre, 'Taller para PTH') === FALSE &&
            strpos($v->nombre, 'Taller para RCDBT') === FALSE &&
            strpos($v->nombre, 'Taller para Arreglo Directo') === FALSE;
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
              $this->getCarShopsByCapital(
                  $cap,
                  $cities,
                  $parameters
              )
              );
          }
        }
        else {
          $carshops = array_merge(
            $carshops,
            $this->getCarShopsByCapital(
                $capital['CAPITAL'],
                $cities,
                $parameters
            )
                );
        }
      }
    }

    return $carshops;
  }

  /**
   * Gets the workshops by capital cities.
   */
  private function getCarShopsByCapital($capital, $cities, $parameters) {
    $parameters['query']['ciudad'] = $capital;
    $capital_name = array_filter($cities,
          function ($v) use ($capital) {
              return isset($v['COD']) && $v['COD'] == $capital;
          },
          ARRAY_FILTER_USE_BOTH
      );

    $capital_name = ucfirst(\strtolower(key($capital_name)));

    $carshops = $this->carShopsService($parameters);
    unset($parameters['query']['concesionario']);
    $carshops = array_merge($carshops, $this->carShopsService($parameters));

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
   */
  private function carShopsService(array $parameters = []) {
    $client = new Client([
      'base_uri' => $this->getConnectionData('base_uri'),
    ]);

    try {
      $response = $client->request('GET', '/fnol/consultaTalleres', $parameters);
      $body = $response->getBody()->getContents();
      $carshops = $body ? json_decode($body) : [];
    }
    catch (\Exception $e) {
      $carshops = [];
      $this->drupalLogger->error($e->getMessage());
    } finally {
      return $carshops;
    }
  }

  /**
   * Gets the car shops service token.
   *
   * @return string
   *   The token.
   */
  private function getCesviToken() {
    $cid = 'claims:cesvi_token';

    if ($cache = $this->cacheManager->get($cid)) {
      return $cache->data;
    }
    else {
      $client = new Client([
        'base_uri' => $this->getConnectionData('base_uri'),
      ]);
      try {
        $response = $client->request(
          'POST',
          'fnol/autenticacionCesvi',
          [
            'http_errors' => TRUE,
            'headers' => [
              'Content-Type' => 'application/json',
              'Authorization' =>
              'Bearer ' . $this->getMainToken(),
            ],
            'body' =>
            '{
              "username":"' .
            $this->getConnectionData('username') .
            '",
              "password":"' .
            $this->getConnectionData('password') .
            '"
            }',
          ]
          );

        $body = $response->getBody()->getContents();
        $json = json_decode($body);
        if (@$json->access_token) {
          $this->cacheManager->set($cid, $json->access_token, REQUEST_TIME + $json->expires_in);
          return $json->access_token;
        }
      }
      catch (\Exception $e) {
        $this->drupalLogger->error($e->getMessage());
        return '';
      }
    }
  }

  /**
   * Gets the main token.
   *
   * @return string
   *   The token.
   */
  private function getMainToken() {
    $cid = 'claims:main_token';
    if ($cache = $this->cacheManager->get($cid)) {
      return $cache->data;
    }
    else {
      $access_token = $this->getProviderToken();

      $this->cacheManager->set($cid, $access_token->getToken(), $access_token->getExpires());
      return $access_token->getToken();
    }
  }

  /**
   * Get token provider.
   */
  private function getProviderToken() {
    $client_id = $this->getConnectionData('validate_plate_token');
    $client_secret = $this->getConnectionData('client_secret');
    $token_uri = $this->getConnectionData('token_uri');

    $provider = new GenericProvider([
      'clientId' => $client_id,
      'clientSecret' => $client_secret,
      'redirectUri' => '',
      'urlAuthorize' => '',
      'urlAccessToken' => $token_uri,
      'urlResourceOwnerDetails' => '',
    ]);

    try {
      $accessToken = $provider->getAccessToken('client_credentials');
    }
    catch (IdentityProviderException $e) {
      $this->drupalLogger->error($e->getMessage());
    }

    return $accessToken;
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
  public function postIaxis(string $json, string $token) {
    $data = json_decode($json, TRUE);

    if ($data && isset($data['tellus'])) {
      // Gets samples yml data to creates a JSON request.
      $config = $this->configFactory->get('liberty_claims.settings');
      $samples = $config->get('samples');

      $common = Yaml::decode($samples['common']['data']);
      $type = Yaml::decode($samples[$data['tellus']]['data']);
      $data = $this->getExtraData($data);

      // Creates a unique array from the YML decode data.
      $request = array_merge($common, $type);

      if (is_array($request) && !empty($request)) {
        // Replace each token text of type @[name] to complete the request.
        $request = json_encode($request, JSON_PRETTY_PRINT);
        $request = $this->iAxisCompleteData($request, $data);

        $this->logger->set('request_iaxis', $request, $token);

        $client = new Client([
          'base_uri' => $this->getConnectionData('base_uri'),
        ]);

        $body = NULL;

        try {
          $response = $client->request(
            'POST',
            '/fnol/radicacionSiniestro',
            [
              'http_errors' => TRUE,
              'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' =>
                'Bearer ' . $this->getMainToken(),
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
        }
        catch (RequestException $e) {

          if ($e->hasResponse()) {
            $response = $e->getResponse();
            $error = $response->getBody()->getContents();
            $this->drupalLogger->error($error);
            $this->logger->set('response_iaxis', $error, $token);
          }
          $this->sendEmailErrorIaxis($data);
          unset($_SESSION['GMFChevrolet']);
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
   * @param string $code
   *   Unique code of the claim.
   *
   * @return array
   *   Response.
   */
  public function postSipo(string $json, string $iaxis_id, string $token, $code) {
    if ($iaxis_id) {
      $data['code_request'] = $code;
      $data = json_decode($json, TRUE);
      $config = $this->configFactory->get('liberty_claims.settings');

      $data_taller = $data['nombre'];
      $sipo_sample = $data['tellus'] == 'THIRD_PARTY' ? $config->get('sipo_third_party') : $config->get('sipo_sample');
      $data['iAxis'] = $data['tellus'] == 'THIRD_PARTY' ? 0 : $iaxis_id;

      if ($data['tellus'] == 'THIRD_PARTY') {
        $data['policy'] = 'no-data';
      }
      else {
        $data = $this->getExtraData($data);
      }

      $sipo_sample = $this->sipoCompleteData($sipo_sample, $data);

      $request = Yaml::decode($sipo_sample);

      if ($request['vehiculo']['taller'] === NULL) {
        $request['vehiculo']['taller'] = 0;
      }

      $brand = $request['vehiculo']['marca'];
      if (strpos($brand, 'GREAT WALL MOTOR') !== FALSE) {
        $request['vehiculo']['marca'] = 'GREAT WALL';
      }

      $this->logger->set('request_sipo', json_encode($request, JSON_UNESCAPED_UNICODE), $token);

      $client = new Client([
        'base_uri' => $this->getConnectionData('base_uri'),
      ]);

      $body = NULL;
      try {
        $response = $client->request('POST', '/fnol/asignacionCaso', [
          'http_errors' => TRUE,
          'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getMainToken(),
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
        unset($_SESSION['GMFChevrolet']);
      }
      catch (RequestException $e) {
        if ($e->hasResponse()) {
          $error = (string) $e->getResponse()->getBody();
          $this->drupalLogger->error($error);
          $this->logger->set('response_sipo', $error, $token);
        }

        $this->sendEmailErrorSipo($request, $data_taller);
        unset($_SESSION['GMFChevrolet']);
      }

      return json_decode($body, TRUE);
    }
    else {
      $this->logger->set('iaxis_id', 'error', $token);
      $this->logger->set(
            'request_sipo',
            json_encode(
                ['errorMessage' => 'No iaxis_id'],
                JSON_PRETTY_PRINT
            ),
            $token
            );
      return ['error' => 'no-axiscode'];
    }
  }

  /**
   * Method to validate plate of the vehicle.
   *
   * @param Symfony\Component\HttpFoundation\Request $request
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
  public function validatePlate(Request $request, string $plate, string $type, $date) {
    $client = new Client([
      'base_uri' => $this->getConnectionData('base_uri'),
    ]);

    $config = $this->configFactory->get('liberty_claims.settings');
    $config2 = $this->configFactory->get('liberty_claims_email.settings');

    $body = $this->plateRequestCompleteData($request, $config->get('policy_request'), strtoupper($plate));

    $body = Yaml::decode($body);

    $currentToken = '';
    $currentToken = $this->getConnectionData('validate_plate_token');

    $this->tokenLog = $request->headers->get('token') . $plate;

    $opts = [
      'http' => [
        'user_agent' => 'PHPSoapClient',
        'header' =>
        'VND.LMIG.Authorization: ' .
        $currentToken .
        " \n Country: 1",
      ],
    ];

    ini_set('soap.wsdl_cache_enabled', '0');

    $context = stream_context_create($opts);
    $params = [
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

    $this->logger->set('data', json_encode([
      'consultaPolizaRequestDate' => date('Y-m-d\TH:i:s'),
      'consultaPolizaRequest' => $body,
    ]), $this->tokenLog);

    try {
      $extensionPath = \Drupal::service('extension.list.module')->getPath('liberty_claims');
      $wsdlPath = $extensionPath . '/data/' . 'consulta_placa.wsdl';
      $client = new \SoapClient($wsdlPath, $params);

      $client->__setLocation($this->getConnectionData('base_uri') . '/andino/co/policy-servicing/consultaspolizas');
      $response = $client->__soapCall('consultarPolizas', $body);
      $polizas = [];

      $index_vigencia = 0;
      $jsonString = json_encode($response);
      $response_array = json_decode($jsonString, TRUE);

      $expectedIndex = 0;
      $indicesConsecutivos = TRUE;

      foreach ($response_array['polizas'] as $key => $value) {
        if ($key !== $expectedIndex) {
          $indicesConsecutivos = FALSE;
          break;
        }
        $expectedIndex++;
      }

      foreach ($response_array['polizas'] as $key => $value) {
        $polizas[$key] = $value;
      }

      if ($indicesConsecutivos) {
        usort($polizas, function ($a, $b) {
          $dateA = new DrupalDateTime($a['fechaExpedicion']);
          $dateB = new DrupalDateTime($b['fechaExpedicion']);
          return $dateA->getTimestamp() <=> $dateB->getTimestamp();
        });

        $aseguradoVigente = FALSE;
        foreach ($polizas as $key => $poliza) {
          $policy_start_date = new DrupalDateTime($poliza['fechaExpedicion']);
          $policy_end_date = new DrupalDateTime($poliza['fechaCartera']);

          $dateToCheckObj = new DrupalDateTime($date);

          if (
          $dateToCheckObj >= $policy_start_date &&
          $dateToCheckObj <= $policy_end_date &&
          $poliza['estadoPoliza'] == 'Vigente'
          ) {
            $aseguradoVigente = TRUE;
            $index_vigencia = $key;
          }
        }
      }
      else {
        $aseguradoVigente = FALSE;
        $policy_start_date = new DrupalDateTime($polizas['fechaExpedicion']);
        $policy_end_date = new DrupalDateTime($polizas['fechaCartera']);

        $dateToCheckObj = new DrupalDateTime($date);

        if (
          $dateToCheckObj >= $policy_start_date &&
          $dateToCheckObj <= $policy_end_date &&
          $polizas['estadoPoliza'] == 'Vigente'
          ) {
          $aseguradoVigente = TRUE;
          $index_vigencia = 0;
          $polizas[0] = $polizas;
        }
      }

      $this->logger->set('consulta_placa', json_encode([
        'consultaPolizaResponseDATA' => [
          'consultaPolizaResponseDate' => date('Y-m-d\TH:i:s'),
          'consultaPolizaResponse' => $response,
        ],
      ]), $this->tokenLog);

      if ($response && \property_exists($response, 'numeroRegistros') &&property_exists($response, 'polizas')) {
        $product = $polizas[$index_vigencia]['codigoProducto'];
        $ramo_by_product = Yaml::decode($config->get('policy_ramos'));

        if (isset($ramo_by_product[$product])) {
          $ramo = $ramo_by_product[$product];
          $ramos_enable = $config->get('ramo_' . $ramo);
          if (isset($ramos_enable[$type]) &&$ramos_enable[$type] === 0) {
            return 'error';
          }
        }

        if ($response->numeroRegistros) {

          if ($aseguradoVigente) {

            $codes = Yaml::decode($config->get('insured_codes'));
            $return = [];

            foreach ($polizas[$index_vigencia]['riesgoAuto']['garantiasPoliza'] as $item) {

              if (
              $item['codigoGarantia'] == $codes[$type] ||
              (is_array($codes[$type]) && in_array($item['codigoGarantia'], $codes[$type]))
              ) {

                $data = $polizas[$index_vigencia]['codigoProducto'] . '|' .
                $polizas[$index_vigencia]['numeroInternoSeguro'] . '|' .
                $polizas[$index_vigencia]['numeroPoliza'];

                $return['token'] = $this->crypt($data, 'en');
                $brokers = Yaml::decode($config->get('brokers'));
                if (is_array($brokers) &&in_array($polizas[$index_vigencia]['codigoBroker'], $brokers)) {
                  $return['broker'] = TRUE;
                }
              }
              elseif ($item['codigoGarantia'] == 756 || $item['codigoGarantia'] == 9036) {
                $return['guarantees']['rc1'] = $item['codigoGarantia'];
              }
              elseif ($item['codigoGarantia'] == 757 || $item['codigoGarantia'] == 9037) {
                $return['guarantees']['rc3'] = $item['codigoGarantia'];
              }
            }

            if (array_key_exists('token', $return)) {
              $doc_types = [
                'CC' => 36,
                'CE' => 33,
                'CD' => 44,
                'PAS' => 40,
                'RC' => 35,
                'TI' => 34,
                'NI' => 37,
              ];
              if (isset($polizas[$index_vigencia]['riesgoAuto']['aseguradoPersonaNatural'])) {
                $personal_data = $polizas[$index_vigencia]['riesgoAuto']['aseguradoPersonaNatural'];
                // If personal_data have more than one array index, then use
                // conductorPersonalData.
                $name = '';
                $lastName = '';
                $documentId = '';
                $docType = '';
                $email = '';
                $address = '';
                $phone = '';

                if (isset($personal_data[0]) && count($personal_data) > 1) {
                  if (isset($polizas[$index_vigencia]['riesgoAuto']['conductorPersonaNatural'][0])) {
                    $conductor_data = $polizas[$index_vigencia]['riesgoAuto']['conductorPersonaNatural'][0] ?? '';
                    $name = isset($conductor_data['primerNombre'])
                    ? $conductor_data['primerNombre'] . ' ' . @$conductor_data['segundoNombre']
                    : '';
                    $lastName = isset($conductor_data['primerApellido'])
                    ? $conductor_data['primerApellido'] . ' ' . @$conductor_data['segundoApellido']
                    : '';
                    $documentId = $conductor_data['numeroDocumento'] ?? '';
                    $docType = isset($conductor_data['tipoDocumento']) && $conductor_data['tipoDocumento']
                    ? $doc_types[$conductor_data['tipoDocumento']['codigo']]
                    : 0;
                    if (isset($conductor_data['email'])) {
                      $email = $conductor_data['email'];
                    }
                    elseif (isset($conductor_data['mail'])) {
                      $email = $conductor_data['mail'];
                    }
                    else {
                      $email = '';
                    }
                    $address = isset($conductor_data['direccion']) ? $conductor_data['direccion']['direccion'] : '';
                    $phone = isset($conductor_data['telefono']) && $conductor_data['telefono']['numero'] != 0
                    ? $conductor_data['telefono']['numero']
                    : '';
                  }
                }
                else {
                  $name = isset($personal_data['primerNombre'])
                    ? $personal_data['primerNombre'] . ' ' . @$personal_data['segundoNombre']
                    : '';
                  $lastName = isset($personal_data['primerApellido'])
                  ? $personal_data['primerApellido'] . ' ' . $personal_data['segundoApellido']
                  : '';
                  $documentId = $personal_data['numeroDocumento'] ?? '';
                  $docType = isset($personal_data['tipoDocumento']) && $personal_data['tipoDocumento']
                    ? $doc_types[$personal_data['tipoDocumento']['codigo']]
                    : 0;
                  if (isset($personal_data['email'])) {
                    $email = $personal_data['email'];
                  }
                  elseif (isset($personal_data['mail'])) {
                    $email = $personal_data['mail'];
                  }
                  else {
                    $email = '';
                  }
                  $address = isset($personal_data['direccion']) ? $personal_data['direccion']['direccion'] : '';
                  $phone = isset($personal_data['telefono']) && $personal_data['telefono']['numero'] != 0
                  ? $personal_data['telefono']['numero']
                  : '';
                }
                $return['personalInfo'] = [
                  'name' => $name ?? '',
                  'lastname' => $lastName ?? '',
                  'documentId' => $documentId ?? '',
                  'docType' => $docType ?? '',
                  'email' => $email ?? '',
                  'address' => $address ?? '',

                  'brand' => isset($polizas[$index_vigencia])
                    ? $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca']
                    : '',

                  'model' => isset($polizas[$index_vigencia])
                    ? $polizas[$index_vigencia]['riesgoAuto']['automovil']['version']
                    : '',
                  'phone' => $phone ?? '',
                ];
              }
              elseif (isset($polizas[$index_vigencia]['riesgoAuto']['aseguradoPersonaJuridica'])) {
                $personal_data = $polizas[$index_vigencia]['riesgoAuto']['aseguradoPersonaJuridica'];

                // If personal_data have more than one array index, then use
                // conductorPersonalData.
                $name = '';
                $lastName = '';
                $documentId = '';
                $docType = '';
                $email = '';
                $address = '';
                $phone = '';

                if (isset($personal_data[0]) && count($personal_data) > 1) {
                  if (isset($polizas[$index_vigencia]['riesgoAuto']['conductorPersonaNatural'][0])) {
                    $conductor_data = $polizas[$index_vigencia]['riesgoAuto']['conductorPersonaNatural'][0] ?? '';
                    $name = isset($conductor_data['primerNombre'])
                    ? $conductor_data['primerNombre'] . ' ' . @$conductor_data['segundoNombre']
                    : '';
                    $lastName = isset($conductor_data['primerApellido'])
                    ? $conductor_data['primerApellido'] . ' ' . @$conductor_data['segundoApellido']
                    : '';
                    $documentId = $conductor_data['numeroDocumento'] ?? '';
                    $docType = isset($conductor_data['tipoDocumento']) && $conductor_data['tipoDocumento']
                    ? $doc_types[$conductor_data['tipoDocumento']['codigo']]
                    : 0;
                    if (isset($conductor_data['email'])) {
                      $email = $conductor_data['email'];
                    }
                    elseif (isset($conductor_data['mail'])) {
                      $email = $conductor_data['mail'];
                    }
                    else {
                      $email = '';
                    }
                    $address = isset($conductor_data['direccion']) ? $conductor_data['direccion']['direccion'] : '';
                    $phone = isset($conductor_data['telefono']) && $conductor_data['telefono']['numero'] != 0
                    ? $conductor_data['telefono']['numero']
                    : '';
                  }
                }
                else {
                  $name = $personal_data['razonSocial'] ?? '';
                  $lastName = ' ';
                  $documentId = $personal_data['numeroDocumento'] ?? '';
                  $docType = isset($personal_data['tipoDocumento']) && $personal_data['tipoDocumento']
                    ? $doc_types[$personal_data['tipoDocumento']['codigo']]
                    : 0;
                  if (isset($personal_data['email'])) {
                    $email = $personal_data['email'];
                  }
                  elseif (isset($personal_data['mail'])) {
                    $email = $personal_data['mail'];
                  }
                  else {
                    $email = '';
                  }
                  $address = isset($personal_data['direccion']) ? $personal_data['direccion']['direccion'] : '';
                  $phone = isset($personal_data['telefono']) && $personal_data['telefono']['numero'] != 0
                  ? $personal_data['telefono']['numero']
                  : '';
                }

                $return['personalInfo'] = [
                  'name' => $name ?? '',
                  'lastname' => $lastName,
                  'documentId' => $documentId ?? '',
                  'docType' => $docType ?? '',
                  'email' => $email ?? '',
                  'address' => $address ?? '',
                  'brand' => isset($polizas[$index_vigencia])
                    ? $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca']
                    : '',
                  'model' => isset($polizas[$index_vigencia])
                    ? $polizas[$index_vigencia]['riesgoAuto']['automovil']['version']
                    : '',
                  'phone' => $phone ?? '',
                ];

              }

              $matches = \explode(' /', $return['personalInfo']['address']);

              foreach ($matches as $item) {
                if (strlen($item) > 2) {
                  $return['personalInfo']['address'] = substr($item, 0, 50);
                }
              }

              $model = $polizas[$index_vigencia]['riesgoAuto']['automovil']['version'];
              $model_actual = date('Y');
              $model_actual = date('Y', strtotime($model_actual . '+ 1 year'));

              $seven_year = date('Y', strtotime($model_actual . '- 7 year'));

              if ($polizas[$index_vigencia]['codigoBroker'] == $config2->get('cod_chevrolet')) {

                if (
                $this->checkInRange($seven_year, $model_actual, $model) &&
                (
                $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'] == "CHEVROLET" ||
                $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'] == "chevrolet"
                )
                ) {

                  $return['GMFChevrolet']['codigoConcesionario'] = $polizas[$index_vigencia]['codigoConcesionario'];
                  $_SESSION['GMFChevrolet'] = $return['GMFChevrolet'];
                }
                else {
                  if (isset($_SESSION['GMFChevrolet'])) {
                    unset($_SESSION['GMFChevrolet']);
                  }
                }
              }
              else {
                if (isset($_SESSION['GMFChevrolet'])) {
                  unset($_SESSION['GMFChevrolet']);
                }
              }
              if (isset($polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'])) {
                $brand = $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'];
                if (strpos($brand, 'GREAT WALL') !== FALSE) {
                  $return['personalInfo']['brand'] = 'GREAT WALL MOTOR';
                }
              }

              return $return;
            }
            else {
              $this->logger->set('consulta_placa', json_encode([
                'resultadoOperacion' => [
                  'date' => date('Y-m-d\TH:i:s'),
                  'message' =>
                  'no hay garantias para la el caso',
                  'estado' => 'no-guarantee',
                ],
              ]), $this->tokenLog);

              return 'no-guarantee';
            }
          }
          else {
            $this->logger->set('consulta_placa', json_encode([
              'resultadoOperacion' => [
                'date' => date('Y-m-d\TH:i:s'),
                'message' => 'fecha de seguro vencida y/o no vigente',
                'estado' => 'not-in-time',
              ],
            ]), $this->tokenLog);
            return 'not-in-time';
          }
        }
        else {
          $this->logger->set('consulta_placa', json_encode([
            'resultadoOperacion' => [
              'date' => date('Y-m-d\TH:i:s'),
              'message' => 'no hay registros para la placa',
              'estado' => 'invalid',
            ],
          ]), $this->tokenLog);
          return 'invalid';
        }
      }
      else {
        $this->logger->set('consulta_placa', json_encode([
          'resultadoOperacion' => [
            'date' => date('Y-m-d\TH:i:s'),
            'message' => 'no hay datos de la placa',
            'estado' => 'no-data',
          ],
        ]), $this->tokenLog);
        return 'no-data';
      }
    }
    catch (\Throwable $th) {
      $this->logger->set('consulta_placa', json_encode([
        'resultadoOperacion' => [
          'date' => date('Y-m-d\TH:i:s'),
          'message' => $th,
          'estado' => 'error',
        ],
      ]), $this->tokenLog);
      $this->drupalLogger->error($th->getMessage());

      return 'error';
    }
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
  private function getConnectionData($item) {
    $config = $this->configFactory->get('liberty_claims.settings');
    $mode = $config->get('mode');
    return $config->get($mode)[$item];
  }

  /**
   * Method to match values from the ymls data.
   *
   * @param string $resource
   *   Resource from the service.
   * @param string $data
   *   Data from the app.
   *
   * @return array
   *   Resource matched.
   */
  private function matchValues($resource, $data) {
    foreach ($resource as $k => $value) {
      if (is_array($value)) {
        $new = $this->matchValues($value, $data);
        $resource[$k] = $new;
      }
      elseif (is_string($value)) {
        if (strpos($value, '_#@') === 0) {
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
   */
  private function plateRequestCompleteData(Request $request, $data, $plate) {
    $data = str_replace('_#@plate', $plate, $data);
    $data = str_replace('_#@date', date('Y-m-d\TH:i:s'), $data);
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
   */
  private function iAxisCompleteData($data, array $source) {
    $lastnameExploded = explode(' ', $source['lastname']);
    $nameExploded = explode(' ', $source['name']);
    $dateExploded = explode(' ', $source['date']);

    $replacements = [
      '_#@_lastname' => $lastnameExploded[0] ?? $source['lastname'],
      '_#@_firstname' => $nameExploded[0] ?? $source['name'],
      '_#@_secondlastname' => $lastnameExploded[1] ?? $source['lastname'],
      '_#@_secondname' => $nameExploded[1] ?? $source['name'],
      '_#@_claimdate' => date('d/m/Y', strtotime($dateExploded[0])),
    ];

    foreach ($replacements as $key => $value) {
      $data = str_replace($key, $value, $data);
    }

    $replacements = [
      '_#@_currentday' => date('d/m/Y'),
      '_#@_time' => date('H:i', strtotime($source['date'])),
      '_#@_city' => (int) substr($source['city'], 2, 3),
      '_#@_provcode' => substr($source['city'], 0, 2),
    ];

    foreach ($replacements as $key => $value) {
      $data = str_replace($key, $value, $data);
    }

    $replacements = [
      '_#@_wherename' => \explode(' ', $source['whereAddress'])[1] ?? $source['whereAddress'],
      '_#@_withMoreInjureddesc' => $source['casualties'] === 'more' ? 'si' : 'no',
      '_#@_withMoreInjuredval' => $source['casualties'] === 'more' ? 1 : 0,
      '_#@_withMoreDeathsdesc' => $source['deaths'] === 'more' ? 'si' : 'no',
      '_#@_withMoreDeathsval' => $source['deaths'] === 'more' ? 1 : 0,
      '_#@_withInjureddesc' => $source['withInjured'] ? 'si' : 'no',
      '_#@_withInjuredval' => $source['withInjured'] ? 1 : 0,
      '_#@_withDeathsdesc' => $source['withDeaths'] ? 'si' : 'no',
      '_#@_withDeathsval' => $source['withDeaths'] ? 1 : 0,
      '_#@_withPolicedesc' => $source['withPolice'] ? 'si' : 'no',
      '_#@_withPoliceval' => $source['withPolice'] ? 1 : 2,
      '_#@_description' => wordwrap($source['description'], 50, "\n\r"),
    ];

    foreach ($replacements as $key => $value) {
      $data = str_replace($key, $value, $data);
    }

    if ($source['damages']) {
      $damages = [];
      $damage_labels = [
        'Sección delantera',
        'Lateral delantero izquierdo',
        'Lateral delantero derecho',
        'Lateral trasero izquierdo',
        'Lateral trasero derecho',
        'Sección posterior',
        'Techo',
        'Por debajo',
      ];

      foreach ($source['damages'] as $key) {
        $damages[] = [
          'numeroRespuestaAPreguntaAsociadaAGarantia' => $key + 1,
          'descripcionRespuestaAPreguntaAsociadaAGarantia' => $damage_labels[$key],
        ];
      }
      $source['_damages'] = $damages;
    }

    $data_to_array = json_decode($data, TRUE);

    if ($source['withInjured'] || $source['withDeaths']) {
      $rc1 = (int) $source['guarantees']['rc1'];
      $withInjured = $source['withInjured'];
      $casualties = $source['casualties'];
      $deaths = $source['deaths'];
      $withDeaths = $source['withDeaths'];

      $condition1 = $withInjured && $casualties === 1 && $deaths !== 'more';
      $condition2 = $withDeaths && $deaths === 1 && $casualties !== 'more';

      if ($rc1 && ($condition1 || $condition2)) {
        $data_to_array['garantias'][] = [
          'codigoGarantia' => $rc1,
        ];
      }
      elseif ((int) $source['guarantees']['rc3']) {
        $data_to_array['garantias'][] = [
          'codigoGarantia' => (int) $source['guarantees']['rc3'],
        ];
      }
    }

    $data_to_array = $this->matchValues($data_to_array, $source);

    if ($source['withInvolved']) {
      $keys = [
        'plateThirdPartyInvolved',
        'plateThirdPartyInvolvedName',
        'plateThirdPartyInvolvedTypeIdentificaction',
        'plateThirdPartyInvolvedIdentificaction',
      ];
      $preguntasExtraGarantia = [];
      foreach ($keys as $index => $key) {
        $questionNumber = 7826 + $index;

        $pregunta = [
          'preguntaAsociadaAGarantia' => [
            'descripcionPregunta' => $index === 0
              ? 'HUBO TERCERO INVOLUCRADO EN EL SINIESTRO'
              : ucwords(str_replace('plateThirdPartyInvolved', '', $key)),
            'numeroPregunta' => $questionNumber,
          ],
          'respuestasAPreguntasAsociadasAGarantia' => [
                [
                  'descripcionRespuestaAPreguntaAsociadaAGarantia' => $source[$key],
                  'numeroRespuestaAPreguntaAsociadaAGarantia' => '0',
                ],
          ],
        ];
        $preguntasExtraGarantia[] = $pregunta;
      }
    }
    else {
      $preguntasExtraGarantia = [];

      $preguntas = [
        "HUBO TERCERO INVOLUCRADO EN EL SINIESTRO",
        "PLACA",
        "NOMBRE TERCER INVOLUCRADO",
        "TIPO IDENTIFICACION TERCERO",
        "NUMERO IDENTIFICACION TERCERO",
      ];

      foreach ($preguntas as $index => $pregunta) {
        $preguntasExtraGarantia[] = [
          "preguntaAsociadaAGarantia" => [
            "descripcionPregunta" => $pregunta,
            "numeroPregunta" => 7825 + $index,
          ],
          "respuestasAPreguntasAsociadasAGarantia" => [
            [
              "descripcionRespuestaAPreguntaAsociadaAGarantia" => "NO",
              "numeroRespuestaAPreguntaAsociadaAGarantia" => "0",
            ],
          ],
        ];
      }
    }

    if ($data_to_array['numeroProducto'] == '900753') {
      foreach ($data_to_array['preguntasAsociadasAGarantia'] as $key => $question) {
        $numeroPregunta = $question['preguntaAsociadaAGarantia']['numeroPregunta'] ?? NULL;

        if ($numeroPregunta == 9096 || $numeroPregunta == 9097) {
          unset($data_to_array['preguntasAsociadasAGarantia'][$key]);
        }
        elseif ($numeroPregunta == 9069 && $source['withInjured'] || $numeroPregunta == 9070 && $source['withDeaths']) {
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
   * @param string $source
   *   Source where check.
   */
  protected function sipoCompleteData($data, $source) {
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

    $matches = [];
    preg_match('/(.*)(?=_#@_description)/i', $data, $matches, PREG_OFFSET_CAPTURE);
    $source['description'] = str_replace("\n", "\n" . $matches[0][0], $source['description']);
    $input = wordwrap($source['description'], 50, "\n" . $matches[0][0]);
    $data = str_replace('_#@_description', $input, $data);

    foreach ($source as $key => $value) {
      if (strpos($data, '_#@' . $key) && is_string($value) || is_int($value)) {
        $data = str_replace('_#@' . $key, $value, $data);
      }
    }

    $replace = preg_replace('/_#@+[a-zA-Z]*/i', '', $data);

    $data = $replace ? $replace : $data;

    return $data;
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
  protected function getExtraData(array $data) {
    $config = $this->configFactory->get('liberty_claims.settings');
    $ramos = Yaml::decode($config->get('policy_ramos'));
    $sipo_ramos = Yaml::decode($config->get('sipo_ramos'));

    $policy = $this->crypt($data['policy'], 'de');
    unset($data['policy']);
    $policy = explode('|', $policy);
    $data['productNumber'] = $policy[0] ?? 0;
    $data['secureNumber'] = $policy[1] ?? 0;
    $data['policyNumber'] = $policy[2] ?? 0;
    $data['ramo'] = array_key_exists((int) $data['productNumber'], $ramos)
            ? $ramos[(int) $data['productNumber']]
            : 0;
    $data['sipoRamo'] = array_key_exists((int) $data['productNumber'], $sipo_ramos)
            ? $sipo_ramos[(int) $data['productNumber']]
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
  private function crypt($string, $action = 'en') {
    $secret_key = 'L!b3rTy';
    $secret_iv = 'Cl41m.';

    $output = FALSE;
    $encrypt_method = 'AES-256-CBC';
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'en') {
      $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    }
    elseif ($action == 'de') {
      $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
  }

  /**
   * Send files.
   *
   * @param string $json
   *   Json data.
   * @param int $sipo_id
   *   SIPO Id.
   */
  public function postFiles(string $json, $sipo_id) {
    if ($sipo_id) {
      $data = json_decode($json);
      $file_path = 'public://claimfiles/' . $data->documentId;
      if (scandir($file_path)) {
        $file_list = array_diff(scandir($file_path), ['..', '.']);

        $body = [];

        foreach ($file_list as $file) {
          $client = new Client([
            'base_uri' => $this->getConnectionData('base_uri'),
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
                      'Content-Type' => 'application/json',
                      'Authorization' =>
                      'Bearer ' . $this->getMainToken(),
                      'cesvi-authorization' => $this->getCesviToken(),
                      'country' => '1',
                    ],
                    'body' => json_encode($body_request),
                  ]
              );

            $body = $response->getBody()->getContents();
            $this->drupalLogger->notice($body);
          }
          catch (\Exception $e) {
            $this->drupalLogger->error($e->getMessage());
          }
        }
      }

      $this->fileSystem->deleteRecursive($file_path);
      return json_encode($body, TRUE);
    }
    else {
      return json_encode(['errorFileUplaod' => 'No sipo_id provided'], TRUE);
    }
  }

  /**
   * Send notificacion Email Error Sipo.
   *
   * @return mixed
   *   Mail rendered.
   */
  public function sendEmailErrorIaxis($data1) {
    $path = \Drupal::request()->getSchemeAndHttpHost();
    $client = new Client(['base_uri' => $path]);

    $response = $client->request('GET', '/claim-data/cities-carshops', [
      'http_errors' => TRUE,
    ]);

    $data_cities = json_decode($response->getBody()->getContents(), TRUE);

    $quetepaso = [
      'CLAIM_TYPE_PPD' => 'Daños en el vehículo a causa de un accidente o evento súbito e imprevisto.',
      'CLAIM_TYPE_PPH' => 'Hurto de cualquier parte o accesorio de su vehículo.',
      'CLAIM_TYPE_PTH' => 'Hurto de su vehículo.',
      'CLAIM_TYPE_AC' => 'Pequeños accesorios.',
      'CLAIM_TYPE_PL' => 'Pérdida de llaves.',
      'CLAIM_TYPE_LR' => 'Llantas estalladas.',
    ];

    $subject = 'Error creación flujo asegurado IAXIS - ' . $data1['plate'];

    $body = "Buen día,
        Al momento de crear el siniestro en IAXIS en el flujo de asegurado hubo un error." .
        " La información relevante para su creación manual es:
        Que te pasó: " . ($quetepaso[$data1['tellus']] ?? 'Tipo de reclamo desconocido') . "
        Fecha y hora: {$data1['date']}
        Siniestro: 0
        Placa: {$data1['plate']}
        Celular: {$data1['driverPhone']}
        Correo: {$data1['email']}
        Descripción de los hechos: {$data1['description']}
        Nombre del conductor: {$data1['driverName']}
        Cédula del conductor: {$data1['driverDocumentId']}
        Teléfono del conductor: {$data1['driverPhone']}
        Nombre declarante: {$data1['personalData']['name']}
        Teléfono declarante: {$data1['phone']}
        Ciudad: " . ($data_cities[$data1['city']] ?? 'Ciudad no encontrada') . "
        Dirección de ocurrencia: {$data1['whereAddress']}
        Taller seleccionado: {$data1['nombre']}";

    $params = [
      'subject2' => $subject,
      'subject' => 'Error radicacion Iaxis',
      'message' => nl2br($body),
    ];

    $config = $this->configFactory->get('liberty_claims_email.settings');
    $module = 'liberty_claims';
    $to = $config->get('email_send');
    $langcode = 'es';
    $send = TRUE;

    $result = $this->mailManager->mail($module, 'send_email', $to, $langcode, $params, NULL, $send);

    return new JsonResponse([
      'result' => $result['result'],
    ]);
  }

  /**
   * Send mail error sipo.
   */
  public function sendEmailErrorSipo($data, $data1) {

    $date = date('d/m/Y');

    $subject = 'Error creación siniestro SIPO - #' . $data['caso']['numeroSiniestroiAxis'];

    $body = "Buen día,
        Al momento de crear el siniestro en SIPO, el flujo de asegurado presentó un error." .
        " La información relevante para su creación manual es:
        Número de caso de Iaxis: {$data['caso']['numeroSiniestroiAxis']}
        Datos del asegurado: {$data['asegurado']['nombre']}
        Placa: {$data['vehiculo']['placa']}
        Taller Escogido:  {$data1}
        Fecha de creación del siniestro: {$date}
        Número Celular: {$data['asegurado']['celular']}
        Correo: {$data['asegurado']['email']}
        Fecha siniestro: {$data['caso']['fechaSiniestro']}
        Enviado desde el portal Liberty Seguros Colombia";

    $params = [
      'subject2' => $subject,
      'subject' => 'Error radicacion Sipo',
      'message' => nl2br($body),
    ];

    $config = $this->configFactory->get('liberty_claims_email.settings');
    $module = 'liberty_claims';
    $to = $config->get('email_send');
    $langcode = 'es';
    $send = TRUE;

    $result = $this->mailManager->mail($module, 'send_email', $to, $langcode, $params, NULL, $send);

    return new JsonResponse([
      'result' => $result['result'],
    ]);
  }

}
