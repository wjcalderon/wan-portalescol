<?php

namespace Drupal\lib_rm\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\views\Views;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 * id = "render_view_search_medical_network",
 * admin_label = @Translation("Render view search medical network"),
 * )
 */
class RenderViewMnBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $html_view = "";
    $class = "content__view--rm";
    $request = \Drupal::requestStack()->getCurrentRequest();

    $parametros_get = $request->getCurrentRequest()->query->all();

    if ((isset($parametros_get['c']) && is_numeric($parametros_get['c'])) || (isset($parametros_get['t']) && !empty($parametros_get['t']))) {

      // Get view.
      $view = Views::getView('search_rm');
      $display = 'page_2';
      if (isset($parametros_get['vm']) && !empty($parametros_get['vm'])) {
        $display = ($parametros_get['vm'] == 'map') ? 'page_3' : 'page_2';
      }
      $view->setDisplay($display);
      $view->preExecute();

      $args_view = [
        'field_type_plan_target_id' => 'All',
        'field_ubication_target_id' => 'All',
        'field_speciality_target_id' => 'All',
        'title' => '',
        'field_location_map_proximity-lat' => '',
        'field_location_map_proximity-lng' => '',
        'field_location_map_proximity' => '3',
      ];

      // Plan type.
      $class = "content__view--rm";
      if (isset($parametros_get['pt']) && is_numeric($parametros_get['pt'])) {
        if ($parametros_get['pt'] == 662) {
          $class = "content__view--rm-poliza-salud";
        }
        $our_service = \Drupal::service('lib_rm.srm');
        $tids = $our_service->getChildrensTipoPlan($parametros_get['pt']);
        $args_view['field_type_plan_target_id'] = $tids;
      }
      // Cities.
      if (isset($parametros_get['c']) && is_numeric($parametros_get['c'])) {
        $args_view['field_ubication_target_id'] = $parametros_get['c'];
      }
      // Speciality.
      if (isset($parametros_get['e']) && is_numeric($parametros_get['e'])) {
        $args_view['field_speciality_target_id'] = $parametros_get['e'];
      }

      // Title.
      if (isset($parametros_get['t']) && !empty($parametros_get['t'])) {
        $args_view['title'] = $parametros_get['t'];
      }

      // Latitude.
      if (isset($parametros_get['lat']) && is_numeric($parametros_get['lat'])) {
        $args_view['field_location_map_proximity-lat'] = $parametros_get['lat'];
      }

      // Longitude.
      if (isset($parametros_get['lng']) && is_numeric($parametros_get['lng'])) {
        $args_view['field_location_map_proximity-lng'] = $parametros_get['lng'];
      }

      $view->setExposedInput($args_view);
      $view->is_cacheable = FALSE;
      $view->execute();
      $view_render = $view->buildRenderable();
      $html_view = \Drupal::service('renderer')->render($view_render);
    }
    return [
      '#type' => 'markup',
      '#markup' => '<div class="' . $class . '">' . $html_view . '</div>',
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
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), ['url.path']);
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
