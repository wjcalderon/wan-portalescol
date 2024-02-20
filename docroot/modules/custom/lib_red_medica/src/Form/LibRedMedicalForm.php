<?php

namespace Drupal\lib_red_medica\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure lib_red_medica settings for this site.
 */
class LibRedMedicalForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'lib_red_medica_lib_red_medica';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['lib_red_medica.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['form_container'] = [
      '#title' => 'Configuración buscador',
      '#type'  => 'details',
      '#open' => TRUE,
    ];

    $plan_list = $this->getPlans();
    $default_value = [];

    $form['form_container']['plan']['list'] = [
      '#type' => 'checkboxes',
      '#options' => $plan_list,
      '#title' => 'Planes disponibles',
      '#required' => TRUE,
      '#default_value' => $this->config('lib_red_medica.settings')->get('plan_list') ?? $default_value,
    ];

    foreach ($plan_list as $tid => $plan) {
      $form['form_container']['plan']['description_' . $tid] = [
        '#type' => 'textfield',
        '#title' => "Descripción del plan: $plan",
        '#size' => 60,
        '#maxlength' => 150,
        '#states' => [
          'visible' => [
            ':input[name="list[' . $tid . ']"]' => ['checked' => TRUE],
          ],
          'required' => [
            ':input[name="list[' . $tid . ']"]' => ['checked' => TRUE],
          ],
        ],
        '#default_value' => $this->config('lib_red_medica.settings')->get('description_' . $tid),
      ];
    }

    $form['form_container']['distance'] = [
      '#type' => 'number',
      '#title' => "Distancia maxima",
      '#required' => TRUE,
      '#min' => 1,
      '#max' => 100,
      '#default_value' => $this->config('lib_red_medica.settings')->get('map_distance'),
    ];

    $form['preferential_container'] = [
      '#title' => 'Red Médica Preferencial',
      '#type'  => 'details',
      '#open' => TRUE,
    ];

    $form['preferential_container']['preferential_title'] = [
      '#type' => 'textfield',
      '#title' => 'Título',
      '#default_value' => $this->config('lib_red_medica.settings')->get('preferential_title'),
    ];

    $form['preferential_container']['preferential_description'] = [
      '#type' => 'textarea',
      '#title' => 'Descripción',
      '#default_value' => $this->config('lib_red_medica.settings')->get('preferential_description'),
    ];

    $form['additional_container'] = [
      '#title' => 'Configuración adicional',
      '#type'  => 'details',
      '#open' => TRUE,
    ];

    $form['additional_container']['personal_data_url'] = [
      '#type' => 'textfield',
      '#title' => 'URL política de tratamiento de datos',
      // '#default_value' => $config->get('personal_data_url'),
      '#default_value' => 'https://libertyseguros.co/terminos-de-uso-y-privacidad',
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('lib_red_medica.settings');

    // Set values.
    $config
      ->set('plan_list', $form_state->getValue('list'))
      ->set('map_distance', $form_state->getValue('distance'))
      ->set('preferential_title', $form_state->getValue('preferential_title'))
      ->set('preferential_description', $form_state->getValue('preferential_description'));

    foreach ($form_state->getValue('list') as $plan_tid) {
      $config
        ->set('description_' . $plan_tid, $form_state->getValue('description_' . $plan_tid));
    }

    // Save.
    $config->save();
    parent::submitForm($form, $form_state);
  }

  /**
   * Get plans from taxonomies.
   */
  private function getPlans() {
    $options = [];
    $vid = 'tipo_de_plan';

    $terms = \Drupal::entityTypeManager()
      ->getStorage('taxonomy_term')
      ->loadTree($vid, 0, 1);
    foreach ($terms as $term) {
      $options[$term->tid] = $term->name;
    }

    return $options;
  }

}
