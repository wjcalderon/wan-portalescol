<?php

namespace Drupal\lib_ls\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;

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
