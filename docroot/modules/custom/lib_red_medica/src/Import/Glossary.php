<?php

namespace Drupal\lib_red_medica\Import;

use Drupal\node\Entity\Node;

/**
 * Custom import for content type: Glosario de especialidades
 */
class Glossary {

  /**
   * Add import item to batch
   *
   * @param array $item
   * @param array $context
   * @return void
   */
  public static function ImportItem($item, &$context) {
    $context['sandbox']['current_item'] = $item;
    $message = 'Creating ' . $item['A'];
    $results = array();
    self::createNode($item);
    $context['message'] = $message;
    $context['results'][] = $item;
  }

  /**
   * Batch step callback
   *
   * @param bool $success
   * @param array $results
   * @param array $operations
   * @return void
   */
  public static function ImportItemCallback($success, $results, $operations) {
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

  /**
   * Create node
   *
   * @param array $item
   * @return void
   */
  public static function createNode($item) {
    $values = [
      'type' => 'glosario_de_especialidades',
      'uid' => 1,
      'status' => TRUE,
      'title' => $item['A'],
      'body' => $item['B']
    ];

    $glossary = Node::create($values);
    $glossary->save();
  }
}
