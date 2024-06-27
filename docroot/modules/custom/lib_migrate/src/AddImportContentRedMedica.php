<?php

namespace Drupal\lib_migrate;

use Drupal\lib_migrate\Controller\GetLatLong;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

/**
 * Add import content.
 */
class AddImportContentRedMedica {

  /**
   * Add import content item .
   */
  public static function addImportContentItem($item, &$context) {
    $context['sandbox']['current_item'] = $item;
    $message = 'Creating ' . $item['D'];
    create_node($item);
    $context['message'] = $message;
    $context['results'][] = $item;
  }

  /**
   * Remove import content item .
   */
  public static function removeImportContentItem($item, &$context) {
    $result = \Drupal::entityQuery('node')
      ->range(0, 1000)
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

  /**
   * Add import content item callback.
   */
  public static function addImportContentItemCallback($success, $results, $operations) {
    if ($success) {
      $message = \Drupal::translation()->formatPlural(
        count($results),
        'One item processed.', '@count items processed.'
      );
      unset($_SESSION['time_log_latlng']);
      unset($_SESSION['date_log_latlng']);
      \Drupal::messenger()->addStatus($message);
    } else {
      $message = t('Finished with an error.');
      \Drupal::messenger()->addError($message);
    }
  }

}

/**
 * Add node in data base.
 */
function create_node($item) {
  $conditions = [
    'S' => 40,
    'T' => 42,
    'U' => 41,
    'V' => 663,
  ];

  $field_type_plan = [];
  $plan_type = [];

  foreach ($conditions as $key => $value) {
    if ($item[$key] == 1) {
      $field_type_plan[] = ['target_id' => $value];
      $plan_type[] = $value;
    }
  }

  $telefonos = [];

  add_phone_number($telefonos, $item['N'], $item['O']);
  if ($item['P']) {
    add_phone_number($telefonos, $item['P'], $item['Q']);
  }

  $especialidades = [];
  if (!empty($item['C']) && !is_null($item['C'])) {
    $tid = get_tid_by_name($item['C'], 'speciality');
    if ($tid == 0) {
      $new_term = Term::create([
        'vid' => 'speciality',
        'name' => $item['C'],
      ]);
      $new_term->enforceIsNew();
      $new_term->save();
      $tid = $new_term->id();
      if (!empty($tid) && $tid > 0) {
        $especialidades[] = ['target_id' => $tid];
      }
    } else {
      $especialidades[] = ['target_id' => $tid];
    }
  }

  $tipoproveedor = [];
  if (!empty($item['B']) && !is_null($item['B'])) {
    $tid = get_tid_by_name($item['B'], 'provider_type');
    if ($tid == 0) {
      $new_term = Term::create([
        'vid' => 'provider_type',
        'name' => $item['B'],
      ]);
      $new_term->enforceIsNew();
      $new_term->save();
      $tid = $new_term->id();
      if (!empty($tid) && $tid > 0) {
        $tipoproveedor[] = ['target_id' => $tid];
      }
    } else {
      $tipoproveedor[] = ['target_id' => $tid];
    }
  }

  $ubiciacion = [];
  if (!empty($item['E']) && !is_null($item['E'])) {
    if ($item['E'] == 'COLOMBIA') {
      $tid = 31;
      $ubiciacion[] = ['target_id' => $tid];
    } else {
      $tid = get_tid_by_name($item['E'], 'ubication');
      if ($tid == 0) {
        $new_term = Term::create([
          'vid' => 'ubication',
          'name' => $item['E'],
        ]);
        $new_term->enforceIsNew();
        $new_term->save();
        $tid = $new_term->id();
        if (!empty($tid) && $tid > 0) {
          $ubiciacion[] = ['target_id' => $tid];
        }
      } else {
        $ubiciacion[] = ['target_id' => $tid];
      }
    }
    $pais = $tid;
  }

  if (!empty($item['F']) && !is_null($item['F'])) {
    $tid = get_tid_by_name($item['F'], 'ubication');
    if ($tid == 0) {
      $new_term = Term::create([
        'vid' => 'ubication',
        'name' => $item['F'],
        'parent' => ['target_id' => $pais],
      ]);
      $new_term->enforceIsNew();
      $new_term->save();
      $tid = $new_term->id();
      if (!empty($tid) && $tid > 0) {
        $ubiciacion[] = ['target_id' => $tid];
      }
    } else {
      $ubiciacion[] = ['target_id' => $tid];
    }
    $departemento = $tid;
  }

  if (!empty($item['G']) && !is_null($item['G'])) {
    $tid = get_tid_by_name($item['G'], 'ubication');
    if ($tid == 0) {
      $new_term = Term::create([
        'vid' => 'ubication',
        'name' => $item['G'],
        'parent' => ['target_id' => $departemento],
      ]);
      $new_term->enforceIsNew();
      $new_term->save();
      $tid = $new_term->id();
      if (!empty($tid) && $tid > 0) {
        $ubiciacion[] = ['target_id' => $tid];
      }
    } else {
      $ubiciacion[] = ['target_id' => $tid];
    }
    $ciudad = $tid;
  }

  $node = NULL;
  $search = ["'", "\""];
  $nombre = str_replace($search, "", $item['D']);
  $address = $item['K'];
  $connection = \Drupal::database();
  if (empty($plan_type)) {
    $query = $connection
      ->query("SELECT n.nid FROM {node_field_data} n
        inner join node__field_type_plan p on p.entity_id = n.nid
        inner join node__field_google_maps_address a on a.entity_id = n.nid
        where n.title = '" . $nombre . "' and
        n.type ='lender' and
        a.field_google_maps_address_value = '" . $address . "' and
        p.field_type_plan_target_id in (" . implode(',', $plan_type) . ")");
  } else {
    $query = $connection->query("SELECT n.nid FROM {node_field_data} n where n.title = '" . $nombre . "'");
  }
  $result = $query->fetchAll();
  foreach ($result as $row) {
    $node = Node::load($row->nid);
  }

  if (is_null($node)) {
    $lenderCategory = NULL;
    if ($item['AB'] == 'Institución') {
      $lenderCategory = 1;
    }
    elseif ($item['AB'] == 'Especialista') {
      $lenderCategory = 2;
    }

    $values = [
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
      'field_ubication' => ['target_id' => $ciudad],
      'field_whatsapp' => $item['Z'],
      'field_lender_category' => $lenderCategory,
      'field_telemedicine' => ($item['AA'] == 'SI' ? 1 : 0),
    ];

    // Latitude - longitude.
    $values['field_location_map'] = execute_process_lat_lng([
      'type_process' => 'new',
      'new_lat' => $item['L'],
      'new_lng' => $item['M'],
      'new_google_add' => $item['K'],
      'cc' => $item['W'],
    ]);

    $prestador = Node::create($values);
    $prestador->save();
  } else {
    $flag_graba = true;

    $especialiades_new = $node->field_speciality->getValue();
    foreach ($especialidades as $value) {
      if (!in_array($value, $especialiades_new)) {
        $flag_graba = true;
        $especialiades_new[] = $value;
      }
    }

    $tipoproveedor_new = $node->field_provider_type->getValue();
    foreach ($tipoproveedor as $value) {
      if (!in_array($value, $tipoproveedor_new)) {
        $flag_graba = true;
        $tipoproveedor_new[] = $value;
      }
    }

    $tipoplan_new = $node->field_type_plan->getValue();
    foreach ($field_type_plan as $value) {
      if (!in_array($value, $tipoplan_new)) {
        $flag_graba = true;
        $tipoplan_new[] = $value;
      }
    }

    $ubicaciones = $node->field_ubication->getValue();
    if (!in_array(['target_id' => $ciudad], $ubicaciones)) {
      $flag_graba = true;
      $ubicaciones[] = ['target_id' => $ciudad];
    }

    // Latitude - longitude.
    $fld_location_map = execute_process_lat_lng([
      'type_process' => 'update',
      'old_node' => $node,
      'new_google_add' => $item['K'],
      'cc' => $item['W'],
    ]);

    if ($flag_graba) {
      $node->set('field_speciality', $especialiades_new);
      $node->set('field_provider_type', $tipoproveedor_new);
      $node->set('field_type_plan', $tipoplan_new);
      $node->set('field_ubication', $ubicaciones);
      $node->set('field_location_map', $fld_location_map);
      $node->set('field_phone', $telefonos);
      $node->save();
    }
  }

}

/**
 * Get tid a toxonomy by name.
 */
function get_tid_by_name($name, $type) {
  $connection = \Drupal::database();
  $query = $connection->query("SELECT t.tid  FROM {taxonomy_term_field_data} t where name = '" . $name . "' and vid = '" . $type . "'");
  $result = $query->fetchAll();
  foreach ($result as $row) {
    return $row->tid;
  }
  return 0;
}

/**
 * Execute process lat lng.
 */
function execute_process_lat_lng($prmts) {
  extract($prmts);

  switch ($type_process) {
    case 'new':
      if (!empty($new_lat) && !empty($new_lng)) {
        $lat = $new_lat;
        $lng = $new_lng;
      }
      elseif (!empty($new_google_add)) {
        $resp = execute_ws_to_get_lat_lng($new_google_add, $cc);
        if (!empty($resp['lat']) && !empty($resp['long'])) {
          $lat = $resp['lat'];
          $lng = $resp['long'];
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

    default:
      break;
  }

  if (!empty($lat) && !empty($lng)) {
    return [
      'lat' => $lat,
      'lng' => $lng,
    ];
  }
}

/**
 * Execute ws to get lat lng.
 */
function execute_ws_to_get_lat_lng($address, $cc) {
  $getLatLong = new GetLatLong();
  $resp = $getLatLong->getLatLongByAddress($address, $cc);
  if (!empty($resp['lat']) && !empty($resp['long'])) {
    return [
      'lat' => $resp['lat'],
      'long' => $resp['long'],
    ];
  }
}

/**
 * Add Phone Number.
 */
function add_phone_number(&$telefonos, $number, $extension = NULL) {
  $clean_number = trim($number);
  if (!empty($clean_number) && !is_null($clean_number)) {
    $phoneNumber = ['value' => $number];
    if ($extension !== NULL) {
      $phoneNumber['value'] .= ' ext ' . $extension;
    }
    $telefonos[] = $phoneNumber;
  }
}
