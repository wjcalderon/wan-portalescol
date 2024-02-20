<?php

namespace Drupal\liberty_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class vip.
 */
<<<<<<< HEAD
class vip extends ConfigFormBase {
=======
class Vip extends ConfigFormBase {
>>>>>>> main

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'liberty_form.vip',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'vip';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('liberty_form.vip');
    $form['variable_get_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Ingrese nombre de la variable'),
      '#description' => $this->t('Ingrese el nombre variable para acceder vip a la landing'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('variable_get_name'),
    ];
    $form['variable_get_value'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Ingrese nombre de la variable'),
      '#description' => $this->t('Ingrese el nombre variable para acceder vip a la landing'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('variable_get_value'),
    ];
<<<<<<< HEAD
    
    
=======

>>>>>>> main
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('liberty_form.vip')
      ->set('variable_get_name', $form_state->getValue('variable_get_name'))
      ->set('variable_get_value', $form_state->getValue('variable_get_value'))
      ->save();
  }

}
