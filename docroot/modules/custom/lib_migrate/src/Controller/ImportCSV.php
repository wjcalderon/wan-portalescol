<?php

namespace Drupal\lib_migrate\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller for building migratemedical network form.
 */
<<<<<<< HEAD
class ImportCSV extends ControllerBase
{
    public function content()
    {
        $form = \Drupal::formBuilder()->getForm('Drupal\lib_migrate\Form\ImportForm');
        return $form;
    }
}
=======
class ImportCSV extends ControllerBase {

  /**
   * Contents controller.
   */
  public function content() {
    $form = \Drupal::formBuilder()->getForm('Drupal\lib_migrate\Form\ImportForm');
    return $form;
  }

}
>>>>>>> main
