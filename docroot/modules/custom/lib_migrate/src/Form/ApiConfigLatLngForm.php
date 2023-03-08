<?php

namespace Drupal\lib_migrate\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class ApiConfigLatLngForm extends ConfigFormBase {

  const SETTINGS = 'lib_migrate.settings';

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
    return 'api_config_lat_lng_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['api_key_lat_lng'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Api key lat - lng'),
      '#description' => $this->t('API Key de latitud y longitud para el proceso de migración de prestadores'),
      '#default_value' => $config->get('config.api_key_lat_lng'),
      '#required' => TRUE,
    ];

    $config_count = $config->get('config.count_reqs_lat_lng');
    $dflt_count = !empty($config_count) ? $config_count : 0;
    $form['count_reqs_lat_lng'] = [
      '#type' => 'hidden',
      '#default_value' => $dflt_count,
    ];
    $form['markup_reqs_lat_lng'] = [
      'label' => array(
        '#prefix' => '<p><strong>',
        '#suffix' => '</strong></p>',
        '#markup' => 'Número de peticiones realizadas : ',
        'count' => array(
          '#markup' => $dflt_count
        )
      )
    ];

    $form['markup_reqs_lat_lng']['label']['reset_count'] = [
      '#prefix' => '<p>',
      '#suffix' => '</p>',
      '#type' => 'submit',
      '#value' => 'Reiniciar contador',
      '#name' => 'restart'
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $count_reqs_lat_lng = $form_state->getValue('count_reqs_lat_lng');
    $trigger_element = $form_state->getTriggeringElement();
    $submit_name = $trigger_element['#name'];
    
    if ($submit_name == 'restart') {
      $config = $this->configFactory->getEditable(static::SETTINGS)
      ->set('config.count_reqs_lat_lng', 0)
      ->save();
    }
    else {
      $config = $this->configFactory->getEditable(static::SETTINGS)
        ->set('config.api_key_lat_lng', $form_state->getValue('api_key_lat_lng'))
        ->set('config.count_reqs_lat_lng', $count_reqs_lat_lng)
        ->save();
    }
    parent::submitForm($form, $form_state);
  }
}
