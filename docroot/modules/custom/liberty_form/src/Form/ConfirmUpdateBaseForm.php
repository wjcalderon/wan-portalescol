<?php

namespace Drupal\liberty_form\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Defines a confirmation form to confirm deletion of something by id.
 */
class ConfirmUpdateBaseForm extends ConfirmFormBase {

  /**
   * ID of the item to delete.
   *
   * @var int
   */
  protected $id;

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, string $id = "¿Desea importar la base de datos?") {
    $this->id = $id;
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    return new Url('liberty_form.db_migrator');
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return "confirm_update_base_form";
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('liberty_form.db_migrator');
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('¿Desea importar la base de datos?');
  }

}
