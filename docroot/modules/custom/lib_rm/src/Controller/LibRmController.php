<?php
<<<<<<< HEAD
namespace Drupal\lib_rm\Controller;

use Drupal;
use Drupal\node\Entity\Node;
use Drupal\Core\Controller\ControllerBase;
use Drupal\taxonomy\Entity\Term;
use Symfony\Component\HttpFoundation\Response;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Component\Utility\Tags;
use Drupal\Component\Utility\Unicode;

class LibRmController extends ControllerBase {

  public function _lib_rm_get_options_by_vocabulary($voc_name, $bool_opt_default = TRUE) {
    if (!empty($voc_name)) {
      $opts = array();
      if ($bool_opt_default) {
      	$opts['none'] = 'Seleccionar';
      }

      $our_service = \Drupal::service('lib_rm.srm');
=======

namespace Drupal\lib_rm\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Lib Rm Controller.
 */
class LibRmController extends ControllerBase {

  /**
   * Lib Rm Get Options By Vocabulary.
   */
  public function libRmGetOptionsByVocabulary($voc_name, $bool_opt_default = TRUE) {
    if (!empty($voc_name)) {
      $opts = [];
      if ($bool_opt_default) {
        $opts['none'] = 'Seleccionar';
      }
>>>>>>> main
      $query = \Drupal::database()->select('taxonomy_term_field_data', 'tfd');
      $query->addField('tfd', 'tid');
      $query->addField('tfd', 'name');
      $query->condition('tfd.vid', $voc_name);
      $query->condition('p.parent_target_id', 0);
<<<<<<< HEAD
      $query->leftJoin('taxonomy_term__parent' ,'p', 'p.entity_id=tfd.tid');
      $query->orderBy('tfd.weight');
      $result = $query->execute()->fetchAll();
      if (!empty($result)) {
        foreach ($result as $key => $value) {
=======
      $query->leftJoin('taxonomy_term__parent', 'p', 'p.entity_id=tfd.tid');
      $query->orderBy('tfd.weight');
      $result = $query->execute()->fetchAll();
      if (!empty($result)) {
        foreach ($result as $value) {
>>>>>>> main
          $opts[$value->tid] = $value->name;
        }
      }
      return $opts;
    }
  }

<<<<<<< HEAD
  public function cities_autocomplete(int $plan_tid, string $name_city) {
    $opts = array();
    if  ($plan_tid == 0 && $name_city == 'all') {
=======
  /**
   * Cities autocomplete.
   */
  public function citiesAutocomplete(int $plan_tid, string $name_city) {
    $opts = [];
    if ($plan_tid == 0 && $name_city == 'all') {
>>>>>>> main
      $connection = \Drupal::database();
      $sql = "SELECT tfd.tid, tfd.name
        FROM
          {taxonomy_term_field_data} AS tfd
        WHERE
          tfd.vid = 'ubication' and
          tfd.status = 1
        ORDER BY tfd.name";
      $query = $connection->query($sql);
      $result = $query->fetchAll();

      if (!empty($result)) {
<<<<<<< HEAD
        foreach ($result as $key => $value) {
          $opts[] = array(
            'label' => $value->name,
            'value' => $value->tid
          );
=======
        foreach ($result as $value) {
          $opts[] = [
            'label' => $value->name,
            'value' => $value->tid,
          ];
>>>>>>> main
        }
      }

      return new JsonResponse($opts);
    }

<<<<<<< HEAD

=======
>>>>>>> main
    if ($plan_tid && $name_city != 'none') {

      $connection = \Drupal::database();
      $sql = "SELECT tfd.tid, tfd.name
        FROM
          {taxonomy_term_field_data} AS tfd
          LEFT JOIN {node__field_ubication} AS nfu ON tfd.tid = nfu.field_ubication_target_id
          LEFT JOIN {node_field_data} AS nfd ON (
            nfu.entity_id = nfd.nid
            AND nfd.status = 1
          )
          LEFT JOIN {node__field_type_plan} AS nftp ON (
            nfu.entity_id = nftp.entity_id
            AND nftp.field_type_plan_target_id = $plan_tid
          )
        WHERE
          nfu.bundle = 'lender'
          AND tfd.name LIKE '" . \Drupal::database()->escapeLike($name_city) . "%'
        GROUP BY tfd.tid, tfd.name
        ORDER BY tfd.name";
      $query = $connection->query($sql);
      $result = $query->fetchAll();

      if (!empty($result)) {
<<<<<<< HEAD
        foreach ($result as $key => $value) {
          $opts[] = array(
            'label' => $value->name,
            'value' => $value->tid
          );
=======
        foreach ($result as $value) {
          $opts[] = [
            'label' => $value->name,
            'value' => $value->tid,
          ];
>>>>>>> main
        }
      }
    }
    return new JsonResponse($opts);
  }

<<<<<<< HEAD
  public function specialties_select($plan_tid, $city_tid, $term) {
    $opts = array();
=======
  /**
   * Specialties Select.
   */
  public function specialtiesSelect($plan_tid, $city_tid, $term) {
    $opts = [];
>>>>>>> main
    if (is_numeric($plan_tid) && is_numeric($city_tid) && $term != '') {
      $our_service = \Drupal::service('lib_rm.srm');
      $tipos = $our_service->getChildrensTipoPlan($plan_tid);
      $query = \Drupal::database()->select('node__field_speciality', 'nfs');
      $query->join('node__field_ubication', 'nfu', 'nfu.entity_id = nfs.entity_id');
      $query->join('node__field_type_plan', 'nftp', 'nftp.entity_id = nfu.entity_id');
      $query->join('node_field_data', 'nfd', 'nfd.nid = nfu.entity_id');
      $query->join('taxonomy_term_field_data', 'tfd', 'tfd.tid = nfs.field_speciality_target_id');
      $query->addField('tfd', 'tid');
      $query->addField('tfd', 'name');
      $query->condition('nfs.bundle', 'lender');
      $query->condition('nfd.status', 1);
      $query->condition('nftp.field_type_plan_target_id', $tipos, 'IN');
      $query->condition('nfu.field_ubication_target_id', $city_tid);
<<<<<<< HEAD
      $query->condition('tfd.name', \Drupal::database()->escapeLike($term) . "%" ,'LIKE' );
=======
      $query->condition('tfd.name', \Drupal::database()->escapeLike($term) . "%", 'LIKE');
>>>>>>> main
      $query->groupBy('tfd.tid, tfd.name');
      $query->orderBy('tfd.name');
      $result = $query->execute()->fetchAll();
      if (!empty($result)) {
<<<<<<< HEAD
        foreach ($result as $key => $value) {
          $opts[] = array(
            'label' => $value->name,
            'value' => $value->tid
          );
=======
        foreach ($result as $value) {
          $opts[] = [
            'label' => $value->name,
            'value' => $value->tid,
          ];
>>>>>>> main
        }
      }
    }
    return new JsonResponse($opts);
  }

<<<<<<< HEAD
  public function word_autocomplete(string $word, int $plan_tid, $city_tid, $specialty_tid) {
=======
  /**
   * Word autocomplete.
   */
  public function wordAutocomplete(string $word, int $plan_tid, $city_tid, $specialty_tid) {
>>>>>>> main
    $connection = \Drupal::database();
    $our_service = \Drupal::service('lib_rm.srm');
    $tipos = $our_service->getChildrensTipoPlan($plan_tid);
    if ($word != 'none' && is_numeric($plan_tid)) {
      $sql = "SELECT DISTINCT TRIM(nfd.title) AS label, nfd.nid AS value
      FROM
        {node_field_data} AS nfd
        LEFT JOIN {node__field_type_plan} AS nftp ON nftp.entity_id = nfd.nid";
<<<<<<< HEAD
      // Add city
      if (is_numeric($city_tid)) {
        $sql .= " LEFT JOIN {node__field_ubication} AS nfu ON nfd.nid = nfu.entity_id ";
      }
      // Add specilality
      if (is_numeric($specialty_tid)) {
        $sql .= " LEFT JOIN {node__field_speciality} AS nfs ON nfu.entity_id = nfs.entity_id ";
      }
      // Conditions
=======
      // Add city.
      if (is_numeric($city_tid)) {
        $sql .= " LEFT JOIN {node__field_ubication} AS nfu ON nfd.nid = nfu.entity_id ";
      }
      // Add specilality.
      if (is_numeric($specialty_tid)) {
        $sql .= " LEFT JOIN {node__field_speciality} AS nfs ON nfu.entity_id = nfs.entity_id ";
      }
      // Conditions.
>>>>>>> main
      $sql .= " WHERE
        nfd.type = 'lender'
        AND nfd.status = 1
        AND nftp.field_type_plan_target_id in ( " . implode(',', $tipos) . " )
        AND nfd.title LIKE '%" . \Drupal::database()->escapeLike($word) . "%'";
<<<<<<< HEAD
      // Add city condition
      if (is_numeric($city_tid)) {
        $sql .= " AND nfu.field_ubication_target_id = $city_tid ";
      }
      // Add speciality condition
      if (is_numeric($specialty_tid)) {
        $sql .= " AND nfs.field_speciality_target_id = $specialty_tid ";
      }
      // Order an limit
=======
      // Add city condition.
      if (is_numeric($city_tid)) {
        $sql .= " AND nfu.field_ubication_target_id = $city_tid ";
      }
      // Add speciality condition.
      if (is_numeric($specialty_tid)) {
        $sql .= " AND nfs.field_speciality_target_id = $specialty_tid ";
      }
      // Order an limit.
>>>>>>> main
      $sql .= " ORDER BY TRIM(nfd.title)
      LIMIT 10";
      $query = $connection->query($sql);
      $result = $query->fetchAll();
      return new JsonResponse($result);
    }
  }
<<<<<<< HEAD
=======

>>>>>>> main
}
