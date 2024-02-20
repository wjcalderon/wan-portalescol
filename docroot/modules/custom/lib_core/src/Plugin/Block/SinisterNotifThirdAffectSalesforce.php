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
* id = "sinister_notification_third_salesforce",
* admin_label = @Translation("Sinister notification third affected salesforce"),
* )


*/
class SinisterNotifThirdAffectSalesforce extends BlockBase {
=======
/**
 * Provides a block with a simple text.
 *
 * @Block(
 * id = "sinister_notification_third_salesforce",
 * admin_label = @Translation("Sinister notification third affected salesforce"),
 * )
 */
class SinisterNotifThirdAffectSalesforce extends BlockBase {

>>>>>>> main
  /**
   * {@inheritdoc}
   */
  public function build() {

    $form = \Drupal::formBuilder()->getForm('Drupal\lib_core\Form\SinisterNotifthirdAffectedSalesforce');
<<<<<<< HEAD
    // return $form;
    return array (
      '#type' => 'markup',
      '#markup' => \Drupal::service('renderer')->render($form),
      '#cache' => ['max-age' => 0],
    );
=======
    // Return $form;.
    return [
      '#type' => 'markup',
      '#markup' => \Drupal::service('renderer')->render($form),
      '#cache' => ['max-age' => 0],
    ];
>>>>>>> main
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
=======

>>>>>>> main
}
