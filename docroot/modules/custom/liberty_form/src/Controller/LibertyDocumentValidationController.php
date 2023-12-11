<?php

namespace Drupal\liberty_form\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Validaion controller custom.
 */
class LibertyDocumentValidationController extends ControllerBase {

  /**
   * Validation form render.
   */
  public function validation($id) {

    $myForm = $this->formBuilder()->getForm('Drupal\liberty_form\Form\LibertyDocumentValidationForm');
    $renderer = \Drupal::service('renderer');
    $myFormHtml = $renderer->render($myForm);

    return [
      '#markup' => $myFormHtml,
    ];
  }

}
