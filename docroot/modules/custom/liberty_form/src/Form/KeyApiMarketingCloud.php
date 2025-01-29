<?php

namespace Drupal\liberty_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class key api fot marketing cloud .
 */
class KeyApiMarketingCloud extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'liberty_form.KeyApiMarketingCloud',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'KeyApiMarketingCloud';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('liberty_form.KeyApiMarketingCloud');

    $form['variable_get_key_auth'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Ingrese la url del Api Marketing Cloud Autenticación'),
      '#description' => $this->t('Ingrese la url de conexión para la autenticación envio de correos marketing cloud'),
      '#maxlength' => 255,
      '#size' => 255,
      '#default_value' => $config->get('variable_get_key_auth'),
    ];

    $form['variable_get_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Ingrese la url del Api Marketing Cloud Rest'),
      '#description' => $this->t('Ingrese la url de conexión para el envio de correos marketing cloud'),
      '#maxlength' => 255,
      '#size' => 255,
      '#default_value' => $config->get('variable_get_key'),
    ];

    $form['api_client_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t("Id Cliente"),
      '#default_value' => $config->get('api_client_id'),
      '#maxlength' => 255,
      '#weight' => 1,
    ];

    $form['api_service_auth'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Clave Secreta'),
      '#default_value' => $config->get('api_service_auth'),
      '#maxlength' => 255,
      '#weight' => 1,
    ];

    $form['account_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Account ID'),
      '#default_value' => $config->get('account_id'),
      '#maxlength' => 255,
      '#weight' => 1,
    ];

    $form['journey_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Journey name'),
      '#default_value' => $config->get('journey_name'),
      '#maxlength' => 255,
      '#weight' => 1,
    ];

    $form['journey_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Journey API key'),
      '#default_value' => $config->get('journey_api_key'),
      '#maxlength' => 255,
      '#weight' => 1,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('liberty_form.KeyApiMarketingCloud')
      ->set('variable_get_key_auth', $form_state->getValue('variable_get_key_auth'))
      ->set('variable_get_key', $form_state->getValue('variable_get_key'))
      ->set('api_service_auth', $form_state->getValue('api_service_auth'))
      ->set('api_client_id', $form_state->getValue('api_client_id'))
      ->set('account_id', $form_state->getValue('account_id'))
      ->set('journey_name', $form_state->getValue('journey_name'))
      ->set('journey_api_key', $form_state->getValue('journey_api_key'))
      ->save();
  }

}
