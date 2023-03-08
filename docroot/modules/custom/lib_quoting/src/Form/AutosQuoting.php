<?php

namespace Drupal\lib_quoting\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * AutosQuoting form
 */
class AutosQuoting extends FormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'autos_quoting_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {

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
        $form['wp_stps_header'] = array(
            '#prefix' => '<ul class="header-steps">',
            '#suffix' => '</ul>',
            '#markup' => $list,
        );

        /***********
         ** STEPS CONTENT
         ***********/
        $form['wp_stps_ctn'] = array(
            '#prefix' => '<div class="content-steps opacity-loading">',
            '#suffix' => '</div>',
        );

        /***********
         ** STEP 1
         ***********/
        $form['wp_stps_ctn']['wrp_stp1'] = array(
            '#prefix' => '<div class="wrapper-form-step1 step1 active">',
            '#suffix' => '</div>',
        );

        $title = $this->t('Listed here your car insurance');
        $form['wp_stps_ctn']['wrp_stp1']['title'] = array(
            '#markup' => '<h1>' . $title . '</h1>',
        );

        $subtitle = $this->t('It will not take long, enter the following information');
        $form['wp_stps_ctn']['wrp_stp1']['subtitle'] = array(
            '#markup' => '<p class="subtitle">' . $subtitle . '</p>',
        );

        $form['wp_stps_ctn']['wrp_stp1']['type_doc'] = array(
            '#prefix' => '<div class="group-field info-document">',
            '#type' => 'select',
            '#required' => true,
            '#title' => $this->t('Document type'),
            '#options' => array(
                36 => 'Cédula de ciudadanía',
                33 => 'Cédula de extranjería',
                44 => 'Carnet Diplomático',
                40 => 'Pasaporte',
                34 => 'Tarjeta de Identidad',
                35 => 'Registro Civil',
                38 => 'Número único de identificación personal (NUIP)',
                37 => 'NIT',
            ),
        );

        $form['wp_stps_ctn']['wrp_stp1']['num_doc'] = array(
            '#suffix' => '</div>',
            '#type' => 'textfield',
            '#title' => t('Document number'),
            '#size' => 10,
            '#maxlength' => 10,
            '#required' => true,
        );

        $form['wp_stps_ctn']['wrp_stp1']['type_plate'] = array(
            '#prefix' => '<div class="group-field info-plate">',
            '#type' => 'select',
            '#title' => $this->t('Plate type'),
            '#required' => true,
            '#options' => array(
                12 => 'Placa tipo Colombia',
                13 => 'Placa tipo Extranjera',
            ),
        );

        $form['wp_stps_ctn']['wrp_stp1']['num_plate'] = array(
            '#suffix' => '</div>',
            '#type' => 'textfield',
            '#title' => t('Plate number'),
            '#size' => 10,
            '#maxlength' => 10,
            '#required' => true,
        );

        $form['wp_stps_ctn']['wrp_stp1']['use_data'] = array(
            '#type' => 'checkbox',
            '#title' => t('I authorize the consultation and use of personal data'),
            '#required' => true,
        );

        $form['wp_stps_ctn']['wrp_stp1']['hd_fields'] = array(
            '#prefix' => '<div class="content-hd-fields hidden">',
            '#suffix' => '</div>',
        );

        $label_names = $this->t('Names');
        $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['names'] = array(
            '#prefix' => '<div class="group-field info-complete-name">',
            '#type' => 'textfield',
            '#title' => $label_names,
            '#size' => 120,
            '#maxlength' => 120,
        );
        $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['mkp_names'] = array(
            '#prefix' => '<div class="field-markup mkp-field-names">',
            '#suffix' => '</div>',
            'label' => array(
                '#markup' => '<span>' . $label_names . '</span>',
            ),
            'content' => array(
                '#markup' => '<span class="content"></span>',
            ),
        );

        $label_lastnames = $this->t('Lastnames');
        $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['mkp_lastnames'] = array(
            '#prefix' => '<div class="field-markup mkp-field-lastnames">',
            '#suffix' => '</div>',
            'label' => array(
                '#markup' => '<span>' . $label_lastnames . '</span>',
            ),
            'content' => array(
                '#markup' => '<span class="content"></span>',
            ),
        );
        $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['lastnames'] = array(
            '#suffix' => '</div>',
            '#type' => 'textfield',
            '#title' => $label_lastnames,
            '#size' => 120,
            '#maxlength' => 120,
        );

        $gender_checkboxes = '<div class="form-item form-item-gender">
      <div id="edit-gender" class="switch" style="margin-top: 2rem;">
        <span class="label">Genero</span>
        <input data-drupal-selector="edit-gender-masculino" type="radio" id="edit-gender-masculino" name="gender" value="Masculino" class="form-radio toggle toggle-right" checked="checked">
        <label for="edit-gender-masculino" class="option btn btn-right" style="margin-left: 0px;">Masculino</label>
        <input data-drupal-selector="edit-gender-femenino" type="radio" id="edit-gender-femenino" name="gender" value="Femenino" class="form-radio toggle toggle-left">
        <label for="edit-gender-femenino" class="option btn btn-left">Femenino</label>
      </div>
    </div>';
        $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['gender'] = array(
            '#markup' => $gender_checkboxes,
            '#allowed_tags' => ['input', 'label', 'div', 'span'],
        );

        $label_mail = $this->t('mail');
        $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['mail'] = array(
            '#prefix' => '<div class="group-field info-mail-cell">',
            '#type' => 'email',
            '#title' => $label_mail,
            '#size' => 60,
            '#maxlength' => 60,
            '#required' => true,
        );

        $label_cell = $this->t('Cellphone');
        $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['cellphone'] = array(
            '#suffix' => '</div>',
            '#type' => 'textfield',
            '#title' => $label_cell,
            '#size' => 60,
            '#maxlength' => 60,
            '#required' => true,
        );

        $label_birthdate = $this->t('Birthdate');
        $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['birthdate'] = array(
            '#prefix' => '<div class="group-field info-birthdate-city">',
            '#type' => 'textfield',
            '#title' => $label_birthdate,
            '#size' => 60,
            '#maxlength' => 60,
            '#required' => true,
        );

        $form['wp_stps_ctn']['wrp_stp1']['hd_fields']['circulation_city'] = array(
            '#suffix' => '</div>',
            '#type' => 'textfield',
            '#title' => t('Zona de circulación del vehículo'),
            '#required' => true,
            '#size' => 60,
            '#maxlength' => 60,
            '#attributes' => array(
                'class' => ['field-autocomplete', 'cir-city'],
            ),
        );

        $form['wp_stps_ctn']['wrp_stp1']['next'] = array(
            '#prefix' => '<div class="form-item form-actions">',
            '#suffix' => '</div>',
            '#type' => 'submit',
            '#disabled' => true,
            '#value' => $this->t('Continue'),
            '#attributes' => array(
                'class' => ['submit-next'],
                'step' => 1,
            ),
        );

        /***********
         ** STEP 2
         ***********/
        $form['wp_stps_ctn']['wrp_stp2'] = array(
            '#prefix' => '<div class="wrapper-form-step2 step2 hidden"><a  href="/cotiza-en-linea/cotizador-autos" class="quoting-back">Volver</a>',
            '#suffix' => '</div>',
        );

        $title = $this->t('Tell us about your vehicle');
        $form['wp_stps_ctn']['wrp_stp2']['title'] = array(
            '#markup' => '<h1>' . $title . '</h1>',
        );

        $subtitle = $this->t("It's almost time, having the information allows us to give you a custom-made price");
        $form['wp_stps_ctn']['wrp_stp2']['subtitle'] = array(
            '#markup' => '<p class="subtitle">' . $subtitle . '</p>',
        );

        $form['wp_stps_ctn']['wrp_stp2']['vehicle_use'] = array(
            '#type' => 'select',
            '#title' => t('Vehicle use'),
            '#options' => array(
                'particular' => 'Particular',
            ),
            '#default_value' => 'particular',
        );

        $find_vehicle_title = $this->t('Find your vehicle');
        $form['wp_stps_ctn']['wrp_stp2']['find_vehicle_title'] = array(
            '#markup' => '<p class="subtitle">' . $find_vehicle_title . '</p>',
        );

        // Find vehicle
        $form['wp_stps_ctn']['wrp_stp2']['find_vehicle'] = array(
            '#type' => 'textfield',
            '#title' => t('Find your vehicle'),
            '#required' => true,
            '#attributes' => array(
                'class' => ['field-autocomplete', 'find-vehicle'],
            ),
        );

        // Marca
        $label_brand = $this->t('Brand');
        $form['wp_stps_ctn']['wrp_stp2']['vehicle_brand'] = array(
            '#prefix' => '<div class="group-field info-brand-class">',
            '#type' => 'textfield',
            '#title' => $label_brand,
        );
        $form['wp_stps_ctn']['wrp_stp2']['mkp_vehicle_brand'] = array(
            '#prefix' => '<div class="field-markup mkp-field-brand">',
            '#suffix' => '</div>',
            'label' => array(
                '#markup' => '<span>' . $label_brand . '</span>',
            ),
            'content' => array(
                '#markup' => '<span class="content"></span>',
            ),
        );

        // Clase
        $label_class = $this->t('Class');
        $form['wp_stps_ctn']['wrp_stp2']['mkp_vehicle_class'] = array(
            '#prefix' => '<div class="field-markup mkp-field-class">',
            '#suffix' => '</div>',
            'label' => array(
                '#markup' => '<span>' . $label_class . '</span>',
            ),
            'content' => array(
                '#markup' => '<span class="content"></span>',
            ),
        );
        $form['wp_stps_ctn']['wrp_stp2']['vehicle_class'] = array(
            '#suffix' => '</div>',
            '#type' => 'textfield',
            '#title' => $label_class,
        );

        // Version (Ref 1)
        $label_version = $this->t('Version');
        $form['wp_stps_ctn']['wrp_stp2']['vehicle_version'] = array(
            '#prefix' => '<div class="group-field info-version-type">',
            '#type' => 'textfield',
            '#title' => $label_version,
        );
        $form['wp_stps_ctn']['wrp_stp2']['mkp_vehicle_version'] = array(
            '#prefix' => '<div class="field-markup mkp-field-version">',
            '#suffix' => '</div>',
            'label' => array(
                '#markup' => '<span>' . $label_version . '</span>',
            ),
            'content' => array(
                '#markup' => '<span class="content"></span>',
            ),
        );

        // Tipo (Ref2)
        $label_type = $this->t('Type');
        $form['wp_stps_ctn']['wrp_stp2']['mkp_vehicle_type'] = array(
            '#prefix' => '<div class="field-markup mkp-field-type">',
            '#suffix' => '</div>',
            'label' => array(
                '#markup' => '<span>' . $label_type . '</span>',
            ),
            'content' => array(
                '#markup' => '<span class="content"></span>',
            ),
        );
        $form['wp_stps_ctn']['wrp_stp2']['vehicle_type'] = array(
            '#suffix' => '</div>',
            '#type' => 'textfield',
            '#title' => $label_type,
        );

        // Modelo
        $label_model = $this->t('Model');
        $form['wp_stps_ctn']['wrp_stp2']['vehicle_model'] = array(
            '#prefix' => '<div class="group-field info-model-price">',
            '#type' => 'textfield',
            '#title' => $label_model,
        );
        $form['wp_stps_ctn']['wrp_stp2']['mkp_vehicle_model'] = array(
            '#prefix' => '<div class="field-markup mkp-field-model">',
            '#suffix' => '</div>',
            'label' => array(
                '#markup' => '<span>' . $label_model . '</span>',
            ),
            'content' => array(
                '#markup' => '<span class="content"></span>',
            ),
        );

        // Comercial valor
        $label_com_value = $this->t('Comercial value');
        $form['wp_stps_ctn']['wrp_stp2']['mkp_vehicle_com_value'] = array(
            '#prefix' => '<div class="field-markup mkp-field-com-value">',
            '#suffix' => '</div>',
            'label' => array(
                '#markup' => '<span>' . $label_com_value . '</span>',
            ),
            'content' => array(
                '#markup' => '<span class="content"></span>',
            ),
        );
        $form['wp_stps_ctn']['wrp_stp2']['vehicle_com_value'] = array(
            '#suffix' => '</div>',
            '#type' => 'textfield',
            '#title' => $label_com_value,
        );

        $form['wp_stps_ctn']['wrp_stp2']['next'] = array(
            '#prefix' => '<div class="form-item form-actions">',
            '#suffix' => '</div>',
            '#type' => 'submit',
            '#value' => $this->t('Next'),
            '#attributes' => array(
                'class' => ['submit-next'],
                'step' => 2,
            ),
        );

        /***********
         ** STEP 3
         ***********/
        $form['wp_stps_ctn']['wrp_stp3'] = array(
            '#prefix' => '<div class="wrapper-form-step3 step3 hidden"><a  href="/cotiza-en-linea/cotizador-autos" class="quoting-back">Volver</a>',
            '#suffix' => '</div>',
        );

        $title = $this->t('Your policy');
        $form['wp_stps_ctn']['wrp_stp3']['title'] = array(
            '#markup' => '<h1>' . $title . '</h1>',
        );

        $subtitle = $this->t("Check the value of the insurance and its coverages");
        $form['wp_stps_ctn']['wrp_stp3']['subtitle'] = array(
            '#markup' => '<p class="subtitle">' . $subtitle . '</p>',
        );
        $form['wp_stps_ctn']['wrp_stp3']['message'] = array(
            '#prefix' => '<div class="message">',
            '#suffix' => '</div>',
        );

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
            '#value' => t('Generate PDF'),
        ];

        $form['wp_stps_ctn']['wrp_error'] = array(
            '#prefix' => '<div class="wrapper-form-error error hidden"><a  href="/cotiza-en-linea/cotizador-autos" class="quoting-back">Volver</a>',
            '#suffix' => '</div>',
            '#markup' => '<h3>Ups, lo sentimos. Riesgo fuera de políticas, la identificación o placa que ingresaste no nos permite continuar con el proceso</h3>',
        );

        $form['wp_stps_ctn']['loading'] = [
            '#markup' => '<div class="loading"><div class="loading__item"></div><div class="loading__item"></div><div class="loading__item"></div></div>',
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
        $form_state->setRebuild();
        $type_doc = $form_state->getValue('type_doc');
        $num_doc = $form_state->getValue('num_doc');

        $names = $form_state->getValue('names');
        if (!empty($form_state->getValue('hd_names'))) {
            $names = $form_state->getValue('hd_names');
        }

        $lastnames = $form_state->getValue('lastnames');
        if (!empty($form_state->getValue('hd_lastnames'))) {
            $lastnames = $form_state->getValue('hd_lastnames');
        }

        $mail = $form_state->getValue('mail');
        if (!empty($form_state->getValue('hd_mail'))) {
            $lastnames = $form_state->getValue('hd_mail');
        }

        $gender = $form_state->getValue('hd_gender');
        $circulation_city = $form_state->getValue('circulation_city');
        $vehicle_use = $form_state->getValue('vehicle_use');
    }
}
