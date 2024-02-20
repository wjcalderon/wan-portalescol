<?php

namespace Drupal\liberty_claims;

<<<<<<< HEAD
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;
use Drupal\Component\Serialization\Yaml;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\oauth2_client\Service\Oauth2ClientServiceInterface;
use GuzzleHttp\Client;
use Drupal\Core\Mail\MailManagerInterface;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\File\FileSystemInterface;
=======
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
>>>>>>> main

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
<<<<<<< HEAD
        MailManagerInterface $mail_manager,
        ConfigFactoryInterface $config_factory,
        Oauth2ClientServiceInterface $oauth2_client_service,
        ModuleHandlerInterface $module_handler,
        CacheBackendInterface $cache,
        LoggerServiceInterface $liberty_logger,
        LoggerChannelFactoryInterface $drupal_logger,
        FileSystemInterface $file_system
=======
    MailManagerInterface $mail_manager,
    ConfigFactoryInterface $config_factory,
    Oauth2ClientServiceInterface $oauth2_client_service,
    ModuleHandlerInterface $module_handler,
    CacheBackendInterface $cache,
    LoggerServiceInterface $liberty_logger,
    LoggerChannelFactoryInterface $drupal_logger,
    FileSystemInterface $file_system
>>>>>>> main
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
<<<<<<< HEAD

    if ($fecha >= $fecha_inicio && $fecha <= $fecha_fin) {
      return TRUE;
    }
    else {
      return FALSE;
    }
=======
    $value = FALSE;

    if ($fecha >= $fecha_inicio && $fecha <= $fecha_fin) {
      $value = TRUE;
    }
    else {
      $value = FALSE;
    }

    return $value;
>>>>>>> main
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
<<<<<<< HEAD
        // $this->drupalLogger->error("hola");
=======
>>>>>>> main
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
<<<<<<< HEAD
    // var_dump($this->getConnectionData('token_uri'));.
=======
>>>>>>> main
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
<<<<<<< HEAD
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
=======
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
>>>>>>> main

          $body = $response->getBody()->getContents();

          $this->logger->setMultiple(
                [
                  'response_iaxis' => $body,
                  'status' => 2,
<<<<<<< HEAD
                ],
                $token
          );
        }
        catch (RequestException $e) {
          if ($e->hasResponse()) {
            $error = (string) $e->getResponse()->getBody();
            $this->drupalLogger->error($error);
            $this->logger->set('response_iaxis', $error, $token);
          }
          $this->sendEmailErrorIaxis($request, $data);
        }

        return json_decode($body, TRUE);
=======
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
>>>>>>> main
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
<<<<<<< HEAD
      // Gets SIPO yml data to creates a JSON request.
      $config = $this->configFactory->get('liberty_claims.settings');
      $data = json_decode($json, TRUE);
=======
      $data['code_request'] = $code;
      $data = json_decode($json, TRUE);
      $config = $this->configFactory->get('liberty_claims.settings');

>>>>>>> main
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
<<<<<<< HEAD
      // @todo Add to data log.
=======

>>>>>>> main
      $request = Yaml::decode($sipo_sample);

      if ($request['vehiculo']['taller'] === NULL) {
        $request['vehiculo']['taller'] = 0;
      }

<<<<<<< HEAD
      $this->logger->set(
            'request_sipo',
            json_encode($request, JSON_UNESCAPED_UNICODE),
            $token
        );
=======
      $brand = $request['vehiculo']['marca'];
      if (strpos($brand, 'GREAT WALL MOTOR') !== FALSE) {
        $request['vehiculo']['marca'] = 'GREAT WALL';
      }

      $this->logger->set('request_sipo', json_encode($request, JSON_UNESCAPED_UNICODE), $token);
>>>>>>> main

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
<<<<<<< HEAD
=======
        unset($_SESSION['GMFChevrolet']);
>>>>>>> main
      }
      catch (RequestException $e) {
        if ($e->hasResponse()) {
          $error = (string) $e->getResponse()->getBody();
          $this->drupalLogger->error($error);
          $this->logger->set('response_sipo', $error, $token);
        }

        $this->sendEmailErrorSipo($request, $data_taller);
<<<<<<< HEAD
=======
        unset($_SESSION['GMFChevrolet']);
>>>>>>> main
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
<<<<<<< HEAD
    // SOAP call consultaspolizas.
=======
>>>>>>> main
    $client = new Client([
      'base_uri' => $this->getConnectionData('base_uri'),
    ]);

<<<<<<< HEAD
    // Gets a config objet of the module.
    $config = $this->configFactory->get('liberty_claims.settings');
    $config2 = $this->configFactory->get('SettingsEmalForm.settings');

    // Generates a XML body from the yml configuration of the policy request.
    $body = $this->plateRequestCompleteData($request, $config->get('policy_request'), strtoupper($plate));
=======
    $config = $this->configFactory->get('liberty_claims.settings');
    $config2 = $this->configFactory->get('liberty_claims_email.settings');

    $body = $this->plateRequestCompleteData($request, $config->get('policy_request'), strtoupper($plate));

>>>>>>> main
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

<<<<<<< HEAD
    $this->logger->set(
          'data',
          json_encode([
            'consultaPolizaRequestDate' => date('Y-m-d\TH:i:s'),
            'consultaPolizaRequest' => $body,
          ]),
          $this->tokenLog
      );

    try {
      $client = new \SoapClient(drupal_get_path('module', 'liberty_claims') . '/data/' . 'consulta_placa.wsdl', $params);
      $client->__setLocation($this->getConnectionData('base_uri') . '/andino/co/policy-servicing/consultaspolizas');
      $response = $client->__soapCall('consultarPolizas', $body);

      // $currentLogData = $this->logger->get('data', $this->tokenLog);
      $this->logger->set(
            'consulta_placa',
            json_encode([
              'consultaPolizaResponseDATA' => [
                'consultaPolizaResponseDate' => date('Y-m-d\TH:i:s'),
                'consultaPolizaResponse' => $response,
              ],
            ]),
            $this->tokenLog
        );

      // If the response has a property "numeroRegistros"
      // it means the plate has a policy.
      if ($response &&\property_exists($response, 'numeroRegistros') &&property_exists($response, 'polizas')) {
        $product = $response->polizas->codigoProducto;
=======
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
>>>>>>> main
        $ramo_by_product = Yaml::decode($config->get('policy_ramos'));

        if (isset($ramo_by_product[$product])) {
          $ramo = $ramo_by_product[$product];
          $ramos_enable = $config->get('ramo_' . $ramo);
<<<<<<< HEAD

=======
>>>>>>> main
          if (isset($ramos_enable[$type]) &&$ramos_enable[$type] === 0) {
            return 'error';
          }
        }

        if ($response->numeroRegistros) {
<<<<<<< HEAD
          $policy_start_date = strtotime($response->polizas->fechaExpedicion);
          $policy_end_date = strtotime($response->polizas->fechaCartera);
          $date = strtotime($date);

          if ($policy_start_date <= $date &&$date <= $policy_end_date) {
            $codes = Yaml::decode($config->get('insured_codes'));
            $return = [];

            foreach ($response->polizas->riesgoAuto->garantiasPoliza as $item) {
              if ($item->codigoGarantia == $codes[$type] || (is_array($codes[$type]) &&in_array($item->codigoGarantia, $codes[$type]))) {
                // This creates a token with data gets from plate Service.
                $data = $response->polizas->codigoProducto . '|' . $response->polizas->numeroInternoSeguro . '|' . $response->polizas->numeroPoliza;
                $return['token'] = $this->crypt($data, 'en');
                $brokers = Yaml::decode($config->get('brokers'));
                if (is_array($brokers) &&in_array($response->polizas->codigoBroker, $brokers)) {
                  $return['broker'] = TRUE;
                }
              }
              elseif ($item->codigoGarantia == 756 ||$item->codigoGarantia == 9036
              ) {
                $return['guarantees']['rc1'] = $item->codigoGarantia;
              }
              elseif ($item->codigoGarantia == 757 ||$item->codigoGarantia == 9037) {
                $return['guarantees']['rc3'] = $item->codigoGarantia;
=======

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
>>>>>>> main
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
<<<<<<< HEAD

              if (isset($response->polizas->riesgoAuto->aseguradoPersonaNatural)) {
                $personal_data = $response->polizas->riesgoAuto->aseguradoPersonaNatural;
                $personal_data = is_array($personal_data) ? $personal_data[0] : $personal_data;
                $return['personalInfo'] = [
                  'name' => isset($personal_data->primerNombre) ? $personal_data->primerNombre . ' ' . @$personal_data->segundoNombre : '',
                  'lastname' => isset($personal_data->primerApellido) ? $personal_data->primerApellido . ' ' . $personal_data->segundoApellido : '',
                  'documentId' => $personal_data->numeroDocumento ?? '',
                  'docType' => isset($personal_data->tipoDocumento) &&$personal_data->tipoDocumento ? $doc_types[$personal_data->tipoDocumento->codigo] : 0,
                  'email' => $personal_data->email ?? '',
                  'address' => isset($personal_data->direccion) ? $personal_data->direccion->direccion : '',
                  'brand' => isset($response->polizas) ? $response->polizas->riesgoAuto->automovil->marca : '',
                  'model' => isset($response->polizas) ? $response->polizas->riesgoAuto->automovil->version : '',
                ];

                if (isset($personal_data->telefono) &&$personal_data->telefono->numero != 0) {
                  $return['personalInfo']['phone'] = $personal_data->telefono->numero;
=======
              if (isset($polizas[$index_vigencia]['riesgoAuto']['aseguradoPersonaNatural'])) {
                $personal_data = $polizas[$index_vigencia]['riesgoAuto']['aseguradoPersonaNatural'];
                // If personal_data have more than one, then use
                // conductorPersonalData for name and lastname.
                $name = '';
                $lastname = '';
                if (count($personal_data) > 1) {
                  if (isset($polizas[$index_vigencia]['riesgoAuto']['conductorPersonaNatural'][0])) {
                    $conductor_data = $polizas[$index_vigencia]['riesgoAuto']['conductorPersonaNatural'][0] ?? '';
                    $name = isset($conductor_data['primerNombre'])
                    ? $conductor_data['primerNombre'] . ' ' . @$conductor_data['segundoNombre']
                    : '';
                    $lastname = isset($conductor_data['primerApellido'])
                    ? $conductor_data['primerApellido'] . ' ' . @$conductor_data['segundoApellido']
                    : '';
                  }
                }
                else {
                  $name = isset($personal_data['primerNombre'])
                    ? $personal_data['primerNombre'] . ' ' . @$personal_data['segundoNombre']
                    : '';
                  $lastname = isset($personal_data['primerApellido'])
                  ? $personal_data['primerApellido'] . ' ' . $personal_data['segundoApellido']
                  : '';
                }
                $return['personalInfo'] = [
                  'name' => $name,
                  'lastname' => $lastname,
                  'documentId' => $personal_data['numeroDocumento'] ?? '',
                  'docType' => isset($personal_data['tipoDocumento']) && $personal_data['tipoDocumento']
                    ? $doc_types[$personal_data['tipoDocumento']['codigo']]
                    : 0,

                  'email' => $personal_data['email'] ?? '',
                  'address' => isset($personal_data['direccion']) ? $personal_data['direccion']['direccion'] : '',

                  'brand' => isset($polizas[$index_vigencia])
                    ? $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca']
                    : '',

                  'model' => isset($polizas[$index_vigencia])
                    ? $polizas[$index_vigencia]['riesgoAuto']['automovil']['version']
                    : '',
                ];

                if (isset($personal_data['telefono']) && $personal_data['telefono']['numero'] != 0) {
                  $return['personalInfo']['phone'] = $personal_data['telefono']['numero'];
>>>>>>> main
                }
                else {
                  $return['personalInfo']['phone'] = '';
                }
<<<<<<< HEAD
              }
              elseif (isset($response->polizas->riesgoAuto->aseguradoPersonaJuridica)) {
                $personal_data = $response->polizas->riesgoAuto->aseguradoPersonaJuridica;
                $return['personalInfo'] = [
                  'name' => $personal_data->razonSocial ?? '',
                  'lastname' => ' ',
                  'documentId' => $personal_data->numeroDocumento ?? '',
                  'docType' =>
                  isset($personal_data->tipoDocumento) &&
                  $personal_data->tipoDocumento ? $doc_types[$personal_data->tipoDocumento->codigo] : 0,
                  'address' => isset($personal_data->direccion) ? $personal_data->direccion->direccion : '',
                  'brand' => isset($response->polizas) ? $response->polizas->riesgoAuto->automovil->marca : '',
                  'model' => isset($response->polizas) ? $response->polizas->riesgoAuto->automovil->version : '',
                ];
              }

              $matches = \explode(
                ' /',
                $return['personalInfo']['address']
              );

              foreach ($matches as $item) {
                if (strlen($item) > 2) {
                  $return['personalInfo']['address'] = substr(
                  $item,
                  0,
                  50
                  );
                }
              }

              $model =
                                  $response->polizas->riesgoAuto->automovil
                                    ->version;

              $model_actual = date('Y');
              $model_actual = date(
                'Y',
                strtotime($model_actual . '+ 1 year')
              );

              $seven_year = date(
                'Y',
                strtotime($model_actual . '- 7 year')
              );

              if ($response->polizas->codigoBroker == $config2->get('cod_chevrolet')) {

                if ($this->checkInRange($seven_year, $model_actual, $model) && ($response->polizas->riesgoAuto->automovil->marca == "CHEVROLET" || $response->polizas->riesgoAuto->automovil->marca == "chevrolet")) {
                  $return['GMFChevrolet']['codigoConcesionario'] = $response->polizas->codigoConcesionario;
=======

              }
              elseif (isset($polizas[$index_vigencia]['riesgoAuto']['aseguradoPersonaJuridica'])) {
                $personal_data = $polizas[$index_vigencia]['riesgoAuto']['aseguradoPersonaJuridica'];

                $return['personalInfo'] = [
                  'name' => $personal_data['razonSocial'] ?? '',
                  'lastname' => ' ',
                  'documentId' => $personal_data['numeroDocumento'] ?? '',
                  'docType' =>
                  isset($personal_data['tipoDocumento']) &&
                  $personal_data['tipoDocumento'] ? $doc_types[$personal_data['tipoDocumento']['codigo']] : 0,
                  'address' => isset($personal_data['direccion']) ? $personal_data['direccion']['direccion'] : '',
                  'brand' => isset($polizas[$index_vigencia])
                    ? $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca']
                    : '',
                  'model' => isset($polizas[$index_vigencia])
                    ? $polizas[$index_vigencia]['riesgoAuto']['automovil']['version']
                    : '',
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
>>>>>>> main
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
<<<<<<< HEAD
              if (
                    isset(
                        $response->polizas->riesgoAuto->automovil
                          ->marca
                    )
                ) {
                $brand = $response->polizas->riesgoAuto->automovil
                  ->marca;
=======
              if (isset($polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'])) {
                $brand = $polizas[$index_vigencia]['riesgoAuto']['automovil']['marca'];
>>>>>>> main
                if (strpos($brand, 'GREAT WALL') !== FALSE) {
                  $return['personalInfo']['brand'] = 'GREAT WALL MOTOR';
                }
              }

              return $return;
            }
            else {
<<<<<<< HEAD
              $this->logger->set(
                'consulta_placa',
                json_encode([
                  'resultadoOperacion' => [
                    'date' => date('Y-m-d\TH:i:s'),
                    'message' =>
                    'no hay garantias para la el caso',
                    'estado' => 'no-guarantee',
                  ],
                ]),
                $this->tokenLog
              );
=======
              $this->logger->set('consulta_placa', json_encode([
                'resultadoOperacion' => [
                  'date' => date('Y-m-d\TH:i:s'),
                  'message' =>
                  'no hay garantias para la el caso',
                  'estado' => 'no-guarantee',
                ],
              ]), $this->tokenLog);
>>>>>>> main

              return 'no-guarantee';
            }
          }
          else {
<<<<<<< HEAD
            $this->logger->set(
            'consulta_placa',
            json_encode([
              'resultadoOperacion' => [
                'date' => date('Y-m-d\TH:i:s'),
                'message' => 'fecha de seguro vencida',
                'estado' => 'not-in-time',
              ],
            ]),
            $this->tokenLog
            );
=======
            $this->logger->set('consulta_placa', json_encode([
              'resultadoOperacion' => [
                'date' => date('Y-m-d\TH:i:s'),
                'message' => 'fecha de seguro vencida y/o no vigente',
                'estado' => 'not-in-time',
              ],
            ]), $this->tokenLog);
>>>>>>> main
            return 'not-in-time';
          }
        }
        else {
<<<<<<< HEAD
          $this->logger->set(
            'consulta_placa',
            json_encode([
              'resultadoOperacion' => [
                'date' => date('Y-m-d\TH:i:s'),
                'message' => 'no hay registros para la placa',
                'estado' => 'invalid',
              ],
            ]),
            $this->tokenLog
                );
=======
          $this->logger->set('consulta_placa', json_encode([
            'resultadoOperacion' => [
              'date' => date('Y-m-d\TH:i:s'),
              'message' => 'no hay registros para la placa',
              'estado' => 'invalid',
            ],
          ]), $this->tokenLog);
>>>>>>> main
          return 'invalid';
        }
      }
      else {
<<<<<<< HEAD
        $this->logger->set(
          'consulta_placa',
          json_encode([
            'resultadoOperacion' => [
              'date' => date('Y-m-d\TH:i:s'),
              'message' => 'no hay datos de la placa',
              'estado' => 'no-data',
            ],
          ]),
          $this->tokenLog
            );
=======
        $this->logger->set('consulta_placa', json_encode([
          'resultadoOperacion' => [
            'date' => date('Y-m-d\TH:i:s'),
            'message' => 'no hay datos de la placa',
            'estado' => 'no-data',
          ],
        ]), $this->tokenLog);
>>>>>>> main
        return 'no-data';
      }
    }
    catch (\Throwable $th) {
<<<<<<< HEAD
      $this->logger->set(
            'consulta_placa',
            json_encode([
              'resultadoOperacion' => [
                'date' => date('Y-m-d\TH:i:s'),
                'message' => $th,
                'estado' => 'error',
              ],
            ]),
            $this->tokenLog
            );
=======
      $this->logger->set('consulta_placa', json_encode([
        'resultadoOperacion' => [
          'date' => date('Y-m-d\TH:i:s'),
          'message' => $th,
          'estado' => 'error',
        ],
      ]), $this->tokenLog);
>>>>>>> main
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
<<<<<<< HEAD
      else {
=======
      elseif (is_string($value)) {
>>>>>>> main
        if (strpos($value, '_#@') === 0) {
          $input = str_replace('_#@', '', $value);
          if (isset($data[$input])) {
            $resource[$k] = $data[$input];
          }
        }
      }
    }
<<<<<<< HEAD

=======
>>>>>>> main
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
<<<<<<< HEAD
    // Replacing _#@_lastname Token.
    $splite = \explode(' ', $source['lastname']);
    $input = $splite[0] ?? $source['lastname'];
    $data = str_replace('_#@_lastname', $input, $data);

    // Replacing _#@_firstname Token.
    $splite = \explode(' ', $source['name']);
    $input = $splite[0] ?? $source['name'];
    $data = str_replace('_#@_firstname', $input, $data);

    // Replacing _#@_secondlastname Token.
    $splite = \explode(' ', $source['lastname']);
    $input = $splite[1] ?? $source['lastname'];
    $data = str_replace('_#@_secondlastname', $input, $data);

    // Replacing _#@_secondname Token.
    $splite = \explode(' ', $source['name']);
    $input = $splite[1] ?? $source['lastname'];
    $data = str_replace('_#@_secondname', $input, $data);

    // Replacing _#@_claimdate Token.
    $date = \explode(' ', $source['date']);
    $data = str_replace(
          '_#@_claimdate',
          date('d/m/Y', strtotime($date[0])),
          $data
      );

    // Replacing _#@_currentday Token.
    $data = str_replace('_#@_currentday', date('d/m/Y'), $data);

    // Replacing _#@_time Token.
    $date = strtotime($source['date']);
    $data = str_replace('_#@_time', date('H:i', $date), $data);

    // Replacing _#@_city Token.
    $data = str_replace(
          '_#@_city',
          (int) substr($source['city'], 2, 3),
          $data
      );

    // Replacing _#@_provcode Token.
    $data = str_replace(
          '_#@_provcode',
          substr($source['city'], 0, 2),
          $data
      );

    // Replacing _#@_wherename Token.
    $splite = \explode(' ', $source['whereAddress']);
    $input = $splite[1] ?? $source['whereAddress'];
    $data = str_replace('_#@_wherename', $input, $data);

    // Replacing _#@_withInjureddesc Token.
    $data = str_replace(
          '_#@_withMoreInjureddesc',
          (string) $source['casualties'] === 'more' ? 'si' : 'no',
          $data
      );

    // Replacing _#@_withInjuredval Token.
    $data = str_replace(
          '_#@_withMoreInjuredval',
          $source['casualties'] === 'more' ? 1 : 0,
          $data
      );

    // Replacing _#@_withDeathsdesc Token.
    $data = str_replace(
          '_#@_withMoreDeathsdesc',
          $source['deaths'] === 'more' ? 'si' : 'no',
          $data
      );

    // Replacing _#@_withDeathsval Token.
    $data = str_replace(
          '_#@_withMoreDeathsval',
          $source['deaths'] === 'more' ? 1 : 0,
          $data
      );

    // Replacing _#@_withInjureddesc Token.
    $data = str_replace(
          '_#@_withInjureddesc',
          $source['withInjured'] ? 'si' : 'no',
          $data
      );

    // Replacing _#@_withInjuredval Token.
    $data = str_replace(
          '_#@_withInjuredval',
          $source['withInjured'] ? 1 : 0,
          $data
      );

    // Replacing _#@_withDeathsdesc Token.
    $data = str_replace(
          '_#@_withDeathsdesc',
          $source['withDeaths'] ? 'si' : 'no',
          $data
      );

    // Replacing _#@_withDeathsval Token.
    $data = str_replace(
          '_#@_withDeathsval',
          $source['withDeaths'] ? 1 : 0,
          $data
      );

    // Replacing _#@_withPolicedesc Token.
    $data = str_replace(
          '_#@_withPolicedesc',
          $source['withPolice'] ? 'si' : 'no',
          $data
      );

    // Replacing _#@_withPoliceval Token.
    $data = str_replace(
          '_#@_withPoliceval',
          $source['withPolice'] ? 1 : 2,
          $data
      );

    // Replacing _#@description Token.
    $input = wordwrap($source['description'], 50, "\n\r");
    $data = str_replace('_#@_description', $input, $data);

    // Replacing _#@_damages Token.
=======
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

>>>>>>> main
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
<<<<<<< HEAD
          'descripcionRespuestaAPreguntaAsociadaAGarantia' =>
          $damage_labels[$key],
        ];
      }

=======
          'descripcionRespuestaAPreguntaAsociadaAGarantia' => $damage_labels[$key],
        ];
      }
>>>>>>> main
      $source['_damages'] = $damages;
    }

    $data_to_array = json_decode($data, TRUE);

    if ($source['withInjured'] || $source['withDeaths']) {
<<<<<<< HEAD
      if (
            (int) $source['guarantees']['rc1'] &&
            (($source['withInjured'] &&
                $source['casualties'] === 1 &&
                $source['deaths'] !== 'more') ||
                ($source['withDeaths'] &&
                    $source['deaths'] === 1 &&
                    $source['casualties'] !== 'more'))
        ) {
        $data_to_array['garantias'][] = [
          'codigoGarantia' => (int) $source['guarantees']['rc1'],
=======
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
>>>>>>> main
        ];
      }
      elseif ((int) $source['guarantees']['rc3']) {
        $data_to_array['garantias'][] = [
          'codigoGarantia' => (int) $source['guarantees']['rc3'],
        ];
      }
    }

    $data_to_array = $this->matchValues($data_to_array, $source);

<<<<<<< HEAD
    if ($data_to_array['numeroProducto'] == '900753') {
      foreach ($data_to_array['preguntasAsociadasAGarantia'] as $key => $question) {
        if (
              isset(
                  $question['preguntaAsociadaAGarantia']['numeroPregunta']
              ) &&
              $question['preguntaAsociadaAGarantia']['numeroPregunta'] ==
                  9096
          ) {
          unset($data_to_array['preguntasAsociadasAGarantia'][$key]);
        }
        elseif (
              isset(
                  $question['preguntaAsociadaAGarantia']['numeroPregunta']
              ) &&
              $question['preguntaAsociadaAGarantia']['numeroPregunta'] ==
                  9097
          ) {
          unset($data_to_array['preguntasAsociadasAGarantia'][$key]);
        }
        elseif (
              isset(
                  $question['preguntaAsociadaAGarantia']['numeroPregunta']
              ) &&
              $question['preguntaAsociadaAGarantia']['numeroPregunta'] ==
                  9069 &&
              $source['withInjured']
          ) {
          $data_to_array['preguntasAsociadasAGarantia'][$key]['respuestasAPreguntasAsociadasAGarantia'][0] = [
            'descripcionRespuestaAPreguntaAsociadaAGarantia' =>
            'si',
            'numeroRespuestaAPreguntaAsociadaAGarantia' => '1',
          ];
        }
        elseif (
              isset(
                  $question['preguntaAsociadaAGarantia']['numeroPregunta']
              ) &&
              $question['preguntaAsociadaAGarantia']['numeroPregunta'] ==
                  9070 &&
              $source['withDeaths']
          ) {
          $data_to_array['preguntasAsociadasAGarantia'][$key]['respuestasAPreguntasAsociadasAGarantia'][0] = [
            'descripcionRespuestaAPreguntaAsociadaAGarantia' =>
            'si',
=======
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
>>>>>>> main
            'numeroRespuestaAPreguntaAsociadaAGarantia' => '1',
          ];
        }
      }
    }
<<<<<<< HEAD
    // Normalize the array.
=======

>>>>>>> main
    $data_to_array['preguntasAsociadasAGarantia'] = array_values(
          $data_to_array['preguntasAsociadasAGarantia']
      );

<<<<<<< HEAD
=======
    $data_to_array['preguntasAsociadasAGarantia'] = array_merge(
      $data_to_array['preguntasAsociadasAGarantia'],
      $preguntasExtraGarantia
    );
>>>>>>> main
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

<<<<<<< HEAD
    if (
          $source['tellus'] == 'THIRD_PARTY' ||
          $source['tellus'] == 'CLAIM_TYPE_PTH'
      ) {
      $carshops_by_city = Yaml::decode(
            $config->get('third_party_cities_carshops')
        );
      $city = array_search(
            $source['city'],
            array_combine(
                array_keys($carshops_by_city),
                array_column($carshops_by_city, 'COD')
            )
        );

      $index = $source['tellus'] == 'THIRD_PARTY' ? 'RCDBT' : 'PTH';

      $data = str_replace(
            '_#@codTaller',
            $carshops_by_city[$city][$index],
            $data
        );
    }

    // Replacing _#@_dateISO Token.
=======
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

>>>>>>> main
    $date = strtotime($source['date']);
    $input = date('Y-m-d\TH:i:s.\Z', $date);
    $data = str_replace('_#@_dateISO', $input, $data);

<<<<<<< HEAD
    // Replacing _#@_vehicleType Token.
    $input = substr($source['vehicleType'], 0, 1);
    $data = str_replace('_#@_vehicleType', $input, $data);

    // Replacing _#@_form Token.
    $input = $source['tellus'] != 'THIRD_PARTY' ? 'Asegurado' : 'Tercero';
    $data = str_replace('_#@_form', $input, $data);

    // Replacing _#@_type Token.
=======
    $input = substr($source['vehicleType'], 0, 1);
    $data = str_replace('_#@_vehicleType', $input, $data);

    $input = $source['tellus'] != 'THIRD_PARTY' ? 'Asegurado' : 'Tercero';
    $data = str_replace('_#@_form', $input, $data);

>>>>>>> main
    $input = array_key_exists($source['tellus'], $protections)
            ? $protections[$source['tellus']]
            : '';
    $data = str_replace('_#@_type', $input, $data);

<<<<<<< HEAD
    // Replacing _#@_city Token.
    $input = substr($source['city'], 2, 3);
    $data = str_replace('_#@_city', $input, $data);

    // Replacing _#@_provcode Token.
    $input = substr($source['city'], 0, 2);
    $data = str_replace('_#@_provcode', $input, $data);

    // Replacing _#@_currentDateISO Token.
    $input = date('Y-m-d\TH:i:s.\Z', time());
    $data = str_replace('_#@_currentDateISO', $input, $data);

    // Replacing _#@_description Token.
    $matches = [];
    preg_match(
          '/(?>)(.*)(?=_#@_description)/i',
          $data,
          $matches,
          PREG_OFFSET_CAPTURE
      );
    $source['description'] = str_replace(
          "\n",
          "\n" . $matches[0][0],
          $source['description']
      );
=======
    $input = substr($source['city'], 2, 3);
    $data = str_replace('_#@_city', $input, $data);

    $input = substr($source['city'], 0, 2);
    $data = str_replace('_#@_provcode', $input, $data);

    $input = date('Y-m-d\TH:i:s.\Z', time());
    $data = str_replace('_#@_currentDateISO', $input, $data);

    $matches = [];
    preg_match('/(.*)(?=_#@_description)/i', $data, $matches, PREG_OFFSET_CAPTURE);
    $source['description'] = str_replace("\n", "\n" . $matches[0][0], $source['description']);
>>>>>>> main
    $input = wordwrap($source['description'], 50, "\n" . $matches[0][0]);
    $data = str_replace('_#@_description', $input, $data);

    foreach ($source as $key => $value) {
<<<<<<< HEAD
      if (strpos($data, '_#@' . $key)) {
        if (is_string($value) || is_int($value)) {
          $data = str_replace('_#@' . $key, $value, $data);
        }
      }
    }

    $replace = preg_replace('/_#@[a-zA-Z]*/i', '', $data);
=======
      if (strpos($data, '_#@' . $key) && is_string($value) || is_int($value)) {
        $data = str_replace('_#@' . $key, $value, $data);
      }
    }

    $replace = preg_replace('/_#@+[a-zA-Z]*/i', '', $data);

>>>>>>> main
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

<<<<<<< HEAD
    // Decrypt policy data from the request.
=======
>>>>>>> main
    $policy = $this->crypt($data['policy'], 'de');
    unset($data['policy']);
    $policy = explode('|', $policy);
    $data['productNumber'] = $policy[0] ?? 0;
    $data['secureNumber'] = $policy[1] ?? 0;
    $data['policyNumber'] = $policy[2] ?? 0;
    $data['ramo'] = array_key_exists((int) $data['productNumber'], $ramos)
            ? $ramos[(int) $data['productNumber']]
            : 0;
<<<<<<< HEAD
    $data['sipoRamo'] = array_key_exists(
          (int) $data['productNumber'],
          $sipo_ramos
      )
            ? $sipo_ramos[(int) $data['productNumber']]
            : 0;

=======
    $data['sipoRamo'] = array_key_exists((int) $data['productNumber'], $sipo_ramos)
            ? $sipo_ramos[(int) $data['productNumber']]
            : 0;
>>>>>>> main
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
<<<<<<< HEAD
      $output = base64_encode(
            openssl_encrypt($string, $encrypt_method, $key, 0, $iv)
        );
    }
    elseif ($action == 'de') {
      $output = openssl_decrypt(
            base64_decode($string),
            $encrypt_method,
            $key,
            0,
            $iv
            );
=======
      $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    }
    elseif ($action == 'de') {
      $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
>>>>>>> main
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
<<<<<<< HEAD
            'Archivo' => \base64_encode(
                    \file_get_contents($file_path . '/' . $file)
            ),
=======
            'Archivo' => \base64_encode(\file_get_contents($file_path . '/' . $file)),
>>>>>>> main
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

<<<<<<< HEAD
      // Delete the complete folder.
=======
>>>>>>> main
      $this->fileSystem->deleteRecursive($file_path);
      return json_encode($body, TRUE);
    }
    else {
<<<<<<< HEAD
      return json_encode(
            ['errorFileUplaod' => 'No sipo_id provided'],
            TRUE
            );
=======
      return json_encode(['errorFileUplaod' => 'No sipo_id provided'], TRUE);
>>>>>>> main
    }
  }

  /**
   * Send notificacion Email Error Sipo.
   *
   * @return mixed
   *   Mail rendered.
   */
<<<<<<< HEAD
  public function sendEmailErrorIaxis($data, $data1) {

    $path = \Drupal::request()->getSchemeAndHttpHost();

    $client = new Client(['base_uri' => $path]);

    $body = NULL;

=======
  public function sendEmailErrorIaxis($data1) {
    $path = \Drupal::request()->getSchemeAndHttpHost();
    $client = new Client(['base_uri' => $path]);

>>>>>>> main
    $response = $client->request('GET', '/claim-data/cities-carshops', [
      'http_errors' => TRUE,
    ]);

<<<<<<< HEAD
    $data_cities = $response->getBody()->getContents();
    $data_cities = json_decode($data_cities, TRUE);
    foreach ($data_cities as $key => $data_city) {
      if ($key == $data1['city']) {
        $value_city = $data_city;
      }
    }

    if ($data1['tellus'] == 'CLAIM_TYPE_PPD') {
      $quetepaso =
                'Daños en el vehículo a causa de un accidente o evento súbito e imprevisto.';
    }
    elseif ($data1['tellus'] == 'CLAIM_TYPE_PPH') {
      $quetepaso = 'Hurto de cualquier parte o accesorio de su vehículo.';
    }
    elseif ($data1['tellus'] == 'CLAIM_TYPE_PTH') {
      $quetepaso = 'Hurto de su vehículo.';
    }
    elseif ($data1['tellus'] == 'CLAIM_TYPE_AC') {
      $quetepaso = 'Pequeños accesorios.';
    }
    elseif ($data1['tellus'] == 'CLAIM_TYPE_PL') {
      $quetepaso = 'Perdida de llaves.';
    }
    elseif ($data1['tellus'] == 'CLAIM_TYPE_LR') {
      $quetepaso = 'Llantas estalladas.';
    }

    $params['subject2'] =
            'Error creación flujo asegurado IAXIS - ' . $data1['plate'];
    $params['subject'] = 'Error radicacion Iaxis';

    $body =
            "Buen día,

        Al momento de crear el siniestro en IAXIS en el flujo  de asegurado  hubo un error, la información relevante para su creación manual es:

        Que te paso:  " .
            $quetepaso .
            "
        Fecha y hora: " .
            $data1['date'] .
            "
        Siniestro: 0
        Placa: " .
            $data1['plate'] .
            "
        Celular: " .
            $data1['driverPhone'] .
            "
        Correo: " .
            $data1['email'] .
            "
        Descripcion de los hechos: " .
            $data1['description'] .
            "
        Nombre del conductor: " .
            $data1['driverName'] .
            "
        Cedula del conductor: " .
            $data1['driverDocumentId'] .
            "
        Telefono del conductor: " .
            $data1['driverPhone'] .
            "
        Nombre declarante: " .
            $data1['personalData']['name'] .
            "
        Telefono declarante: " .
            $data1['phone'] .
            "
        ciudad: " .
            $value_city .
            "
        dirreccion ocurrencia: " .
            $data1['whereAddress'] .
            "
        Taller seleccionado: " .
            $data1['nombre'] .
            "
        ";
    $params['message'] = nl2br($body);

    $config = $this->configFactory->get('SettingsEmalForm.settings');

=======
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
>>>>>>> main
    $module = 'liberty_claims';
    $to = $config->get('email_send');
    $langcode = 'es';
    $send = TRUE;
<<<<<<< HEAD
    $result = $this->mailManager->mail(
          $module,
          'send_email',
          $to,
          $langcode,
          $params,
          NULL,
          $send
      );
=======

    $result = $this->mailManager->mail($module, 'send_email', $to, $langcode, $params, NULL, $send);
>>>>>>> main

    return new JsonResponse([
      'result' => $result['result'],
    ]);
  }

  /**
   * Send mail error sipo.
   */
  public function sendEmailErrorSipo($data, $data1) {
<<<<<<< HEAD
    // dump($data);
    $date = date('d/m/Y');
    $params['subject'] = 'Error radicacion Sipo';
    $params['subject2'] =
            'Error creación siniestro SIPO - #' .
            $data['caso']['numeroSiniestroiAxis'];
    $body =
            'Buen dia,

        Al momento de crear el siniestro  en sipo  el flujo de asegurado hubo un error, la información relevante para su creación manual es:

        Numero de caso  de iaxis: ' .
            $data['caso']['numeroSiniestroiAxis'] .
            '
        Datos del asegurado: ' .
            $data['asegurado']['nombre'] .
            '
        Placa: ' .
            $data['vehiculo']['placa'] .
            '
        Taller Escogido:  ' .
            $data1 .
            '
        Fecha  de la creación del siniestro: ' .
            $date .
            '
        Numero Celular: ' .
            $data['asegurado']['celular'] .
            '
        Correo: ' .
            $data['asegurado']['email'] .
            '
        Fecha siniestro: ' .
            $data['caso']['fechaSiniestro'] .
            '

        Enviado desde el portal Liberty Seguros Colombia';

    $params['message'] = nl2br($body);

    $config = $this->configFactory->get('SettingsEmalForm.settings');
    $module = 'liberty_claims';
    $to = $config->get('email_send');

    $langcode = 'es';
    $send = TRUE;
    $result = $this->mailManager->mail(
          $module,
          'send_email',
          $to,
          $langcode,
          $params,
          NULL,
          $send
      );
=======

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
>>>>>>> main

    return new JsonResponse([
      'result' => $result['result'],
    ]);
  }

}
