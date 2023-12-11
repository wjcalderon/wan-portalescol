<?php

namespace Drupal\lib_core\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Environment Vars.
 */
class EnvironmentVarsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'lib_core_environmentvars_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['lib_core.environmentvars.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    /* Portal Colombia */
    $form['container'] = [
      '#type' => 'details',
      '#title' => $this->t('Portal Colombia'),
      '#open' => FALSE,
    ];

    /*$form['container']['portalcolombia_hostname'] = [
    '#type' => 'textfield',
    '#title' => $this->t('PortalColombia_hostname'),
    '#default_value' => $this->config('lib_core.environmentvars.settings')->get('portalcolombia_hostname'),
    '#required' => TRUE,
    '#maxlength' => 255,
    ];

    $form['container']['portalcolombia_port'] = [
    '#type' => 'textfield',
    '#title' => $this->t('PortalColombia_port'),
    '#default_value' => $this->config('lib_core.environmentvars.settings')->get('portalcolombia_port'),
    '#required' => TRUE,
    '#maxlength' => 255,
    ];

    $form['container']['portalcolombia_username'] = [
    '#type' => 'textfield',
    '#title' => $this->t('PortalColombia_username'),
    '#default_value' => $this->config('lib_core.environmentvars.settings')->get('portalcolombia_username'),
    '#required' => TRUE,
    '#maxlength' => 255,
    ];

    $form['container']['portalcolombia_password'] = [
    '#type' => 'textfield',
    '#title' => $this->t('PortalColombia_password'),
    '#default_value' => $this->config('lib_core.environmentvars.settings')->get('portalcolombia_password'),
    '#required' => TRUE,
    '#maxlength' => 255,
    ];

    $form['container']['portalcolombia_namedb'] = [
    '#type' => 'textfield',
    '#title' => $this->t('PortalColombia_nameDB'),
    '#default_value' => $this->config('lib_core.environmentvars.settings')->get('portalcolombia_namedb'),
    '#required' => TRUE,
    '#maxlength' => 255,
    ];*/

    $form['container']['AH_SITE_ENVIRONMENT'] = [
      '#type' => 'textfield',
      '#title' => $this->t('AH_SITE_ENVIRONMENT'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('AH_SITE_ENVIRONMENT'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    /* Chat */
    $form['container_two'] = [
      '#type' => 'details',
      '#title' => $this->t('CHAT'),
      '#open' => FALSE,
    ];

    $form['container_two']['CHAT_BASE_LIVE_AGENT_CONTENT_URL'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CHAT_BASE_LIVE_AGENT_CONTENT_URL'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('CHAT_BASE_LIVE_AGENT_CONTENT_URL'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_two']['CHAT_BASE_LIVE_AGENT_URL'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CHAT_BASE_LIVE_AGENT_URL'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('CHAT_BASE_LIVE_AGENT_URL'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_two']['CHAT_BUTTON_ID'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CHAT_BUTTON_ID'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('CHAT_BUTTON_ID'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_two']['CHAT_ESW_LIVE_AGENT_NAME'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CHAT_ESW_LIVE_AGENT_NAME'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('CHAT_ESW_LIVE_AGENT_NAME'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_two']['CHAT_ID'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CHAT_ID'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('CHAT_ID'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_two']['CHAT_RECORD_TYPE_ID'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CHAT_RECORD_TYPE_ID'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('CHAT_RECORD_TYPE_ID'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_two']['CHAT_SALESFORCE_URL'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CHAT_SALESFORCE_URL'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('CHAT_SALESFORCE_URL'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_two']['CHAT_SET_ATTRIBUTE'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CHAT_SET_ATTRIBUTE'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('CHAT_SET_ATTRIBUTE'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_two']['CHAT_URL'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CHAT_URL'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('CHAT_URL'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_two']['ENDPOINT_ORGID'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ENDPOINT_ORGID'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('ENDPOINT_ORGID'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    /* Salesforce */
    $form['container_three'] = [
      '#type' => 'details',
      '#title' => $this->t('SALESFORCE'),
      '#open' => FALSE,
    ];

    $form['container_three']['ENDPOINT_SALESFORCE'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ENDPOINT_SALESFORCE'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('ENDPOINT_SALESFORCE'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    /* PQR */
    $form['container_four'] = [
      '#type' => 'details',
      '#title' => $this->t('PQR'),
      '#open' => FALSE,
    ];

    $form['container_four']['PQRAutorizacionDatosPersonales'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRAutorizacionDatosPersonales'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRAutorizacionDatosPersonales'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRCanal'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRCanal'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRCanal'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRCelular'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRCelular'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRCelular'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRCiudadEvento'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRCiudadEvento'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRCiudadEvento'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRCondicionEspecial'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRCondicionEspecial'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRCondicionEspecial'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRDescription'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRDescription'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRDescription'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRDireccion'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRDireccion'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRDireccion'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQREmail'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQREmail'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQREmail'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQREntidadVigilada'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQREntidadVigilada'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQREntidadVigilada'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRGenero'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRGenero'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRGenero'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRLGBTIQ'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRLGBTIQ'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRLGBTIQ'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRMedioEnvio'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRMedioEnvio'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRMedioEnvio'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRMotivoSFC'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRMotivoSFC'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRMotivoSFC'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRNombre'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRNombre'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRNombre'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRNumeroCaso'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRNumeroCaso'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRNumeroCaso'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRNumeroIdentificacion'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRNumeroIdentificacion'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRNumeroIdentificacion'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRPaisEvento'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRPaisEvento'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRPaisEvento'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRPlaca'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRPlaca'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRPlaca'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRProducto'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRProducto'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRProducto'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRRegistroWebToCase'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRRegistroWebToCase'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRRegistroWebToCase'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRStatusSFC'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRStatusSFC'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRStatusSFC'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRTelefonoFijo'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRTelefonoFijo'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRTelefonoFijo'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRTieneCondicionEspecial'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRTieneCondicionEspecial'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRTieneCondicionEspecial'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRTipoIdentidad'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRTipoIdentidad'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRTipoIdentidad'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRorgId'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRorgId'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRorgId'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_four']['PQRreplica'] = [
      '#type' => 'textfield',
      '#title' => $this->t('PQRreplica'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('PQRreplica'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    /* SINIESTROS */
    $form['container_five'] = [
      '#type' => 'details',
      '#title' => $this->t('SINIESTROS'),
      '#open' => FALSE,
    ];

    $form['container_five']['involved'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Involved'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('involved'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_five']['know_plate_involved'] = [
      '#type' => 'textfield',
      '#title' => $this->t('know_plate_involved'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('know_plate_involved'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_five']['involved_plate'] = [
      '#type' => 'textfield',
      '#title' => $this->t('involved_plate'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('involved_plate'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_five']['know_name_involved'] = [
      '#type' => 'textfield',
      '#title' => $this->t('know_name_involved'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('know_name_involved'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_five']['name_involved'] = [
      '#type' => 'textfield',
      '#title' => $this->t('name_involved'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('name_involved'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_five']['know_type_identification_involved'] = [
      '#type' => 'textfield',
      '#title' => $this->t('know_type_identification_involved'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('know_type_identification_involved'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_five']['type_identification_involved'] = [
      '#type' => 'textfield',
      '#title' => $this->t('type_identification_involved'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('type_identification_involved'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_five']['know_identification_number_involved'] = [
      '#type' => 'textfield',
      '#title' => $this->t('know_identification_number_involved'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('know_identification_number_involved'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['container_five']['identification_number_involved'] = [
      '#type' => 'textfield',
      '#title' => $this->t('identification_number_involved'),
      '#default_value' => $this->config('lib_core.environmentvars.settings')->get('identification_number_involved'),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('lib_core.environmentvars.settings')
      ->set('AH_SITE_ENVIRONMENT', $form_state->getValue('AH_SITE_ENVIRONMENT'))
    /* CHAT */
      ->set('CHAT_BASE_LIVE_AGENT_CONTENT_URL', $form_state->getValue('CHAT_BASE_LIVE_AGENT_CONTENT_URL'))
      ->set('CHAT_BASE_LIVE_AGENT_URL', $form_state->getValue('CHAT_BASE_LIVE_AGENT_URL'))
      ->set('CHAT_BUTTON_ID', $form_state->getValue('CHAT_BUTTON_ID'))
      ->set('CHAT_ESW_LIVE_AGENT_NAME', $form_state->getValue('CHAT_ESW_LIVE_AGENT_NAME'))
      ->set('CHAT_ID', $form_state->getValue('CHAT_ID'))
      ->set('CHAT_RECORD_TYPE_ID', $form_state->getValue('CHAT_RECORD_TYPE_ID'))
      ->set('CHAT_SALESFORCE_URL', $form_state->getValue('CHAT_SALESFORCE_URL'))
      ->set('CHAT_SET_ATTRIBUTE', $form_state->getValue('CHAT_SET_ATTRIBUTE'))
      ->set('CHAT_URL', $form_state->getValue('CHAT_URL'))
      ->set('ENDPOINT_ORGID', $form_state->getValue('ENDPOINT_ORGID'))
    /*SALESFORCE*/
      ->set('ENDPOINT_SALESFORCE', $form_state->getValue('ENDPOINT_SALESFORCE'))
    /* PQR */
      ->set('PQRAutorizacionDatosPersonales', $form_state->getValue('PQRAutorizacionDatosPersonales'))
      ->set('PQRCanal', $form_state->getValue('PQRCanal'))
      ->set('PQRCelular', $form_state->getValue('PQRCelular'))
      ->set('PQRCiudadEvento', $form_state->getValue('PQRCiudadEvento'))
      ->set('PQRCondicionEspecial', $form_state->getValue('PQRCondicionEspecial'))
      ->set('PQRDescription', $form_state->getValue('PQRDescription'))
      ->set('PQRDireccion', $form_state->getValue('PQRDireccion'))
      ->set('PQREmail', $form_state->getValue('PQREmail'))
      ->set('PQREntidadVigilada', $form_state->getValue('PQREntidadVigilada'))
      ->set('PQRGenero', $form_state->getValue('PQRGenero'))
      ->set('PQRLGBTIQ', $form_state->getValue('PQRLGBTIQ'))
      ->set('PQRMedioEnvio', $form_state->getValue('PQRMedioEnvio'))
      ->set('PQRMotivoSFC', $form_state->getValue('PQRMotivoSFC'))
      ->set('PQRNombre', $form_state->getValue('PQRNombre'))
      ->set('PQRNumeroCaso', $form_state->getValue('PQRNumeroCaso'))
      ->set('PQRNumeroIdentificacion', $form_state->getValue('PQRNumeroIdentificacion'))
      ->set('PQRPaisEvento', $form_state->getValue('PQRPaisEvento'))
      ->set('PQRPlaca', $form_state->getValue('PQRPlaca'))
      ->set('PQRProducto', $form_state->getValue('PQRProducto'))
      ->set('PQRRegistroWebToCase', $form_state->getValue('PQRRegistroWebToCase'))
      ->set('PQRStatusSFC', $form_state->getValue('PQRStatusSFC'))
      ->set('PQRTelefonoFijo', $form_state->getValue('PQRTelefonoFijo'))
      ->set('PQRTieneCondicionEspecial', $form_state->getValue('PQRTieneCondicionEspecial'))
      ->set('PQRTipoIdentidad', $form_state->getValue('PQRTipoIdentidad'))
      ->set('PQRorgId', $form_state->getValue('PQRorgId'))
      ->set('PQRreplica', $form_state->getValue('PQRreplica'))
    /* SINIESTROS */
      ->set('involved', $form_state->getValue('involved'))
      ->set('know_plate_involved', $form_state->getValue('know_plate_involved'))
      ->set('involved_plate', $form_state->getValue('involved_plate'))
      ->set('know_name_involved', $form_state->getValue('know_name_involved'))
      ->set('name_involved', $form_state->getValue('name_involved'))
      ->set('know_type_identification_involved', $form_state->getValue('know_type_identification_involved'))
      ->set('type_identification_involved', $form_state->getValue('type_identification_involved'))
      ->set('know_identification_number_involved', $form_state->getValue('know_identification_number_involved'))
      ->set('identification_number_involved', $form_state->getValue('identification_number_involved'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
