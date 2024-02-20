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
* id = "pqr_thankyou",
* admin_label = @Translation("Pqr thank you message"),
* )


*/
class PqrNotifThankyou extends BlockBase {
=======
/**
 * Provides a block with a simple text.
 *
 * @Block(
 * id = "pqr_thankyou",
 * admin_label = @Translation("Pqr thank you message"),
 * )
 */
class PqrNotifThankyou extends BlockBase {

>>>>>>> main
  /**
   * {@inheritdoc}
   */
  public function build() {

<<<<<<< HEAD
    // return $form;
    if (isset($_GET['resp']) && is_numeric($_GET['resp']) && $_GET['resp'] == '1') {
=======
    $request = \Drupal::requestStack()->getCurrentRequest();
    $resp = $request->query->get('resp');

    if ($resp !== NULL && is_numeric($resp) && $resp == '1') {
>>>>>>> main
      $html = '<div class="ctn-confirm-msg ctn-confirm-msg-pqr">
        <h2>Gracias !!</h2>
        <p>Tu solicitud será revisada por nuestra área encargada y pronto te daremos respuesta por medio de correo electrónico</p>
        <img alt="Confirmation" height="120" src="/themes/custom/liberty_public/images/icons/confirmation_form.svg" width="120" />
        </div>';

<<<<<<< HEAD
      return array (
        '#type' => 'markup',
        '#markup' => $html,
        '#cache' => ['max-age' => 0],
      );
=======
      return [
        '#type' => 'markup',
        '#markup' => $html,
        '#cache' => ['max-age' => 0],
      ];
>>>>>>> main
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
