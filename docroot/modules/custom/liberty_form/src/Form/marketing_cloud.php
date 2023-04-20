<?php

namespace Drupal\liberty_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class marketing_cloud.
 */
class marketing_cloud extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'liberty_form.marketing_cloud',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'marketing_cloud';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('liberty_form.marketing_cloud');
    $form['host_sftp'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Url host'),
      '#description' => $this->t('Ingrese el host de conexión'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('host_sftp'),
    ];
    $form['user_sftp'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Usuario'),
      '#description' => $this->t('Ingrese el usuario de conexión'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('user_sftp'),
    ];
    $form['pass_sftp'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Credenciales'),
      '#description' => $this->t('Ingrese las credenciales de conexión'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('pass_sftp'),
    ];
    $form['port_sftp'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Puerto'),
      '#description' => $this->t('Ingrese el puerto de destino'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('port_sftp'),
    ];
    $form['path_sftp'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Path'),
      '#description' => $this->t('Ingrese la ruta de destino'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('path_sftp'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('liberty_form.marketing_cloud')
      ->set('host_sftp', $form_state->getValue('host_sftp'))
      ->set('user_sftp', $form_state->getValue('user_sftp'))
      ->set('pass_sftp', $form_state->getValue('pass_sftp'))
      ->set('port_sftp', $form_state->getValue('port_sftp'))
      ->set('path_sftp', $form_state->getValue('path_sftp'))
      ->save();
  }

}
