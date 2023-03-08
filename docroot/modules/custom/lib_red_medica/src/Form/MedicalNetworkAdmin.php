<?php
/**
 * @file
 * Contains Drupal\lib_red_medica\Form\MedicalNetworkAdmin.
 */
namespace Drupal\lib_red_medica\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Medical network configuration form
 */
class MedicalNetworkAdmin extends ConfigFormBase {

  /** 
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'lib_red_medical.settings';

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
    return 'medical_network_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    // Get plan types taxonomies
    $plan_list = $this->getPlans();

    $form['form_container'] = [
      '#title' => 'Configuración buscador',
      '#type'  => 'details',
      '#open' => TRUE,
    ];

    $form['form_container']['plan']['list'] = [
      '#type' => 'checkboxes',
      '#options' => $plan_list,
      '#title' => 'Planes disponibles',
      '#required' => TRUE,
      '#default_value' => $config->get('plan_list'),
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
        '#default_value' => $config->get('description_' .  $tid),
      ];
    }

    $form['form_container']['distance'] = [
      '#type' => 'number',
      '#title' => "Distancia maxima",
      '#required' => TRUE,
      '#min' => 1,
      '#max' => 100,
      '#default_value' => $config->get('map_distance'),
    ];

    $form['preferential_container'] = [
      '#title' => 'Red Médica Preferencial',
      '#type'  => 'details',
      '#open' => true,
    ];

    $form['preferential_container']['preferential_title'] = [
      '#type' => 'textfield',
      '#title' => 'Título',
      '#default_value' => $config->get('preferential_title'),
    ];

    $form['preferential_container']['preferential_description'] = [
      '#type' => 'textarea',
      '#title' => 'Descripción',
      '#default_value' => $config->get('preferential_description'),
    ];

    $form['additional_container'] = [
      '#title' => 'Configuración adicional',
      '#type'  => 'details',
      '#open' => true,
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
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $config = $this->config(static::SETTINGS);

    // Set values
    $config
      ->set('plan_list', $form_state->getValue('list'))
      ->set('map_distance', $form_state->getValue('distance'))
      ->set('preferential_title', $form_state->getValue('preferential_title'))
      ->set('preferential_description', $form_state->getValue('preferential_description'));

    foreach ($form_state->getValue('list') as $plan_tid) {
      $config
        ->set('description_' . $plan_tid, $form_state->getValue('description_' . $plan_tid));
    }

    // Save
    $config->save();
  }

  /**
   * Get plans from taxonomies
   *
   * @access private
   * @return array
   */
  private function getPlans() {
    $options = [];
    $vid = 'tipo_de_plan';

    $terms =\Drupal::entityTypeManager()
      ->getStorage('taxonomy_term')
      ->loadTree($vid, 0, 1);
    foreach ($terms as $term) {
      $options[$term->tid] = $term->name;
    }

    return $options;
  }
}
