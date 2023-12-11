<?php

/**
 * @file
 * Preprocessors and theme functions of Aggregator module.
 */

use Drupal\Core\Template\Attribute;

/**
 * Prepares variables for Views unformatted rows templates.
 *
 * Default template: views-view-unformatted.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - view: The view object.
 *   - rows: An array of row items. Each row is an array of content.
 */
function template_preprocess_esn_views_grid(array &$variables) {
  $view = $variables['view'];
  $rows = $variables['rows'];
  $style = $view->style_plugin;
  $options = $style->options;
  $variables['default_row_class'] = !empty($options['default_row_class']);
  $variables['columns'] = $options['columns'];
  foreach ($rows as $id => $row) {
    $variables['rows'][$id] = [];
    $variables['rows'][$id]['content'] = $row;
    $variables['rows'][$id]['attributes'] = new Attribute();
    if ($row_class = $view->style_plugin->getRowClass($id)) {
      $variables['rows'][$id]['attributes']->addClass($row_class);
    }
  }
}
