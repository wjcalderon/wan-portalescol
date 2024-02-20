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
 * id = "sinister_notification_thankyou",
 * admin_label = @Translation("Sinister thank you message"),
 * )
 */
class SinisterNotifThankyou extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $request = \Drupal::requestStack()->getCurrentRequest();
    $resp = $request->query->get('resp');

    // Return $form;.
    if ($resp !== NULL && is_numeric($resp) && $resp == '1') {
      $num_rand = random_int(100, 10000);
      $html = '<div class="ctn-msg-notif-sinister">
        <h2>¡Hemos recibido la información!</h2>
        <p>En el transcurso del siguiente día hábil, recibirás un correo con la información para continuar con el proceso</p>
        <img alt="Confirmation" height="120" src="/themes/custom/liberty_public/images/icons/ok-repo-sinis.svg" width="120" />
        <p>Tu número de radicado es <span class="number">' . $num_rand . '</span></p>
        <p>Si tienes alguna duda sobre el proceso puedes comunicarte a la línea de Bogotá <span class="number">3077050</span> y <span class="number">018000113390</span></p>
        <p><a  href="/aviso-de-siniestros" title="Volver al home de siniestros">Volver al home de siniestros</a></p>
        </div>';

      return [
        '#type' => 'markup',
        '#markup' => $html,
        '#cache' => ['max-age' => 0],
      ];
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
