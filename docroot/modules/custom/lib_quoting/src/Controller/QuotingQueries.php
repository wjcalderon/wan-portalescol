<?php

namespace Drupal\lib_quoting\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
<<<<<<< HEAD
 * Controller with queries of vehicles quoting
=======
 * Controller with queries of vehicles quoting.
>>>>>>> main
 */
class QuotingQueries extends ControllerBase {

  /**
<<<<<<< HEAD
   * Return the minimum year to quoting
   * @return int
   */
  private function min_year() {
=======
   * Return the minimum year to quoting.
   */
  private function minYear() {
>>>>>>> main
    $actual_date = new \DateTime();
    $actual_date->sub(new \DateInterval('P30Y'));
    return $actual_date->format('Y');
  }

  /**
<<<<<<< HEAD
  * Query for brand autocomplete vehicles
  * @param $brand
  */
  public function circulation_city_autocomplete($city) {
=======
   * Query for brand autocomplete vehicles.
   */
  public function circulationCityAutocomplete($city) {
>>>>>>> main
    $db = \Drupal::database();
    $city = strtoupper($db->escapeLike($city));
    $query = $db->query("SELECT
        CONCAT(dep.name, ' - ', ttfd.name) city_name,
        ttfd.tid,
        ttfcd.field_code_dian_value code
      FROM taxonomy_term_field_data ttfd
      LEFT JOIN taxonomy_term__parent ttp on ttfd.tid = ttp.entity_id
      LEFT JOIN taxonomy_term__field_code_dian ttfcd on ttfd.tid = ttfcd.entity_id
      LEFT JOIN (
        SELECT ttfd.tid, ttfd.name
        FROM taxonomy_term_field_data ttfd
        LEFT JOIN taxonomy_term__parent ttp ON ttfd.tid = ttp.entity_id
        WHERE ttp.parent_target_id = 31
      ) dep ON ttp.parent_target_id = dep.tid
      WHERE ttfd.vid = 'ubication'
      AND dep.tid IS NOT NULL
      AND UPPER(CONCAT(dep.name, ' - ', ttfd.name)) LIKE '%$city%'
      ORDER BY ttfd.tid
      LIMIT 10
    ");
    $result = $query->fetchAll();

    if (!empty($result)) {
<<<<<<< HEAD
      foreach ($result as $key => $value) {
        $opts[] = array(
          'id' => $value->tid,
          'value' => $value->city_name,
          'code' => $value->code
        );
=======
      foreach ($result as $value) {
        $opts[] = [
          'id' => $value->tid,
          'value' => $value->city_name,
          'code' => $value->code,
        ];
>>>>>>> main
      }
      return new JsonResponse($opts);
    }
  }

<<<<<<< HEAD

  /**
  * Query for label autocomplete vehicles
  * @param $brand
  */
  public function vehicle_label_autocomplete($label) {
    $opts = array();
    if  (!empty($label)) {
      $db = \Drupal::database();
      $label = strtoupper($db->escapeLike($label));
      $min_year = $this->min_year();
=======
  /**
   * Query for label autocomplete vehicles.
   */
  public function vehicleLabelAutocomplete($label) {
    $opts = [];
    if (!empty($label)) {
      $db = \Drupal::database();
      $label = strtoupper($db->escapeLike($label));
      $minYear = $this->minYear();
>>>>>>> main

      $query = $db->query("SELECT
          nfla.entity_id AS nid_vehicle_price,
          nfla.field_label_autocomplete_value AS label,
          nfum.field_um_value
        FROM
        node__field_label_autocomplete nfla
        INNER JOIN node__field_vehiculo nfv ON nfla.entity_id = nfv.entity_id
        INNER JOIN node__field_um nfum ON nfv.field_vehiculo_target_id = nfum.entity_id
        INNER JOIN node__field_modelo nfmod ON nfv.entity_id = nfmod.entity_id
        INNER JOIN node__field_precio nfp ON nfv.entity_id = nfp.entity_id
        LEFT JOIN node__field_tipo_vehiculo nftv ON nfv.field_vehiculo_target_id = nftv.entity_id
        INNER JOIN taxonomy_term_field_data ttfd ON nfmod.field_modelo_target_id = ttfd.tid
        LEFT JOIN taxonomy_term_field_data ttfd2 ON nftv.field_tipo_vehiculo_target_id = ttfd2.tid
        LEFT JOIN taxonomy_term_field_data ttfd3 ON nfmod.field_modelo_target_id = ttfd3.tid
        WHERE nfla.bundle = 'precio_vehiculo'
        AND UPPER(nfla.field_label_autocomplete_value) LIKE '%$label%'
        AND nfp.field_precio_value <= 200000000
<<<<<<< HEAD
        AND ttfd.name >= $min_year
=======
        AND ttfd.name >= $minYear
>>>>>>> main
        AND ttfd2.tid NOT IN (834, 825, 824, 823, 819, 828, 835, 817, 818, 830, 829)
        ORDER BY ttfd.name DESC
        LIMIT 25"
      );

      $result = $query->fetchAll();
      if (!empty($result)) {
        foreach ($result as $key => $value) {
          if ($key === 0 && $value->field_um_value === 'F') {
            continue;
          }
<<<<<<< HEAD
          $opts[] = array(
            'id' => $value->nid_vehicle_price,
            'value' => $value->label,
          );
=======
          $opts[] = [
            'id' => $value->nid_vehicle_price,
            'value' => $value->label,
          ];
>>>>>>> main
        }
      }
      return new JsonResponse($opts);
    }
  }

  /**
<<<<<<< HEAD
  * Query for get info vehicles by nid price
  * @param $brand
  */
  public function vehicle_get_info_by_nid_price($nid_veh_price) {
    $info = array();
    if ($nid_veh_price && is_numeric($nid_veh_price)) {
      $db = \Drupal::database();
      $min_year = $this->min_year();
=======
   * Query for get info vehicles by nid price.
   */
  public function vehicleGetInfoByNidPrice($nid_veh_price) {
    $info = [];
    if ($nid_veh_price && is_numeric($nid_veh_price)) {
      $db = \Drupal::database();
      $minYear = $this->minYear();
>>>>>>> main

      $query = $db->query("SELECT nfd.title AS name_vehicle,
          ttfd1.name AS ref2,
          ttfd2.name AS clase,
          ttfd2.tid clas_tid,
          ttfd3.name AS modelo,
          nfp.field_precio_value AS price,
          nfas.field_agrupador_sistema_value AS agrupador,
          nfpu.field_puertas_value AS puertas,
          nfci.field_cilindraje_value AS cilindraje,
          nfco.field_combustible_value AS combustible,
          nfpkg.field_peso_kg_value AS peso,
          nftc.field_tipo_de_caja_value AS caja,
          nftr.field_transmision_value AS transmision,
          nfsr.field_servicio_value AS servicio,
          nfum.field_um_value AS um
        FROM
        node_field_data nfd
        LEFT JOIN node__field_vehiculo nfv ON nfd.nid = nfv.field_vehiculo_target_id
        LEFT JOIN node__field_ref2 nfr2 ON nfd.nid = nfr2.entity_id
        LEFT JOIN node__field_tipo_vehiculo nftv ON nfd.nid = nftv.entity_id
        LEFT JOIN node__field_modelo nfm ON nfv.entity_id = nfm.entity_id
        LEFT JOIN node__field_precio nfp ON nfv.entity_id = nfp.entity_id
        LEFT JOIN taxonomy_term_field_data ttfd1 ON nfr2.field_ref2_target_id = ttfd1.tid
        LEFT JOIN taxonomy_term_field_data ttfd2 ON nftv.field_tipo_vehiculo_target_id = ttfd2.tid
        LEFT JOIN taxonomy_term_field_data ttfd3 ON nfm.field_modelo_target_id = ttfd3.tid
        LEFT JOIN node__field_agrupador_sistema nfas ON nfd.nid = nfas.entity_id
        LEFT JOIN node__field_puertas nfpu ON nfd.nid = nfpu.entity_id
        LEFT JOIN node__field_cilindraje nfci ON nfd.nid = nfci.entity_id
        LEFT JOIN node__field_combustible nfco ON nfd.nid = nfco.entity_id
        LEFT JOIN node__field_peso_kg nfpkg ON nfd.nid = nfpkg.entity_id
        LEFT JOIN node__field_tipo_de_caja nftc ON nfd.nid = nftc.entity_id
        LEFT JOIN node__field_transmision nftr ON nfd.nid = nftr.entity_id
        LEFT JOIN node__field_servicio nfsr ON nfd.nid = nfsr.entity_id
        LEFT JOIN node__field_um nfum ON nfd.nid = nfum.entity_id
        LEFT JOIN taxonomy_term_field_data ttfd ON nfm.field_modelo_target_id = ttfd.tid
        WHERE ttfd1.vid = 'referencia_adicional'
        AND ttfd2.vid = 'tipo_vehiculo'
        AND ttfd3.vid = 'modelo'
        AND nfv.bundle = 'precio_vehiculo'
        AND nfp.field_precio_value < 200000000
<<<<<<< HEAD
        AND ttfd.name >= $min_year
=======
        AND ttfd.name >= $minYear
>>>>>>> main
        AND ttfd2.tid NOT IN (834, 825, 824, 823, 819, 828, 835, 817, 818, 830, 829)
        AND nfv.entity_id = $nid_veh_price");

      $result = $query->fetchAll();
      if (!empty($result)) {
<<<<<<< HEAD
        foreach ($result as $key => $value) {
          // if ($key === 0 && $value->um === 'F') {
          //   continue;
          // }
=======
        foreach ($result as $value) {
>>>>>>> main
          $info[$nid_veh_price] = $value->name_vehicle;
          $info[$nid_veh_price] .= '|' . $value->clase;
          $info[$nid_veh_price] .= '|' . $value->ref2;
          $info[$nid_veh_price] .= '|' . $value->modelo;
          $info[$nid_veh_price] .= '|' . $value->price;
          $info[$nid_veh_price] .= '|' . $value->agrupador;
          $info[$nid_veh_price] .= '|' . $value->puertas;
          $info[$nid_veh_price] .= '|' . $value->cilindraje;
          $info[$nid_veh_price] .= '|' . $value->combustible;
          $info[$nid_veh_price] .= '|' . $value->peso;
          $info[$nid_veh_price] .= '|' . $value->caja;
          $info[$nid_veh_price] .= '|' . $value->transmision;
          $info[$nid_veh_price] .= '|' . $value->servicio;
          $info[$nid_veh_price] .= '|' . $value->um;
        }
      }
      return new JsonResponse($info);
    }
  }

<<<<<<< HEAD
  public function vehicle_get_info_by_code_fasecolda($code, $model) {
    $info = array();
    if ($code && is_numeric($code)) {
      $db = \Drupal::database();
      $min_year = $this->min_year();
=======
  /**
   * Fucntion fasecolda.
   */
  public function vehicleGetInfoByCodeFasecolda($code, $model) {
    $info = [];
    if ($code && is_numeric($code)) {
      $db = \Drupal::database();
      $minYear = $this->minYear();
>>>>>>> main

      $query = $db->query("SELECT
          nfd.title AS name_vehicle,
          ttfd1.name AS ref2,
          ttfd2.name AS clase,
          ttfd3.name AS modelo,
          nfp.field_precio_value AS price,
          nfas.field_agrupador_sistema_value AS agrupador,
          nfpu.field_puertas_value AS puertas,
          nfci.field_cilindraje_value AS cilindraje,
          nfco.field_combustible_value AS combustible,
          nfpkg.field_peso_kg_value AS peso,
          nftc.field_tipo_de_caja_value AS caja,
          nftr.field_transmision_value AS transmision,
          nfsr.field_servicio_value AS servicio,
          nfum.field_um_value AS um
        FROM
        node_field_data nfd
        INNER JOIN node__field_vehiculo nfv ON nfd.nid = nfv.field_vehiculo_target_id
        INNER JOIN node__field_ref2 nfr2 ON nfd.nid = nfr2.entity_id
        INNER JOIN node__field_tipo_vehiculo nftv ON nfd.nid = nftv.entity_id
        INNER JOIN node__field_codigo nfc ON nfd.nid = nfc.entity_id
        INNER JOIN node__field_modelo nfm ON nfv.entity_id = nfm.entity_id
        INNER JOIN node__field_precio nfp ON nfv.entity_id = nfp.entity_id
        INNER JOIN node__field_agrupador_sistema nfas ON nfd.nid = nfas.entity_id
        INNER JOIN node__field_puertas nfpu ON nfd.nid = nfpu.entity_id
        INNER JOIN node__field_cilindraje nfci ON nfd.nid = nfci.entity_id
        INNER JOIN node__field_combustible nfco ON nfd.nid = nfco.entity_id
        INNER JOIN node__field_peso_kg nfpkg ON nfd.nid = nfpkg.entity_id
        INNER JOIN node__field_tipo_de_caja nftc ON nfd.nid = nftc.entity_id
        INNER JOIN node__field_transmision nftr ON nfd.nid = nftr.entity_id
        INNER JOIN node__field_servicio nfsr ON nfd.nid = nfsr.entity_id
        INNER JOIN node__field_um nfum ON nfd.nid = nfum.entity_id
        INNER JOIN taxonomy_term_field_data ttfd1 ON nfr2.field_ref2_target_id = ttfd1.tid
        INNER JOIN taxonomy_term_field_data ttfd2 ON nftv.field_tipo_vehiculo_target_id = ttfd2.tid
        INNER JOIN taxonomy_term_field_data ttfd3 ON nfm.field_modelo_target_id = ttfd3.tid
        WHERE ttfd1.vid = 'referencia_adicional'
        AND ttfd2.vid = 'tipo_vehiculo'
        AND ttfd3.vid = 'modelo'
        AND nfc.bundle = 'vehiculo'
        AND ttfd2.tid NOT IN (834, 825, 824, 823, 819, 828, 835, 817, 818, 830, 829)
        AND nfp.field_precio_value < 200000000
<<<<<<< HEAD
        AND ttfd3.name >= $min_year
=======
        AND ttfd3.name >= $minYear
>>>>>>> main
        AND nfc.field_codigo_value = $code
        ORDER BY ttfd3.name DESC"
      );
      $result = $query->fetchAll();
      if (!empty($result)) {
        foreach ($result as $key => $value) {
          if ($key === 0 && $value->um === 'F') {
            continue;
          }
          if ($value->modelo === $model) {
            $info[$code] = $value->name_vehicle;
            $info[$code] .= '|' . $value->clase;
            $info[$code] .= '|' . $value->ref2;
            $info[$code] .= '|' . $value->modelo;
            $info[$code] .= '|' . $value->price;
            $info[$code] .= '|' . $value->agrupador;
            $info[$code] .= '|' . $value->puertas;
            $info[$code] .= '|' . $value->cilindraje;
            $info[$code] .= '|' . $value->combustible;
            $info[$code] .= '|' . $value->peso;
            $info[$code] .= '|' . $value->caja;
            $info[$code] .= '|' . $value->transmision;
            $info[$code] .= '|' . $value->servicio;
            $info[$code] .= '|' . $value->um;
          }
        }
      }
      return new JsonResponse($info);
    }
  }

}
