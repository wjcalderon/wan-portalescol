<?php

namespace Drupal\lib_red_medica\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MedicalNetworkController extends ControllerBase {

  /**
   * Search cities in plan type
   *
   * @param integer $plan_tid
   * @param string $name_city
   * @return string
   */
  public function plan (int $plan_tid) {
    $options = [];

    // If both fields exists
    if ($plan_tid != '') {
      // Query
      $connection = \Drupal::database();
      $sql = "SELECT name
        FROM taxonomy_term_field_data
        WHERE tid = $plan_tid";

      $query = $connection->query($sql);
      $result = $query->fetchObject();

      $tids = $this->getChildTaxonomies($plan_tid);

      // If exist data
      if (!empty($result)) {
        $options[] = [
          'name' => $result->name,
          'tid' => is_array($tids) ? \implode(', ', $tids) : $plan_tid
        ];
      }
    }

    return new JsonResponse($options);
  }

  /**
   * Search cities in plan type
   *
   * @param integer $plan_tid
   * @param string $name_city
   * @return string
   */
  public function cities (int $plan_tid, string $name_city) {
    $options = [];

    // If both fields exists
    if ($plan_tid != '') {
      // Escape data from user
      $name_city = \Drupal::database()->escapeLike($name_city);

      // Search child taxonomies
      $query_condition = $this->queryCondition($plan_tid);

      // Query
      $connection = \Drupal::database();
      $sql = "SELECT DISTINCT tfd.tid, tfd.name
        FROM taxonomy_term_field_data tfd
        INNER JOIN node__field_ubication fu
          ON tfd.tid = fu.field_ubication_target_id
        INNER JOIN node__field_type_plan ftp
          ON fu.entity_id = ftp.entity_id
        WHERE tfd.vid = 'ubication'
          AND ftp.field_type_plan_target_id $query_condition
          AND tfd.name LIKE '%$name_city%'
        ORDER BY tfd.name
        LIMIT 10";

      $query = $connection->query($sql);
      $result = $query->fetchAll();

      // If exist data
      if (!empty($result)) {
        foreach ($result as $key => $value) {
          $options[] = [
            'name' => $value->name,
            'tid' => $value->tid
          ];
        }
      }
    }

    return new JsonResponse($options);
  }

  /**
   * Search specialities
   *
   * @param integer $plan_tid
   * @param integer $city_tid
   * @param string $speciality
   * @return string
   */
  public function specialities (int $plan_tid, $city_tid, string $speciality) {
    $options = [];

    // If both fields exists
    if ($plan_tid != '' && $city_tid != null && $city_tid != '') {
      // Escape data from user
      $speciality = \Drupal::database()->escapeLike($speciality);

      // Search child taxonomies
      $query_condition = $this->queryCondition($plan_tid);

      // Query
      $connection = \Drupal::database();
      $sql = "SELECT DISTINCT tfd.tid, tfd.name
        FROM taxonomy_term_field_data tfd
        INNER JOIN node__field_speciality fs
          ON (tfd.tid = fs.field_speciality_target_id AND ((tfd.name LIKE '$speciality%') OR (tfd.name LIKE '%$speciality%')))
        INNER JOIN node__field_type_plan ftp
          ON fs.entity_id = ftp.entity_id
        INNER JOIN node__field_ubication fu
          ON fs.entity_id = fu.entity_id
        WHERE tfd.vid = 'speciality'
          AND ftp.field_type_plan_target_id $query_condition
          AND fu.field_ubication_target_id = $city_tid
        ORDER BY tfd.name
        LIMIT 50";

      $query = $connection->query($sql);
      $result = $query->fetchAll();

      // If exist data
      if (!empty($result)) {
        foreach ($result as $key => $value) {
          $options[] = [
            'name' => $value->name,
            'tid' => $value->tid
          ];
        }
      }
    }

    return new JsonResponse($options);
  }

  public function institutions (int $plan_tid, string $institution) {
    $options = [];

    // If both fields exists
    if ($plan_tid != '' && $institution != '') {
      // Escape data from user
      $institution = \Drupal::database()->escapeLike($institution);

      // Search child taxonomies
      $query_condition = $this->queryCondition($plan_tid);

      // Query
      $connection = \Drupal::database();
      $sql = "SELECT DISTINCT TRIM(nfd.title) title
        FROM node_field_data nfd
        INNER JOIN node__field_type_plan ftp
          ON nfd.nid = ftp.entity_id
        WHERE nfd.type = 'lender'
          AND ftp.field_type_plan_target_id $query_condition
          AND nfd.title LIKE '%$institution%'
        ORDER BY TRIM(nfd.title)
        LIMIT 10";

      $query = $connection->query($sql);
      $result = $query->fetchAll();

      // If exist data
      if (!empty($result)) {
        foreach ($result as $key => $value) {
          $options[] = [
            'title' => $value->title
          ];
        }
      }
    }

    return new JsonResponse($options);
  }


  /**
   * Search child taxonomies
   *
   * @param integer $plan_tid
   * @return string
   */
  private function queryCondition(int $plan_tid) {
    $child_tids = $this->getChildTaxonomies($plan_tid);

    // If exist data
    if (is_array($child_tids)) {
      return " IN (" . \implode(', ', $child_tids) . ")";
    }

    return " = $plan_tid";
  }

  /**
   * Get child taxonomies if exits
   *
   * @return int|array
   */
  private function getChildTaxonomies($plan_tid) {
    // Query
    $connection = \Drupal::database();
    $sql = "SELECT entity_id
      FROM taxonomy_term__parent
      WHERE parent_target_id = $plan_tid";

    $query = $connection->query($sql);

    $child_tids = $query->fetchAll();

    if (!empty($child_tids)) {
      $tids = [];
      foreach ($child_tids as $key => $value) {
        $tids[] = $value->entity_id;
      }

      return $tids;
    }

    return $plan_tid;
  }
}
