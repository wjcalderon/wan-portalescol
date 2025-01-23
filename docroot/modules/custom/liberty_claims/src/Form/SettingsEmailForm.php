<?php

namespace Drupal\liberty_claims\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Configure SettingsEmailForm settings for this site.
 */
class SettingsEmailForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'liberty_claims_liberty_claims_email';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['liberty_claims_email.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['acordeon_destinatario'] = [
      '#type' => 'details',
      '#title' => $this->t('Acordeón de Destinatario'),
    ];

    $form['acordeon_destinatario']['email_send'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Introduzca la dirección de correo electrónico del destinatario'),
      '#required' => TRUE,
      '#default_value' => $this->config('liberty_claims_email.settings')->get('email_send') ?? '',
      '#placeholder' => $this->config('liberty_claims_email.settings')->get('email_send') ? '' : $this->t('Introduzca la dirección de correo electrónico del destinatario'),
    ];

    $form['acordeon_destinatario']['cod_chevrolet'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Introduzca código convenio chevrolet'),
      '#required' => TRUE,
      '#default_value' => $this->config('liberty_claims_email.settings')->get('cod_chevrolet') ?? '',
      '#placeholder' => $this->config('liberty_claims_email.settings')->get('cod_chevrolet') ? '' : $this->t('Introduzca código convenio chevrolet'),
    ];

    $form['acordeon_destinatario']['cod_nissan'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Introduzca código convenio nissan'),
      '#required' => TRUE,
      '#default_value' => $this->config('liberty_claims_email.settings')->get('cod_nissan') ?? '',
      '#placeholder' => $this->config('liberty_claims_email.settings')->get('cod_nissan') ? '' : $this->t('Introduzca código convenio nissan'),
    ];

    $form['acordeon_destinatario']['cod_renault'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Introduzca código convenio renault'),
      '#required' => TRUE,
      '#default_value' => $this->config('liberty_claims_email.settings')->get('cod_renault') ?? '',
      '#placeholder' => $this->config('liberty_claims_email.settings')->get('cod_renault') ? '' : $this->t('Introduzca código convenio renault'),
    ];

    $form['acordeon_destinatario']['cod_chevyplan'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Introduzca código convenio chevyplan'),
      '#required' => TRUE,
      '#default_value' => $this->config('liberty_claims_email.settings')->get('cod_chevyplan') ?? '',
      '#placeholder' => $this->config('liberty_claims_email.settings')->get('cod_chevyplan') ? '' : $this->t('Introduzca código convenio chevyplan'),
    ];

    $form['acordeon_correo_carros'] = [
      '#type' => 'details',
      '#title' => $this->t('Configuración de Correos Carros Hurtados'),
    ];

    $form['acordeon_correo_carros']['subject'] = [
      '#type' => 'textfield',
      '#maxlength' => 1024,
      '#size' => 100,
      '#title' => $this->t('Asunto Correo'),
      '#default_value' => $this->config('liberty_claims_email.settings')->get('subject') ?? '',
      '#required' => TRUE,
      '#description' => $this->t('<li>Para agregar la placa  el token asignado es [liberty_claims:plate]</li>'),
    ];

    $form['acordeon_correo_carros']['email_send_car'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Introduzca la dirección de correo electrónico del destinatario correo carros hurtados'),
      '#required' => TRUE,
      '#default_value' => $this->config('liberty_claims_email.settings')->get('email_send_car') ?? '',
      '#placeholder' => $this->config('liberty_claims_email.settings')->get('email_send_car') ? '' : $this->t('Introduzca la dirección de correo electrónico del destinatario'),
      '#description' => $this->t('<li>Destinatarios para el envío de emails</li>
          <li>Múltiples emails separados por coma.</li>
          <li>Ejemplo: user1@dominio.com,user2@dominio.com</li>'),
    ];

    $form['acordeon_correo_carros']['list_logs'] = [
      '#type' => 'link',
      '#title' => $this->t('Ver logs envió de correo'),
      '#url' => Url::fromUri('internal:/admin/config/liberty_claims/settings/repots/hurto'),
      '#attributes' => [
        'class' => [
          'button',
          'button--primary',
        ],
      ],
    ];
    $form['acordeon_correo_carros']['template_correo'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Plantilla Correo'),
      '#format' => $this->config('liberty_claims_email.settings')->get('template_correo')['format'] ?? '',
      '#default_value' => $this->config('liberty_claims_email.settings')->get('template_correo')['value'] ?? '',
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $value_email = trim($form_state->getValue('email_send'), ',');

    $this->config('liberty_claims_email.settings')
      ->set('cod_chevrolet', $form_state->getValue('cod_chevrolet'))
      ->set('cod_nissan', $form_state->getValue('cod_nissan'))
      ->set('cod_renault', $form_state->getValue('cod_renault'))
      ->set('cod_chevyplan', $form_state->getValue('cod_chevyplan'))
      ->set('email_send', $value_email)
      ->set('email_send_car', $form_state->getValue('email_send_car'))
      ->set('template_correo', $form_state->getValue('template_correo'))
      ->set('subject', $form_state->getValue('subject'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
