<?php

namespace Drupal\lib_migrate;

use Drupal\node\Entity\Node;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
use Drupal\lib_migrate\Controller\GetLatLong;


class addImportContent {
  public static function addImportContentItem($item, &$context) {
    $context['sandbox']['current_item'] = $item;
    $message = 'Creating ' . $item['D'];
    $results = array();
    create_node($item);
    $context['message'] = $message;
    $context['results'][] = $item;
  }

  public static function removeImportContentItem($item, &$context){

    $result = \Drupal::entityQuery('node')
          ->range(0,1000)
          ->condition('type', 'lender')
          ->execute();
    $context['sandbox']['current_item'] = $item;
    $message = 'Deleting node ';
    $context['message'] = $message;
    $context['results'][] = $item;
    $storage_handler = \Drupal::entityTypeManager()->getStorage('node');
    $entities = $storage_handler->loadMultiple($result);
    $storage_handler->delete($entities);
  }

  public static function addImportContentItemCallback($success, $results, $operations) {

    if ($success) {
      $message = \Drupal::translation()->formatPlural(
        count($results),
        'One item processed.', '@count items processed.'
      );
      unset($_SESSION['time_log_latlng']);
      unset($_SESSION['date_log_latlng']);
      \Drupal::messenger()->addStatus($message);
    }
    else {
      $message = t('Finished with an error.');
      \Drupal::messenger()->addError($message);
    }
  }
}

/**
* add node in data base.
*
* @param $item array.
*
*/
function create_node($item) {
  $plan_type = [];
  $field_type_plan = array();
  if ($item['S'] == 1 ) {
    $field_type_plan[] = array('target_id' => 40);
    $plan_type[] = 40;
  }
  if ($item['T'] == 1 ) {
    $field_type_plan[] = array('target_id' => 42);
    $plan_type[] = 42;
  }
  if ($item['U'] == 1 ) {
    $field_type_plan[] = array('target_id' => 41);
    $plan_type[] = 41;
  }
  if ($item['V'] == 1 ) {
    $field_type_plan[] = array('target_id' => 663);
    $plan_type[] = 663;
  }

  $telefonos = array();
  if (!empty(trim($item['N'])) && !is_null(trim($item['N']))) {
    $telefonos[0] = array('value' => $item['N']);
  }
  if (!empty(trim($item['O'])) && !is_null(trim($item['O']))) {
    $telefonos[0]['value'] .= ' ext ' . $item['O'];
  }

  if (!empty(trim($item['P'])) && !is_null(trim($item['P']))) {
    $telefonos[1] = array('value' => $item['P']);
  }
  if (!empty(trim($item['Q'])) && !is_null(trim($item['Q']))) {
    $telefonos[1]['value'] .= ' ext ' . $item['Q'];
  }


  $especialidades = array();
  if (!empty($item['C']) && !is_null($item['C'])) {
    $tid = getTidByName($item['C'],'speciality');
    if ($tid == 0) {
      $new_term = \Drupal\taxonomy\Entity\Term::create([
          'vid' => 'speciality',
          'name' => $item['C'],
      ]);
      $new_term->enforceIsNew();
      $new_term->save();
      $tid = $new_term->id();
      if (!empty($tid) && $tid > 0){
        $especialidades[] = array('target_id' => $tid);
      }

    }
    else {
      $especialidades[] = array('target_id' => $tid);
    }
  }

  $tipoproveedor = array();
  if (!empty($item['B']) && !is_null($item['B'])) {
    $tid = getTidByName($item['B'],'provider_type');
    if ($tid == 0) {
      $new_term = \Drupal\taxonomy\Entity\Term::create([
          'vid' => 'provider_type',
          'name' => $item['B'],
      ]);
      $new_term->enforceIsNew();
      $new_term->save();
      $tid = $new_term->id();
      if (!empty($tid) && $tid > 0){
        $tipoproveedor[] = array('target_id' => $tid);
      }

    }
    else {
      $tipoproveedor[] = array('target_id' => $tid);
    }
  }


  $ubiciacion = array();
  if (!empty($item['E']) && !is_null($item['E'])) {
    if ($item['E'] == 'COLOMBIA') {
      $tid = 31;
      $ubiciacion[] = array('target_id' => $tid);
    }
    else {
      $tid = getTidByName($item['E'],'ubication');
      if ($tid == 0) {
        $new_term = \Drupal\taxonomy\Entity\Term::create([
            'vid' => 'ubication',
            'name' => $item['E'],
        ]);
        $new_term->enforceIsNew();
        $new_term->save();
        $tid = $new_term->id();
        if (!empty($tid) && $tid > 0){
          $ubiciacion[] = array('target_id' => $tid);
        }

      }
      else {
        $ubiciacion[] = array('target_id' => $tid);
      }
    }
    $pais = $tid;
  }

  if (!empty($item['F']) && !is_null($item['F'])) {
    $tid = getTidByName($item['F'],'ubication');
    if ($tid == 0) {
      $new_term = \Drupal\taxonomy\Entity\Term::create([
          'vid' => 'ubication',
          'name' => $item['F'],
          'parent' => array('target_id' => $pais),
      ]);
      $new_term->enforceIsNew();
      $new_term->save();
      $tid = $new_term->id();
      if (!empty($tid) && $tid > 0) {
        $ubiciacion[] = array('target_id' => $tid);
      }

    }
    else {
      $ubiciacion[] = array('target_id' => $tid);
    }
    $departemento = $tid;
  }

  if (!empty($item['G']) && !is_null($item['G'])) {
    $tid = getTidByName($item['G'],'ubication');
    if ($tid == 0) {
      $new_term = \Drupal\taxonomy\Entity\Term::create([
          'vid' => 'ubication',
          'name' => $item['G'],
          'parent' => array('target_id' => $departemento),
      ]);
      $new_term->enforceIsNew();
      $new_term->save();
      $tid = $new_term->id();
      if (!empty($tid) && $tid > 0) {
        $ubiciacion[] = array('target_id' => $tid);
      }

    }
    else {
      $ubiciacion[] = array('target_id' => $tid);
    }
    $ciudad = $tid;
  }

  $node = NULL;
  $search = array("'","\"");
  $nombre = str_replace($search, "", $item['D']);
  $address = $item['K'];
  $connection = \Drupal::database();
  if (count($plan_type) > 0) {
    $query = $connection
                ->query("SELECT n.nid FROM {node_field_data} n
                      inner join node__field_type_plan p on p.entity_id = n.nid
                      inner join node__field_google_maps_address a on a.entity_id = n.nid
                      where n.title = '" . $nombre . "' and
                      n.type ='lender' and
                      a.field_google_maps_address_value = '" . $address ."' and
                      p.field_type_plan_target_id in (" . implode(',', $plan_type) .")");
  }
  else {
    $query = $connection->query("SELECT n.nid FROM {node_field_data} n where n.title = '" . $nombre . "'");
  }
  $result = $query->fetchAll();
  foreach ($result as $row) {
    $node = \Drupal\node\Entity\Node::load($row->nid);
  }

  if (is_null($node)) {
    $values = array(
      'nid' => NULL,
      'type' => 'lender',
      'title' => $nombre,
      'sticky' => $item['A'] == 1 ? 1 : 0,
      'uid' => 1,
      'status' => TRUE,
      'field_identification' => $item['W'],
      'field_schedules' => $item['Y'],
      'field_network_address' => $item['H'],
      'field_google_maps_address' => $item['K'],
      'field_phone' => $telefonos,
      'field_type_plan' => $field_type_plan,
      'field_consulting_room' => $item['I'],
      'field_dv' => $item['X'],
      'field_oficina' => $item['J'],
      'field_web_page' => $item['R'],
      'field_speciality' => $especialidades,
      'field_provider_type' => $tipoproveedor,
      'field_ubication' => array('target_id' => $ciudad),
      'field_whatsapp' => $item['Z'],
      'field_lender_category' => (
        $item['AB'] == 'Institución' ? 1 : (
          $item['AB'] == 'Especialista' ? 2 : null
        )
      ),
      'field_telemedicine' => ($item['AA'] == 'SI' ? 1 : 0)
    );

    // Latitude - longitude
    $values['field_location_map'] = execute_process_lat_lng(array(
      'type_process' => 'new',
      'new_lat' => $item['L'],
      'new_lng' => $item['M'],
      'new_google_add' => $item['K'],
      'cc' => $item['W'],
    ));


    $prestador = Node::create($values);
    $prestador->save();

  }
  else {

    $flag_graba = FALSE;
    $especialiades_new = $node->field_speciality->getValue();
    foreach ($especialidades as $value) {
      if (!in_array($value, $especialiades_new)) {
        $flag_graba = TRUE;
        $especialiades_new[] = $value;
      }
    }
    $tipoproveedor_new = $node->field_provider_type->getValue();
    foreach ($tipoproveedor as $value) {
      if (!in_array($value, $tipoproveedor_new)) {
        $flag_graba = TRUE;
        $tipoproveedor_new[] = $value;
      }
    }

    $tipoplan_new = $node->field_type_plan->getValue();
    foreach ($field_type_plan as $value) {
      if (!in_array($value, $tipoplan_new)) {
        $flag_graba = TRUE;
        $tipoplan_new[] = $value;
      }
    }

    $ubicaciones = $node->field_ubication->getValue();
    if (!in_array(['target_id' => $ciudad], $ubicaciones)) {
      $flag_graba = TRUE;
      $ubicaciones[] = ['target_id' => $ciudad];
    }


    // Latitude - longitude
    $fld_location_map = execute_process_lat_lng(array(
      'type_process' => 'update',
      'old_node' => $node,
      'new_google_add' => $item['K'],
      'cc' => $item['W'],
    ));


    if ($flag_graba) {
      $node->set('field_speciality',$especialiades_new);
      $node->set('field_provider_type',$tipoproveedor_new);
      $node->set('field_type_plan',$tipoplan_new);
      $node->set('field_ubication',$ubicaciones);
      $node->set('field_location_map', $fld_location_map);
      $node->save();
    }

  }

}

/**
* get tid a toxonomy by name.
*
* @param $name string.
* @param $type string.
* @return integer The unique ID of taxonomy or 0 if not exist.
*
*/
function getTidByName ($name,$type) {
  $connection = \Drupal::database();
  $query = $connection->query("SELECT t.tid  FROM {taxonomy_term_field_data} t where name = '" . $name . "' and vid = '" . $type . "'");
  $result = $query->fetchAll();
  foreach ($result as $row) {
    return $row->tid;
  }
  return 0;
}

/**
 * execute_process_lat_lng
 * @param  [type] $prmts [description]
 * @return [type]        [description]
 */
function execute_process_lat_lng($prmts) {
  extract($prmts);

  switch ($type_process) {
    case 'new':
      if (!empty($new_lat) && !empty($new_lng)) {
        $lat =  $new_lat;
        $lng =  $new_lng;
      }
      elseif (!empty($new_google_add)) {
        $resp = execute_ws_to_get_lat_lng($new_google_add, $cc);
        if (!empty($resp['lat']) && !empty($resp['long'])) {
          $lat =  $resp['lat'];
          $lng =  $resp['long'];
        }
      }
      break;

    case 'update':
      $bool_ws_lat_lng = FALSE;
      if (!empty($new_google_add)) {
        $bool_ws_lat_lng = TRUE;
        if (!empty($old_node->field_google_maps_address->getValue())) {
          $old_fld_google = $old_node->field_google_maps_address->getValue();
          $google_address = $old_fld_google[0]['value'];
          if ($google_address == $new_google_add) {
            $bool_ws_lat_lng = FALSE;
          }
        }
      }
      if (!empty($old_node->field_location_map->getValue())) {
        $lat = $old_node->field_location_map->getValue()[0]['lat'];
        $lng = $old_node->field_location_map->getValue()[0]['lng'];
      }
      if ($bool_ws_lat_lng) {
        $resp = execute_ws_to_get_lat_lng($new_google_add, $cc);
        if (!empty($resp['lat']) && !empty($resp['long'])) {
          $lat = $resp['lat'];
          $lng = $resp['long'];
        }
      }
      break;
  }

  if (!empty($lat) && !empty($lng)) {
    return array(
      'lat' => $lat,
      'lng' => $lng,
    );
  }
}


/**
 * execute_ws_to_get_lat_lng
 * @param  [type] $address [description]
 * @return [type]          [description]
 */
function execute_ws_to_get_lat_lng($address, $cc) {
  $GetLatLong = new GetLatLong();
  $resp = $GetLatLong->get_lat_long_by_address($address, $cc);
  if (!empty($resp['msg'])) {
    die('------------ ' . $resp['msg'] . ' ------------');
  }
  elseif (!empty($resp['lat']) && !empty($resp['long'])) {
    return [
      'lat' => $resp['lat'],
      'long' => $resp['long']
    ];
  }
}
