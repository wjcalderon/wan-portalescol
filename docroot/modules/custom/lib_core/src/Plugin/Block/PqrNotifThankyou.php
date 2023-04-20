<?php

namespace Drupal\lib_core\Plugin\Block;

use Drupal;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;


/**
* Provides a block with a simple text.
*
* @Block(
* id = "pqr_thankyou",
* admin_label = @Translation("Pqr thank you message"),
* )


*/
class PqrNotifThankyou extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    // return $form;
    if (isset($_GET['resp']) && is_numeric($_GET['resp']) && $_GET['resp'] == '1') {
      $html = '<div class="ctn-confirm-msg ctn-confirm-msg-pqr">
        <h2>Gracias !!</h2>
        <p>Tu solicitud será revisada por nuestra área encargada y pronto te daremos respuesta por medio de correo electrónico</p>
        <img alt="Confirmation" height="120" src="/themes/custom/liberty_public/images/icons/confirmation_form.svg" width="120" />
        </div>';

      return array (
        '#type' => 'markup',
        '#markup' => $html,
        '#cache' => ['max-age' => 0],
      );
    }
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
}
