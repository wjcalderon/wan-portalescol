<?php

namespace Drupal\lib_core\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\lib_core\Controller\LibCoreControllerMain;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form sinister.
 */
class SinisterNotifInsured extends FormBase {

  /**
   * Servicio claims controller.
   *
   * @var Drupal\lib_core\Controller\LibCoreControllerMain
   */
  protected $libCoreController;

  /**
   *
   */
  public function __construct(LibCoreControllerMain $libCoreController) {
    $this->libCoreController = $libCoreController;
  }

  /**
   *
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('lib_core.lib_core_controller_main')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sinister_notific_insured_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = \Drupal::config('lib_core.environmentvars.settings');
    $orgid = $config->get('ENDPOINT_ORGID') ?? '';
    $sinister = '00N4A00000FkiLK';
    $sinister_date = '00N4A00000FkjTs';
    $report_type = '00N4A00000FkWpu';
    $vehicle_brand = '00N4A00000FkhWk';
    $vehicle_type = '00N4A00000FkWpk';
    $vehicle_model = '00N4A00000FkWpp';
    $repair_city = '00NG000000FWynf';
    $license_plate = '00NG000000998UR';
    $driver_id = '00N4A00000FgLGC';
    $driver_id_num = '00N4A00000FkWqE';
    $driver_name = '00N4A00000FkWq9';
    $driver_cellphone = '00N4A00000FkWqO';
    $driver_phone = '00N4A00000FkWqJ';
    $driver_email = '00N4A00000FkWqT';
    $driver_address = '00N4A00000FkWqY';
    $insured_id = '00NG000000FWyoW';
    $insured_id_num = '00NG000000FWyoI';
    $insured_name = '00NG000000998UJ';
    $insured_cellphone = '00N4A00000FkhdH';
    $insured_email = '00N4A00000FkhdC';
    $insured_address = '00N4A00000FgLG8';
    $declarant_id = '00N4A00000FgLGD';
    $declarant_id_num = '00N4A00000FkWqi';
    $declarant_name = '00N4A00000FkWqd';
    $declarant_cellphone = '00N4A00000FkWqs';
    $declarant_phone = '00N4A00000FkWqn';
    $declarant_email = '00N4A00000FkWqx';
    $declarant_address = '00N4A00000FkWr2';
    $sinister_description = '00N4A00000FkWr7';
    $sinister_address = '00N4A00000FkWrC';
    $sinister_has_deaths = '00N4A00000FkWrl';
    $sinister_num_deaths = '00N4A00000Fkhd2';
    $sinister_police = '00N4A00000FkWrW';
    $sinister_injured = '00N4A00000FkWrg';
    $sinister_num_injured = '00N4A00000Fkhd7';
    $section_front = '00N4A00000FkhWp';
    $section_front_left = '00N4A00000FkhWu';
    $section_roof = '00N4A00000FkhXJ';
    $section_front_right = '00N4A00000FkhWz';
    $section_back_left = '00N4A00000FkhX4';
    $section_back_right = '00N4A00000FkhX9';
    $section_back = '00N4A00000FkhXE';
    $section_under = '00N4A00000Fklz2';

    $involved = $config->get('involved') ?? '';
    $know_plate_involved = $config->get('know_plate_involved') ?? '';
    $involved_plate = $config->get('involved_plate') ?? '';
    $know_name_involved = $config->get('know_name_involved') ?? '';
    $name_involved = $config->get('name_involved') ?? '';
    $know_type_identification_involved = $config->get('know_type_identification_involved') ?? '';
    $type_identification_involved = $config->get('type_identification_involved') ?? '';
    $know_identification_number_involved = $config->get('know_identification_number_involved') ?? '';
    $identification_number_involved = $config->get('identification_number_involved') ?? '';

    if ($_ENV['AH_SITE_ENVIRONMENT'] == 'prod') {
      $orgid = '00DA0000000AD5W';
    }

    $form['#attached']['library'][] = 'lib_core/sinister_notice';
    $form['#attributes']['cdtype-form'] = 'insured';
    $form['#attributes']['class'] = ['form-ctn-notif-sinister'];

    $form['form_close'] = [
      '#prefix' => '<div class="is-mobile form-item js-form-type-webform-markup form-type-webform-markup form-item- form-no-label">',
      '#suffix' => '</div>',
      '#markup' => '<a id="close" class="close is-mobile">Close</a>',
    ];

    if ($_ENV['AH_SITE_ENVIRONMENT'] != 'prod') {
      // Hidden fields
      // Test.
      $form['debug'] = [
        '#type' => 'hidden',
        '#value' => 1,
        '#name' => 'debug',
      ];

      $form['debugEmail'] = [
        '#type' => 'hidden',
        '#value' => 'andres.alvarez@esinergia.co',
        '#name' => 'debugEmail',
      ];
      // ------- Fin test ----------
    }

    $form['orgid'] = [
      '#type' => 'hidden',
      '#name' => 'orgid',
      '#value' => $orgid,
    ];

    $form['00N4A00000G91wx'] = [
      '#type' => 'hidden',
      '#name' => '00N4A00000G91wx',
      '#value' => 'COLOMBIA',
    ];

    $request = \Drupal::requestStack()->getCurrentRequest();
    $current_path = $request->getRequestUri();
    $url = Url::fromUserInput($current_path, ['query' => ['resp' => 1]]);
    $retURL = $url->toString();
    $form['retURL'] = [
      '#type' => 'hidden',
      '#name' => 'retURL',
      '#value' => $retURL,
    ];

    $form[$sinister] = [
      '#type' => 'hidden',
      '#name' => $sinister,
      '#value' => 'Siniestros Autos',
      '#attributes' => [
        'id' => $sinister,
      ],
    ];

    $form['header_steps3_dk'] = [
      '#prefix' => '<div class="header-steps three-elements is-desktop">',
      '#suffix' => '</div>',
      '#markup' => '<span class="step-1 active">
        <span class="img"><img src="/themes/custom/liberty_public/images/icons/t1-pasos-sini.svg"></span>
        <span class="label">Primer Paso</span>
      </span>
      <span class="step-2">
        <span class="img"><img src="/themes/custom/liberty_public/images/icons/t2-pasos-sini.svg"></span>
        <span class="label">Segundo Paso</span>
      </span>
      <span class="step-3">
        <span class="img"><img src="/themes/custom/liberty_public/images/icons/t3-pasos-sini.svg"></span>
        <span class="label">Tercer Paso</span>
      </span>',
    ];

    // Two elements.
    $form['header_steps2_dk'] = [
      '#prefix' =>
      '<div class="header-steps two-elements is-hidden is-desktop">',
      '#suffix' => '</div>',
      '#markup' => '<span class="step-1 active">
          <span class="img"><img src="/themes/custom/liberty_public/images/icons/t1-pasos-sini.svg"></span>
          <span class="label">Primer Paso</span>
        </span>
        <span class="step-2">
          <span class="img"><img src="/themes/custom/liberty_public/images/icons/t2-pasos-sini.svg"></span>
          <span class="label">Segundo Paso</span>
        </span>',
    ];

    // Mobile
    // Three elements.
    $form['header_steps3_mb'] = [
      '#prefix' => '<div class="header-steps three-elements is-mobile">',
      '#suffix' => '</div>',
      '#markup' => '<span class="step-1 active">1</span><span class="step-2">2</span><span class="step-3">3</span>',
    ];
    // Two elements.
    $form['header_steps2_mb'] = [
      '#prefix' => '<div class="header-steps two-elements is-hidden is-mobile">',
      '#suffix' => '</div>',
      '#markup' => '<span class="step-1 active">1</span><span class="step-2">2</span>',
    ];

    // ***********************
    // ******** STEP 1 *******
    // ***********************
    $form['step1'] = [
      '#type' => 'container',
      '#prefix' => '<div class="steps step-1" step="1">',
      '#suffix' => '</div>',
    ];

    // Container
    // Insure vehicule info
    // -------------------------.
    $form['step1']['ins_veh_info'] = [
      '#type' => 'container',
      '#prefix' => '<div class="ctn-ins-veh-info">',
      '#suffix' => '</div>',
    ];

    $form['step1']['ins_veh_info']['title']['#markup'] = '<h2>Información General</h2>';
    $form['step1']['ins_veh_info']['subtitle']['#markup'] = '<h3>Información del Vehículo Asegurado</h3>';

    // sinister_report.
    $form['step1']['ins_veh_info'][$report_type] = [
      '#type' => 'select',
      '#title' => 'Usted va a reportar',
      '#id' => $report_type,
      '#name' => $report_type,
      '#required' => TRUE,
      '#options' => [
        'Daños en el vehículo a causa de un accidente o evento súbito e imprevisto.' => 'Daños en el vehículo a causa de un accidente o evento súbito e imprevisto.',
        'Hurto de cualquier parte o accesorio de su vehículo.' => 'Hurto de cualquier parte o accesorio de su vehículo.',
        'Hurto de su vehículo.' => 'Hurto de su vehículo.',
        'Pequeños accesorios.' => 'Pequeños accesorios.',
        'Perdida de llaves.' => 'Perdida de llaves.',
        'Llantas estalladas.' => 'Llantas estalladas.',
      ],
      '#attributes' => [
        'id' => $report_type,
      ],
    ];

    // Brand.
    $opts_brands = $this->libCoreController->sinistersVehiclesBrandsSelect();
    $form['step1']['ins_veh_info'][$vehicle_brand] = [
      '#type' => 'select',
      '#title' => 'Marca',
      '#required' => TRUE,
      '#id' => $vehicle_brand,
      '#name' => $vehicle_brand,
      '#options' => $opts_brands,
      '#attributes' => [
        'id' => $vehicle_brand,
      ],
    ];

    // type_vehicle.
    $form['step1']['ins_veh_info'][$vehicle_type] = [
      '#type' => 'select',
      '#title' => 'Tipo de vehiculo',
      '#required' => TRUE,
      '#id' => $vehicle_type,
      '#name' => $vehicle_type,
      '#options' => [
        'Livianos' => 'Livianos',
        'Pesados' => 'Pesados',
        'Motos' => 'Motos',
      ],
      '#attributes' => [
        'id' => $vehicle_type,
      ],
    ];

    $opts_year = [];
    // Actual year.
    $y = intval(date('Y'));
    // Actual month.
    $m = intval(date('m'));

    for ($i = 1980; $i <= ($m >= 6 ? ($y + 1) : $y); $i++) {
      $opts_year[$i] = $i;
    }
    arsort($opts_year);
    // Model.
    $form['step1']['ins_veh_info'][$vehicle_model] = [
      '#type' => 'select',
      '#title' => 'Modelo',
      '#required' => TRUE,
      '#id' => $vehicle_model,
      '#name' => $vehicle_model,
      '#options' => $opts_year,
      '#attributes' => [
        'id' => $vehicle_model,
      ],
    ];

    $opts_cities = $this->libCoreController->sinistersCitiesSelect();
    $form['step1']['ins_veh_info'][$repair_city] = [
      '#type' => 'select',
      '#required' => TRUE,
      '#title' => 'Ciudad y departamento de reparación',
      '#options' => $opts_cities,
      '#id' => $repair_city,
      '#name' => $repair_city,
      '#attributes' => [
        'id' => $repair_city,
      ],
    ];

    // Plaque.
    $form['step1']['ins_veh_info'][$license_plate] = [
      '#type' => 'textfield',
      '#title' => 'Placa',
      '#required' => TRUE,
      '#maxlength' => 6,
      '#name' => $license_plate,
      '#id' => $license_plate,
      '#attributes' => [
        'id' => $license_plate,
      ],
    ];

    // Container
    // Driver info
    // -------------------------.
    $form['step1']['driver_info'] = [
      '#type' => 'container',
      '#prefix' => '<div class="ctn-driver-info">',
      '#suffix' => '</div>',
    ];

    $form['step1']['driver_info']['title']['#markup'] = '<h3>Información del conductor</h3>';

    // driver_ident_type.
    $form['step1']['driver_info'][$driver_id] = [
      '#type' => 'select',
      '#title' => 'Tipo de identificación',
      '#required' => TRUE,
      '#id' => $driver_id,
      '#name' => $driver_id,
      '#options' => [
        'Cédula de ciudadanía' => 'Cédula de ciudadanía',
        'Cédula de Extranjería' => 'Cédula de Extranjería',
        'Número único Identificación Personal' => 'Número único Identificación Personal',
        'BIC' => 'BIC',
        'Carnet Diplomático' => 'Carnet Diplomático',
        'Identificador simulaciones' => 'Identificador simulaciones',
        'NIT' => 'NIT',
        'NUIP' => 'NUIP',
        'Pasaporte' => 'Pasaporte',
        'Registro Civil' => 'Registro Civil',
        'Tarjeta de Identidad' => 'Tarjeta de Identidad',
        'No Válido' => 'No Válido',
      ],
      '#attributes' => [
        'id' => $driver_id,
        'class' => ['driver_info-driver_id'],
      ],
    ];

    // driver_num_ident.
    $form['step1']['driver_info'][$driver_id_num] = [
      '#type' => 'textfield',
      '#title' => 'Número de identificación conductor',
      '#maxlength' => 20,
      '#required' => TRUE,
      '#name' => $driver_id_num,
      '#id' => $driver_id_num,
      '#attributes' => [
        'id' => $driver_id_num,
        'class' => ['driver_info-driver_id_num'],
      ],
    ];

    // driver_name.
    $form['step1']['driver_info'][$driver_name] = [
      '#type' => 'textfield',
      '#title' => 'Nombre del conductor',
      '#maxlength' => 40,
      '#name' => $driver_name,
      '#id' => $driver_name,
      '#attributes' => [
        'id' => $driver_name,
        'class' => ['driver_info-driver_name'],
      ],
    ];

    // driver_cellphone.
    $form['step1']['driver_info'][$driver_cellphone] = [
      '#type' => 'textfield',
      '#title' => 'Celular del conductor',
      '#maxlength' => 10,
      '#name' => $driver_cellphone,
      '#id' => $driver_cellphone,
      '#attributes' => [
        'id' => $driver_cellphone,
        'class' => ['driver_info-driver_cellphone'],
      ],
    ];

    // driver_phone.
    $form['step1']['driver_info'][$driver_phone] = [
      '#type' => 'textfield',
      '#title' => 'Teléfono fijo conductor',
      '#maxlength' => 10,
      '#name' => $driver_phone,
      '#id' => $driver_phone,
      '#attributes' => [
        'id' => $driver_phone,
        'class' => ['driver_info-driver_phone'],
      ],
    ];

    // driver_mail.
    $form['step1']['driver_info'][$driver_email] = [
      '#type' => 'textfield',
      '#title' => 'Email conductor',
      '#id' => $driver_email,
      '#name' => $driver_email,
      '#attributes' => [
        'id' => $driver_email,
        'class' => ['driver_info-driver_email'],
      ],
    ];

    // driver_address.
    $form['step1']['driver_info'][$driver_address] = [
      '#type' => 'textfield',
      '#title' => 'Dirección conductor',
      '#name' => $driver_address,
      '#id' => $driver_address,
      '#attributes' => [
        'id' => $driver_address,
        'class' => ['driver_info-driver_address'],
      ],
    ];

    $form['step1']['driver_info']['subtitle_driver']['#markup'] = '<div class="form-item"><p>¿El conductor es el mismo asegurado?</p></div>';

    $mrkup = '<div class="form-item">
      <div id="edit-driver-same-insure" class="switch" style="margin-top: 2rem;">
      <input data-drupal-selector="edit-driver-same-insure-si" type="radio" id="edit-driver-same-insure-si" name="driver_same_insure" value="Si" class="form-radio toggle toggle-left">
      <label for="edit-driver-same-insure-si" class="option btn btn-left">Si</label>
      <input data-drupal-selector="edit-driver-same-insure-no" type="radio" id="edit-driver-same-insure-no" name="driver_same_insure" value="No" class="form-radio toggle toggle-right" checked="checked">
      <label for="edit-driver-same-insure-no" class="option btn btn-right" style="margin-left: 0px;">No</label>
      </div>
      </div>';
    $form['step1']['driver_info']['driver_same_insure'] = [
      '#markup' => $mrkup,
      '#allowed_tags' => ['input', 'label', 'div', 'h2'],
    ];

    // Container
    // Insured info
    // -------------------------.
    $form['step1']['insured_info'] = [
      '#type' => 'container',
      '#prefix' => '<div class="ctn-insured-info">',
      '#suffix' => '</div>',
    ];

    $form['step1']['insured_info']['subtitle']['#markup'] = '<h3>Información del Asegurado</h3>';

    // insured_ident_type.
    $form['step1']['insured_info'][$insured_id] = [
      '#type' => 'select',
      '#title' => 'Tipo de identificación',
      '#id' => $insured_id,
      '#name' => $insured_id,
      '#required' => TRUE,
      '#options' => [
        'Cédula de ciudadanía' => 'Cédula de ciudadanía',
        'Cédula de Extranjería' => 'Cédula de Extranjería',
        'Número único Identificación Personal' => 'Número único Identificación Personal',
        'BIC' => 'BIC',
        'Carnet Diplomático' => 'Carnet Diplomático',
        'Identificador simulaciones' => 'Identificador simulaciones',
        'NIT' => 'NIT',
        'NUIP' => 'NUIP',
        'Pasaporte' => 'Pasaporte',
        'Registro Civil' => 'Registro Civil',
        'Tarjeta de Identidad' => 'Tarjeta de Identidad',
        'No Válido' => 'No Válido',
      ],
      '#attributes' => [
        'id' => $insured_id,
        'class' => ['insured_info-insured_id'],
      ],
    ];

    // insured_num_ident.
    $form['step1']['insured_info'][$insured_id_num] = [
      '#type' => 'textfield',
      '#title' => 'Número de identificación asegurado',
      '#maxlength' => 20,
      '#name' => $insured_id_num,
      '#id' => $insured_id_num,
      '#attributes' => [
        'id' => $insured_id_num,
        'class' => ['insured_info-insured_id_num'],
      ],
    ];

    // insured_name.
    $form['step1']['insured_info'][$insured_name] = [
      '#type' => 'textfield',
      '#title' => 'Nombre del asegurado',
      '#maxlength' => 40,
      '#name' => $insured_name,
      '#id' => $insured_name,
      '#attributes' => [
        'id' => $insured_name,
        'class' => ['insured_info-insured_name'],
      ],
    ];

    // insured_cellphone.
    $form['step1']['insured_info'][$insured_cellphone] = [
      '#type' => 'textfield',
      '#title' => 'Celular del asegurado',
      '#maxlength' => 10,
      '#name' => $insured_cellphone,
      '#id' => $insured_cellphone,
      '#attributes' => [
        'id' => $insured_cellphone,
        'class' => ['insured_info-insured_cellphone'],
      ],
    ];

    // insured_mail.
    $form['step1']['insured_info'][$insured_email] = [
      '#type' => 'textfield',
      '#title' => 'Email asegurado',
      '#name' => $insured_email,
      '#id' => $insured_email,
      '#attributes' => [
        'id' => $insured_email,
        'class' => ['insured_info-insured_email'],
      ],
    ];

    // insured_address.
    $form['step1']['insured_info'][$insured_address] = [
      '#type' => 'textfield',
      '#title' => 'Dirección asegurado',
      '#name' => $insured_address,
      '#id' => $insured_address,
      '#attributes' => [
        'id' => $insured_address,
        'class' => ['insured_info-insured_address'],
      ],
    ];

    // ***********************
    // ******** STEP 2 *******
    // ***********************
    $form['step2'] = [
      '#type' => 'container',
      '#prefix' => '<div class="steps step-2 active" step="2">',
      '#suffix' => '</div>',
    ];

    // Container
    // Declarant info
    // -------------------------.
    $form['step2']['declarant_info'] = [
      '#type' => 'container',
      '#prefix' => '<div class="ctn-declarant-info">',
      '#suffix' => '</div>',
    ];

    $form['step2']['declarant_info']['subtitle_declarant']['#markup'] = '<div class="form-item"><p>¿El declarante es el mismo asegurado?</p></div>';

    $mrkup = '<div class="form-item">
      <div id="edit-driver-same-insure" class="switch" style="margin-top: 2rem;">
      <input data-drupal-selector="edit-declarant-same-insure-si" type="radio" id="edit-declarant-same-insure-si" name="declarant_same_insure" value="Si" class="form-radio toggle toggle-left">
      <label for="edit-declarant-same-insure-si" class="option btn btn-left">Si</label>
      <input data-drupal-selector="edit-declarant-same-insure-no" type="radio" id="edit-declarant-same-insure-no" name="declarant_same_insure" value="No" class="form-radio toggle toggle-right" checked="checked">
      <label for="edit-declarant-same-insure-no" class="option btn btn-right" style="margin-left: 0px;">No</label>
      </div>
      </div>';
    $form['step2']['declarant_info']['declarant_same_insure'] = [
      '#markup' => $mrkup,
      '#allowed_tags' => ['input', 'label', 'div', 'h2'],
    ];

    $form['step2']['declarant_info']['title']['#markup'] = '<h3>Información del declarante</h3>';

    // declarant_ident_type.
    $form['step2']['declarant_info'][$declarant_id] = [
      '#type' => 'select',
      '#title' => 'Tipo de documento Declarante',
      '#id' => $declarant_id,
      '#name' => $declarant_id,
      '#required' => TRUE,
      '#options' => [
        'Cédula de ciudadanía' => 'Cédula de ciudadanía',
        'Cédula de Extranjería' => 'Cédula de Extranjería',
        'Número único Identificación Personal' => 'Número único Identificación Personal',
        'BIC' => 'BIC',
        'Carnet Diplomático' => 'Carnet Diplomático',
        'Identificador simulaciones' => 'Identificador simulaciones',
        'NIT' => 'NIT',
        'NUIP' => 'NUIP',
        'Pasaporte' => 'Pasaporte',
        'Registro Civil' => 'Registro Civil',
        'Tarjeta de Identidad' => 'Tarjeta de Identidad',
        'No Válido' => 'No Válido',
      ],
      '#attributes' => [
        'id' => $declarant_id,
        'class' => ['declarant_info-declarant_id'],
      ],
    ];

    // declarant_num_ident.
    $form['step2']['declarant_info'][$declarant_id_num] = [
      '#type' => 'textfield',
      '#title' => 'Número de identificación declarante',
      '#maxlength' => 20,
      '#name' => $declarant_id_num,
      '#id' => $declarant_id_num,
      '#attributes' => [
        'id' => $declarant_id_num,
        'class' => ['declarant_info-declarant_id_num'],
      ],
    ];

    // declarant_name.
    $form['step2']['declarant_info'][$declarant_name] = [
      '#type' => 'textfield',
      '#title' => 'Nombre del declarante',
      '#maxlength' => 40,
      '#name' => $declarant_name,
      '#id' => $declarant_name,
      '#attributes' => [
        'id' => $declarant_name,
        'class' => ['declarant_info-declarant_name'],
      ],
    ];

    // declarant_cellphone.
    $form['step2']['declarant_info'][$declarant_cellphone] = [
      '#type' => 'textfield',
      '#title' => 'Celular del declarante',
      '#maxlength' => 10,
      '#name' => $declarant_cellphone,
      '#id' => $declarant_cellphone,
      '#attributes' => [
        'id' => $declarant_cellphone,
        'class' => ['declarant_info-declarant_cellphone'],
      ],
    ];

    // declarant_phone.
    $form['step2']['declarant_info'][$declarant_phone] = [
      '#type' => 'textfield',
      '#title' => 'Teléfono fijo declarante',
      '#maxlength' => 10,
      '#id' => $declarant_phone,
      '#name' => $declarant_phone,
      '#attributes' => [
        'id' => $declarant_phone,
        'class' => ['declarant_info-declarant_phone'],
      ],
    ];

    // declarant_mail.
    $form['step2']['declarant_info'][$declarant_email] = [
      '#type' => 'textfield',
      '#title' => 'Email declarante',
      '#id' => $declarant_email,
      '#name' => $declarant_email,
      '#attributes' => [
        'id' => $declarant_email,
        'class' => ['declarant_info-declarant_email'],
      ],
    ];

    // declarant_address.
    $form['step2']['declarant_info'][$declarant_address] = [
      '#type' => 'textfield',
      '#title' => 'Dirección declarante',
      '#id' => $declarant_address,
      '#name' => $declarant_address,
      '#attributes' => [
        'id' => $declarant_address,
        'class' => ['declarant_info-declarant_address'],
      ],
    ];

    // Container
    // Sinester info
    // -------------------------.
    $form['step2']['sinister_info'] = [
      '#type' => 'container',
      '#prefix' => '<div class="ctn-descrip-sinister-info">',
      '#suffix' => '</div>',
    ];

    $form['step2']['sinister_info']['title']['#markup'] = '<h3>Ocurrencia del Siniestro</h3>';

    // description_sinister.
    $form['step2']['sinister_info'][$sinister_description] = [
      '#title' => 'Descripción de los hechos',
      '#type' => 'textarea',
      '#name' => $sinister_description,
      '#attributes' => [
        'id' => $sinister_description,
      ],
      '#maxlength' => 255,
      '#minlength' => 100,
    ];

    // address_sinister.
    $form['step2']['sinister_info'][$sinister_address] = [
      '#type' => 'textfield',
      '#title' => 'Dirección ocurrencia',
      '#name' => $sinister_address,
      '#id' => $sinister_address,
      '#attributes' => [
        'id' => $sinister_address,
      ],
      '#description' => '*Es importante que registres la dirección exacta en donde ocurrió el siniestro',
    ];

    // exist_deaths.
    $form['step2']['sinister_info'][$sinister_has_deaths] = [
      '#type' => 'select',
      '#title' => 'Existen muertos',
      '#id' => $sinister_has_deaths,
      '#name' => $sinister_has_deaths,
      '#required' => TRUE,
      '#options' => [
        'Si' => 'Si',
        'No' => 'No',
      ],
      '#attributes' => [
        'id' => $sinister_has_deaths,
      ],
    ];

    // num_deaths.
    $form['step2']['sinister_info'][$sinister_num_deaths] = [
      '#type' => 'select',
      '#title' => 'Número de muertos',
      '#id' => $sinister_num_deaths,
      '#name' => $sinister_num_deaths,
      '#options' => [
        '' => '- Seleccione -',
        '1' => '1',
        'Mas de 1' => 'Mas de 1',
      ],
      '#attributes' => [
        'id' => $sinister_num_deaths,
      ],
    ];

    $form['step2']['sinister_info'][$involved] = [
      '#type' => 'select',
      '#title' => '¿Hubo tercero involucrado? ',
      '#required' => TRUE,
      '#id' => $involved,
      '#name' => $involved,
      '#options' => [
        'Si' => 'Si',
        'No' => 'No',
      ],
      '#default_value' => 'No',
      '#attributes' => [
        'id' => '00N7j0000026tc9',
      ],
    ];

    $form['step2']['sinister_info'][$know_plate_involved] = [
      '#type' => 'select',
      '#title' => '¿Conoce la placa del tercero involucrado?',
      '#id' => $know_plate_involved,
      '#name' => $know_plate_involved,
      '#options' => [
        'Si' => 'Si',
        'No' => 'No',
      ],
      '#default_value' => 'No',
      '#attributes' => [
        'id' => '00N7j0000026tc6',
      ],
    ];

    $form['step2']['sinister_info'][$involved_plate] = [
      '#type' => 'textfield',
      '#title' => 'Ingrese placa del tercero involucrado',
      '#id' => $involved_plate,
      '#name' => $involved_plate,
      '#attributes' => [
        'id' => '00N7j0000026tcB',
      ],
    ];

    $form['step2']['sinister_info'][$know_name_involved] = [
      '#type' => 'select',
      '#title' => '¿Conoce el nombre del tercero involucrado?',
      '#id' => $know_name_involved,
      '#name' => $know_name_involved,
      '#options' => [
        'Si' => 'Si',
        'No' => 'No',
      ],
      '#default_value' => 'No',
      '#attributes' => [
        'id' => '00N7j0000026tc5',
      ],
    ];

    $form['step2']['sinister_info'][$name_involved] = [
      '#type' => 'textfield',
      '#title' => 'Ingrese nombre del tercero involucrado',
      '#id' => $name_involved,
      '#name' => $name_involved,
      '#attributes' => [
        'id' => '00N7j0000026tcA',
      ],
    ];

    $form['step2']['sinister_info'][$know_type_identification_involved] = [
      '#type' => 'select',
      '#title' => '¿Conoce el tipo de identificación tercero involucrado?',
      '#id' => $know_type_identification_involved,
      '#name' => $know_type_identification_involved,
      '#options' => [
        'Si' => 'Si',
        'No' => 'No',
      ],
      '#default_value' => 'No',
      '#attributes' => [
        'id' => '00N7j0000026tc8',
      ],
    ];

    $form['step2']['sinister_info'][$type_identification_involved] = [
      '#type' => 'select',
      '#title' => 'Seleccione el tipo de identificación tercero involucrado',
      '#id' => $type_identification_involved,
      '#name' => $type_identification_involved,
      '#options' => [
        'Cédula de ciudadanía' => 'Cédula de ciudadanía',
        'Cédula de Extranjería' => 'Cédula de Extranjería',
        'Número único Identificación Personal' => 'Número único Identificación Personal',
        'BIC' => 'BIC',
        'Carnet Diplomático' => 'Carnet Diplomático',
        'Identificador simulaciones' => 'Identificador simulaciones',
        'NIT' => 'NIT',
        'NUIP' => 'NUIP',
        'Pasaporte' => 'Pasaporte',
        'Registro Civil' => 'Registro Civil',
        'Tarjeta de Identidad' => 'Tarjeta de Identidad',
        'No Válido' => 'No Válido',
      ],
      '#attributes' => [
        'id' => '00N7j0000026tcC',
      ],
    ];

    $form['step2']['sinister_info'][$know_identification_number_involved] = [
      '#type' => 'select',
      '#title' => '¿Conoce el número de identificación del involucrado?',
      '#id' => $know_identification_number_involved,
      '#name' => $know_identification_number_involved,
      '#options' => [
        'Si' => 'Si',
        'No' => 'No',
      ],
      '#default_value' => 'No',
      '#attributes' => [
        'id' => '00N7j0000026tc7',
      ],
    ];

    $form['step2']['sinister_info'][$identification_number_involved] = [
      '#type' => 'textfield',
      '#title' => 'Ingrese número de identificación',
      '#id' => $identification_number_involved,
      '#name' => $identification_number_involved,
      '#attributes' => [
        'id' => '00N7j0000026tcD',
      ],
    ];

    // intervened_police.
    $form['step2']['sinister_info'][$sinister_police] = [
      '#type' => 'select',
      '#title' => 'Intervino policía de tránsito',
      '#id' => $sinister_police,
      '#name' => $sinister_police,
      '#required' => TRUE,
      '#options' => [
        'Si' => 'Si',
        'No' => 'No',
      ],
      '#attributes' => [
        'id' => $sinister_police,
      ],
    ];

    // exist_wounded.
    $form['step2']['sinister_info'][$sinister_injured] = [
      '#type' => 'select',
      '#title' => 'Existen heridos',
      '#id' => $sinister_injured,
      '#name' => $sinister_injured,
      '#required' => TRUE,
      '#options' => [
        'Si' => 'Si',
        'No' => 'No',
      ],
      '#attributes' => [
        'id' => $sinister_injured,
      ],
    ];

    // num_wounded.
    $form['step2']['sinister_info'][$sinister_num_injured] = [
      '#type' => 'select',
      '#title' => 'Número de heridos',
      '#id' => $sinister_num_injured,
      '#name' => $sinister_num_injured,
      '#options' => [
        '' => '- Seleccione -',
        '1' => '1',
        'Mas de 1' => 'Mas de 1',
      ],
      '#attributes' => [
        'id' => $sinister_num_injured,
      ],
    ];

    // date_sinister.
    $form['step2']['sinister_info'][$sinister_date] = [
      '#type' => 'textfield',
      '#title' => 'Fecha y hora de ocurrencia',
      '#id' => $sinister_date,
      '#name' => $sinister_date,
      '#attributes' => [
        'id' => 'date-field-insured',
        'class' => ['date-field-insured'],
      ],
    ];

    // **********************
    // ******** STEP 3 ******
    // **********************
    $form['step3'] = [
      '#type' => 'container',
      '#prefix' => '<div class="steps step-3 is-hidden" step="3">',
      '#suffix' => '</div>',
    ];

    // Container
    // Affected area vehicle
    // -------------------------.
    $form['step3']['area_vehicle'] = [
      '#type' => 'container',
      '#prefix' => '<div class="ctn-affected-vehicle-info">',
      '#suffix' => '</div>',
    ];

    $form['step3']['area_vehicle']['title']['#markup'] = '<h2>Marca la Zona Afectada de tu Vehículo</h2>';

    // Car image.
    $form['step3']['area_vehicle']['car_image'] = [
      '#markup' => '<img src="/themes/custom/liberty_public/images/car-form.png">',
    ];

    // Lead.
    $form['step3']['area_vehicle'][$section_front] = [
      '#type' => 'checkbox',
      '#title' => 'Sección delantera',
      '#name' => $section_front,
      '#attributes' => [
        'id' => 'edit-' . $section_front,
      ],
    ];

    // left_front_lateral.
    $form['step3']['area_vehicle'][$section_front_left] = [
      '#type' => 'checkbox',
      '#title' => 'Lateral delantero Izquierdo',
      '#name' => $section_front_left,
      '#attributes' => [
        'id' => 'edit-' . $section_front_left,
      ],
    ];

    // Ceiling.
    $form['step3']['area_vehicle'][$section_roof] = [
      '#type' => 'checkbox',
      '#title' => 'techo',
      '#name' => $section_roof,
      '#attributes' => [
        'id' => 'edit-' . $section_roof,
      ],
    ];

    // right_front_lateral.
    $form['step3']['area_vehicle'][$section_front_right] = [
      '#type' => 'checkbox',
      '#title' => 'Lateral delantero derecho',
      '#name' => $section_front_right,
      '#attributes' => [
        'id' => 'edit-' . $section_front_right,
      ],
    ];

    // right_rear_side.
    $form['step3']['area_vehicle'][$section_back_left] = [
      '#type' => 'checkbox',
      '#title' => 'Lateral trasero izquierdo',
      '#name' => $section_back_left,
      '#attributes' => [
        'id' => 'edit-' . $section_back_left,
      ],
    ];

    // left_rear_side.
    $form['step3']['area_vehicle'][$section_back_right] = [
      '#type' => 'checkbox',
      '#title' => 'Lateral trasero derecho',
      '#name' => $section_back_right,
      '#attributes' => [
        'id' => 'edit-' . $section_back_right,
      ],
    ];

    // later_section.
    $form['step3']['area_vehicle'][$section_back] = [
      '#type' => 'checkbox',
      '#title' => 'Sección posterior',
      '#name' => $section_back,
      '#attributes' => [
        'id' => 'edit-' . $section_back,
      ],
    ];

    // Under.
    $form['step3']['area_vehicle'][$section_under] = [
      '#type' => 'checkbox',
      '#title' => 'Por debajo',
      '#name' => $section_under,
      '#attributes' => [
        'id' => 'edit-' . $section_under,
      ],
    ];

    $form['ctn_submits'] = [
      '#prefix' => '<div class="form-item form-actions">',
      '#suffix' => '</div>',
    ];

    $form['ctn_submits']['back'] = [
      '#type' => 'submit',
      '#value' => 'Volver',
      '#name' => 'back',
      '#attributes' => [
        'class' => ['btn-submit-step btn-back is-hidden button--primary'],
        'cdtype' => 'back',
      ],
    ];

    $form['ctn_submits']['next'] = [
      '#type' => 'submit',
      '#value' => 'Siguiente',
      '#name' => 'next',
      '#attributes' => [
        'class' => ['btn-submit-step btn-next button--primary'],
        'cdtype' => 'next',
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $form_state->setRebuild(TRUE);

    // Post to webform and sales force.
    $coreController = $this->libCoreController;
    $coreController->webformRestPost('aviso_de_siniestro_asegurado', $values);
  }

}
