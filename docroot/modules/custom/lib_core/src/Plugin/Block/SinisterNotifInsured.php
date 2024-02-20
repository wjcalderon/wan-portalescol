<?php

namespace Drupal\lib_core\Plugin\Block;

<<<<<<< HEAD
use Drupal;
=======
>>>>>>> main
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

<<<<<<< HEAD

/**
* Provides a block with a simple text.
*
* @Block(
* id = "sinister_notification_insured",
* admin_label = @Translation("Sinister notification insured"),
* )


*/
class SinisterNotifInsured extends BlockBase {
=======
/**
 * Provides a block with a simple text.
 *
 * @Block(
 * id = "sinister_notification_insured",
 * admin_label = @Translation("Sinister notification insured"),
 * )
 */
class SinisterNotifInsured extends BlockBase {

>>>>>>> main
  /**
   * {@inheritdoc}
   */
  public function build() {

    $form = \Drupal::formBuilder()->getForm('Drupal\lib_core\Form\SinisterNotifInsured');
    return $form;

  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
<<<<<<< HEAD
    $config = $this->getConfiguration();

=======
>>>>>>> main
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['my_block_settings'] = $form_state->getValue('my_block_settings');
  }
<<<<<<< HEAD
}
=======

}
>>>>>>> main
