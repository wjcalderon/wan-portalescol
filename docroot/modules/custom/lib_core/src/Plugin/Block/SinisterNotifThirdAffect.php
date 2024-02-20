<?php

namespace Drupal\lib_core\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 * id = "sinister_notification_third",
 * admin_label = @Translation("Sinister notification third affected"),
 * )
 */
class SinisterNotifThirdAffect extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm(
          'Drupal\lib_core\Form\SinisterNotifthirdAffectedd'
      );
    // Return $form;.
    return [
      '#type' => 'markup',
      '#markup' => \Drupal::service('renderer')->render($form),
      '#cache' => ['max-age' => 0],
    ];
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
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['my_block_settings'] = $form_state->getValue(
          'my_block_settings'
      );
  }

}
