<?php

namespace Drupal\liberty_claims\Controller;

use Drupal\Component\Serialization\Yaml;
use Drupal\Core\Cache\CacheableJsonResponse;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\File\FileSystemInterface;
use Drupal\file\Entity\File;
use Drupal\liberty_claims\ClaimServices;
use Drupal\liberty_claims\LoggerServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class ClaimNotificationController.
 */
class ClaimNotificationController extends ControllerBase
{
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
     * Constructs a new SettingsForm object.
     */
    public function __construct(
        ModuleHandlerInterface $module_handler,
        ConfigFactory $config_factory,
        Session $session,
        ClaimServices $claim_services,
        FileSystemInterface $file_system,
        LoggerServiceInterface $liberty_logger
    ) {
        $this->moduleHandler = $module_handler;
        $this->configFactory = $config_factory;
        $this->currentSession = $session;
        $this->claimService = $claim_services;
        $this->fileSystem = $file_system;
        $this->logger = $liberty_logger;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('module_handler'),
            $container->get('config.factory'),
            $container->get('session'),
            $container->get('claims.services'),
            $container->get('file_system'),
            $container->get('liberty.logger')
        );
    }

    /**
     * Claim.
     *
     * @return string
     *   Return Wrapper for a Vue App.
     */
    public function claim()
    {
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
    public function getCities()
    {
        return $this->getResource('cities');
    }

    /**
     * Brands.
     *
     * @return string
     *   Return a list of brands.
     */
    public function getBrands()
    {
        return $this->getResource('brands');
    }

    /**
     * Cities carshops.
     *
     * @return string
     *   Return a list of cities.
     */
    public function getCitiesCarShops()
    {
        return $this->getResource('cities.carshops');
    }

    /**
     * Cities carshops chevrolet.
     *
     * @return string
     *   Return a list of cities.
     */
    public function getCitiesCarShopsChevrolet()
    {
        return $this->getResource('cities.chevrolet');
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
    public function getCarShops($city, $brand, $model, $type)
    {
        if ($_SESSION['GMFChevrolet']) {
            $result = $this->claimService->carShops(
                $city,
                $brand,
                $model,
                $type
            );
            $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(
                [
                'vid' => 'talleres_chevrolet',
                ]
            );
            $datos = [];
            foreach ($terms as $key => $term) {
                $datos[$key]['nit'] = $term->field_nit->value;
                $datos[$key]['codTaller']  = $term->field_codtaller->value;
                $datos[$key]['aixis']  = $term->field_aixis->value;
                $datos[$key]['nombre']  = $term->name->value;
                $datos[$key]['direccion']  = $term->field_direccion->value;
                $datos[$key]['ciudad']  = $term->field_ciudad->value;
                $datos[$key]['cod ciudad']  = $term->field_cod_ciudad->value;
                $datos[$key]['email']  = $term->field_email->value;
                $datos[$key]['telefono']  = $term->field_telefono->value;
                $datos[$key]['sucursal']  = $term->field_sucursal->value;
            }
           

            foreach ($datos as $key => $value) {
                if ($city == $value['cod ciudad']) {
                    $filterData[] = $value;
                }
            }

            
            foreach ($filterData as $key => $value) {
                if (
                    $_SESSION['GMFChevrolet']['codigoConcesionario'] ==
                    $value['aixis']
                ) {
                    $filterData2[] = $value;
                }
            }

            if (!empty($filterData2)) {
                $result = $filterData2;
            } else {
                $result = $filterData;
            }
            
        } else {
            $result = $this->claimService->carShops(
                $city,
                $brand,
                $model,
                $type
            );
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
    public function validatePlate(
        Request $request,
        string $plate,
        string $type,
        string $date
    ) {
        if ($request->headers->get('token')) {
            $this->logger->logActivity($plate, $request->headers->get('token'));
            return new JsonResponse(
                $this->claimService->validatePlate(
                    $request,
                    $plate,
                    $type,
                    $date
                )
            );
        } else {
            $this->logger->logActivity($plate, 'No token received');
        }

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
    public function manageFiles(Request $request, $folder, $op)
    {
        if ($request->headers->get('token')) {
            if ($op === 'save') {
                /** @var Symfony\Component\HttpFoundation\UploadedFile $source */
                $source = $request->files->get('file', []);

                $path = 'public://claimfiles/' . $folder . '/';

                $this->fileSystem->prepareDirectory(
                    $path,
                    $this->fileSystem::CREATE_DIRECTORY
                );

                $data = file_get_contents($source);

                /** @var Drupal\file\Entity\File $file */
                $file = file_save_data(
                    $data,
                    $path . $source->getClientOriginalName(),
                    $this->fileSystem::EXISTS_REPLACE
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
                // @TODO contar files para logger.
                $json = $request->getContent();
                $response = json_decode($json, true);
                if (array_key_exists('fileId', $response)) {
                    $file = File::load($response['fileId']);
                    $file->delete();
                    return new JsonResponse(['fileDeleted' => 'ok']);
                }
            }

            return new JsonResponse($response);
        } else {
            return new JsonResponse(['error' => 'remote not trusted']);
        }
    }

    /**
     * Mothod to submit the result of the form.
     *
     * @return string
     *   ID of the service.
     */
    public function submit(Request $request, $type)
    {
        // @TODO validar token seguros.
        if ($request->headers->get('token')) {
            $response = $request->getContent();
            $data = json_decode($response, true);
            $token = $request->headers->get('token') . $data['plate'];

            $this->logger->set(
                'submitdataasegurado',
                json_encode([
                    'submitData' => [
                        'date' => date('Y-m-d\TH:i:s'),
                        'data' => json_decode($response),
                    ],
                ]),
                $token
            );

            if ($type == 'Asegurado') {
                $code = $this->claimService->postIaxis($response, $token);

                if (isset($code['numeroSiniestro'])) {
                    $this->logger->set(
                        'iaxis_id',
                        $code['numeroSiniestro'],
                        $token
                    );

                    $sipo = $this->claimService->postSipo(
                        $response,
                        $code['numeroSiniestro'],
                        $token,
                        $code
                    );

                    // Save files locally to be proccessed by the cron.
                    $this->claimService->postFiles(
                        $response,
                        $sipo['numeroCaso']
                    );
                    //file_save_data($response, "public://claimfiles/" . $data['documentId'] . "/" . $sipo['numeroCaso'] . ".json", $this->fileSystem::EXISTS_REPLACE);
                    $return = ['success' => $code['numeroSiniestro']];
                } else {
                    $this->logger->set('iaxis_id', 'error', $token);

                    $return = ['error' => $code['mensajeOperacion']];
                }
            } else {
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
                //\file_save_data($response, "public://claimfiles/" . $data['documentId'] . "/" . $sipo['numeroCaso'] + ".json", $this->fileSystem::EXISTS_REPLACE);
                $return = ['success' => $sipo['numeroCaso']];
            }

            if (isset($sipo) && array_key_exists('numeroCaso', $sipo)) {
                $this->logger->set('sipo_id', $sipo['numeroCaso'], $token);
            }

            return new JsonResponse($return);
        } else {
            return new JsonResponse(['error' => 'remote not trusted']);
        }
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
    private function getResource($name)
    {
        $path_module = $this->moduleHandler
            ->getModule('liberty_claims')
            ->getPath();
        $data = Yaml::decode(
            file_get_contents($path_module . '/data/' . $name . '.yaml')
        );

        $response = new CacheableJsonResponse($data);
        $response->addCacheableDependency(
            (new CacheableMetadata())->setCacheContexts(['url.path'])
        );
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
    public function sendEmail(Request $request)
    {
        $params = json_decode($request->getContent(), true);
        $params['subject'] = 'Liberty Seguros | Tu siniestro ha sido radicado';

        $mailManager = \Drupal::service('plugin.manager.mail');
        $module = 'liberty_claims';
        $to = $params['email'];
        $langcode = 'es';
        $send = true;
        $result = $mailManager->mail(
            $module,
            'send_email',
            $to,
            $langcode,
            $params,
            null,
            $send
        );

        return new JsonResponse([
            'result' => $result['result'],
        ]);
    }
}
