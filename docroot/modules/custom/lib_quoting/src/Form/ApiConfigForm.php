<?php

namespace Drupal\lib_quoting\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Api config form custom.
 */
class ApiConfigForm extends ConfigFormBase {

  const SETTINGS = 'lib_quoting.settings';

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'api_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);
    $form['api_apigee_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('apigee url'),
      '#description' => $this->t('API url'),
      '#default_value' => $config->get('config.apigee_url'),
      '#required' => TRUE,
    ];
    $form['api_client_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Client api id'),
      '#description' => $this->t('Client id for api calls'),
      '#default_value' => $config->get('config.api.client_id'),
      '#required' => TRUE,
    ];
    $form['api_client_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Client api secret'),
      '#description' => $this->t('Client secret for api calls'),
      '#default_value' => $config->get('config.api.client_secret'),
      '#required' => TRUE,
    ];

    $form['sisa_client_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Client SISA api id'),
      '#description' => $this->t('Client id for sisa api calls'),
      '#default_value' => $config->get('config.sisa.client_id'),
      '#required' => TRUE,
    ];
    $form['sisa_client_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Client SISA api secret'),
      '#description' => $this->t('Client secret for sisa api calls'),
      '#default_value' => $config->get('config.sisa.client_secret'),
      '#required' => TRUE,
    ];
    $form['perlrating_client_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Client PELHRating api id'),
      '#description' => $this->t('Client id for PELHRating api calls'),
      '#default_value' => $config->get('config.perlrating.client_id'),
      '#required' => TRUE,
    ];
    $form['perlrating_client_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Client PELHRating api secret'),
      '#description' => $this->t('Client secret for PELHRating api calls'),
      '#default_value' => $config->get('config.perlrating.client_secret'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable(static::SETTINGS)
      ->set('config.apigee_url', $form_state->getValue('api_apigee_url'))
      ->set('config.api.client_id', $form_state->getValue('api_client_id'))
      ->set('config.api.client_secret', $form_state->getValue('api_client_secret'))
      ->set('config.sisa.client_id', $form_state->getValue('sisa_client_id'))
      ->set('config.sisa.client_secret', $form_state->getValue('sisa_client_secret'))
      ->set('config.perlrating.client_id', $form_state->getValue('perlrating_client_id'))
      ->set('config.perlrating.client_secret', $form_state->getValue('perlrating_client_secret'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
