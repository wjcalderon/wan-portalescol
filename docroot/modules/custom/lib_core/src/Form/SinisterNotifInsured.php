<?php
namespace Drupal\lib_core\Form;

use Drupal;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\lib_core\Controller\LibCoreControllerMain;

class SinisterNotifInsured extends FormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'sinister_notific_insured_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        // Fields SF id's
        $orgid = $_ENV['ENDPOINT_ORGID'];
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

        if ($_ENV['AH_SITE_ENVIRONMENT'] == 'prod') {
            $orgid = '00DA0000000AD5W';
        }

        $form['#attached']['library'][] = 'lib_core/sinister_notice';
        $form['#attributes']['cdtype-form'] = 'insured';
        $form['#attributes']['class'] = ['form-ctn-notif-sinister'];

        $form['form_close'] = array(
            '#prefix' => '<div class="is-mobile form-item js-form-type-webform-markup form-type-webform-markup form-item- form-no-label">',
            '#suffix' => '</div>',
            '#markup' => '<a  id="close" class="close is-mobile">Close</a>',
        );

        if ($_ENV['AH_SITE_ENVIRONMENT'] != 'prod') {
            // Hidden fields
            // Test
            $form['debug'] = array(
                '#type' => 'hidden',
                '#value' => 1,
                '#name' => 'debug',
            );

            $form['debugEmail'] = array(
                '#type' => 'hidden',
                // '#value' => 'lmacea@avanxo.com',
                '#value' => 'Dari.Hernandez@libertyseguros.co',
                '#name' => 'debugEmail',
            );
            // ------- Fin test ----------
        }

        $form['orgid'] = array(
            '#type' => 'hidden',
            '#name' => 'orgid',
            '#value' => $orgid,
            // '#value' => '00DJ0000003Sezd',
        );

        $form['00N4A00000G91wx'] = array(
            '#type' => 'hidden',
            '#name' => '00N4A00000G91wx',
            '#value' => 'COLOMBIA',
        );

        global $base_url;
        $current_path = \Drupal::service('path.current')->getPath();
        $current_alias = \Drupal::service('path_alias.manager')->getAliasByPath($current_path);
        $retURL = $base_url . $current_alias . '?resp=1';
        $form['retURL'] = array(
            '#type' => 'hidden',
            '#name' => 'retURL',
            '#value' => $retURL,
        );

        $form[$sinister] = array(
            '#type' => 'hidden',
            '#name' => $sinister,
            '#value' => 'Siniestros Autos',
            '#attributes' => array(
                'id' => $sinister,
            ),
        );

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

        // Two elements
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
        // Three elements
        $form['header_steps3_mb'] = array(
            '#prefix' => '<div class="header-steps three-elements is-mobile">',
            '#suffix' => '</div>',
            '#markup' => '<span class="step-1 active">1</span><span class="step-2">2</span><span class="step-3">3</span>',
        );
        // Two elements
        $form['header_steps2_mb'] = array(
            '#prefix' => '<div class="header-steps two-elements is-hidden is-mobile">',
            '#suffix' => '</div>',
            '#markup' => '<span class="step-1 active">1</span><span class="step-2">2</span>',
        );

        // ***********************
        // ******** STEP 1 *******
        // ***********************
        $form['step1'] = array(
            '#type' => 'container',
            '#prefix' => '<div class="steps step-1 active" step="1">',
            '#suffix' => '</div>',
        );

        // Container
        // Insure vehicule info
        // -------------------------
        $form['step1']['ins_veh_info'] = array(
            '#type' => 'container',
            '#prefix' => '<div class="ctn-ins-veh-info">',
            '#suffix' => '</div>',
        );

        $form['step1']['ins_veh_info']['title']['#markup'] = '<h2>Información General</h2>';
        $form['step1']['ins_veh_info']['subtitle']['#markup'] = '<h3>Información del Vehículo Asegurado</h3>';

        // sinister_report
        $form['step1']['ins_veh_info'][$report_type] = array(
            '#type' => 'select',
            '#title' => 'Usted va a reportar',
            '#name' => $report_type,
            '#required' => true,
            '#options' => array(
                'Daños en el vehículo a causa de un accidente o evento súbito e imprevisto.' => 'Daños en el vehículo a causa de un accidente o evento súbito e imprevisto.',
                'Hurto de cualquier parte o accesorio de su vehículo.' => 'Hurto de cualquier parte o accesorio de su vehículo.',
                'Hurto de su vehículo.' => 'Hurto de su vehículo.',
                'Pequeños accesorios.' => 'Pequeños accesorios.',
                'Perdida de llaves.' => 'Perdida de llaves.',
                'Llantas estalladas.' => 'Llantas estalladas.',
            ),
            '#attributes' => array(
                'id' => $report_type,
            ),
        );

        // brand
        $LibCoreController = new LibCoreControllerMain;
        $opts_brands = $LibCoreController->sinisters_vehicles_brands_select();
        $form['step1']['ins_veh_info'][$vehicle_brand] = array(
            '#type' => 'select',
            '#title' => 'Marca',
            '#name' => $vehicle_brand,
            '#options' => $opts_brands,
            '#attributes' => array(
                'id' => $vehicle_brand,
            ),
        );

        // type_vehicle
        $form['step1']['ins_veh_info'][$vehicle_type] = array(
            '#type' => 'select',
            '#title' => 'Tipo de vehiculo',
            '#required' => true,
            '#name' => $vehicle_type,
            '#options' => array(
                'Livianos' => 'Livianos',
                'Pesados' => 'Pesados',
                'Motos' => 'Motos',
            ),
            '#attributes' => array(
                'id' => $vehicle_type,
            ),
        );

        $opts_year = [];
        // Actual year
        $y = intval(date('Y'));
        // Actual month
        $m = intval(date('m'));

        for ($i = 1980; $i <= ($m >= 6 ? ($y + 1) : $y); $i++) {
            $opts_year[$i] = $i;
        }
        arsort($opts_year);
        // model
        $form['step1']['ins_veh_info'][$vehicle_model] = array(
            '#type' => 'select',
            '#title' => 'Modelo',
            '#required' => true,
            '#name' => $vehicle_model,
            '#options' => $opts_year,
            '#attributes' => array(
                'id' => $vehicle_model,
            ),
        );

        $opts_cities = $LibCoreController->sinisters_cities_select();
        $form['step1']['ins_veh_info'][$repair_city] = array(
            '#type' => 'select',
            '#title' => 'Ciudad y departamento de reparación',
            '#options' => $opts_cities,
            '#name' => $repair_city,
            '#attributes' => array(
                'id' => $repair_city,
            ),
        );

        // plaque
        $form['step1']['ins_veh_info'][$license_plate] = array(
            '#type' => 'textfield',
            '#title' => 'Placa',
            '#required' => true,
            '#maxlength' => 6,
            '#name' => $license_plate,
            '#attributes' => array(
                'id' => $license_plate,
            ),
        );

        // Container
        // Driver info
        // -------------------------
        $form['step1']['driver_info'] = array(
            '#type' => 'container',
            '#prefix' => '<div class="ctn-driver-info">',
            '#suffix' => '</div>',
        );

        $form['step1']['driver_info']['title']['#markup'] = '<h3>Información del conductor</h3>';

        // driver_ident_type
        $form['step1']['driver_info'][$driver_id] = array(
            '#type' => 'select',
            '#title' => 'Tipo de identificación',
            '#required' => true,
            '#name' => $driver_id,
            '#options' => array(
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
            ),
            '#attributes' => array(
                'id' => $driver_id,
                'class' => ['driver_info-driver_id'],
            ),
        );

        // driver_num_ident
        $form['step1']['driver_info'][$driver_id_num] = array(
            '#type' => 'textfield',
            '#title' => 'Número de identificación conductor',
            '#maxlength' => 15,
            '#required' => true,
            '#name' => $driver_id_num,
            '#attributes' => array(
                'id' => $driver_id_num,
                'class' => ['driver_info-driver_id_num'],
            ),
        );

        // driver_name
        $form['step1']['driver_info'][$driver_name] = array(
            '#type' => 'textfield',
            '#title' => 'Nombre del conductor',
            '#maxlength' => 40,
            '#name' => $driver_name,
            '#attributes' => array(
                'id' => $driver_name,
                'class' => ['driver_info-driver_name'],
            ),
        );

        // driver_cellphone
        $form['step1']['driver_info'][$driver_cellphone] = array(
            '#type' => 'textfield',
            '#title' => 'Celular del conductor',
            '#maxlength' => 10,
            '#name' => $driver_cellphone,
            '#attributes' => array(
                'id' => $driver_cellphone,
                'class' => ['driver_info-driver_cellphone'],
            ),
        );

        // driver_phone
        $form['step1']['driver_info'][$driver_phone] = array(
            '#type' => 'textfield',
            '#title' => 'Teléfono fijo conductor',
            '#maxlength' => 10,
            '#name' => $driver_phone,
            '#attributes' => array(
                'id' => $driver_phone,
                'class' => ['driver_info-driver_phone'],
            ),
        );

        // driver_mail
        $form['step1']['driver_info'][$driver_email] = array(
            '#type' => 'textfield',
            '#title' => 'Email conductor',
            '#name' => $driver_email,
            '#attributes' => array(
                'id' => $driver_email,
                'class' => ['driver_info-driver_email'],
            ),
        );

        // driver_address
        $form['step1']['driver_info'][$driver_address] = array(
            '#type' => 'textfield',
            '#title' => 'Dirección conductor',
            '#name' => $driver_address,
            '#attributes' => array(
                'id' => $driver_address,
                'class' => ['driver_info-driver_address'],
            ),
        );

        $form['step1']['driver_info']['subtitle_driver']['#markup'] = '<div class="form-item"><p>¿El conductor es el mismo asegurado?</p></div>';

        $mrkup = '<div class="form-item">
      <div id="edit-driver-same-insure" class="switch" style="margin-top: 2rem;">
      <input data-drupal-selector="edit-driver-same-insure-si" type="radio" id="edit-driver-same-insure-si" name="driver_same_insure" value="Si" class="form-radio toggle toggle-left">
      <label for="edit-driver-same-insure-si" class="option btn btn-left">Si</label>
      <input data-drupal-selector="edit-driver-same-insure-no" type="radio" id="edit-driver-same-insure-no" name="driver_same_insure" value="No" class="form-radio toggle toggle-right" checked="checked">
      <label for="edit-driver-same-insure-no" class="option btn btn-right" style="margin-left: 0px;">No</label>
      </div>
      </div>';
        $form['step1']['driver_info']['driver_same_insure'] = array(
            '#markup' => $mrkup,
            '#allowed_tags' => ['input', 'label', 'div', 'h2'],
        );

        // Container
        // Insured info
        // -------------------------
        $form['step1']['insured_info'] = array(
            '#type' => 'container',
            '#prefix' => '<div class="ctn-insured-info">',
            '#suffix' => '</div>',
        );

        $form['step1']['insured_info']['subtitle']['#markup'] = '<h3>Información del Asegurado</h3>';

        // insured_ident_type
        $form['step1']['insured_info'][$insured_id] = array(
            '#type' => 'select',
            '#title' => 'Tipo de identificación',
            '#name' => $insured_id,
            '#required' => true,
            '#options' => array(
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
            ),
            '#attributes' => array(
                'id' => $insured_id,
                'class' => ['insured_info-insured_id'],
            ),
        );

        // insured_num_ident
        $form['step1']['insured_info'][$insured_id_num] = array(
            '#type' => 'textfield',
            '#title' => 'Número de identificación asegurado',
            '#name' => $insured_id_num,
            '#attributes' => array(
                'id' => $insured_id_num,
                'class' => ['insured_info-insured_id_num'],
            ),
        );

        // insured_name
        $form['step1']['insured_info'][$insured_name] = array(
            '#type' => 'textfield',
            '#title' => 'Nombre del asegurado',
            '#maxlength' => 40,
            '#name' => $insured_name,
            '#attributes' => array(
                'id' => $insured_name,
                'class' => ['insured_info-insured_name'],
            ),
        );

        // insured_cellphone
        $form['step1']['insured_info'][$insured_cellphone] = array(
            '#type' => 'textfield',
            '#title' => 'Celular del asegurado',
            '#maxlength' => 10,
            '#name' => $insured_cellphone,
            '#attributes' => array(
                'id' => $insured_cellphone,
                'class' => ['insured_info-insured_cellphone'],
            ),
        );

        // insured_mail
        $form['step1']['insured_info'][$insured_email] = array(
            '#type' => 'textfield',
            '#title' => 'Email asegurado',
            '#name' => $insured_email,
            '#attributes' => array(
                'id' => $insured_email,
                'class' => ['insured_info-insured_email'],
            ),
        );

        // insured_address
        $form['step1']['insured_info'][$insured_address] = array(
            '#type' => 'textfield',
            '#title' => 'Dirección asegurado',
            '#name' => $insured_address,
            '#attributes' => array(
                'id' => $insured_address,
                'class' => ['insured_info-insured_address'],
            ),
        );

        // ***********************
        // ******** STEP 2 *******
        // ***********************
        $form['step2'] = array(
            '#type' => 'container',
            '#prefix' => '<div class="steps step-2 is-hidden" step="2">',
            '#suffix' => '</div>',
        );

        // Container
        // Declarant info
        // -------------------------
        $form['step2']['declarant_info'] = array(
            '#type' => 'container',
            '#prefix' => '<div class="ctn-declarant-info">',
            '#suffix' => '</div>',
        );

        $form['step2']['declarant_info']['subtitle_declarant']['#markup'] = '<div class="form-item"><p>¿El declarante es el mismo asegurado?</p></div>';

        $mrkup = '<div class="form-item">
      <div id="edit-driver-same-insure" class="switch" style="margin-top: 2rem;">
      <input data-drupal-selector="edit-declarant-same-insure-si" type="radio" id="edit-declarant-same-insure-si" name="declarant_same_insure" value="Si" class="form-radio toggle toggle-left">
      <label for="edit-declarant-same-insure-si" class="option btn btn-left">Si</label>
      <input data-drupal-selector="edit-declarant-same-insure-no" type="radio" id="edit-declarant-same-insure-no" name="declarant_same_insure" value="No" class="form-radio toggle toggle-right" checked="checked">
      <label for="edit-declarant-same-insure-no" class="option btn btn-right" style="margin-left: 0px;">No</label>
      </div>
      </div>';
        $form['step2']['declarant_info']['declarant_same_insure'] = array(
            '#markup' => $mrkup,
            '#allowed_tags' => ['input', 'label', 'div', 'h2'],
        );

        $form['step2']['declarant_info']['title']['#markup'] = '<h3>Información del declarante</h3>';

        // declarant_ident_type
        $form['step2']['declarant_info'][$declarant_id] = array(
            '#type' => 'select',
            '#title' => 'Tipo de documento Declarante',
            '#name' => $declarant_id,
            '#required' => true,
            '#options' => array(
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
            ),
            '#attributes' => array(
                'id' => $declarant_id,
                'class' => ['declarant_info-declarant_id'],
            ),
        );

        // declarant_num_ident
        $form['step2']['declarant_info'][$declarant_id_num] = array(
            '#type' => 'textfield',
            '#title' => 'Número de identificación declarante',
            '#name' => $declarant_id_num,
            '#attributes' => array(
                'id' => $declarant_id_num,
                'class' => ['declarant_info-declarant_id_num'],
            ),
        );

        // declarant_name
        $form['step2']['declarant_info'][$declarant_name] = array(
            '#type' => 'textfield',
            '#title' => 'Nombre del declarante',
            '#maxlength' => 40,
            '#name' => $declarant_name,
            '#attributes' => array(
                'id' => $declarant_name,
                'class' => ['declarant_info-declarant_name'],
            ),
        );

        // declarant_cellphone
        $form['step2']['declarant_info'][$declarant_cellphone] = array(
            '#type' => 'textfield',
            '#title' => 'Celular del declarante',
            '#maxlength' => 10,
            '#name' => $declarant_cellphone,
            '#attributes' => array(
                'id' => $declarant_cellphone,
                'class' => ['declarant_info-declarant_cellphone'],
            ),
        );

        // declarant_phone
        $form['step2']['declarant_info'][$declarant_phone] = array(
            '#type' => 'textfield',
            '#title' => 'Teléfono fijo declarante',
            '#maxlength' => 10,
            '#name' => $declarant_phone,
            '#attributes' => array(
                'id' => $declarant_phone,
                'class' => ['declarant_info-declarant_phone'],
            ),
        );

        // declarant_mail
        $form['step2']['declarant_info'][$declarant_email] = array(
            '#type' => 'textfield',
            '#title' => 'Email declarante',
            '#name' => $declarant_email,
            '#attributes' => array(
                'id' => $declarant_email,
                'class' => ['declarant_info-declarant_email'],
            ),
        );

        // declarant_address
        $form['step2']['declarant_info'][$declarant_address] = array(
            '#type' => 'textfield',
            '#title' => 'Dirección declarante',
            '#name' => $declarant_address,
            '#attributes' => array(
                'id' => $declarant_address,
                'class' => ['declarant_info-declarant_address'],
            ),
        );

        // Container
        // Sinester info
        // -------------------------
        $form['step2']['sinister_info'] = array(
            '#type' => 'container',
            '#prefix' => '<div class="ctn-descrip-sinister-info">',
            '#suffix' => '</div>',
        );

        $form['step2']['sinister_info']['title']['#markup'] = '<h3>Ocurrencia del Siniestro</h3>';

        // description_sinister
        $form['step2']['sinister_info'][$sinister_description] = array(
            '#title' => 'Descripción de los hechos',
            '#type' => 'textarea',
            '#name' => $sinister_description,
            '#attributes' => array(
                'id' => $sinister_description,
            ),
        );

        // address_sinister
        $form['step2']['sinister_info'][$sinister_address] = array(
            '#type' => 'textfield',
            '#title' => 'Dirección ocurrencia',
            '#name' => $sinister_address,
            '#attributes' => array(
                'id' => $sinister_address,
            ),
        );

        // exist_deaths
        $form['step2']['sinister_info'][$sinister_has_deaths] = array(
            '#type' => 'select',
            '#title' => 'Existen muertos',
            '#name' => $sinister_has_deaths,
            '#required' => true,
            '#options' => array(
                'Si' => 'Si',
                'No' => 'No',
            ),
            '#attributes' => array(
                'id' => $sinister_has_deaths,
            ),
        );

        // num_deaths
        $form['step2']['sinister_info'][$sinister_num_deaths] = array(
            '#type' => 'select',
            '#title' => 'Número de muertos',
            '#name' => $sinister_num_deaths,
            '#options' => array(
                '' => '- Seleccione -',
                '1' => '1',
                'Mas de 1' => 'Mas de 1',
            ),
            '#attributes' => array(
                'id' => $sinister_num_deaths,
            ),
        );

        // intervened_police
        $form['step2']['sinister_info'][$sinister_police] = array(
            '#type' => 'select',
            '#title' => 'Intervino policía de tránsito',
            '#name' => $sinister_police,
            '#required' => true,
            '#options' => array(
                'Si' => 'Si',
                'No' => 'No',
            ),
            '#attributes' => array(
                'id' => $sinister_police,
            ),
        );

        // exist_wounded
        $form['step2']['sinister_info'][$sinister_injured] = array(
            '#type' => 'select',
            '#title' => 'Existen heridos',
            '#name' => $sinister_injured,
            '#required' => true,
            '#options' => array(
                'Si' => 'Si',
                'No' => 'No',
            ),
            '#attributes' => array(
                'id' => $sinister_injured,
            ),
        );

        // num_wounded
        $form['step2']['sinister_info'][$sinister_num_injured] = array(
            '#type' => 'select',
            '#title' => 'Número de heridos',
            '#name' => $sinister_num_injured,
            '#options' => array(
                '' => '- Seleccione -',
                '1' => '1',
                'Mas de 1' => 'Mas de 1',
            ),
            '#attributes' => array(
                'id' => $sinister_num_injured,
            ),
        );

        // date_sinister
        $form['step2']['sinister_info'][$sinister_date] = array(
            '#type' => 'textfield',
            '#title' => 'Fecha y hora de ocurrencia',
            '#name' => $sinister_date,
            '#attributes' => array(
                'id' => 'date-field-insured',
                'class' => array('date-field-insured'),
            ),
        );

        // **********************
        // ******** STEP 3 ******
        // **********************
        $form['step3'] = array(
            '#type' => 'container',
            '#prefix' => '<div class="steps step-3 is-hidden" step="3">',
            '#suffix' => '</div>',
        );

        // Container
        // Affected area vehicle
        // -------------------------
        $form['step3']['area_vehicle'] = array(
            '#type' => 'container',
            '#prefix' => '<div class="ctn-affected-vehicle-info">',
            '#suffix' => '</div>',
        );

        $form['step3']['area_vehicle']['title']['#markup'] = '<h2>Marca la Zona Afectada de tu Vehículo</h2>';

        // Car image
        $form['step3']['area_vehicle']['car_image'] = array(
            '#markup' => '<img src="/themes/custom/liberty_public/images/car-form.png">',
        );

        // lead
        $form['step3']['area_vehicle'][$section_front] = array(
            '#type' => 'checkbox',
            '#title' => 'Sección delantera',
            '#name' => $section_front,
            '#attributes' => array(
                'id' => 'edit-' . $section_front,
            ),
        );

        // left_front_lateral
        $form['step3']['area_vehicle'][$section_front_left] = array(
            '#type' => 'checkbox',
            '#title' => 'Lateral delantero Izquierdo',
            '#name' => $section_front_left,
            '#attributes' => array(
                'id' => 'edit-' . $section_front_left,
            ),
        );

        // ceiling
        $form['step3']['area_vehicle'][$section_roof] = array(
            '#type' => 'checkbox',
            '#title' => 'techo',
            '#name' => $section_roof,
            '#attributes' => array(
                'id' => 'edit-' . $section_roof,
            ),
        );

        // right_front_lateral
        $form['step3']['area_vehicle'][$section_front_right] = array(
            '#type' => 'checkbox',
            '#title' => 'Lateral delantero derecho',
            '#name' => $section_front_right,
            '#attributes' => array(
                'id' => 'edit-' . $section_front_right,
            ),
        );

        // right_rear_side
        $form['step3']['area_vehicle'][$section_back_left] = array(
            '#type' => 'checkbox',
            '#title' => 'Lateral trasero izquierdo',
            '#name' => $section_back_left,
            '#attributes' => array(
                'id' => 'edit-' . $section_back_left,
            ),
        );

        // left_rear_side
        $form['step3']['area_vehicle'][$section_back_right] = array(
            '#type' => 'checkbox',
            '#title' => 'Lateral trasero derecho',
            '#name' => $section_back_right,
            '#attributes' => array(
                'id' => 'edit-' . $section_back_right,
            ),
        );

        // later_section
        $form['step3']['area_vehicle'][$section_back] = array(
            '#type' => 'checkbox',
            '#title' => 'Sección posterior',
            '#name' => $section_back,
            '#attributes' => array(
                'id' => 'edit-' . $section_back,
            ),
        );

        // under
        $form['step3']['area_vehicle'][$section_under] = array(
            '#type' => 'checkbox',
            '#title' => 'Por debajo',
            '#name' => $section_under,
            '#attributes' => array(
                'id' => 'edit-' . $section_under,
            ),
        );

        $form['ctn_submits'] = array(
            '#prefix' => '<div class="form-item form-actions">',
            '#suffix' => '</div>',
        );

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
    public function validateForm(array &$form, FormStateInterface $form_state)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $values = $form_state->getValues();
        $form_state->setRebuild(true);

        // Post to webform and sales force
        $coreController = new LibCoreControllerMain;
        $coreController->webformRestPost(
            'aviso_de_siniestro_asegurado',
            $values
        );
    }
}
