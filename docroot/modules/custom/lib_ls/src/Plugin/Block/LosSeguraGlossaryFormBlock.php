<?php

namespace Drupal\lib_ls\Plugin\Block;

use Drupal\Core\Block\BlockBase;
<<<<<<< HEAD
use Drupal\Core\Form\FormInterface;
=======
>>>>>>> main

/**
 * Provides a 'LSGlossaryFormBlock' block.
 *
 * @Block(
 *  id = "ls_glossary_form_block",
 *  admin_label = @Translation("LS glossary form block"),
 * )
 */
class LosSeguraGlossaryFormBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $form = \Drupal::formBuilder()->getForm('Drupal\lib_ls\Form\LosSeguraGlossaryForm');

    return $form;
  }

}
