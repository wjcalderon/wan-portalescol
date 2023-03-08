<?php

/**
 * @file
 * Contains \Drupal\liberty_form\Controller\LibertyDocumentValidationController
 */

namespace Drupal\liberty_form\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\Markup;

class LibertyDocumentValidationController extends ControllerBase {

  public function validation($id) {

    $myForm = $this->formBuilder()->getForm('Drupal\liberty_form\Form\LibertyDocumentValidationForm');
    $renderer = \Drupal::service('renderer');
    $myFormHtml = $renderer->render($myForm);

    return [
        '#markup' => $myFormHtml,
    ];
  }
}