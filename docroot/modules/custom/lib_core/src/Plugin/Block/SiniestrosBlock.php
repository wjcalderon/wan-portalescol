<?php

namespace Drupal\lib_core\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;

/**
 * Provides a 'DefaultBlock' block.
 *
 * @Block(
 *  id = "tabs_documents_required",
 *  admin_label = @Translation("Tabs documentos requeridos"),
 * )
 */
class SiniestrosBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $connection = \Drupal::database();
    $query = $connection->query("
      SELECT r.tid, r.name, i.field_icon_target_id AS fid, t.field_person_type_target_id
      FROM taxonomy_term_field_data r
      INNER JOIN taxonomy_term__field_person_type t ON t.entity_id = r.tid
      LEFT JOIN taxonomy_term__field_icon i ON i.entity_id = r.tid
      WHERE status = 1
      AND vid = 'product_type'
      ORDER BY r.weight");
    $result = $query->fetchAll();

    $ramos = [];
    $products = [];
    foreach ($result as $tax) {
      $uri = '';
      if (isset($tax->fid) && is_numeric($tax->fid) && $tax->tid > 0) {
        $icon_ramo = File::load($tax->fid);
        if (isset($icon_ramo->uri->value)) {
          $uri = $icon_ramo->uri->value;
        }
      }
      $connection = \Drupal::database();
      $query = $connection->query("SELECT n.nid, n.title
		      FROM node_field_data n
		      inner join node__field_product_type t on t.entity_id = n.nid
		      where n.status = 1
		      and n.type = 'product'
		      and t.field_product_type_target_id = " . $tax->tid);
      $resulta = $query->fetchAll();
      foreach ($resulta as $row) {
        $node = Node::load($row->nid);
        $documents = $node->field_documents_required->getValue();
        $content = [];
        foreach ($documents as $element) {
          $content[] = $element;
        }
        $title = $row->title;
        if (count($content) > 0) {
          $ramos[$tax->tid] = [
            'icon' => $uri,
            'name' => $tax->name,
          ];
          $products[$tax->tid][] = [
            'title' => $title,
            'nid' => $row->nid,
            'content' => $content,
          ];
        }

      }
    }

    return [
      '#theme' => 'tabs_documents_required',
      '#ramos' => $ramos,
      '#products' => $products,
      '#cache' => ['max-age' => 0],
    ];
  }

}
