<?php

namespace Drupal\liberty_claims\Form;

<<<<<<< HEAD
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SettingsEmailForm.
 */
class SettingsEmailForm extends FormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'settings_email_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = \Drupal::config('SettingsEmalForm.settings');

        $form['email_send'] = [
            '#type' => 'textfield',
            '#title' => t('Introduzca la dirección de correo electrónico del destinatario'),
            '#required' => true,
            '#default_value' => $config->get('email_send') ? $config->get('email_send') : '',
            '#placeholder' => $config->get('email_send') ? '' : t('Introduzca la dirección de correo electrónico del destinatario'),
        ];

        $form['cod_chevrolet'] = [
            '#type' => 'textfield',
            '#title' => t('Introduzca codigo convenio chevrolet'),
            '#required' => true,
            '#default_value' => $config->get('cod_chevrolet') ? $config->get('cod_chevrolet') : '',
            '#placeholder' => $config->get('cod_chevrolet') ? '' : t('Introduzca codigo convenio chevrolet'),
        ];

        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Enviar'),
        ];

        return $form;

    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        foreach ($form_state->getValues() as $key => $value) {
            // @TODO: Validate fields.
        }
        parent::validateForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {

        $config = \Drupal::service('config.factory')->getEditable('SettingsEmalForm.settings');

        $config->set('email_send', $form_state->getValues()['email_send'])->save();
        $config->set('cod_chevrolet', $form_state->getValues()['cod_chevrolet'])->save();

        \Drupal::messenger()->addMessage(t('Configuración guardada exitosamente'));
    }
=======
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
      ->set('email_send', $value_email)
      ->set('email_send_car', $form_state->getValue('email_send_car'))
      ->set('template_correo', $form_state->getValue('template_correo'))
      ->set('subject', $form_state->getValue('subject'))
      ->save();
    parent::submitForm($form, $form_state);
  }
>>>>>>> main

}
