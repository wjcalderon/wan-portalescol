<?php

namespace Drupal\lib_rm;

/**
 * CowService is a simple exampe of a Drupal 8 service.
 */
class RmService {

<<<<<<< HEAD
  private $id_plan = 40;

=======
>>>>>>> main
  /**
   * Returns a cow sound.
   */
  public function saySomething() {
    return $this->sounds[array_rand($this->sounds)];
  }

<<<<<<< HEAD
  function getChildrensTipoPlan($id){
      $options = [];
      $query = \Drupal::database()->select('taxonomy_term__parent', 'p');
      $query->addField('p', 'entity_id','tid');
      $query->condition('p.parent_target_id', $id);
      $result = $query->execute()->fetchAll();
      if (!empty($result)) {
        foreach ($result as $key => $value) {
          $opts[] = $value->tid;
        }
      }
      else {
        $opts[] = $id;

      }
      return $opts;
  }


  /**
   * Real photo of our cow.
   */
  public function howDoYouLookLike() {
    return print_r('
           (    )
            (oo)
   )\.-----/(O O)
  # ;       / u
    (  .   |} )
     |/ `.;|/;
     "     " "
     ', FALSE);
  }
}
=======
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
>>>>>>> main
