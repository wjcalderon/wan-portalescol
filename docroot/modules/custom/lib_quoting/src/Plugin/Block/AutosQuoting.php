<?php

namespace Drupal\lib_quoting\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'DefaultBlock' block.
 *
 * @Block(
 *  id = "autos_quoting_form",
 *  admin_label = @Translation("Autos quoting form"),
 * )
 */
class AutosQuoting extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\lib_quoting\Form\AutosQuoting');
    return $form;
  }

}
