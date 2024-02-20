<?php

namespace Drupal\liberty_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Msn api.
 */
class MsnApi extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'liberty_form.msn_api',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'msn_api';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('liberty_form.msn_api');
    $form['url_fetch'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Url consumo'),
      '#description' => $this->t('Ingrese url de consumo'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('url_fetch'),
    ];
    $form['url_token'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Url token'),
      '#description' => $this->t('Ingrese url del token'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('url_token'),
    ];
    $form['client_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Client ID'),
      '#description' => $this->t('Ingrese el ID del cliente'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('client_id'),
    ];
    $form['client_secret_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Client secret key'),
      '#description' => $this->t('Ingrese la llave de usuario secreta'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('client_secret_key'),
    ];
    $form['sms_type'] = [
      '#type' => 'textfield',
      '#title' => $this->t('smsType'),
      '#description' => $this->t('Ingrese el tipo de sms'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('sms_type'),
    ];
    $form['sender_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('senderId'),
      '#description' => $this->t('Ingrese el senderId'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('sender_id'),
    ];
    $form['provider'] = [
      '#type' => 'textfield',
      '#title' => $this->t('provider'),
      '#description' => $this->t('Ingrese el provider'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('provider'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('liberty_form.msn_api')
      ->set('url_fetch', $form_state->getValue('url_fetch'))
      ->set('url_token', $form_state->getValue('url_token'))
      ->set('client_id', $form_state->getValue('client_id'))
      ->set('client_secret_key', $form_state->getValue('client_secret_key'))
      ->set('cuerpo_del_mensaje', $form_state->getValue('cuerpo_del_mensaje'))
      ->set('sender_id', $form_state->getValue('sender_id'))
      ->set('sms_type', $form_state->getValue('sms_type'))
      ->set('provider', $form_state->getValue('provider'))
      ->save();
  }

}
