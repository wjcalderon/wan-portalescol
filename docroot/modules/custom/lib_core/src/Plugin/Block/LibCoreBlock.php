<?php

namespace Drupal\lib_core\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\image\Entity\ImageStyle;

/**
 * Provides a 'DefaultBlock' block.
 *
 * @Block(
 *  id = "tabs_assistances",
 *  admin_label = @Translation("Tabs Asistencias"),
 * )
 */
class LibCoreBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $current_path = \Drupal::request();
    $path_args = explode('/', $current_path);
    $tid = 0;
    if (isset($path_args[1])) {
      $root = $path_args[1];
      $term = \Drupal::entityTypeManager()
        ->getStorage('taxonomy_term')
        ->loadByProperties(['name' => $root]);
      $tid = key($term);
    }

    $connection = \Drupal::database();
    $query = $connection->query("SELECT r.tid, r.name, i.field_icon_target_id as fid FROM {taxonomy_term_field_data} r inner join {taxonomy_term__field_person_type} t on t.entity_id = r.tid left join taxonomy_term__field_icon i on i.entity_id = r.tid where status = 1 and vid = 'product_type' and t.field_person_type_target_id = " . $tid);
    $result = $query->fetchAll();
    $ramos = array();
    $products = array();
    foreach ($result as $tax) {
      $uri = '';
      if (isset($tax->fid) && is_numeric($tax->fid) && $tax->tid > 0) {
        $icon_ramo = \Drupal\file\Entity\File::load($tax->fid);
        if (isset($icon_ramo->uri->value)) {
          $uri = 	$icon_ramo->uri->value;
        }
      }

      // $ramos[$tax->tid] = array('icon'=>$uri,'name'=>$tax->name);
      $connection = \Drupal::database();
      $query = $connection->query("SELECT n.nid, n.title
          FROM {node_field_data} n
          inner join {node__field_product_type} t on t.entity_id = n.nid
          where n.status = 1
          and n.type = 'product'
          and t.field_product_type_target_id = " . $tax->tid);
      $resulta = $query->fetchAll();
// echo '<pre>';

      if (count($resulta) > 0) {
        // print_r($resulta);
        foreach ($resulta as $row) {
          // print_r($row->nid . "\n");
          if (!empty($row->nid)) {
            $ramos[$tax->tid] = array('icon'=>$uri,'name'=>$tax->name);
            $node  = \Drupal\node\Entity\Node::load($row->nid);
            //$paras = $node->field_assistances->referencedEntities();
            $display_options = [
              'label'    => 'hidden',
              'type'     => 'responsive_image',
              'settings' => [
                'responsive_image_style' => 'img_40X40',
              ],
            ];
            $paragraphs = $node->field_assistances->getValue();
            $p = array();
            $content = array();
            // print_r($paragraphs);
            foreach ($paragraphs as $element) {
              // print_r($element);
              $paragraph = \Drupal::entityTypeManager()
                ->getStorage('paragraph')
                ->loadRevision($element['target_revision_id']);
              if (!empty($paragraph)) {
                $heading = $paragraph->get('field_heading')->getValue();
                $icon = '';
                if (isset($paragraph->field_c_image) && isset($paragraph->field_c_image->entity)) {
                  $icon = $paragraph->field_c_image->entity->uri->value;
                }
                $lead = $paragraph->get('field_lead')->getValue();
                $steps = $paragraph->field_step->getValue();
                $content[] = array('heading' => $heading,'icon'=>$icon,'lead'=>$lead,'steps'=>$steps);
              }
            }
            if (!empty($node->field_icon->entity->uri)) {
              $icon = $node->field_icon->entity->uri->value;
              $title = $row->title;
            }
            if (count($content) > 0) {
              $products[$tax->tid][] = array('title' => $title, 'nid'=>$row->nid, 'content' => $content);
            }

          }
        }
      }
    }


    // echo '<pre>';
    // var_dump($ramos);

    // die();

    $block = \Drupal\block_content\Entity\BlockContent::load(3);

    $contact = array();
    $contact[] = array('label'=>'Celular', 'value'=> $block->get('field_numero_mst')->value);
    $contact[] = array('label'=>$block->field_bogota->getFieldDefinition()->getLabel(), 'value'=> $block->get('field_bogota')->value);
    $contact[] = array('label'=>$block->field_resto_pais->getFieldDefinition()->getLabel(), 'value'=> $block->get('field_resto_pais')->value);

     return array (
      '#theme' => 'tabs_assistances',
      '#ramos' => $ramos,
      '#products' => $products,
      '#block_contact' => $contact,
      '#cache' => ['max-age' => 0],
     );

    }
}
