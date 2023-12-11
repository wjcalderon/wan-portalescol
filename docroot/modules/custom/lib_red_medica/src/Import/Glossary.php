<?php

namespace Drupal\lib_red_medica\Import;

use Drupal\node\Entity\Node;

/**
 * Custom import for content type: Glosario de especialidades.
 */
class Glossary {

  /**
   * Add import item to batch.
   */
  public function importItem($item, &$context) {
    $context['sandbox']['current_item'] = $item;
    $message = 'Creating ' . $item['A'];
    self::createNode($item);
    $context['message'] = $message;
    $context['results'][] = $item;
  }

  /**
   * Batch step callback.
   */
  public function importItemCallback($success, $results, $operations) {
    if ($success) {
      $message = \Drupal::translation()->formatPlural(
        count($results),
        'One item processed.', '@count items processed.'
      );
    }
    else {
      $message = 'Finished with an error.';
    }
    \Drupal::messenger()->addStatus($message);
  }

  /**
   * Create node.
   */
  public static function createNode($item) {
    $values = [
      'type' => 'glosario_de_especialidades',
      'uid' => 1,
      'status' => TRUE,
      'title' => $item['A'],
      'body' => $item['B'],
    ];

    $glossary = Node::create($values);
    $glossary->save();
  }

}
