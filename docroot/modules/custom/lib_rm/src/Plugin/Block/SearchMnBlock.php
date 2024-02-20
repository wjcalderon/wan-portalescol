<?php

namespace Drupal\lib_rm\Plugin\Block;

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
* id = "search_medical_network",
* admin_label = @Translation("Search medical network"),
* )
*/
class SearchMnBlock extends BlockBase {
=======
/**
 * Provides a block with a simple text.
 *
 * @Block(
 * id = "search_medical_network",
 * admin_label = @Translation("Search medical network"),
 * )
 */
class SearchMnBlock extends BlockBase {

>>>>>>> main
  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\lib_rm\Form\SearchMedicalNetwork');
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
    $config = $this->getConfiguration();

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['my_block_settings'] = $form_state->getValue('my_block_settings');
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
<<<<<<< HEAD
=======

>>>>>>> main
}
