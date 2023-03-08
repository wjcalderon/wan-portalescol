<?php

namespace Drupal\lib_ls\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

/**
 * Class LosSeguraGlossaryForm.
 */
class LosSeguraGlossaryForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'los_segura_glossary_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#prefix'] = '<div class="modal-overlay jsModalOverlay"><div class="modal"><div class="modal-content">
    <div class="jsModalClose"><span>X</span></div>';
    $form['#suffix'] = '</div></div></div>';
    $form['ls_heading'] = [
      '#type' => 'markup',
      '#markup' => '
      <div class="glosario-ls__heading-form">
      <span class="glosario-ls__icon-form"></span>
      <h2 class="glosario-ls__title-form">Agrega tu palabra</h2>
      <p class="glosario-ls__lead-form">Llena el siguiente campo y agrega tu palabra a la lista de glosarío</p></div>',
    ];
    $form['ls_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Nombre'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
      '#required' => TRUE,
    ];
    $form['ls_email'] = [
      '#type' => 'email',
      '#title' => $this->t('Correo'),
      '#weight' => '0',
      '#required' => TRUE,
    ];
    $form['ls_phone'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Teléfono'),
      '#maxlength' => 64,
      '#size' => 64,
      '#required' => TRUE,
      '#weight' => '0',
    ];
    $form['ls_new_word'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Escribe tu nueva palabra'),
      '#maxlength' => 64,
      '#required' => TRUE,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Enviar'),
      '#attributes' => array('class' => array('button--primary button-large')),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    foreach ($form_state->getValues() as $key => $value) {
      // @TODO: Validate fields.
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    $node = Node::create(['type' => 'glosario_los_segura']);
    $node->set('title', $form_state->getValue('ls_new_word'));
    $node->set('field_usuario_info', $form_state->getValue('ls_name') . ' Email:' . $form_state->getValue('ls_email') . ' Teléfono:' . $form_state->getValue('ls_phone'));
    $node->set('status', 0);
    $node->enforceIsNew();
    $node->save();
  }

}
