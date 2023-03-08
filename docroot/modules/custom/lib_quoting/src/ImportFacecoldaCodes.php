<?php

namespace Drupal\lib_quoting;

use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;


class ImportFacecoldaCodes {
  public static function addImportContentItem($item, &$context) {
    $context['sandbox']['current_item'] = $item;
    switch ($item['typeLoad']) {
      case 'brand_line':
        $message = 'Creating ' . trim($item['F']) . '|' . trim($item['J']);
        create_taxonomy($item, 'marca_linea');
        break;
      case 'ref2':
        $message = 'Creating ' . trim($item['K']);
        create_taxonomy($item, 'referencia_adicional');
        break;
      case 'code_facecolda':
        $message = 'Creating ' . $item['B'];
        create_code_facecolda($item);
        break;
      case 'code_facecolda_price':
        $message = 'Creating ' . $item['B'];
        create_code_facecolda_price($item);
        break;
    }
    $results = array();
    $context['message'] = $message;
    $context['results'][] = $item;
  }

  public static function addImportContentItemCallback($success, $results, $operations) {
    if ($success) {
      $message = \Drupal::translation()->formatPlural(
        count($results),
        'One item processed.', '@count items processed.'
      );
    } 
    else {
      $message = t('Finished with an error.');
    }
    drupal_set_message($message);
  }
}


/**
* add node in data base.
*
* @param $item array.
*
*/
function create_code_facecolda($item) {
  if (!empty($item)) {
    $bool_brand = !empty(trim($item['F']));
    $bool_line = !empty(trim($item['J']));
    $bool_code = !empty(trim($item['B']));
    if ($bool_brand && $bool_line && $bool_code) {
      $code_facecolda = trim($item['B']);
      $nid_vehicle = getNidByCodeFacecolda($code_facecolda, 'vehiculo');
      if (!$nid_vehicle) {
        $brand = str_replace(" ", "-", trim($item['F']));
        $name_vehicle = $brand . '|' . trim($item['J']) . '|' . $code_facecolda;

        $name_brand_line = $brand . '|' . trim($item['J']);
        $tid_brand_line = getTidByName($name_brand_line, 'marca_linea');

        $tid_ref2 = NULL;
        if (!empty($item['K'])) {
          $name_ref2 = trim($item['K']);
          $tid_ref2 = getTidByName($name_ref2, 'referencia_adicional');
        }

        $tid_type_vehicle = NULL;
        if (!empty($item['G'])) {
          $name_type_vehicle = trim($item['G']);
          $tid_type_vehicle = getTidByName($name_type_vehicle, 'tipo_vehiculo');
        }

        $vars = array(
          'grouper_system' => 'E',
          'weigthkg' => 'M',
          'id_service' => 'N',
          'service' => 'O',
          'bcpp' => 'BJ',
          'imported' => 'BK',
          'power' => 'BL',
          'box_type' => 'BM',
          'displacement' => 'BN',
          'nationality' => 'BO',
          'passengers_capacity' => 'BP',
          'kg_capacity' => 'BQ',
          'doors' => 'BR',
          'air_conditioner' => 'BS',
          'ejes' => 'BT',
          'fuel' => 'BV',
          'transmition' => 'BW',
          'um' => 'BX',
          'weigth_cat' => 'BY'
        );
        foreach ($vars as $name_var => $letter) {
          if ($name_var == 'air_conditioner') {
            ${"$name_var"} = FALSE;
            if (!empty($item[$letter]) && $item[$letter] == 'CON') {
              $air_conditioner = TRUE;
            }
          }
          elseif (!empty($item[$letter])) {
            ${"$name_var"} = trim($item[$letter]);
          }
        }

        $values = array(
          'nid' => NULL,
          'type' => 'vehiculo',
          'title' => $name_vehicle,
          'uid' => 1,
          'status' => TRUE,
          'field_codigo' => trim($item['B']),
          'field_tipo_vehiculo' => $tid_type_vehicle ? array(
            'target_id' => $tid_type_vehicle
          ) : array(),
          'field_marca_linea' => $tid_brand_line ? array(
            'target_id' => $tid_brand_line
          ) : array(),
          'field_ref2' => $tid_ref2 ? array(
            'target_id' => $tid_ref2
          ) : array(),
          'field_agrupador_sistema' => $grouper_system,
          'field_peso_kg' => $weigthkg,
          'field_id_servicio' => $id_service,
          'field_servicio' => $service,
          'field_bcpp' => $bcpp,
          'field_importado' => $imported,
          'field_potencia' => $power,
          'field_tipo_de_caja' => $box_type,
          'field_cilindraje' => $displacement,
          'field_nacionalidad' => $nationality,
          'field_capacidad_pasajeros' => $passengers_capacity,
          'field_capacidad_kg' => $kg_capacity,
          'field_puertas' => $doors,
          'field_aire_acondicionado' => $air_conditioner,
          'field_ejes' => $ejes,
          'field_combustible' => $fuel,
          'field_transmision' => $transmition,
          'field_um' => $um,
          'field_peso_categoria' => $weigth_cat
        );
        $codFacecolda = Node::create($values);
        $codFacecolda->save();

      }
    }
  }
}


/**
* add node in data base.
*
* @param $item array.
*
*/
function create_code_facecolda_price($item) {
  if (!empty($item)) {
    $bool_brand = !empty(trim($item['F']));
    $bool_line = !empty(trim($item['J']));
    $bool_code = !empty(trim($item['B']));
    if ($bool_brand && $bool_line && $bool_code) {
      $code_facecolda = trim($item['B']);
      $nid_vehicle = getNidByCodeFacecolda($code_facecolda, 'vehiculo');
      if ($nid_vehicle) {
        $brand = trim($item['F']);
        $name_vehicle = $brand . '|' . trim($item['J']) . '|' . $code_facecolda;
        $letters = array('P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA',
          'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM',
          'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ',
          'BA', 'BB', 'BC', 'BD','BE','BF', 'BG', 'BH', 'BI' 
        );

        $columns = array();
        $num = 1975;
        foreach ($letters as $key => $letter) {
          $columns[$letter] = $num;
          $num++;
        }

        $models = array();
        foreach ($columns as $letter => $year) {
          if (!empty($item[$letter])) {
            $models[$year] = $item[$letter];
          }
        }

        if (!empty($models)) {
          foreach ($models as $year => $price) {
            $tid_model = getTidByName($year, 'modelo');
            if ($tid_model) {
              $real_price = $price * 1000;
              $name_price_vehicle = 'Precio-' . $name_vehicle . '|' . $year;
              $label_autocomplete = $year . ' ' . $code_facecolda . ' ' . $brand;
              $label_autocomplete .= ' ' . trim($item['J']) . ' ' . trim($item['K']);  
              $nid_price_vehicle = getNidByTitle($name_price_vehicle, 'precio_vehiculo');
              if (!$nid_price_vehicle) {
                $values = array(
                  'nid' => NULL,
                  'type' => 'precio_vehiculo',
                  'title' => $name_price_vehicle,
                  'uid' => 1,
                  'status' => TRUE,
                  'field_vehiculo' => array(
                    'target_id' => $nid_vehicle
                  ),
                  'field_modelo' => array(
                    'target_id' => $tid_model
                  ),
                  'field_label_autocomplete' => $label_autocomplete,
                  'field_precio' => $real_price
                );
                $codPriceVehicle = Node::create($values);
                $codPriceVehicle->save();
              }
            }
          }
        }
      }
    }
  }
}


/**
* add node in data base.
*
* @param $item array.
*
*/
function create_taxonomy($item, $vid) {
  if (!empty($vid) && !empty($item)) {
    switch ($vid) {
      case 'marca_linea':
      case 'referencia_adicional':
        if (!empty($item['F']) && !empty($item['J'])) {
          $brand = str_replace(" ", "-", trim($item['F']));
          $line = trim($item['J']);
          $name_brand_line = $brand . '|' . $line;
          if ($vid == 'marca_linea') {
            $tid_brand_line = getTidByName($name_brand_line, $vid);
            if (!$tid_brand_line) {
              $term = Term::create([
                'name' => $name_brand_line,
                'field_marca' => $brand,
                'field_ref1' => $line,
                'vid' => $vid,
              ])->save();
            }
          }
          else {
            if (!empty($item['K'])) {
              $name_ref2 = trim($item['K']);
              $tid_ref2 = getTidByName($name_ref2, $vid);
              $tid_brand_line = getTidByName($name_brand_line, 'marca_linea');
              if (!$tid_ref2 && $tid_brand_line) {
                $term = Term::create([
                  'name' => $name_ref2, 
                  'vid' => $vid,
                  'field_marca_linea' => array(
                    'target_id' => $tid_brand_line
                  )
                ])->save();
              }
            }
          }

        }
        break;
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
function getTidByName($name, $type) {
  $connection = \Drupal::database();
  $query = $connection->query("SELECT t.tid  FROM {taxonomy_term_field_data} t where name = :name and vid = :vid", [':name' => $name, ':vid' => $type]);
  $result = $query->fetchAll();
  foreach ($result as $row) {
    return $row->tid;
  }
  return 0;
}


/**
* get nid a node by code_facecolda.
*
* @param $code_facecolda string.
* @param $bundle string.
* @return integer The unique ID of node or 0 if not exist.
*
*/
function getNidByCodeFacecolda($code_facecolda, $bundle) {
  $connection = \Drupal::database();
  $query = $connection->query("SELECT n.entity_id  FROM {node__field_codigo} n where field_codigo_value = :code_facecolda and bundle= :bundle", [':code_facecolda' => $code_facecolda, ':bundle' => $bundle]);
  $result = $query->fetchAll();
  foreach ($result as $row) {
    return $row->entity_id;
  }
  return 0;
}


/**
* get nid a node by title.
*
* @param $title string.
* @param $type string.
* @return integer The unique ID of node or 0 if not exist.
*
*/
function getNidByTitle($title, $type) {
  $connection = \Drupal::database();
  $query = $connection->query("SELECT n.nid  FROM {node_field_data} n where title = :title and type = :type", [':title' => $title, ':type' => $type]);
  $result = $query->fetchAll();
  foreach ($result as $row) {
    return $row->nid;
  }
  return 0;
}