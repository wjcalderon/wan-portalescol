<?php

namespace Drupal\lib_red_medica\Import;

use Drupal\node\Entity\Node;

/**
<<<<<<< HEAD
 * Custom import for content type: Glosario de especialidades
=======
 * Custom import for content type: Glosario de especialidades.
>>>>>>> main
 */
class Glossary {

  /**
<<<<<<< HEAD
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
=======
   * Add import item to batch.
   */
  public function importItem($item, &$context) {
    $context['sandbox']['current_item'] = $item;
    $message = 'Creating ' . $item['A'];
>>>>>>> main
    self::createNode($item);
    $context['message'] = $message;
    $context['results'][] = $item;
  }

  /**
<<<<<<< HEAD
   * Batch step callback
   *
   * @param bool $success
   * @param array $results
   * @param array $operations
   * @return void
   */
  public static function ImportItemCallback($success, $results, $operations) {
=======
   * Batch step callback.
   */
  public function importItemCallback($success, $results, $operations) {
>>>>>>> main
    if ($success) {
      $message = \Drupal::translation()->formatPlural(
        count($results),
        'One item processed.', '@count items processed.'
      );
    }
    else {
<<<<<<< HEAD
      $message = t('Finished with an error.');
    }
    drupal_set_message($message);
  }

  /**
   * Create node
   *
   * @param array $item
   * @return void
=======
      $message = 'Finished with an error.';
    }
    \Drupal::messenger()->addStatus($message);
  }

  /**
   * Create node.
>>>>>>> main
   */
  public static function createNode($item) {
    $values = [
      'type' => 'glosario_de_especialidades',
      'uid' => 1,
      'status' => TRUE,
      'title' => $item['A'],
<<<<<<< HEAD
      'body' => $item['B']
=======
      'body' => $item['B'],
>>>>>>> main
    ];

    $glossary = Node::create($values);
    $glossary->save();
  }
<<<<<<< HEAD
=======

>>>>>>> main
}
