<?php

namespace Drupal\lib_core\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\lib_core\Controller\LibCoreController;
use Drupal\webform\Entity\Webform;
use Drupal\webform\Entity\WebformSubmission;

/**
 * Sinister Notifthird Affected Salesforce.
 */
class SinisterNotifthirdAffectedSalesforce extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    // Nombre del formulario.
    return 'sinister_notific_third_affectt_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $libCoreController = new LibCoreController();
    $form['#attached']['library'][] = 'lib_core/sinister_notice';
    $form['#attributes']['cdtype-form'] = 'third-affect';
    $form['#attributes']['class'] = [
      'form-ctn-notif-sinister',
    ];

    $orgid = '00D040000004eAH';
    $sinister = '00N4A00000FkiLK';
    $sinister_date = '00N4A00000FkjTs';
    $report_type = '00N4A00000FkWpu';
    $vehicle_brand = '00N4A00000FkhWk';
    $vehicle_type = '00N4A00000FkWpk';
    $vehicle_model = '00N4A00000FkWpp';
    $insured_email = '00N4A00000FkhdC';
    $insured_cellphone = '00N4A00000FkhdH';
    // $driver_name = '00N4A00000FkWq9';
    // $driver_id_num = '00N4A00000FkWqE';
    // $driver_email = '00N4A00000FkWqT';
    // $driver_cellphone = '00N4A00000FkWqO';
    // $driver_phone = '00N4A00000FkWqJ';
    // $driver_address = '00N4A00000FkWqY';
    $declarant_name = '00N4A00000FkWqd';
    $declarant_doc_type = '00N4A00000FgLGD';
    $declarant_id_num = '00N4A00000FkWqi';
    $declarant_phone = '00N4A00000FkWqn';
    $declarant_cellphone = '00N4A00000FkWqs';
    $declarant_email = '00N4A00000FkWqx';
    $declarant_address = '00N4A00000FkWr2';
    $sinister_description = '00N4A00000FkWr7';
    $sinister_address = '00N4A00000FkWrC';
    $sinister_has_deaths = '00N4A00000FkWrl';
    $sinister_num_deaths = '00N4A00000Fkhd2';
    $sinister_police = '00N4A00000FkWrW';
    $sinister_injured = '00N4A00000FkWrg';
    $sinister_num_injured = '00N4A00000Fkhd7';
    $section_roof = '00N4A00000FkhXJ';
    $section_front = '00N4A00000FkhWp';
    $section_front_left = '00N4A00000FkhWu';
    $section_front_right = '00N4A00000FkhWz';
    $section_back_left = '00N4A00000FkhX4';
    $section_back_right = '00N4A00000FkhX9';
    $section_back = '00N4A00000FkhXE';
    $section_down = '00N4A00000Fklz2';
    $third_doc_type = '00N4A00000FkjTv';
    $third_doc_num = '00N4A00000FkjTo';
    $third_name = '00N4A00000FkjTt';
    $third_cellphone = '00N4A00000FkjTu';
    $third_phone = '00N4A00000FkjTp';
    $third_email = '00N4A00000FkjTr';
    $third_address = '00N4A00000FkjTq';
    $insured_address = '00N4A00000FgLG8';
    // $driver_id_type = '00N4A00000FgLGC';
    // $declarant_id_type = '00N4A00000FgLGD';
    $third_vehicle_model = '00N4A00000FgLGA';
    $third_vehicle_brand = '00N4A00000FgLG9';
    $third_vehicle_type = '00N4A00000FgLGE';
    $third_license = '00N4A00000FgLGB';

    if ($_ENV['AH_SITE_ENVIRONMENT'] == 'prod') {

      $orgid = '00DA0000000AD5W';
      $sinister = '00N4A00000FkiLK';
      $sinister_date = '00N4A00000FkjTs';
      $report_type = '00N4A00000FkWpu';
      $vehicle_brand = '00N4A00000FkhWk';
      $vehicle_type = '00N4A00000FkWpk';
      $vehicle_model = '00N4A00000FkWpp';
      $insured_email = '00N4A00000FkhdC';
      $insured_cellphone = '00N4A00000FkhdH';
      // $driver_name = '00N4A00000FkWq9';
      // $driver_id_num = '00N4A00000FkWqE';
      // $driver_email = '00N4A00000FkWqT';
      // $driver_cellphone = '00N4A00000FkWqO';
      // $driver_phone = '00N4A00000FkWqJ';
      // $driver_address = '00N4A00000FkWqY';
      $declarant_name = '00N4A00000FkWqd';
      $declarant_doc_type = '00N4A00000FgLGD';
      $declarant_id_num = '00N4A00000FkWqi';
      $declarant_phone = '00N4A00000FkWqn';
      $declarant_cellphone = '00N4A00000FkWqs';
      $declarant_email = '00N4A00000FkWqx';
      $declarant_address = '00N4A00000FkWr2';
      $sinister_description = '00N4A00000FkWr7';
      $sinister_address = '00N4A00000FkWrC';
      $sinister_has_deaths = '00N4A00000FkWrl';
      $sinister_num_deaths = '00N4A00000Fkhd2';
      $sinister_police = '00N4A00000FkWrW';
      $sinister_injured = '00N4A00000FkWrg';
      $sinister_num_injured = '00N4A00000Fkhd7';
      $section_roof = '00N4A00000FkhXJ';
      $section_front = '00N4A00000FkhWp';
      $section_front_left = '00N4A00000FkhWu';
      $section_front_right = '00N4A00000FkhWz';
      $section_back_left = '00N4A00000FkhX4';
      $section_back_right = '00N4A00000FkhX9';
      $section_back = '00N4A00000FkhXE';
      $section_down = '00N4A00000Fklz2';
      $third_doc_type = '00N4A00000FkjTv';
      $third_doc_num = '00N4A00000FkjTo';
      $third_name = '00N4A00000FkjTt';
      $third_cellphone = '00N4A00000FkjTu';
      $third_phone = '00N4A00000FkjTp';
      $third_email = '00N4A00000FkjTr';
      $third_address = '00N4A00000FkjTq';
      $insured_address = '00N4A00000FgLG8';
      // $driver_id_type = '00N4A00000FgLGC';
      // $declarant_id_type = '00N4A00000FgLGD';
      $third_vehicle_model = '00N4A00000FgLGA';
      $third_vehicle_brand = '00N4A00000FgLG9';
      $third_vehicle_type = '00N4A00000FgLGE';
      $third_license = '00N4A00000FgLGB';
    }

    $form['form_close'] = [
      '#prefix' => '<div class="is-mobile form-item js-form-type-webform-markup form-type-webform-markup form-item- form-no-label">',
      '#suffix' => '</div>',
      '#markup' => '<a id="close" class="close is-mobile">Close</a>',
    ];

    if ($_ENV['AH_SITE_ENVIRONMENT'] != 'prod') {
      $form['debug'] = [
        '#type' => 'hidden',
        '#value' => 1,
        '#name' => 'debug',
      ];

      // Test QA.
      $form['debugEmail'] = [
        '#type' => 'hidden',
        '#value' => 'andrs.alvarez@esinergia.co',
        '#name' => 'debugEmail',
      ];
    }

    // Hidden fields.
    $form['orgid'] = [
      '#type' => 'hidden',
      '#name' => 'orgid',
      '#value' => $orgid,
    ];

    $form[$sinister] = [
      '#type' => 'hidden',
      '#name' => $sinister,
      '#value' => 'Siniestros Autos',
      '#attributes' => [
        'id' => $sinister,
      ],
    ];

    $form['00N4A00000G91wx'] = [
      '#type' => 'hidden',
      '#name' => '00N4A00000G91wx',
      '#value' => 'ECUADOR',
      '#attributes' => [
        'id' => '00N4A00000G91wx',
      ],
    ];

    global $base_url;
    $current_path = \Drupal::service('path.current')->getPath();
    $current_alias = \Drupal::service('path_alias.manager')->getAliasByPath($current_path);
    $retURL = $base_url . $current_alias . '?resp=1';
    $form['retURL'] = [
      '#type' => 'hidden',
      '#name' => 'retURL',
      '#value' => $retURL,
    ];

    // sinister_vehicles.
    $form['00N4A00000FkiLK'] = [
      '#type' => 'hidden',
      '#name' => '00N4A00000FkiLK',
      '#value' => 'Siniestros Autos',
      '#attributes' => [
        'id' => '00N4A00000FkiLK',
      ],
    ];
    // STEP HEADERS
    // Desktop
    // Three elements.
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

    // Mobile
    // Three elements.
    $form['header_steps3_mb'] = [
      '#prefix' => '<div class="header-steps three-elements is-mobile">',
      '#suffix' => '</div>',
      '#markup' => '<span class="step-1 active">1</span><span class="step-2">2</span><span class="step-3">3</span>',
    ];

    // ***********************
    // ******** STEP 1 *******
    // ***********************
    $form['step1'] = [
      '#type' => 'container',
      '#prefix' => '<div class="steps step-1 active" step="1">',
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
      '#name' => $report_type,
      '#required' => TRUE,
      '#options' => [
        "Responsabilidad civil daños materiales" => $this->t("Responsabilidad civil daños materiales."),
        "Responsabilidad civil lesiones" => $this->t("Responsabilidad civil lesiones."),
      ],
      '#attributes' => [
        'id' => $report_type,
      ],
    ];

    // Brand.
    $opts_brands = $libCoreController->sinistersVehiclesBrandsSelect();

    $form['step1']['ins_veh_info'][$vehicle_brand] = [
      '#type' => 'select',
      '#title' => 'Marca',
      '#options' => $opts_brands,
      '#name' => $vehicle_brand,
      '#attributes' => [
        'id' => $vehicle_brand,
      ],
    ];

    // type_vehicle.
    $form['step1']['ins_veh_info'][$vehicle_type] = [
      '#type' => 'select',
      '#title' => 'Tipo de vehiculo',
      '#required' => TRUE,
      '#name' => $vehicle_type,
      '#options' => [
        'Livianos' => $this->t('Livianos'),
        'Pesados' => $this->t('Pesados'),
        'Motos' => $this->t('Motos'),
      ],
      '#attributes' => [
        'id' => $vehicle_type,
      ],
    ];

    $opts_year = [];
    for ($i = 1980; $i <= 2022; $i++) {
      $opts_year[$i] = $i;
    }
    arsort($opts_year);
    // Model.
    $form['step1']['ins_veh_info'][$vehicle_model] = [
      '#type' => 'select',
      '#title' => 'Modelo',
      '#required' => TRUE,
      '#name' => $vehicle_model,
      '#options' => $opts_year,
      '#attributes' => [
        'id' => $vehicle_model,
      ],
    ];

    // Plaque.
    $form['step1']['ins_veh_info']['00NG000000998UR'] = [
      '#type' => 'textfield',
      '#title' => 'Placa',
      '#maxlength' => 8,
      '#required' => TRUE,
      '#name' => '00NG000000998UR',
      '#attributes' => [
        'id' => '00NG000000998UR',
      ],
    ];

    $form['step1']['ins_veh_info']['00N4A00000G91ww'] = [
      '#type' => 'textfield',
      '#title' => 'Número de Motor',
      '#maxlength' => 255,
      '#name' => '00N4A00000G91ww',
      '#attributes' => [
        'id' => '00N4A00000G91ww',
      ],
    ];

    $form['step1']['ins_veh_info']['00N4A00000G91wv'] = [
      '#type' => 'textfield',
      '#title' => 'Número Chasis',
      '#maxlength' => 255,
      '#name' => '00N4A00000G91wv',
      '#attributes' => [
        'id' => '00N4A00000G91wv',
      ],
    ];

    // Container
    // Affected vehicle owner
    // -------------------------.
    $form['step1']['affect_vehic_own'] = [
      '#type' => 'container',
      '#prefix' => '<div class="ctn-affect-vehicle-owner">',
      '#suffix' => '</div>',
    ];

    $form['step1']['affect_vehic_own']['title']['#markup'] = '<h3>Datos propietario del vehículo afectado</h3>';

    // affect_vehic_own_type--.
    $form['step1']['affect_vehic_own'][$third_doc_type] = [
      '#type' => 'select',
      '#title' => 'Tipo de documento tercero afectado',
      '#name' => $third_doc_type,
      '#required' => TRUE,
      '#options' => [
        'Cédula de ciudadanía' => $this->t('Cédula de ciudadanía'),
        'Ruc' => $this->t('Ruc'),
        'Pasaporte' => $this->t('Pasaporte'),
      ],
      '#attributes' => [
        'id' => $third_doc_type,
      ],
    ];

    // affect_vehic_own_num_ident.
    $form['step1']['affect_vehic_own'][$third_doc_num] = [
      '#type' => 'textfield',
      '#required' => TRUE,
      '#title' => 'Cédula tercero afectado',
      '#maxlength' => 255,
      '#name' => $third_doc_num,
      '#attributes' => [
        'id' => $third_doc_num,
      ],
    ];

    // affect_vehic_own_name.
    $form['step1']['affect_vehic_own'][$third_name] = [
      '#type' => 'textfield',
      "#required" => TRUE,
      '#title' => 'Nombre tercero afectado',
      '#maxlength' => 40,
      '#name' => $third_name,
      '#attributes' => [
        'id' => $third_name,
      ],
    ];

    // affect_vehic_own_cellphone.
    $form['step1']['affect_vehic_own'][$third_cellphone] = [
      '#type' => 'textfield',
      '#title' => 'Celular tercero afectado',
      '#maxlength' => 255,
      '#required' => TRUE,
      '#name' => $third_cellphone,
      '#attributes' => [
        'id' => $third_cellphone,
      ],
    ];

    // affect_vehic_own_phone.
    $form['step1']['affect_vehic_own'][$third_phone] = [
      '#type' => 'textfield',
      '#title' => 'Teléfono fijo tercero afectado',
      '#maxlength' => 255,
      '#name' => $third_phone,
      '#attributes' => [
        'id' => $third_phone,
      ],
    ];

    // affect_vehic_own_mail.
    $form['step1']['affect_vehic_own'][$third_email] = [
      '#type' => 'textfield',
      '#title' => 'Email tercero afectado',
      '#name' => $third_email,
      '#attributes' => [
        'id' => $third_email,
      ],
    ];

    // affect_vehic_own_address.
    $form['step1']['affect_vehic_own'][$third_address] = [
      '#type' => 'textfield',
      '#title' => 'Dirección tercero afectado',
      '#maxlength' => 255,
      '#name' => $third_address,
      '#attributes' => [
        'id' => $third_address,
      ],
    ];

    $opts_year = [];
    for ($i = 1980; $i <= 2025; $i++) {
      $opts_year[$i] = $i;
    }
    arsort($opts_year);
    // affect_vehic_own_model.
    $form['step1']['affect_vehic_own'][$third_vehicle_model] = [
      '#type' => 'select',
      '#required' => TRUE,
      '#title' => 'Modelo de vehiculo tercero afectado',
      '#name' => $third_vehicle_model,
      '#options' => $opts_year,
      '#attributes' => [
        'id' => $third_vehicle_model,
      ],
    ];

    // affect_vehic_own_brand.
    $form['step1']['affect_vehic_own'][$third_vehicle_brand] = [
      '#type' => 'select',
      '#title' => 'Marca de vehiculo tercero afectado',
      '#options' => $opts_brands,
      '#name' => $third_vehicle_brand,
      '#attributes' => [
        'id' => $third_vehicle_brand,
      ],
    ];

    // affect_vehic_own_type_vehicle.
    $form['step1']['affect_vehic_own'][$third_vehicle_type] = [
      '#type' => 'select',
      '#title' => 'Tipo de vehiculo Tercero afectado',
      '#name' => $third_vehicle_type,
      '#required' => TRUE,
      '#options' => [
        'Livianos' => $this->t('Livianos'),
        'Pesados' => $this->t('Pesados'),
        'Motos' => $this->t('Motos'),
      ],
      '#attributes' => [
        'id' => $third_vehicle_type,
      ],
    ];

    $opts_cities = $libCoreController->sinistersCitiesSelect('salesforce');
    $form['step1']['affect_vehic_own']['00NG000000FWynf'] = [
      '#type' => 'select',
      '#title' => 'Ciudad y departamento de reparación',
      '#options' => $opts_cities,
      '#name' => '00NG000000FWynf',
      '#attributes' => [
        'id' => '00NG000000FWynf',
      ],
    ];

    // Plaque.
    $form['step1']['affect_vehic_own'][$third_license] = [
      '#type' => 'textfield',
      '#title' => 'Placa de vehiculo Tercero afectado',
      '#maxlength' => 8,
      '#name' => $third_license,
      '#attributes' => [
        'id' => $third_license,
      ],
    ];

    // Container
    // Insured info
    // -------------------------.
    $form['step1']['insured_info'] = [
      '#type' => 'container',
      '#prefix' => '<div class="ctn-insured-info is-hidden">',
      '#suffix' => '</div>',
    ];

    $form['step1']['insured_info']['subtitle']['#markup'] = '<h3>Información del Asegurado</h3>';

    // insured_ident_type.
    $form['step1']['insured_info']['00NG000000FWyoW'] = [
      '#type' => 'select',
      '#title' => 'Tipo de identificación',
      '#name' => '00NG000000FWyoW',
      '#options' => [
        'Cédula de ciudadanía' => $this->t('Cédula de ciudadanía'),
        'Ruc' => $this->t('Ruc'),
        'Pasaporte' => $this->t('Pasaporte'),
      ],
      '#attributes' => [
        'id' => '00NG000000FWyoW',
      ],
    ];

    // insured_num_ident.
    $form['step1']['insured_info']['00NG000000FWyoI'] = [
      '#type' => 'textfield',
      '#title' => 'Número de identificación asegurado',
      '#maxlength' => 50,
      '#name' => '00NG000000FWyoI',
      '#attributes' => [
        'id' => '00NG000000FWyoI',
      ],
    ];

    // insured_name.
    $form['step1']['insured_info']['00NG000000998UJ'] = [
      '#type' => 'textfield',
      '#title' => 'Nombre del asegurado',
      '#maxlength' => 40,
      '#name' => '00NG000000998UJ',
      '#attributes' => [
        'id' => '00NG000000998UJ',
      ],
    ];

    // insured_cellphone.
    $form['step1']['insured_info'][$insured_cellphone] = [
      '#type' => 'number',
      '#title' => 'Celular del asegurado',
      '#maxlength' => 255,
      '#name' => $insured_cellphone,
      '#attributes' => [
        'id' => $insured_cellphone,
      ],
    ];

    // insured_mail.
    $form['step1']['insured_info'][$insured_email] = [
      '#type' => 'textfield',
      '#title' => 'Email asegurado',
      '#maxlength' => 255,
      '#name' => $insured_email,
      '#attributes' => [
        'id' => $insured_email,
      ],
    ];

    // insured_address.
    $form['step1']['insured_info'][$insured_address] = [
      '#type' => 'textfield',
      '#title' => 'Dirección asegurado',
      '#maxlength' => 255,
      '#name' => $insured_address,
      '#attributes' => [
        'id' => $insured_address,
      ],
    ];

    // ***********************
    // ******** STEP 2 *******
    // ***********************
    $form['step2'] = [
      '#type' => 'container',
      '#prefix' => '<div class="steps step-2 is-hidden" step="2">',
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

    $mrkup = '<div class="form-item">
      <h3>¿El declarante es el mismo tercero afectado?</h3>
      <div id="edit-declarant-same-third" class="switch" style="margin-top: 2rem;">
      <input data-drupal-selector="edit-declarant-same-third-si" type="radio" id="edit-declarant-same-third-si" name="declarant_same_third" value="Si" class="form-radio toggle toggle-left">
      <label for="edit-declarant-same-third-si" class="option btn btn-left">Si</label>
      <input data-drupal-selector="edit-declarant-same-third-no" type="radio" id="edit-declarant-same-third-no" name="declarant_same_third" value="No" class="form-radio toggle toggle-right" checked="checked">
      <label for="edit-declarant-same-third-no" class="option btn btn-right" style="margin-left: 0px;">No</label>
      </div>
      </div>';
    $form['step2']['declarant_info']['declarant_same_third'] = [
      '#markup' => $mrkup,
      '#allowed_tags' => ['input', 'label', 'div', 'h2'],
    ];

    $form['step2']['declarant_info']['title']['#markup'] = '<h3>Información del declarante</h3>';

    $form['step2']['declarant_info'][$declarant_doc_type] = [
      '#type' => 'select',
      '#title' => 'Tipo de documento Declarante',
      '#name' => $declarant_doc_type,
      '#required' => TRUE,
      '#options' => [
        'Cédula de ciudadanía' => $this->t('Cédula de ciudadanía'),
        'Ruc' => $this->t('Ruc'),
        'Pasaporte' => $this->t('Pasaporte'),
      ],
      '#attributes' => [
        'id' => $declarant_doc_type,
      ],
    ];

    // declarant_num_ident.
    $form['step2']['declarant_info'][$declarant_id_num] = [
      '#type' => 'textfield',
      '#title' => 'Número de identificación declarante',
      '#maxlength' => 18,
      '#required' => TRUE,
      '#name' => $declarant_id_num,
      '#attributes' => [
        'id' => $declarant_id_num,
      ],
    ];

    // declarant_name.
    $form['step2']['declarant_info'][$declarant_name] = [
      '#type' => 'textfield',
      '#title' => 'Nombre del declarante',
      '#maxlength' => 40,
      '#required' => TRUE,
      '#name' => $declarant_name,
      '#attributes' => [
        'id' => $declarant_name,
      ],
    ];

    // declarant_cellphone.
    $form['step2']['declarant_info'][$declarant_cellphone] = [
      '#type' => 'number',
      '#title' => 'Celular del declarante',
      '#maxlength' => 40,
      '#required' => TRUE,
      '#name' => $declarant_cellphone,
      '#attributes' => [
        'id' => $declarant_cellphone,
      ],
    ];

    // declarant_phone.
    $form['step2']['declarant_info'][$declarant_phone] = [
      '#type' => 'textfield',
      '#title' => 'Teléfono fijo declarante',
      '#maxlength' => 18,
      '#name' => $declarant_phone,
      '#attributes' => [
        'id' => $declarant_phone,
      ],
    ];

    // declarant_mail.
    $form['step2']['declarant_info'][$declarant_email] = [
      '#type' => 'textfield',
      '#title' => 'Email declarante',
      '#maxlength' => 50,
      '#required' => TRUE,
      '#name' => $declarant_email,
      '#attributes' => [
        'id' => $declarant_email,
      ],
    ];

    // declarant_address.
    $form['step2']['declarant_info'][$declarant_address] = [
      '#type' => 'textfield',
      '#title' => 'Dirección declarante',
      '#maxlength' => 50,
      '#required' => TRUE,
      '#name' => $declarant_address,
      '#attributes' => [
        'id' => $declarant_address,
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

    // Description.
    $form['step2']['sinister_info'][$sinister_description] = [
      '#title' => 'Descripción de los hechos',
      '#type' => 'textarea',
      '#required' => TRUE,
      '#name' => $sinister_description,
      '#attributes' => [
        'id' => $sinister_description,
      ],
    ];

    // address_sinister.
    $form['step2']['sinister_info'][$sinister_address] = [
      '#type' => 'textfield',
      '#title' => 'Dirección ocurrencia',
      '#maxlength' => 50,
      '#required' => TRUE,
      '#name' => $sinister_address,
      '#attributes' => [
        'id' => $sinister_address,
      ],
    ];

    // exist_deaths.
    $form['step2']['sinister_info'][$sinister_has_deaths] = [
      '#type' => 'select',
      '#title' => 'Existen muertos',
      '#required' => TRUE,
      '#name' => $sinister_has_deaths,
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
      '#name' => $sinister_num_deaths,
      '#options' => [
        '' => $this->t('- Seleccione -'),
        '1' => $this->t('1'),
        'Mas de 1' => $this->t('Mas de 1'),
      ],
      '#attributes' => [
        'id' => $sinister_num_deaths,
      ],
    ];

    // intervened_police.
    $form['step2']['sinister_info'][$sinister_police] = [
      '#type' => 'select',
      '#title' => 'Intervino Circulacion',
      '#required' => TRUE,
      '#name' => $sinister_police,
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
      '#required' => TRUE,
      '#name' => $sinister_injured,
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
      '#name' => $sinister_num_injured,
      '#options' => [
        '' => $this->t('- Seleccione -'),
        '1' => $this->t('1'),
        'Mas de 1' => $this->t('Mas de 1'),
      ],
      '#attributes' => [
        'id' => $sinister_num_injured,
      ],
    ];

    // date_sinister.
    $form['step2']['sinister_info'][$sinister_date] = [
      '#type' => 'textfield',
      '#title' => 'Fecha y hora de ocurrencia',
      '#maxlength' => 20,
      '#name' => $sinister_date,
      '#attributes' => [
        'id' => 'date-field-third',
        'class' => ['date-field-third', 'date-field'],
      ],
    ];

    // ***********************
    // ******** STEP 3 *******
    // ***********************
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

    $form['step3']['area_vehicle']['title']['#markup'] = '<h2 class="principal">Marca la Zona Afectada de tu Vehículo</h2>';

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
    $form['step3']['area_vehicle'][$section_down] = [
      '#type' => 'checkbox',
      '#title' => 'Por debajo',
      '#name' => $section_down,
      '#attributes' => [
        'id' => 'edit-' . $section_down,
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

    \Drupal::service('page_cache_kill_switch')->trigger();

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $form_state->setRebuild(TRUE);
    $submission_data = [];

    $webform = Webform::load('aviso_de_siniestro_tercero_afect');
    if ($webform->hasSubmissions()) {
      $query = \Drupal::entityQuery('webform_submission')
        ->condition('webform_id', 'aviso_de_siniestro_tercero_afect')->sort('created', 'DESC')->range(0, 1);
      $result = $query->execute();

      foreach ($result as $item) {
        $submission = WebformSubmission::load($item);
        $submission_data = $submission->getData();
        error_log(print_r($submission_data, TRUE));

      }
    }
    // error_log(print_r($values, true));.
    if (isset($submission_data['00n4a00000fkjtu'])) {
      if ($submission_data['00n4a00000fkjtu'] != $values['00n4a00000fkjtu']) {
        // Post to webform and sales force.
        $coreController = new LibCoreController();
        $coreController->webformRestPost('aviso_de_siniestro_tercero_afect', $values);
      }
    }
    else {
      $coreController = new LibCoreController();
      $coreController->webformRestPost('aviso_de_siniestro_tercero_afect', $values);
    }

  }

}
