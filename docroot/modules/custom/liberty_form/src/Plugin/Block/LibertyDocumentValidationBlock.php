<?php

namespace Drupal\liberty_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;

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
      '#markup' => $form
    ];
  }

}
