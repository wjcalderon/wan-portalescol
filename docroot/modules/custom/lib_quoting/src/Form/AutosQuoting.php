<?php

namespace Drupal\lib_quoting\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Autos Quoting form.
 */
class AutosQuoting extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'autos_quoting_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['#attached']['library'][] = 'lib_quoting/lib_quoting';
    $form['#attached']['library'][] = 'lib_quoting/lib_quoting_validate';

    $form['#action'] = Url::fromRoute('lib_quoting.generate_pdf')->toString();

    /***********
     ** STEPS HEADER
     ***********/
    $list = '<li class="header-step header-step1 active">';
    $list .= $this->t('Personal information') . '</li>';
    $list .= '<li class="header-step header-step2 not-complete">';
    $list .= $this->t('Vehicle data') . '</li>';
    $list .= '<li class="header-step header-step3 not-complete">';
    $list .= $this->t('Your policy') . '</li>';
    $form['wp_stps_header'] = [
      '#prefix' => '<ul class="header-steps">',
      '#suffix' => '</ul>',
      '#markup' => $list,
    ];

    /***********
     ** STEPS CONTENT
     ***********/
    $form['wp_stps_ctn'] = [
      '#prefix' => '<div class="content-steps opacity-loading">',
      '#suffix' => '</div>',
    ];

    /***********
     ** STEP 1
     ***********/
    $form['wp_stps_ctn']['wrp_stp1'] = [
      '#prefix' => '<div class="wrapper-form-step1 step1 active">',
      '#suffix' => '</div>',
    ];

    $title = $this->t('Listed here your car insurance');
    $form['wp_stps_ctn']['wrp_stp1']['title'] = [
      '#markup' => '<h1>' . $title . '</h1>',
    ];

    $subtitle = $this->t('It will not take long, enter the following information');
    $form['wp_stps_ctn']['wrp_stp1']['subtitle'] = [
      '#markup' => '<p class="subtitle">' . $subtitle . '</p>',
    ];

    $form['wp_stps_ctn']['wrp_stp1']['type_doc'] = [
      '#prefix' => '<div class="group-field info-document">',
      '#type' => 'select',
      '#required' => TRUE,
      '#title' => $this->t('Document type'),
      '#options' => [
        36 => $this->t('Cédula de ciudadanía'),
        33 => $this->t('Cédula de extranjería'),
        44 => $this->t('Carnet Diplomático'),
        40 => $this->t('Pasaporte'),
        34 => $this->t('Tarjeta de Identidad'),
        35 => $this->t('Registro Civil'),
        38 => $this->t('Número único de identificación personal (NUIP)'),
        37 => $this->t('NIT'),
      ],
    ];

    $form['wp_stps_ctn']['wrp_stp1']['num_doc'] = [
      '#suffix' => '</div>',
      '#type' => 'textfield',
      '#title' => $this->t('Document number'),
      '#size' => 10,
      '#maxlength' => 10,
      '#required' => TRUE,
    ];

    $form['wp_stps_ctn']['wrp_stp1']['type_plate'] = [
      '#prefix' => '<div class="group-field info-plate">',
      '#type' => 'select',
      '#title' => $this->t('Plate type'),
      '#required' => TRUE,
      '#options' => [
        12 => $this->t('Placa tipo Colombia'),
        13 => $this->t('Placa tipo Extranjera'),
      ],
    ];

    $form['wp_stps_ctn']['wrp_stp1']['num_plate'] = [
      '#suffix' => '</div>',
      '#type' => 'textfield',
      '#title' => $this->t('Plate number'),
      '#size' => 10,
      '#maxlength' => 10,
      '#required' => TRUE,
    ];

    $form['wp_stps_ctn']['wrp_stp1']['use_data'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('I authorize the consultation and use of personal data'),
      '#required' => TRUE,
    ];

    $form['wp_stps_ctn']['wrp_stp1']['hd_fields'] = [
      '#prefix' => '<div class="content-hd-fields hidden">',
      '#suffix' => '</div>',
    ];

    $label_names = $this->t('Names');
    $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['names'] = [
      '#prefix' => '<div class="group-field info-complete-name">',
      '#type' => 'textfield',
      '#title' => $label_names,
      '#size' => 120,
      '#maxlength' => 120,
    ];
    $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['mkp_names'] = [
      '#prefix' => '<div class="field-markup mkp-field-names">',
      '#suffix' => '</div>',
      'label' => [
        '#markup' => '<span>' . $label_names . '</span>',
      ],
      'content' => [
        '#markup' => '<span class="content"></span>',
      ],
    ];

    $label_lastnames = $this->t('Lastnames');
    $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['mkp_lastnames'] = [
      '#prefix' => '<div class="field-markup mkp-field-lastnames">',
      '#suffix' => '</div>',
      'label' => [
        '#markup' => '<span>' . $label_lastnames . '</span>',
      ],
      'content' => [
        '#markup' => '<span class="content"></span>',
      ],
    ];
    $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['lastnames'] = [
      '#suffix' => '</div>',
      '#type' => 'textfield',
      '#title' => $label_lastnames,
      '#size' => 120,
      '#maxlength' => 120,
    ];

    $gender_checkboxes = '<div class="form-item form-item-gender">
      <div id="edit-gender" class="switch" style="margin-top: 2rem;">
        <span class="label">Genero</span>
        <input data-drupal-selector="edit-gender-masculino" type="radio" id="edit-gender-masculino" name="gender" value="Masculino" class="form-radio toggle toggle-right" checked="checked">
        <label for="edit-gender-masculino" class="option btn btn-right" style="margin-left: 0px;">Masculino</label>
        <input data-drupal-selector="edit-gender-femenino" type="radio" id="edit-gender-femenino" name="gender" value="Femenino" class="form-radio toggle toggle-left">
        <label for="edit-gender-femenino" class="option btn btn-left">Femenino</label>
      </div>
    </div>';
    $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['gender'] = [
      '#markup' => $gender_checkboxes,
      '#allowed_tags' => ['input', 'label', 'div', 'span'],
    ];

    $label_mail = $this->t('mail');
    $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['mail'] = [
      '#prefix' => '<div class="group-field info-mail-cell">',
      '#type' => 'email',
      '#title' => $label_mail,
      '#size' => 60,
      '#maxlength' => 60,
      '#required' => TRUE,
    ];

    $label_cell = $this->t('Cellphone');
    $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['cellphone'] = [
      '#suffix' => '</div>',
      '#type' => 'textfield',
      '#title' => $label_cell,
      '#size' => 60,
      '#maxlength' => 60,
      '#required' => TRUE,
    ];

    $label_birthdate = $this->t('Birthdate');
    $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['birthdate'] = [
      '#prefix' => '<div class="group-field info-birthdate-city">',
      '#type' => 'textfield',
      '#title' => $label_birthdate,
      '#size' => 60,
      '#maxlength' => 60,
      '#required' => TRUE,
    ];

    $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['circulation_city'] = [
      '#suffix' => '</div>',
      '#type' => 'textfield',
      '#title' => $this->t('Zona de circulación del vehículo'),
      '#required' => TRUE,
      '#size' => 60,
      '#maxlength' => 60,
      '#attributes' => [
        'class' => ['field-autocomplete', 'cir-city'],
      ],
    ];

    $form['wp_stps_ctn']['wrp_stp1']['next'] = [
      '#prefix' => '<div class="form-item form-actions">',
      '#suffix' => '</div>',
      '#type' => 'submit',
      '#disabled' => TRUE,
      '#value' => $this->t('Continue'),
      '#attributes' => [
        'class' => ['submit-next'],
        'step' => 1,
      ],
    ];

    /***********
     ** STEP 2
     ***********/
    $form['wp_stps_ctn']['wrp_stp2'] = [
      '#prefix' => '<div class="wrapper-form-step2 step2 hidden"><a  href="/cotiza-en-linea/cotizador-autos" class="quoting-back">Volver</a>',
      '#suffix' => '</div>',
    ];

    $title = $this->t('Tell us about your vehicle');
    $form['wp_stps_ctn']['wrp_stp2']['title'] = [
      '#markup' => '<h1>' . $title . '</h1>',
    ];

    $subtitle = $this->t("It's almost time, having the information allows us to give you a custom-made price");
    $form['wp_stps_ctn']['wrp_stp2']['subtitle'] = [
      '#markup' => '<p class="subtitle">' . $subtitle . '</p>',
    ];

    $form['wp_stps_ctn']['wrp_stp2']['vehicle_use'] = [
      '#type' => 'select',
      '#title' => $this->t('Vehicle use'),
      '#options' => [
        'particular' => $this->t('Particular'),
      ],
      '#default_value' => 'particular',
    ];

    $find_vehicle_title = $this->t('Find your vehicle');
    $form['wp_stps_ctn']['wrp_stp2']['find_vehicle_title'] = [
      '#markup' => '<p class="subtitle">' . $find_vehicle_title . '</p>',
    ];

    // Find vehicle.
    $form['wp_stps_ctn']['wrp_stp2']['find_vehicle'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Find your vehicle'),
      '#required' => TRUE,
      '#attributes' => [
        'class' => ['field-autocomplete', 'find-vehicle'],
      ],
    ];

    // Marca.
    $label_brand = $this->t('Brand');
    $form['wp_stps_ctn']['wrp_stp2']['vehicle_brand'] = [
      '#prefix' => '<div class="group-field info-brand-class">',
      '#type' => 'textfield',
      '#title' => $label_brand,
    ];
    $form['wp_stps_ctn']['wrp_stp2']['mkp_vehicle_brand'] = [
      '#prefix' => '<div class="field-markup mkp-field-brand">',
      '#suffix' => '</div>',
      'label' => [
        '#markup' => '<span>' . $label_brand . '</span>',
      ],
      'content' => [
        '#markup' => '<span class="content"></span>',
      ],
    ];

    // Clase.
    $label_class = $this->t('Class');
    $form['wp_stps_ctn']['wrp_stp2']['mkp_vehicle_class'] = [
      '#prefix' => '<div class="field-markup mkp-field-class">',
      '#suffix' => '</div>',
      'label' => [
        '#markup' => '<span>' . $label_class . '</span>',
      ],
      'content' => [
        '#markup' => '<span class="content"></span>',
      ],
    ];
    $form['wp_stps_ctn']['wrp_stp2']['vehicle_class'] = [
      '#suffix' => '</div>',
      '#type' => 'textfield',
      '#title' => $label_class,
    ];

    // Version (Ref 1)
    $label_version = $this->t('Version');
    $form['wp_stps_ctn']['wrp_stp2']['vehicle_version'] = [
      '#prefix' => '<div class="group-field info-version-type">',
      '#type' => 'textfield',
      '#title' => $label_version,
    ];
    $form['wp_stps_ctn']['wrp_stp2']['mkp_vehicle_version'] = [
      '#prefix' => '<div class="field-markup mkp-field-version">',
      '#suffix' => '</div>',
      'label' => [
        '#markup' => '<span>' . $label_version . '</span>',
      ],
      'content' => [
        '#markup' => '<span class="content"></span>',
      ],
    ];

    // Tipo (Ref2)
    $label_type = $this->t('Type');
    $form['wp_stps_ctn']['wrp_stp2']['mkp_vehicle_type'] = [
      '#prefix' => '<div class="field-markup mkp-field-type">',
      '#suffix' => '</div>',
      'label' => [
        '#markup' => '<span>' . $label_type . '</span>',
      ],
      'content' => [
        '#markup' => '<span class="content"></span>',
      ],
    ];
    $form['wp_stps_ctn']['wrp_stp2']['vehicle_type'] = [
      '#suffix' => '</div>',
      '#type' => 'textfield',
      '#title' => $label_type,
    ];

    // Modelo.
    $label_model = $this->t('Model');
    $form['wp_stps_ctn']['wrp_stp2']['vehicle_model'] = [
      '#prefix' => '<div class="group-field info-model-price">',
      '#type' => 'textfield',
      '#title' => $label_model,
    ];
    $form['wp_stps_ctn']['wrp_stp2']['mkp_vehicle_model'] = [
      '#prefix' => '<div class="field-markup mkp-field-model">',
      '#suffix' => '</div>',
      'label' => [
        '#markup' => '<span>' . $label_model . '</span>',
      ],
      'content' => [
        '#markup' => '<span class="content"></span>',
      ],
    ];

    // Comercial valor.
    $label_com_value = $this->t('Comercial value');
    $form['wp_stps_ctn']['wrp_stp2']['mkp_vehicle_com_value'] = [
      '#prefix' => '<div class="field-markup mkp-field-com-value">',
      '#suffix' => '</div>',
      'label' => [
        '#markup' => '<span>' . $label_com_value . '</span>',
      ],
      'content' => [
        '#markup' => '<span class="content"></span>',
      ],
    ];
    $form['wp_stps_ctn']['wrp_stp2']['vehicle_com_value'] = [
      '#suffix' => '</div>',
      '#type' => 'textfield',
      '#title' => $label_com_value,
    ];

    $form['wp_stps_ctn']['wrp_stp2']['next'] = [
      '#prefix' => '<div class="form-item form-actions">',
      '#suffix' => '</div>',
      '#type' => 'submit',
      '#value' => $this->t('Next'),
      '#attributes' => [
        'class' => ['submit-next'],
        'step' => 2,
      ],
    ];

    /***********
     ** STEP 3
     ***********/
    $form['wp_stps_ctn']['wrp_stp3'] = [
      '#prefix' => '<div class="wrapper-form-step3 step3 hidden"><a  href="/cotiza-en-linea/cotizador-autos" class="quoting-back">Volver</a>',
      '#suffix' => '</div>',
    ];

    $title = $this->t('Your policy');
    $form['wp_stps_ctn']['wrp_stp3']['title'] = [
      '#markup' => '<h1>' . $title . '</h1>',
    ];

    $subtitle = $this->t("Check the value of the insurance and its coverages");
    $form['wp_stps_ctn']['wrp_stp3']['subtitle'] = [
      '#markup' => '<p class="subtitle">' . $subtitle . '</p>',
    ];
    $form['wp_stps_ctn']['wrp_stp3']['message'] = [
      '#prefix' => '<div class="message">',
      '#suffix' => '</div>',
    ];

    $prima_anual = '<span class="prima_total">$ 0</span>';
    $form['wp_stps_ctn']['wrp_stp3']['message']['total_prima_anual'] = [
      '#prefix' => '<div class="anual mensual">',
      '#markup' => '<p>Total prima anual</p>' . $prima_anual . '<p class="iva">IVA incluido</p>',
      '#suffix' => '</div>',
    ];

    $form['wp_stps_ctn']['wrp_stp3']['print-pdf'] = [
      '#prefix' => '<div class="wrapper-form-error print-pdf">',
      '#suffix' => '</div>',
      '#markup' => '<h4>Por favor descarga e imprime el PDF, ya que la cotizaci&oacute;n no quedar&aacute; guardada.</h4>',
    ];

    $form['wp_stps_ctn']['wrp_stp3']['generate-pdf'] = [
      '#type' => 'submit',
      '#value' => $this->t('Generate PDF'),
    ];

    $form['wp_stps_ctn']['wrp_error'] = [
      '#prefix' => '<div class="wrapper-form-error error hidden"><a  href="/cotiza-en-linea/cotizador-autos" class="quoting-back">Volver</a>',
      '#suffix' => '</div>',
      '#markup' => '<h3>Ups, lo sentimos. Riesgo fuera de políticas, la identificación o placa que ingresaste no nos permite continuar con el proceso</h3>',
    ];

    $form['wp_stps_ctn']['loading'] = [
      '#markup' => '<div class="loading"><div class="loading__item"></div><div class="loading__item"></div><div class="loading__item"></div></div>',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->setRebuild();
  }

}
