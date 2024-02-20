<?php

namespace Drupal\removeredmedicaspecialties\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Remove Red Medica Specialties form.
 */
class RemoveSpecialtiesForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'removeredmedicaspecialties_remove_specialties';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['price'] = [
      '#markup' => '<h2>Eliminar todas las especialidades existentes</h2>',
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Eliminar'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $vid = 'speciality';
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);

    foreach ($terms as $term) {
      $term_entity = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($term->tid);
      $term_entity->delete();
    }

    $this->messenger()->addStatus($this->t('Especialidades eliminadas.'));

  }

}
