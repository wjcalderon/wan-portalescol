<?php

namespace Drupal\hdi_pqr_salesforce\Plugin\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Saleforce settings for contact form.
 */
class PqrSalesforceForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'pqr_salesforce_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['pqrsalesforce.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('pqrsalesforce.settings');

    $form['general'] = [
      '#type' => 'details',
      '#title' => $this->t('Salesforce settings'),
      '#open' => TRUE,
    ];

    $form['general']['salesforce_endpoint'] = [
      '#default_value' => $config->get('salesforce_endpoint'),
      '#description' => $this->t('Salesforce endpoint'),
      '#maxlength' => 120,
      '#required' => TRUE,
      '#title' => $this->t('Salesforce endpoint'),
      '#type' => 'textfield',
    ];

    $form['general']['salesforce_token_endpoint'] = [
      '#default_value' => $config->get('salesforce_token_endpoint'),
      '#description' => $this->t('Salesforce token endpoint'),
      '#maxlength' => 120,
      '#required' => TRUE,
      '#title' => $this->t('Salesforce token endpoint'),
      '#type' => 'textfield',
    ];

    $form['general']['salesforce_client_id'] = [
      '#default_value' => $config->get('salesforce_client_id'),
      '#description' => $this->t('Salesforce client ID'),
      '#required' => TRUE,
      '#title' => $this->t('Salesforce client ID'),
      '#type' => 'textfield',
    ];

    $form['general']['salesforce_client_secret'] = [
      '#default_value' => $config->get('salesforce_client_secret'),
      '#description' => $this->t('Salesforce client Secret'),
      '#required' => TRUE,
      '#title' => $this->t('Salesforce client Secret'),
      '#type' => 'textfield',
    ];

    $form['general']['salesforce_username'] = [
      '#default_value' => $config->get('salesforce_username'),
      '#description' => $this->t('Salesforce client ID'),
      '#required' => TRUE,
      '#title' => $this->t('Salesforce user name'),
      '#type' => 'textfield',
    ];

    $form['general']['salesforce_password'] = [
      '#default_value' => $config->get('salesforce_password'),
      '#description' => $this->t('Salesforce password'),
      '#required' => TRUE,
      '#title' => $this->t('Salesforce password'),
      '#type' => 'textfield',
    ];

    $form['general']['use_recaptcha'] = [
      '#default_value' => $config->get('use_recaptcha'),
      '#description' => $this->t('Enable / disable reCAPTCHA in form.'),
      '#title' => $this->t('Use reCAPTCHA in form'),
      '#type' => 'checkbox',
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('pqrsalesforce.settings');
    $config
      ->set('salesforce_endpoint', $form_state->getValue('salesforce_endpoint'))
      ->set('salesforce_token_endpoint', $form_state->getValue('salesforce_token_endpoint'))
      ->set('salesforce_client_id', $form_state->getValue('salesforce_client_id'))
      ->set('salesforce_client_secret', $form_state->getValue('salesforce_client_secret'))
      ->set('salesforce_username', $form_state->getValue('salesforce_username'))
      ->set('salesforce_password', $form_state->getValue('salesforce_password'))
      ->set('use_recaptcha', $form_state->getValue('use_recaptcha'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
