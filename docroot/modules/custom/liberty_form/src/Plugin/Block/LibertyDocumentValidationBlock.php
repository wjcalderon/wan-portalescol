<?php

namespace Drupal\liberty_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;
<<<<<<< HEAD
use Drupal\Core\Form\FormInterface;
=======
>>>>>>> main

/**
 * Provides a 'LibertyDocumentValidationBlock' block.
 *
 * @Block(
 *  id = "liberty_form_validation_block",
 *  admin_label = @Translation("Form Validation ID"),
 * )
 */
class LibertyDocumentValidationBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $form = \Drupal::formBuilder()->getForm('Drupal\liberty_form\Form\LibertyDocumentValidationForm');

    return [
      '#type' => 'markup',
<<<<<<< HEAD
      '#markup' => $form
=======
      '#markup' => $form,
>>>>>>> main
    ];
  }

}
