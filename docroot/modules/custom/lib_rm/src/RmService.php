<?php

namespace Drupal\lib_rm;

/**
 * CowService is a simple exampe of a Drupal 8 service.
 */
class RmService {

  /**
   * Returns a cow sound.
   */
  public function saySomething() {
    return $this->sounds[array_rand($this->sounds)];
  }

  /**
   * Get data childrens type plan.
   */
  public function getChildrensTipoPlan($id) {
    $query = \Drupal::database()->select('taxonomy_term__parent', 'p');
    $query->addField('p', 'entity_id', 'tid');
    $query->condition('p.parent_target_id', $id);
    $result = $query->execute()->fetchAll();
    if (!empty($result)) {
      foreach ($result as $value) {
        $opts[] = $value->tid;
      }
    }
    else {
      $opts[] = $id;

    }
    return $opts;
  }

}
