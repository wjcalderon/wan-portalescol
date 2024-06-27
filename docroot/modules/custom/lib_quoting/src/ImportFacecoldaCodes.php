<?php

namespace Drupal\lib_quoting;

use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

/**
 * Import facecolda codes.
 */
class ImportFacecoldaCodes {

  /**
   * Add import content item.
   */
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

      default:
        break;
    }
    $context['message'] = $message;
    $context['results'][] = $item;
  }

  /**
   * Add import conteent item callback.
   */
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
 * Verifica si el elemento proporcionado está vacío o si las claves.
 *
 * @param array $item
 *   El elemento a verificar.
 */
function is_empty_item($item) {
  return empty($item) || !trim($item['F']) || !trim($item['J']) || !trim($item['B']);
}

/**
 * Procesa la marca, reemplazando espacios en blanco por guiones.
 *
 * @param string $brand
 *   La marca a procesar.
 */
function process_brand($brand) {
  return str_replace(" ", "-", $brand);
}

/**
 * Genera el nombre del vehículo combinando marca, línea y código Facecolda.
 *
 * @param string $brand
 *   La marca del vehículo.
 * @param string $line
 *   La línea del vehículo.
 * @param string $code_facecolda
 *   El código Facecolda del vehículo.
 */
function generate_vehicle_name($brand, $line, $code_facecolda) {
  return $brand . '|' . $line . '|' . $code_facecolda;
}

/**
 * Obtiene el ID de término de referencia adicional según nombre proporcionado.
 *
 * @param array $item
 *   El elemento que contiene el nombre de referencia adicional.
 */
function get_tid_ref2($item) {
  return !empty($item['K']) ? get_tid_by_name(trim($item['K']), 'referencia_adicional') : NULL;
}

/**
 * Obtiene el ID de término de tipo de vehículo según el nombre proporcionado.
 *
 * @param array $item
 *   El elemento que contiene el nombre del tipo de vehículo.
 */
function get_tid_type_vehicle($item) {
  return !empty($item['G']) ? get_tid_by_name(trim($item['G']), 'tipo_vehiculo') : NULL;
}

/**
 * Genera un array con los valores necesarios para crear un nodo.
 *
 * @param string $name_vehicle
 *   El nombre del vehículo.
 * @param string $code_facecolda
 *   El código Facecolda del vehículo.
 * @param int|null $tid_type_vehicle
 *   El ID de término de tipo de vehículo.
 * @param int|null $tid_brand_line
 *   El ID de término de marca y línea.
 * @param int|null $tid_ref2
 *   El ID de término de referencia adicional.
 * @param array $vars
 *   Un array con variables adicionales.
 */
function generate_node_values($name_vehicle, $code_facecolda, $tid_type_vehicle, $tid_brand_line, $tid_ref2, $vars) {
  $values = [
    'nid' => NULL,
    'type' => 'vehiculo',
    'title' => $name_vehicle,
    'uid' => 1,
    'status' => TRUE,
    'field_codigo' => $code_facecolda,
    'field_tipo_vehiculo' => $tid_type_vehicle ? ['target_id' => $tid_type_vehicle] : [],
    'field_marca_linea' => $tid_brand_line ? ['target_id' => $tid_brand_line] : [],
    'field_ref2' => $tid_ref2 ? ['target_id' => $tid_ref2] : [],
  ];

  foreach ($vars as $name_var => $letter) {
    if ($name_var == 'air_conditioner') {
      $values["field_$name_var"] = !empty($item[$letter]) && $item[$letter] == 'CON';
    }
    elseif (!empty($item[$letter])) {
      $values["field_$name_var"] = trim($item[$letter]);
    }
  }

  return $values;
}

/**
 * Crea un nodo de Facecolda si no existe un vehículo con el mismo  Facecolda.
 *
 * @param array $item
 *   Los datos del vehículo.
 */
function create_code_facecolda($item) {
  if (is_empty_item($item)) {
    return;
  }

  $code_facecolda = trim($item['B']);
  $nid_vehicle = get_nid_by_code_facecolda($code_facecolda, 'vehiculo');

  if ($nid_vehicle) {
    return;
  }

  $brand = process_brand(trim($item['F']));
  $name_vehicle = generate_vehicle_name($brand, trim($item['J']), $code_facecolda);
  $tid_brand_line = get_tid_by_name($brand . '|' . trim($item['J']), 'marca_linea');
  $tid_ref2 = get_tid_ref2($item);
  $tid_type_vehicle = get_tid_type_vehicle($item);

  $vars = [
    'grouper_system' => 'E',
    'weigthkg' => 'M',
  ];

  $values = generate_node_values($name_vehicle, $code_facecolda, $tid_type_vehicle, $tid_brand_line, $tid_ref2, $vars);

  $codFacecolda = Node::create($values);
  $codFacecolda->save();
}

/**
 * Add node in data base.
 */
function create_code_facecolda_price($item) {
  if (!empty($item)) {
    $bool_brand = !empty(trim($item['F']));
    $bool_line = !empty(trim($item['J']));
    $bool_code = !empty(trim($item['B']));
    if ($bool_brand && $bool_line && $bool_code) {
      $code_facecolda = trim($item['B']);
      $nid_vehicle = get_nid_by_code_facecolda($code_facecolda, 'vehiculo');
      if ($nid_vehicle) {
        $brand = trim($item['F']);
        $name_vehicle = $brand . '|' . trim($item['J']) . '|' . $code_facecolda;
        $letters = ['P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA',
          'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM',
          'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ',
          'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI',
        ];

        $columns = [];
        $num = 1975;
        foreach ($letters as $letter) {
          $columns[$letter] = $num;
          $num++;
        }

        $models = [];
        foreach ($columns as $letter => $year) {
          if (!empty($item[$letter])) {
            $models[$year] = $item[$letter];
          }
        }

        if (!empty($models)) {
          foreach ($models as $year => $price) {
            $tid_model = get_tid_by_name($year, 'modelo');
            if ($tid_model) {
              $real_price = $price * 1000;
              $name_price_vehicle = 'Precio-' . $name_vehicle . '|' . $year;
              $label_autocomplete = $year . ' ' . $code_facecolda . ' ' . $brand;
              $label_autocomplete .= ' ' . trim($item['J']) . ' ' . trim($item['K']);
              $nid_price_vehicle = get_nid_by_title($name_price_vehicle, 'precio_vehiculo');
              if (!$nid_price_vehicle) {
                $values = [
                  'nid' => NULL,
                  'type' => 'precio_vehiculo',
                  'title' => $name_price_vehicle,
                  'uid' => 1,
                  'status' => TRUE,
                  'field_vehiculo' => [
                    'target_id' => $nid_vehicle,
                  ],
                  'field_modelo' => [
                    'target_id' => $tid_model,
                  ],
                  'field_label_autocomplete' => $label_autocomplete,
                  'field_precio' => $real_price,
                ];
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
 * Add node in database based on the provided item and vocabulary ID.
 *
 * @param array $item
 *   The data item.
 * @param string $vid
 *   The vocabulary ID.
 */
function create_taxonomy($item, $vid) {
  if (empty($vid) || empty($item)) {
    return;
  }

  switch ($vid) {
    case 'marca_linea':
      handle_marca_linea($item);
      break;

    case 'referencia_adicional':
      handle_referencia_adicional($item);
      break;

    default:
      break;
  }
}

/**
 * Handle processing for 'marca_linea' vocabulary.
 *
 * @param array $item
 *   The data item.
 */
function handle_marca_linea($item) {
  if (empty($item['F']) || empty($item['J'])) {
    return;
  }

  $brand = str_replace(" ", "-", trim($item['F']));
  $line = trim($item['J']);
  $name_brand_line = $brand . '|' . $line;

  $tid_brand_line = get_tid_by_name($name_brand_line, 'marca_linea');
  if (!$tid_brand_line) {
    create_term('marca_linea', $name_brand_line, $brand, $line);
  }
}

/**
 * Handle processing for 'referencia_adicional' vocabulary.
 *
 * @param array $item
 *   The data item.
 */
function handle_referencia_adicional($item) {
  if (empty($item['F']) || empty($item['J']) || empty($item['K'])) {
    return;
  }

  $brand = str_replace(" ", "-", trim($item['F']));
  $line = trim($item['J']);
  $name_brand_line = $brand . '|' . $line;

  $tid_brand_line = get_tid_by_name($name_brand_line, 'marca_linea');
  if ($tid_brand_line) {
    $name_ref2 = trim($item['K']);
    $tid_ref2 = get_tid_by_name($name_ref2, 'referencia_adicional');
    if (!$tid_ref2) {
      create_term('referencia_adicional', $name_ref2, $brand, $line, $tid_brand_line);
    }
  }
}

/**
 * Create and save a term with the provided data.
 *
 * @param string $vid
 *   The vocabulary ID.
 * @param string $name
 *   The term name.
 * @param string $brand
 *   The brand information.
 * @param string $line
 *   The line information.
 * @param int|null $tid_brand_line
 *   The parent term ID (if applicable).
 */
function create_term($vid, $name, $brand, $line, $tid_brand_line = NULL) {
  $term_data = [
    'name' => $name,
    'vid' => $vid,
    'field_marca' => $brand,
    'field_ref1' => $line,
  ];

  if ($tid_brand_line) {
    $term_data['field_marca_linea'] = ['target_id' => $tid_brand_line];
  }

  Term::create($term_data)->save();
}

/**
 * Get tid a toxonomy by name.
 */
function get_tid_by_name($name, $type) {
  $connection = \Drupal::database();
  $query = $connection->query("SELECT t.tid  FROM {taxonomy_term_field_data} t where name = :name and vid = :vid", [
    ':name' => $name,
    ':vid' => $type,
  ]
  );
  $result = $query->fetchAll();
  foreach ($result as $row) {
    return $row->tid;
  }
  return 0;
}

/**
 * Get nid a node by code_facecolda.
 */
function get_nid_by_code_facecolda($code_facecolda, $bundle) {
  $connection = \Drupal::database();
  $query = $connection->query("SELECT n.entity_id  FROM {node__field_codigo} n where field_codigo_value = :code_facecolda and bundle= :bundle", [
    ':code_facecolda' => $code_facecolda,
    ':bundle' => $bundle,
  ]
  );
  $result = $query->fetchAll();
  foreach ($result as $row) {
    return $row->entity_id;
  }
  return 0;
}

/**
 * Get nid a node by title.
 */
function get_nid_by_title($title, $type) {
  $connection = \Drupal::database();
  $query = $connection->query("SELECT n.nid  FROM {node_field_data} n where title = :title and type = :type", [
    ':title' => $title,
    ':type' => $type,
  ]
  );
  $result = $query->fetchAll();
  foreach ($result as $row) {
    return $row->nid;
  }
  return 0;
}
