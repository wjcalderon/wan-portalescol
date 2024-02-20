<?php
<<<<<<< HEAD
namespace Drupal\lib_core\Form;

use Drupal;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\StateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\lib_core\Controller\LibCoreController;
use Symfony\Component\HttpFoundation\RedirectResponse;

=======

namespace Drupal\lib_core\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\lib_core\Controller\LibCoreController;

/**
 * Sinister NotifInsured Salesforce.
 */
>>>>>>> main
class SinisterNotifInsuredSalesforce extends FormBase {

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
<<<<<<< HEAD
    // $form['#action'] = 'https://webto.salesforce.com/servlet/servlet.WebToCase?encoding=UTF-8';
    // $form['#action'] = 'https://libertysegurosandinomarket--qa.my.salesforce.com/servlet/servlet.WebToCase?encoding=UTF-8';
    $form['#attached']['library'][] = 'lib_core/sinister_notice';
    $form['#attributes']['cdtype-form'] = 'insured';
    $form['#attributes']['class'] = array(
      'form-ctn-notif-sinister',
    );
=======
    $form['#attached']['library'][] = 'lib_core/sinister_notice';
    $form['#attributes']['cdtype-form'] = 'insured';
    $form['#attributes']['class'] = [
      'form-ctn-notif-sinister',
    ];
>>>>>>> main

    $orgid = '00D040000004eAH';
    $sinister = '00N4A00000FkiLK';
    $sinister_date = '00N4A00000FkjTs';
    $report_type = '00N4A00000FkWpu';
    $vehicle_brand = '00N4A00000FkhWk';
    $vehicle_type = '00N4A00000FkWpk';
    $vehicle_model = '00N4A00000FkWpp';
    $insured_email = '00N4A00000FkhdC';
    $insured_cellphone = '00N4A00000FkhdH';
    $driver_name = '00N4A00000FkWq9';
    $driver_id_num = '00N4A00000FkWqE';
    $driver_email = '00N4A00000FkWqT';
    $driver_cellphone = '00N4A00000FkWqO';
    $driver_phone = '00N4A00000FkWqJ';
    $driver_address = '00N4A00000FkWqY';
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
<<<<<<< HEAD
    $section_front_left = '00N4A00000FkhWu';  
=======
    $section_front_left = '00N4A00000FkhWu';
>>>>>>> main
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
<<<<<<< HEAD
    $third_email = '00N4A00000FkjTr';      
=======
    $third_email = '00N4A00000FkjTr';
>>>>>>> main
    $third_address = '00N4A00000FkjTq';
    $insured_address = '00N4A00000FgLG8';
    $driver_id_type = '00N4A00000FgLGC';
    $declarant_id_type = '00N4A00000FgLGD';
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
      $driver_name = '00N4A00000FkWq9';
      $driver_id_num = '00N4A00000FkWqE';
      $driver_email = '00N4A00000FkWqT';
      $driver_cellphone = '00N4A00000FkWqO';
      $driver_phone = '00N4A00000FkWqJ';
      $driver_address = '00N4A00000FkWqY';
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
<<<<<<< HEAD
      $section_front_left = '00N4A00000FkhWu';  
=======
      $section_front_left = '00N4A00000FkhWu';
>>>>>>> main
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
<<<<<<< HEAD
      $third_email = '00N4A00000FkjTr';      
=======
      $third_email = '00N4A00000FkjTr';
>>>>>>> main
      $third_address = '00N4A00000FkjTq';
      $insured_address = '00N4A00000FgLG8';
      $driver_id_type = '00N4A00000FgLGC';
      $declarant_id_type = '00N4A00000FgLGD';
      $third_vehicle_model = '00N4A00000FgLGA';
      $third_vehicle_brand = '00N4A00000FgLG9';
      $third_vehicle_type = '00N4A00000FgLGE';
      $third_license = '00N4A00000FgLGB';
    }

<<<<<<< HEAD
    $form['form_close'] = array(
      '#prefix' => '<div class="is-mobile form-item js-form-type-webform-markup form-type-webform-markup form-item- form-no-label">',
      '#suffix' => '</div>',
      '#markup' => '<a id="close" class="close is-mobile">Close</a>'
    );

    // Hidden fields
    $form['orgid'] = array(
      '#type' => 'hidden',
      '#name' => 'orgid',
      '#value' => $orgid,
    );

    // Test QA
    // $form['debug'] = array(
    //   '#type' => 'hidden',
    //   '#value' => 1,
    //   '#name' => 'debug',
    // );

    // Test QA
    // $form['debugEmail'] = array(
    //   '#type' => 'hidden',
    //   '#value' => 'joe.ayala@globant.com',
    //   '#name' => 'debugEmail',
    // );

    // ------- Fin test ----------

=======
    $form['form_close'] = [
      '#prefix' => '<div class="is-mobile form-item js-form-type-webform-markup form-type-webform-markup form-item- form-no-label">',
      '#suffix' => '</div>',
      '#markup' => '<a id="close" class="close is-mobile">Close</a>',
    ];

    // Hidden fields.
    $form['orgid'] = [
      '#type' => 'hidden',
      '#name' => 'orgid',
      '#value' => $orgid,
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

    // ------- Fin test ----------.
>>>>>>> main
    global $base_url;
    $current_path = \Drupal::service('path.current')->getPath();
    $current_alias = \Drupal::service('path_alias.manager')->getAliasByPath($current_path);
    $retURL = $base_url . $current_alias . '?resp=1';
<<<<<<< HEAD
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
      )
    );

    $form['00N4A00000G91wx'] = array(
      '#type' => 'hidden',
      '#name' => '00N4A00000G91wx',
      '#value' => 'ECUADOR',
      '#attributes' => array(
        'id' => '00N4A00000G91wx',
      )
    );

    $form['header_steps3_dk'] = array(
=======
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

    $form['00N4A00000G91wx'] = [
      '#type' => 'hidden',
      '#name' => '00N4A00000G91wx',
      '#value' => 'ECUADOR',
      '#attributes' => [
        'id' => '00N4A00000G91wx',
      ],
    ];

    $form['header_steps3_dk'] = [
>>>>>>> main
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
<<<<<<< HEAD
    );
    // Two elements
    $form['header_steps2_dk'] = array(
=======
    ];
    // Two elements.
    $form['header_steps2_dk'] = [
>>>>>>> main
      '#prefix' => '<div class="header-steps two-elements is-hidden is-desktop">',
      '#suffix' => '</div>',
      '#markup' => '<span class="step-1 active">
        <span class="img"><img src="/themes/custom/liberty_public/images/icons/t1-pasos-sini.svg"></span>
        <span class="label">Primer Paso</span>
      </span>
      <span class="step-2">
        <span class="img"><img src="/themes/custom/liberty_public/images/icons/t2-pasos-sini.svg"></span>
        <span class="label">Segundo Paso</span>
      </span>',
<<<<<<< HEAD
    );

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

=======
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
>>>>>>> main

    // ***********************
    // ******** STEP 1 *******
    // ***********************
<<<<<<< HEAD
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
=======
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
>>>>>>> main

    $form['step1']['ins_veh_info']['title']['#markup'] = '<h2>Información General</h2>';
    $form['step1']['ins_veh_info']['subtitle']['#markup'] = '<h3>Información del Vehículo Asegurado</h3>';

<<<<<<< HEAD
    // sinister_report
    $form['step1']['ins_veh_info'][$report_type] = array(
=======
    // sinister_report.
    $form['step1']['ins_veh_info'][$report_type] = [
>>>>>>> main
      '#type' => 'select',
      '#title' => 'Usted va a reportar',
      '#name' => $report_type,
      '#required' => TRUE,
<<<<<<< HEAD
      '#options' => array(
=======
      '#options' => [
>>>>>>> main
        "Pérdida Parcial Por Accidente" => "Pérdida Parcial Por Accidente.",
        "Pérdida Parcial Por Robo" => "Pérdida Parcial Por Robo.",
        "Pérdida Total Por Accidente" => "Pérdida Total Por Accidente.",
        "Pérdida Total Por Robo" => "Pérdida Total Por Robo.",
        "Responsabilidad civil daños materiales" => "Responsabilidad civil daños materiales.",
        "Responsabilidad civil lesiones" => "Responsabilidad civil lesiones.",
        "Servicio de Grúa" => "Servicio de Grúa.",
<<<<<<< HEAD
      ),
      '#attributes' => array(
        'id' => $report_type,
      )
    );

    // brand
    $LibCoreController = new LibCoreController;
    $opts_brands = $LibCoreController->sinisters_vehicles_brands_select();
    
    $form['step1']['ins_veh_info'][$vehicle_brand] = array(
      '#type' => 'select',
      '#title' => 'Marca',      
      '#options' => $opts_brands,
      '#name' => $vehicle_brand,
      '#attributes' => array(
        'id' => $vehicle_brand,
      )
    );

    // type_vehicle
    $form['step1']['ins_veh_info'][$vehicle_type] = array(
=======
      ],
      '#attributes' => [
        'id' => $report_type,
      ],
    ];

    // Brand.
    $libCoreController = new LibCoreController();
    $opts_brands = $libCoreController->sinistersVehiclesBrandsSelect();

    $form['step1']['ins_veh_info'][$vehicle_brand] = [
      '#type' => 'select',
      '#required' => TRUE,
      '#title' => 'Marca',
      '#options' => $opts_brands,
      '#name' => $vehicle_brand,
      '#attributes' => [
        'id' => $vehicle_brand,
      ],
    ];

    // type_vehicle.
    $form['step1']['ins_veh_info'][$vehicle_type] = [
>>>>>>> main
      '#type' => 'select',
      '#title' => 'Tipo de vehiculo',
      '#required' => TRUE,
      '#name' => $vehicle_type,
<<<<<<< HEAD
      '#options' => array(
        'Livianos' => 'Livianos',
        'Pesados' => 'Pesados',
        'Motos' => 'Motos',
      ),
      '#attributes' => array(
        'id' => $vehicle_type,
      )
    );
=======
      '#options' => [
        'Livianos' => 'Livianos',
        'Pesados' => 'Pesados',
        'Motos' => 'Motos',
      ],
      '#attributes' => [
        'id' => $vehicle_type,
      ],
    ];
>>>>>>> main

    $opts_year = [];
    $y = intval(date('Y'));
    for ($i = 1980; $i <= 2022; $i++) {
      $opts_year[$i] = $i;
    }
    arsort($opts_year);
<<<<<<< HEAD
    // model
    $form['step1']['ins_veh_info'][$vehicle_model] = array(
=======
    // Model.
    $form['step1']['ins_veh_info'][$vehicle_model] = [
>>>>>>> main
      '#type' => 'select',
      '#title' => 'Modelo',
      '#required' => TRUE,
      '#name' => $vehicle_model,
      '#options' => $opts_year,
<<<<<<< HEAD
      '#attributes' => array(
        'id' => $vehicle_model,
      )
    );

    $opts_cities = $LibCoreController->sinisters_cities_select('salesforce');
    $form['step1']['ins_veh_info']['00NG000000FWynf'] = array(
      '#type' => 'select',
      '#title' => 'Ciudad y departamento de reparación',
      '#options' => $opts_cities,
      '#name' => '00NG000000FWynf',
      '#attributes' => array(
        'id' => '00NG000000FWynf',
      )
    );

    // plaque
    $form['step1']['ins_veh_info']['00NG000000998UR'] = array(
=======
      '#attributes' => [
        'id' => $vehicle_model,
      ],
    ];

    $opts_cities = $libCoreController->sinistersCitiesSelect('salesforce');
    $form['step1']['ins_veh_info']['00NG000000FWynf'] = [
      '#type' => 'select',
      '#required' => TRUE,
      '#title' => 'Ciudad y departamento de reparación',
      '#options' => $opts_cities,
      '#name' => '00NG000000FWynf',
      '#attributes' => [
        'id' => '00NG000000FWynf',
      ],
    ];

    // Plaque.
    $form['step1']['ins_veh_info']['00NG000000998UR'] = [
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Placa',
      '#required' => TRUE,
      '#maxlength' => 8,
      '#name' => '00NG000000998UR',
<<<<<<< HEAD
      '#attributes' => array(
        'id' => '00NG000000998UR',
      )
    );

    $form['step1']['engine_number']['00N4A00000G91ww'] = array(
=======
      '#attributes' => [
        'id' => '00NG000000998UR',
      ],
    ];

    $form['step1']['engine_number']['00N4A00000G91ww'] = [
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Número de Motor',
      '#maxlength' => 255,
      '#name' => '00N4A00000G91ww',
<<<<<<< HEAD
      '#attributes' => array(
        'id' => '00N4A00000G91ww',
      )
    );

    $form['step1']['chasis_number']['00N4A00000G91wv'] = array(
=======
      '#attributes' => [
        'id' => '00N4A00000G91ww',
      ],
    ];

    $form['step1']['chasis_number']['00N4A00000G91wv'] = [
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Número Chasis',
      '#maxlength' => 255,
      '#name' => '00N4A00000G91wv',
<<<<<<< HEAD
      '#attributes' => array(
        'id' => '00N4A00000G91wv',
      )
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
    $form['step1']['driver_info']['00N4A00000FgLGC'] = array( 
=======
      '#attributes' => [
        'id' => '00N4A00000G91wv',
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
    $form['step1']['driver_info']['00N4A00000FgLGC'] = [
>>>>>>> main
      '#type' => 'select',
      '#title' => 'Tipo de identificación',
      '#required' => TRUE,
      '#name' => '00N4A00000FgLGC',
<<<<<<< HEAD
      '#options' => array(
        'Cédula de ciudadanía' => 'Cédula de ciudadanía',
        'Ruc' => 'Ruc',
        'Pasaporte' => 'Pasaporte',
      ),
      '#attributes' => array(
        'id' => '00N4A00000FgLGC',
      )
    );

    // driver_num_ident
    $form['step1']['driver_info'][$driver_id_num] = array(
=======
      '#options' => [
        'Cédula de ciudadanía' => 'Cédula de ciudadanía',
        'Ruc' => 'Ruc',
        'Pasaporte' => 'Pasaporte',
      ],
      '#attributes' => [
        'id' => '00N4A00000FgLGC',
      ],
    ];

    // driver_num_ident.
    $form['step1']['driver_info'][$driver_id_num] = [
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Número de identificación conductor',
      '#maxlength' => 100,
      '#required' => TRUE,
      '#name' => $driver_id_num,
<<<<<<< HEAD
      '#attributes' => array(
        'id' => $driver_id_num,
      )
    );

    // driver_name
    $form['step1']['driver_info'][$driver_name] = array(
=======
      '#attributes' => [
        'id' => $driver_id_num,
      ],
    ];

    // driver_name.
    $form['step1']['driver_info'][$driver_name] = [
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Nombre del conductor',
      '#maxlength' => 40,
      '#name' => $driver_name,
<<<<<<< HEAD
      '#attributes' => array(
        'id' => $driver_name,
      )
    );

    // driver_cellphone
    $form['step1']['driver_info'][$driver_cellphone] = array(
=======
      '#attributes' => [
        'id' => $driver_name,
      ],
    ];

    // driver_cellphone.
    $form['step1']['driver_info'][$driver_cellphone] = [
>>>>>>> main
      '#type' => 'number',
      '#title' => 'Celular del conductor',
      '#maxlength' => 40,
      '#name' => $driver_cellphone,
<<<<<<< HEAD
      '#attributes' => array(
        'id' => $driver_cellphone,
      )
    );

    // driver_phone
    $form['step1']['driver_info'][$driver_phone] = array(
=======
      '#attributes' => [
        'id' => $driver_cellphone,
      ],
    ];

    // driver_phone.
    $form['step1']['driver_info'][$driver_phone] = [
>>>>>>> main
      '#type' => 'number',
      '#title' => 'Teléfono fijo conductor',
      '#maxlength' => 40,
      '#name' => $driver_phone,
<<<<<<< HEAD
      '#attributes' => array(
        'id' => $driver_phone,
      )
    );

    // driver_mail
    $form['step1']['driver_info'][$driver_email] = array(
=======
      '#attributes' => [
        'id' => $driver_phone,
      ],
    ];

    // driver_mail.
    $form['step1']['driver_info'][$driver_email] = [
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Email conductor',
      '#maxlength' => 255,
      '#name' => $driver_email,
<<<<<<< HEAD
      '#attributes' => array(
        'id' => $driver_email,
      )
    );

    // driver_address
    $form['step1']['driver_info'][$driver_address] = array(
=======
      '#attributes' => [
        'id' => $driver_email,
      ],
    ];

    // driver_address.
    $form['step1']['driver_info'][$driver_address] = [
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Dirección conductor',
      '#maxlength' => 100,
      '#name' => $driver_address,
<<<<<<< HEAD
      '#attributes' => array(
        'id' => $driver_address,
      )
    );
=======
      '#attributes' => [
        'id' => $driver_address,
      ],
    ];
>>>>>>> main

    $form['step1']['driver_info']['subtitle_driver']['#markup'] = '<div class="form-item"><p>¿El conductor es el mismo asegurado?</p></div>';

    $mrkup = '<div class="form-item">
      <div id="edit-driver-same-insure" class="switch" style="margin-top: 2rem;">
      <input data-drupal-selector="edit-driver-same-insure-si" type="radio" id="edit-driver-same-insure-si" name="driver_same_insure" value="Si" class="form-radio toggle toggle-left">
      <label for="edit-driver-same-insure-si" class="option btn btn-left">Si</label>
      <input data-drupal-selector="edit-driver-same-insure-no" type="radio" id="edit-driver-same-insure-no" name="driver_same_insure" value="No" class="form-radio toggle toggle-right" checked="checked">
      <label for="edit-driver-same-insure-no" class="option btn btn-right" style="margin-left: 0px;">No</label>
      </div>
      </div>';
<<<<<<< HEAD
    $form['step1']['driver_info']['driver_same_insure'] = array(
      '#markup' => $mrkup,
      '#allowed_tags' => ['input', 'label', 'div', 'h2']
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

    // insured_ident_type --

    $form['step1']['insured_info']['00NG000000FWyoW'] = array(
=======
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

    // insured_ident_type --.
    $form['step1']['insured_info']['00NG000000FWyoW'] = [
>>>>>>> main
      '#type' => 'select',
      '#title' => 'Tipo de identificación',
      '#name' => '00NG000000FWyoW',
      '#required' => TRUE,
<<<<<<< HEAD
      '#options' => array(
        'Cédula de ciudadanía' => 'Cédula de ciudadanía',
        'Ruc' => 'Ruc',
        'Pasaporte' => 'Pasaporte',
      ),
      '#attributes' => array(
        'id' => '00NG000000FWyoW',
      )
    );

    // insured_num_ident
    $form['step1']['insured_info']['00NG000000FWyoI'] = array(
=======
      '#options' => [
        'Cédula de ciudadanía' => 'Cédula de ciudadanía',
        'Ruc' => 'Ruc',
        'Pasaporte' => 'Pasaporte',
      ],
      '#attributes' => [
        'id' => '00NG000000FWyoW',
      ],
    ];

    // insured_num_ident.
    $form['step1']['insured_info']['00NG000000FWyoI'] = [
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Número de identificación asegurado',
      '#maxlength' => 50,
      '#name' => '00NG000000FWyoI',
<<<<<<< HEAD
      '#attributes' => array(
        'id' => '00NG000000FWyoI',
      )
    );

    // insured_name
    $form['step1']['insured_info']['00NG000000998UJ'] = array(
=======
      '#attributes' => [
        'id' => '00NG000000FWyoI',
      ],
    ];

    // insured_name.
    $form['step1']['insured_info']['00NG000000998UJ'] = [
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Nombre del asegurado',
      '#maxlength' => 40,
      '#name' => '00NG000000998UJ',
<<<<<<< HEAD
      '#attributes' => array(
        'id' => '00NG000000998UJ',
      )
    );

    // insured_cellphone
    $form['step1']['insured_info'][$insured_cellphone] = array(
=======
      '#attributes' => [
        'id' => '00NG000000998UJ',
      ],
    ];

    // insured_cellphone.
    $form['step1']['insured_info'][$insured_cellphone] = [
>>>>>>> main
      '#type' => 'number',
      '#title' => 'Celular del asegurado',
      '#maxlength' => 255,
      '#name' => $insured_cellphone,
<<<<<<< HEAD
      '#attributes' => array(
        'id' => $insured_cellphone,
      )
    );

    // insured_mail
    $form['step1']['insured_info'][$insured_email] = array(
=======
      '#attributes' => [
        'id' => $insured_cellphone,
      ],
    ];

    // insured_mail.
    $form['step1']['insured_info'][$insured_email] = [
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Email asegurado',
      '#maxlength' => 255,
      '#name' => $insured_email,
<<<<<<< HEAD
      '#attributes' => array(
        'id' => $insured_email,
      )
    );

    // insured_address
    // $form['step1']['insured_info']['00N4A00000FgLG8'] = array(
    //   '#type' => 'textfield',
    //   '#title' => 'Dirección asegurado',
    //   '#maxlength' => 255,
    //   '#name' => '00N4A00000FgLG8',
    //   '#attributes' => array(
    //     'id' => '00N4A00000FgLG8',
    //   )
    // );

    // Policy number
    
    $form['step1']['insured_info']['00NG000000FWyoG'] = array(
=======
      '#attributes' => [
        'id' => $insured_email,
      ],
    ];

    // Policy number.
    $form['step1']['insured_info']['00NG000000FWyoG'] = [
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Número de póliza',
      '#maxlength' => 25,
      '#required' => TRUE,
      '#name' => '00NG000000FWyoG',
<<<<<<< HEAD
      '#attributes' => array(
        'id' => '00NG000000FWyoG',
      )
    );

=======
      '#attributes' => [
        'id' => '00NG000000FWyoG',
      ],
    ];
>>>>>>> main

    // ***********************
    // ******** STEP 2 *******
    // ***********************
<<<<<<< HEAD
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
=======
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
>>>>>>> main

    $form['step2']['declarant_info']['subtitle_declarant']['#markup'] = '<div class="form-item"><p>¿El declarante es el mismo asegurado?</p></div>';

    $mrkup = '<div class="form-item">
      <div id="edit-driver-same-insure" class="switch" style="margin-top: 2rem;">
      <input data-drupal-selector="edit-declarant-same-insure-si" type="radio" id="edit-declarant-same-insure-si" name="declarant_same_insure" value="Si" class="form-radio toggle toggle-left">
      <label for="edit-declarant-same-insure-si" class="option btn btn-left">Si</label>
      <input data-drupal-selector="edit-declarant-same-insure-no" type="radio" id="edit-declarant-same-insure-no" name="declarant_same_insure" value="No" class="form-radio toggle toggle-right" checked="checked">
      <label for="edit-declarant-same-insure-no" class="option btn btn-right" style="margin-left: 0px;">No</label>
      </div>
      </div>';
<<<<<<< HEAD
    $form['step2']['declarant_info']['declarant_same_insure'] = array(
      '#markup' => $mrkup,
      '#allowed_tags' => ['input', 'label', 'div', 'h2']
    );

    $form['step2']['declarant_info']['title']['#markup'] = '<h3>Información del declarante</h3>';

    $form['step2']['declarant_info'][$declarant_doc_type] = array(
=======
    $form['step2']['declarant_info']['declarant_same_insure'] = [
      '#markup' => $mrkup,
      '#allowed_tags' => ['input', 'label', 'div', 'h2'],
    ];

    $form['step2']['declarant_info']['title']['#markup'] = '<h3>Información del declarante</h3>';

    $form['step2']['declarant_info'][$declarant_doc_type] = [
>>>>>>> main
      '#type' => 'select',
      '#title' => 'Tipo de documento Declarante',
      '#name' => $declarant_doc_type,
      '#required' => TRUE,
<<<<<<< HEAD
      '#options' => array(
        'Cédula de ciudadanía' => 'Cédula de ciudadanía',
        'Ruc' => 'Ruc',
        'Pasaporte' => 'Pasaporte',
      ),
      '#attributes' => array(
        'id' => $declarant_doc_type,
      )
    );

    // declarant_num_ident
    $form['step2']['declarant_info'][$declarant_id_num] = array(
=======
      '#options' => [
        'Cédula de ciudadanía' => 'Cédula de ciudadanía',
        'Ruc' => 'Ruc',
        'Pasaporte' => 'Pasaporte',
      ],
      '#attributes' => [
        'id' => $declarant_doc_type,
      ],
    ];

    // declarant_num_ident.
    $form['step2']['declarant_info'][$declarant_id_num] = [
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Número de identificación declarante',
      '#maxlength' => 18,
      '#name' => $declarant_id_num,
<<<<<<< HEAD
      '#attributes' => array(
        'id' => $declarant_id_num,
      )
    );

    // declarant_name
    $form['step2']['declarant_info'][$declarant_name] = array(
=======
      '#attributes' => [
        'id' => $declarant_id_num,
      ],
    ];

    // declarant_name.
    $form['step2']['declarant_info'][$declarant_name] = [
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Nombre del declarante',
      '#maxlength' => 40,
      '#name' => $declarant_name,
<<<<<<< HEAD
      '#attributes' => array(
        'id' => $declarant_name,
      )
    );

    // declarant_cellphone
    $form['step2']['declarant_info'][$declarant_cellphone] = array(
=======
      '#attributes' => [
        'id' => $declarant_name,
      ],
    ];

    // declarant_cellphone.
    $form['step2']['declarant_info'][$declarant_cellphone] = [
>>>>>>> main
      '#type' => 'number',
      '#title' => 'Celular del declarante',
      '#maxlength' => 40,
      '#name' => $declarant_cellphone,
<<<<<<< HEAD
      '#attributes' => array(
        'id' => $declarant_cellphone,
      )
    );

    // declarant_phone
    $form['step2']['declarant_info'][$declarant_phone] = array(
=======
      '#attributes' => [
        'id' => $declarant_cellphone,
      ],
    ];

    // declarant_phone.
    $form['step2']['declarant_info'][$declarant_phone] = [
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Teléfono fijo declarante',
      '#maxlength' => 18,
      '#name' => $declarant_phone,
<<<<<<< HEAD
      '#attributes' => array(
        'id' => $declarant_phone,
      )
    );

    // declarant_mail
    $form['step2']['declarant_info'][$declarant_email] = array(
=======
      '#attributes' => [
        'id' => $declarant_phone,
      ],
    ];

    // declarant_mail.
    $form['step2']['declarant_info'][$declarant_email] = [
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Email declarante',
      '#maxlength' => 50,
      '#name' => $declarant_email,
<<<<<<< HEAD
      '#attributes' => array(
        'id' => $declarant_email,
      )
    );

    // declarant_address
    $form['step2']['declarant_info'][$declarant_address] = array(
=======
      '#attributes' => [
        'id' => $declarant_email,
      ],
    ];

    // declarant_address.
    $form['step2']['declarant_info'][$declarant_address] = [
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Dirección declarante',
      '#maxlength' => 50,
      '#name' => $declarant_address,
<<<<<<< HEAD
      '#attributes' => array(
        'id' => $declarant_address,
      )
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
      )
    );

    // address_sinister
    $form['step2']['sinister_info'][$sinister_address] = array(
=======
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

    // description_sinister.
    $form['step2']['sinister_info'][$sinister_description] = [
      '#title' => 'Descripción de los hechos',
      '#type' => 'textarea',
      '#name' => $sinister_description,
      '#attributes' => [
        'id' => $sinister_description,
      ],
    ];

    // address_sinister.
    $form['step2']['sinister_info'][$sinister_address] = [
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Dirección ocurrencia',
      '#maxlength' => 50,
      '#name' => $sinister_address,
<<<<<<< HEAD
      '#attributes' => array(
        'id' => $sinister_address,
      )
    );

    // exist_deaths
    $form['step2']['sinister_info'][$sinister_has_deaths] = array(
=======
      '#attributes' => [
        'id' => $sinister_address,
      ],
    ];

    // exist_deaths.
    $form['step2']['sinister_info'][$sinister_has_deaths] = [
>>>>>>> main
      '#type' => 'select',
      '#title' => 'Existen muertos',
      '#name' => $sinister_has_deaths,
      '#required' => TRUE,
<<<<<<< HEAD
      '#options' => array(
        'Si' => 'Si',
        'No' => 'No',
      ),
      '#attributes' => array(
        'id' => $sinister_has_deaths,
      )
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
      )
    );

    // intervened_police
    $form['step2']['sinister_info'][$sinister_police] = array(
=======
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
        '' => '- Seleccione -',
        '1' => '1',
        'Mas de 1' => 'Mas de 1',
      ],
      '#attributes' => [
        'id' => $sinister_num_deaths,
      ],
    ];

    // intervened_police.
    $form['step2']['sinister_info'][$sinister_police] = [
>>>>>>> main
      '#type' => 'select',
      '#title' => 'Intervino Circulacion',
      '#name' => $sinister_police,
      '#required' => TRUE,
<<<<<<< HEAD
      '#options' => array(
        'Si' => 'Si',
        'No' => 'No',
      ),
      '#attributes' => array(
        'id' => $sinister_police,
      )
    );

    // exist_wounded
    $form['step2']['sinister_info'][$sinister_injured] = array(
=======
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
>>>>>>> main
      '#type' => 'select',
      '#title' => 'Existen heridos',
      '#name' => $sinister_injured,
      '#required' => TRUE,
<<<<<<< HEAD
      '#options' => array(
        'Si' => 'Si',
        'No' => 'No',
      ),
      '#attributes' => array(
        'id' => $sinister_injured,
      )
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
      )
    );

    // date_sinister
    $form['step2']['sinister_info'][$sinister_date] = array(
=======
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
>>>>>>> main
      '#type' => 'textfield',
      '#title' => 'Fecha y hora de ocurrencia',
      '#maxlength' => 20,
      '#name' => $sinister_date,
<<<<<<< HEAD
      '#attributes' => array(
        'id' => 'date-field-insured',
        'class' => array('date-field-insured', 'date-field'),
      ),
    );
=======
      '#attributes' => [
        'id' => 'date-field-insured',
        'class' => ['date-field-insured', 'date-field'],
      ],
    ];
>>>>>>> main

    // **********************
    // ******** STEP 3 ******
    // **********************
<<<<<<< HEAD
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
      '#markup' => '<img src="/themes/custom/liberty_public/images/car-form.png">'
    );

    // lead
    $form['step3']['area_vehicle'][$section_front] = array(
      '#type' =>'checkbox',
      '#title' => 'Sección delantera',
      '#name' => $section_front,
      '#attributes' => array(
        'id' => 'edit-' . $section_front,
      )
    );

    // left_front_lateral
    $form['step3']['area_vehicle'][$section_front_left] = array(
      '#type' =>'checkbox',
      '#title' => 'Lateral delantero Izquierdo',
      '#name' => $section_front_left,
      '#attributes' => array(
        'id' => 'edit-' . $section_front_left,
      )
    );

    // ceiling
    $form['step3']['area_vehicle'][$section_roof] = array(
      '#type' =>'checkbox',
      '#title' => 'techo',
      '#name' => $section_roof,
      '#attributes' => array(
        'id' => 'edit-' . $section_roof,
      )
    );

    // right_front_lateral
    $form['step3']['area_vehicle'][$section_front_right] = array(
      '#type' =>'checkbox',
      '#title' => 'Lateral delantero derecho',
      '#name' => $section_front_right,
      '#attributes' => array(
        'id' => 'edit-' . $section_front_right,
      )
    );

    // right_rear_side
    $form['step3']['area_vehicle'][$section_back_left] = array(
      '#type' =>'checkbox',
      '#title' => 'Lateral trasero izquierdo',
      '#name' => $section_back_left,
      '#attributes' => array(
        'id' => 'edit-' . $section_back_left,
      )
    );

    // left_rear_side
    $form['step3']['area_vehicle'][$section_back_right] = array(
      '#type' =>'checkbox',
      '#title' => 'Lateral trasero derecho',
      '#name' => $section_back_right,
      '#attributes' => array(
        'id' => 'edit-' . $section_back_right,
      )
    );

    // later_section
    $form['step3']['area_vehicle'][$section_back] = array(
      '#type' =>'checkbox',
      '#title' => 'Sección posterior',
      '#name' => $section_back,
      '#attributes' => array(
        'id' => 'edit-' . $section_back,
      )
    );

    // under
    $form['step3']['area_vehicle'][$section_down] = array(
      '#type' =>'checkbox',
      '#title' => 'Por debajo',
      '#name' => $section_down,
      '#attributes' => array(
        'id' => 'edit-' . $section_down,
      )
    );

    $form['ctn_submits'] = array(
      '#prefix' => '<div class="form-item form-actions">',
      '#suffix' => '</div>',
    );

    $form['ctn_submits']['back'] = array(
      '#type' => 'submit',
      '#value' => 'Volver',
      '#name' => 'back',
      '#attributes' => array(
        'class' => array('btn-submit-step btn-back is-hidden button--primary'),
        'cdtype' => 'back',
      )
    );

    $form['ctn_submits']['next'] = array(
      '#type' => 'submit',
      '#value' => 'Siguiente',
      '#name' => 'next',
      '#attributes' => array(
        'class' => array('btn-submit-step btn-next button--primary'),
        'cdtype' => 'next',
      )
    );
=======
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
>>>>>>> main

    \Drupal::service('page_cache_kill_switch')->trigger();

    return $form;
  }

<<<<<<< HEAD

=======
>>>>>>> main
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

<<<<<<< HEAD

=======
>>>>>>> main
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $form_state->setRebuild(TRUE);

<<<<<<< HEAD
    // Post to webform and sales force
    $coreController = new LibCoreController;
    $coreController->webformRestPost('aviso_de_siniestro_asegurado', $values);
  }
=======
    // Post to webform and sales force.
    $coreController = new LibCoreController();
    $coreController->webformRestPost('aviso_de_siniestro_asegurado', $values);
  }

>>>>>>> main
}
