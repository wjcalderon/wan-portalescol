<?php

<<<<<<< HEAD
/**
 * @file
 * Contains \Drupal\liberty_form\Controller\LibertyDocumentValidationController
 */

namespace Drupal\liberty_form\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\Markup;

class LibertyDocumentValidationController extends ControllerBase {

=======
namespace Drupal\liberty_form\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Validaion controller custom.
 */
class LibertyDocumentValidationController extends ControllerBase {

  /**
   * Validation form render.
   */
>>>>>>> main
  public function validation($id) {

    $myForm = $this->formBuilder()->getForm('Drupal\liberty_form\Form\LibertyDocumentValidationForm');
    $renderer = \Drupal::service('renderer');
    $myFormHtml = $renderer->render($myForm);

    return [
<<<<<<< HEAD
        '#markup' => $myFormHtml,
    ];
  }
}
=======
      '#markup' => $myFormHtml,
    ];
  }

}
>>>>>>> main
