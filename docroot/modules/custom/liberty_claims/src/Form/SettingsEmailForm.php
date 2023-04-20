<?php

namespace Drupal\liberty_claims\Form;

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

}
