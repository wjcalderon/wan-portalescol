<?php

namespace Drupal\liberty_claims\Controller;

use Drupal\Component\Serialization\Yaml;
use Drupal\Core\Cache\CacheableJsonResponse;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\file\Entity\File;
use Drupal\liberty_claims\ClaimServices;
use Drupal\liberty_claims\LoggerServiceInterface;
use Drupal\liberty_claims\Service\LibertyClaimsLogManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Drupal\file\FileRepositoryInterface;
use Drupal\Core\File\FileExists;

/**
 * Claim Notification Controller.
 */
class ClaimNotificationController extends ControllerBase {

  /**
   * El servicio de gestión de logs.
   *
   * @var \Drupal\liberty_claims\Service\LibertyClaimsLogManager
   */
  protected $libertyClaimsLogManager;

  /**
   * The mail manager.
   *
   * @var \Drupal\Core\Mail\MailManagerInterface
   */
  protected $mailManager;

  /**
   * Drupal\Core\Extension\ModuleHandlerInterface definition.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Drupal\Core\Config\ConfigFactory definition.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * Symfony\Component\HttpFoundation\Session\Session definition.
   *
   * @var \Symfony\Component\HttpFoundation\Session\Session
   */
  protected $currentSession;

  /**
   * Drupal\liberty_claims\ClaimServices definition.
   *
   * @var \Drupal\liberty_claims\ClaimServices
   */
  protected $claimService;

  /**
   * Drupal\Core\File\FileSystemInterface definition.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * Drupal\liberty_claims\LoggerServiceInterface definition.
   *
   * @var \Drupal\liberty_claims\LoggerServiceInterface
   */
  protected $logger;

  /**
   * Drupal\Core\Entity\EntityTypeManager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * Drupal\file\FileRepositoryInterface definition.
   *
   * @var \Drupal\file\FileRepositoryInterface
   */
  protected $fileInterface;

  /**
   * Constructs a new SettingsForm object.
   */
  public function __construct(
    LibertyClaimsLogManager $liberty_claims_log_manager,
    MailManagerInterface $mail_manager,
    ModuleHandlerInterface $module_handler,
    ConfigFactory $config_factory,
    Session $session,
    ClaimServices $claim_services,
    FileSystemInterface $file_system,
    LoggerServiceInterface $liberty_logger,
    EntityTypeManager $entity_type_manager,
    FileRepositoryInterface $file_interface
    ) {
    $this->libertyClaimsLogManager = $liberty_claims_log_manager;
    $this->mailManager = $mail_manager;
    $this->moduleHandler = $module_handler;
    $this->configFactory = $config_factory;
    $this->currentSession = $session;
    $this->claimService = $claim_services;
    $this->fileSystem = $file_system;
    $this->logger = $liberty_logger;
    $this->entityTypeManager = $entity_type_manager;
    $this->fileInterface = $file_interface;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('liberty_claims.log_manager'),
      $container->get('plugin.manager.mail'),
      $container->get('module_handler'),
      $container->get('config.factory'),
      $container->get('session'),
      $container->get('claims.services'),
      $container->get('file_system'),
      $container->get('liberty.logger'),
      $container->get('entity_type.manager'),
      $container->get('file.repository'),
    );
  }

  /**
   * Claim.
   *
   * @return string
   *   Return Wrapper for a Vue App.
   */
  public function claim() {
    $config = $this->configFactory->get('liberty_claims.settings');
    $token = $this->currentSession->getId();

    return [
      '#type' => 'markup',
      '#markup' => '<h1 class="title-prin">Avisa de tu siniestro</h1>
      <p class="lead-prin">Aquí podrás realizar el aviso de tu siniestro en tres simples pasos.</p>
      <div id="coveredApp"></div>',
      '#attached' => [
        'library' => ['liberty_claims/forms'],
        'drupalSettings' => [
          'claimSettings' => [
            'dataBasePath' => '/claim-data',
            'assetsPath' =>
            $this->moduleHandler
              ->getModule('liberty_claims')
              ->getPath() . '/vuejs/src/assets/',
            'token' => $token,
            'imageSize' => $config->get('image_size'),
            'documentSize' => $config->get('document_size'),
            'types' => $config->get('types'),
            'lastModel' => $config->get('last_model'),
          ],
        ],
      ],
    ];
  }

  /**
   * Cities.
   *
   * @return string
   *   Return a list of citites.
   */
  public function getCities() {
    return $this->getResource('cities');
  }

  /**
   * Brands.
   *
   * @return string
   *   Return a list of brands.
   */
  public function getBrands() {
    return $this->getResource('brands');
  }

  /**
   * Cities carshops.
   *
   * @return string
   *   Return a list of cities.
   */
  public function getCitiesCarShops() {
    return $this->getResource('cities.carshops');
  }

  /**
   * Cities carshops chevrolet.
   *
   * @return string
   *   Return a list of cities.
   */
  public function getCitiesCarShopsChevrolet() {
    return $this->getResource('cities.chevrolet');
  }

  /**
   * Cities carshops nissan.
   *
   * @return string
   *   Return a list of cities.
   */
  public function getCitiesCarShopsNissan() {
    return $this->getResource('cities.nissan');
  }

  /**
   * Cities carshops renault.
   *
   * @return string
   *   Return a list of cities.
   */
   public function getCitiesCarShopsRenault() {
    return $this->getResource('cities.renault');
  }

  /**
   * Filters car shops data by concesionario.
   *
   * @param array $filterData
   *   Data to be filtered by concesionario.
   *
   * @return array
   *   Filtered data by concesionario.
   */
  private function filterByConcesionario($filterData, $brand) {

    $concesionarios = [
        'GMFChevrolet' => 'codigoConcesionario',
        'RCINissan' => 'codigoConcesionario',
        'RCIRenault' => 'codigoConcesionario'
    ];

    $filterData2 = array_filter($filterData, function($value) use ($concesionarios, $brand) {
      foreach ($concesionarios as $sessionKey => $codigoKey)
      {
        if($brand === 'RENAULT' && $_SESSION[$brand]['colectivo'] === false)
        {
          if (isset($_SESSION[$sessionKey]) && $_SESSION[$sessionKey][$codigoKey] == $value['codTaller']) {
            return true;
          }
        }
        else
        {
          if (isset($_SESSION[$sessionKey]) && $_SESSION[$sessionKey][$codigoKey] == $value['aixis']) {
            return true;
          }
        }
      }

        return false;
    });

    return !empty($filterData2) ? $filterData2 : $filterData;
}


  /**
   * Loads Chevrolet car shops filtered by city.
   *
   * @param int $city
   *   The city filter.
   *
   * @return array
   *   Filtered car shops by city.
   */
  private function loadChevroletCarShopsByCity($city) {
    // Load taxonomy terms for talleres_chevrolet vocabulary.
    $terms = $this->entityTypeManager->getStorage('taxonomy_term')->loadByProperties([
      'vid' => 'talleres_chevrolet',
    ]);

    $filterData = [];
    foreach ($terms as $key => $term) {
      $field_city = str_pad($term->field_cod_ciudad->value, 5, "0", STR_PAD_LEFT);

      if ($field_city !== $city) {
        continue;
      }

      // Extract necessary data from the loaded terms and populate $datos array.
      $filterData[$key]['nit'] = $term->field_nit->value;
      $filterData[$key]['codTaller'] = $term->field_codtaller->value;
      $filterData[$key]['aixis'] = $term->field_aixis->value;
      $filterData[$key]['nombre'] = $term->name->value;
      $filterData[$key]['direccion'] = $term->field_direccion->value;
      $filterData[$key]['ciudad'] = $term->field_ciudad->value;
      $filterData[$key]['codCiudad'] = $term->field_cod_ciudad->value;
      $filterData[$key]['email'] = $term->field_email->value;
      $filterData[$key]['telefono'] = $term->field_telefono->value;
      $filterData[$key]['sucursal'] = $term->field_sucursal->value;
    }

    return $filterData;
  }

    /**
   * Loads Nissan car shops filtered by city.
   *
   * @param int $city
   *   The city filter.
   *
   * @return array
   *   Filtered car shops by city.
   */
  private function loadNissanCarShopsByCity($city) {
    // Load taxonomy terms for talleres_nissan vocabulary.
    $terms = $this->entityTypeManager->getStorage('taxonomy_term')->loadByProperties([
      'vid' => 'talleres_nissan',
    ]);

    $filterData = [];
    foreach ($terms as $key => $term) {
      $field_city = str_pad($term->field_cod_ciudad_nissan->value, 5, "0", STR_PAD_LEFT);

      if ($field_city !== $city) {
        continue;
      }

      // Extract necessary data from the loaded terms and populate $datos array.
      $filterData[$key]['nit'] = $term->field_nit_nissan->value;
      $filterData[$key]['codTaller'] = $term->field_cod_taller_nissan->value;
      $filterData[$key]['aixis'] = $term->field_aixis_nissan->value;
      $filterData[$key]['nombre'] = $term->name->value;
      $filterData[$key]['direccion'] = $term->field_direccion_nissan->value;
      $filterData[$key]['ciudad'] = $term->field_ciudad_nissan->value;
      $filterData[$key]['codCiudad'] = $term->field_cod_ciudad_nissan->value;
      $filterData[$key]['email'] = $term->field_email_nissan->value;
      $filterData[$key]['telefono'] = $term->field_telefono_nissan->value;
      $filterData[$key]['sucursal'] = $term->field_sucursal_nissan->value;
    }

    return $filterData;
  }

  /**
   * Loads Renault car shops filtered by city.
   *
   * @param int $city
   *   The city filter.
   *
   * @return array
   *   Filtered car shops by city.
   */
  private function loadRenaultCarShopsByCity($city) {
    // Load taxonomy terms for talleres_renault vocabulary.
    $terms = $this->entityTypeManager->getStorage('taxonomy_term')->loadByProperties([
      'vid' => 'talleres_renault',
    ]);

    $filterData = [];
    foreach ($terms as $key => $term) {
      $field_city = str_pad($term->field_cod_ciudad_renault->value, 5, "0", STR_PAD_LEFT);

      if ($field_city !== $city) {
        continue;
      }

      // Extract necessary data from the loaded terms and populate $datos array.
      $filterData[$key]['nit'] = $term->field_nit_renault->value;
      //$filterData[$key]['codTaller'] = $term->field_cod_taller_renault->value;
      $filterData[$key]['aixis'] = $term->field_aixis_renault->value;
      $filterData[$key]['nombre'] = $term->name->value;
      $filterData[$key]['direccion'] = $term->field_direccion_renault->value;
      $filterData[$key]['ciudad'] = $term->field_ciudad_renault->value;
      $filterData[$key]['codCiudad'] = $term->field_cod_ciudad_renault->value;
      $filterData[$key]['email'] = $term->field_email_renault->value;
      $filterData[$key]['telefono'] = $term->field_telefono_renault->value;
      $filterData[$key]['sucursal'] = $term->field_sucursal_renault->value;
      $filterData[$key]['codTaller'] = $term->field_clave_renault->value;
    }

    return $filterData;
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
  public function getCarShops($city, $brand, $model, $type) {

    $carShopFunctions = [
        'GMFChevrolet' => 'loadChevroletCarShopsByCity',
        'RCINissan' => 'loadNissanCarShopsByCity',
        'RCIRenault' => 'loadRenaultCarShopsByCity'
    ];

    $result = [];

    foreach ($carShopFunctions as $sessionKey => $functionName) {
        if (isset($_SESSION[$sessionKey]) && $_SESSION[$sessionKey]) {
            $filterData = $this->$functionName($city);
            $result = $this->filterByConcesionario($filterData, $brand);
            break;
        }
    }

    if (empty($result)) {
        $result = $this->claimService->carShops($city, $brand, $model, $type);
    }

    return new JsonResponse($result);
}


  /**
   * Page of the validaction plate.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   Controller request object.
   * @param string $plate
   *   Plate of the vehicle.
   * @param string $type
   *   Type of the form: Asegurado or Tercero.
   * @param string $date
   *   Claim date.
   *
   * @return array
   *   Service response.
   */
  public function validatePlate(Request $request, string $plate, string $type, string $date) {
    if ($request->headers->get('token')) {
      $this->logger->logActivity($plate, $request->headers->get('token'));

      return new JsonResponse($this->claimService->validatePlate($request, $plate, $type, $date));
    }

    $this->logger->logActivity($plate, 'No token received');

    return new JsonResponse(['error' => 'remote not trusted']);
  }

  /**
   * Gets the car shops service token.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   Controller request object.
   * @param string $folder
   *   Folder name.
   * @param string $op
   *   Operation to be processed.
   *
   * @return string
   *   The token.
   */
  public function manageFiles(Request $request, $folder, $op) {
    if (!$request->headers->get('token')) {
      return new JsonResponse(['error' => 'remote not trusted']);
    }

    if ($op === 'save') {
      /** @var Symfony\Component\HttpFoundation\UploadedFile $source */
      $source = $request->files->get('file', []);

      $path = 'public://claimfiles/' . $folder . '/';

      $this->fileSystem->prepareDirectory(
        $path,
        $this->fileSystem::CREATE_DIRECTORY
      );

      $data = file_get_contents($source);

        $file = $this->fileInterface->writeData(
          $data,
          $path . $source->getClientOriginalName(),
          FileExists::Replace
        );

      $response['file_id'] = $file->id();
      $file->setMimeType = $source->getClientMimeType();
      $file->save();

      // Updates logger activity.
      $this->logger->set(
        'has_files',
        1,
        $request->headers->get('token')
      );
      $this->logger->set(
        'document_id',
        $folder,
        $request->headers->get('token')
      );
    }

    if ($op === 'delete') {
      $json = $request->getContent();
      $response = json_decode($json, TRUE);
      if (array_key_exists('fileId', $response)) {
        $file = File::load($response['fileId']);
        $file->delete();
        return new JsonResponse(['fileDeleted' => 'ok']);
      }
    }

    return new JsonResponse($response);
  }

  /**
   * Method to submit the result of the form.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object containing form data.
   * @param string $type
   *   Type of submission ('Asegurado' or other).
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   JSON response indicating success or error.
   */
  public function submit(Request $request, $type) {
    if (!$request->headers->get('token')) {
      return new JsonResponse(['error' => 'remote not trusted']);
    }

    $response = $request->getContent();
    $data = json_decode($response, TRUE);
    $token = $request->headers->get('token') . $data['plate'];

    $this->logger->set(
      $type == 'Asegurado' ? 'submitdataasegurado' : 'post_sipo_tercero',
      json_encode([
        'submitData' => [
          'date' => date('Y-m-d\TH:i:s'),
          'data' => json_decode($response),
        ],
      ]),
      $token
    );

    if ($type == 'Asegurado') {
      return $this->processAsegurado($response, $token);
    }

    return $this->processTercero($response, $token);
  }

  /**
   * Process the submission for other types.
   *
   * @param string $response
   *   The response data from the request.
   * @param string $token
   *   The token associated with the request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   JSON response indicating success.
   */
  private function processTercero($response, $token) {
    $this->logger->set(
      'post_sipo_tercero',
      json_encode([
        'submitData' => [
          'date' => date('Y-m-d\TH:i:s'),
          'data' => json_decode($response),
        ],
      ]),
      $token
    );

    $sipo = $this->claimService->postSipo($response, 1, $token, 1);
    $this->claimService->postFiles($response, $sipo['numeroCaso']);

    return new JsonResponse(['success' => $sipo['numeroCaso']]);
  }

  /**
   * Process the submission for 'Asegurado' type.
   *
   * @param string $request
   *   The response data from the request.
   * @param string $token
   *   The token associated with the request.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   JSON response indicating success or error.
   */
  private function processAsegurado($request, $token) {
    $request_auto_mail = json_decode($request, TRUE);
    if (isset($request_auto_mail) && $request_auto_mail['tellus'] == 'CLAIM_TYPE_PTH') {
      $this->sendEmailAutoEmail($request_auto_mail);
    }

    $code = $this->claimService->postIaxis($request, $token);

    if (!isset($code['numeroSiniestro'])) {
      $this->logger->set('iaxis_id', 'error', $token);

      return new JsonResponse(['error' => $code['mensajeOperacion']]);
    }

    $this->logger->set('iaxis_id', $code['numeroSiniestro'], $token);
    $this->claimService->postSipo($request, $code['numeroSiniestro'], $token, $code);

    return new JsonResponse(['success' => $code['numeroSiniestro']]);
  }

  /**
   * Return a data resource in json format.
   *
   * @param string $name
   *   The name of the resource.
   *
   * @return string
   *   JSON Data
   */
  private function getResource($name) {
    $path_module = $this->moduleHandler
      ->getModule('liberty_claims')
      ->getPath();
    $data = Yaml::decode(file_get_contents($path_module . '/data/' . $name . '.yaml'));

    $response = new CacheableJsonResponse($data);
    $response->addCacheableDependency((new CacheableMetadata())->setCacheContexts(['url.path']));
    return $response;
  }

  /**
   * Send notificacion Email.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   Controller request object.
   *
   * @return mixed
   *   Mail rendered.
   */
  public function sendEmail(Request $request) {
    $params = json_decode($request->getContent(), TRUE);
    $params['subject'] = 'HDI Seguros | Tu siniestro ha sido radicado';
    $params['headers'] = [
      'Content-Type' => 'text/html; charset=UTF-8;',
    ];
    $mailManager = $this->mailManager;
    $module = 'liberty_claims';
    $to = $params['email'];
    $langcode = 'es';
    $send = TRUE;
    $result = $mailManager->mail($module, 'send_email', $to, $langcode, $params, NULL, $send);

    return new JsonResponse([
      'result' => $result['result'],
    ]);
  }

  /**
   * Send an email for a stolen car report.
   */
  public function sendEmailAutoEmail(array $data) {
    $config = $this->configFactory->get('liberty_claims_email.settings');
    $template = '<html><body>';
    $template .= $config->get('template_correo')['value'] ?? '';

    $subject = $config->get('subject') ?? '';
    $subject = str_replace('[liberty_claims:plate]', $data['plate'], $subject);

    $replacements = [
      '[liberty_claims:plate]' => $data['plate'],
      '[liberty_claims:date]' => $data['date'],
      '[liberty_claims:whereAddress]' => $data['whereAddress'],
      '[liberty_claims:description]' => $data['description'],
      '[liberty_claims:name]' => $data['name'],
      '[liberty_claims:lastname]' => $data['lastname'] ?? '',
      '[liberty_claims:phone]' => $data['phone'],
    ];

    if (isset($data['PhoneFijo']) && $data['PhoneFijo'] != '') {
      $replacements['[liberty_claims:PhoneFijo]'] = $data['PhoneFijo'];
    }
    else {
      unset($replacements['[liberty_claims:PhoneFijo]']);
      $template = str_replace('Teléfono fijo: [liberty_claims:PhoneFijo]', '', $template);
      $replacements['[liberty_claims:PhoneFijo]'] = '';
      $replacements['Teléfono fijo:'] = '';
    }

    $template = strtr($template, $replacements);

    if (!$data['isDriver']) {
      $template .= "<br>";
      $template .= 'Información asegurado:' . "<br>";
      $template .= 'Nombre: ' . ($data['driverName'] ?? '') . "<br>";
      $template .= 'Celular: ' . ($data['driverPhone'] ?? '') . "<br>";
    }

    if (!$data['isDeclarant']) {
      $template .= "<br>";
      $template .= 'Información declarante:' . "<br>";
      $template .= 'Nombre: ' . ($data['declarantName'] ?? '') . "<br>";
      $template .= 'Celular: ' . ($data['declarantPhone'] ?? '') . "<br>";
      if (isset($data['driverPhoneFijo']) && $data['driverPhoneFijo'] != '') {
        $template .= 'Teléfono fijo: ' . ($data['driverPhoneFijo'] ?? '') . "<br>";
      }
    }

    $template .= '</body></html>';
    $params['headers'] = [
      'Content-Type' => 'text/html; charset=UTF-8;',
    ];
    $params['subject'] = $subject;

    $params['message'] = $template;
    $params['message'] = str_replace("\n\n", "\n", $params['message']);
    $params['emails'] = $config->get('email_send_car');
    $params['date'] = date('Y-m-d\TH:i:s');
    $this->libertyClaimsLogManager->agregarNuevaTraza($params);
    $module = 'liberty_claims';
    $to = $config->get('email_send_car');
    $mailManager = $this->mailManager;

    $langcode = 'es';
    $send = TRUE;
    $mailManager->mail($module, 'send_email', $to, $langcode, $params, NULL, $send);
  }

}
