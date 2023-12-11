<?php

namespace Drupal\esn_layouts\Plugin\Layout;

/**
 * Configurable one column layout plugin class.
 *
 * @internal
 *   Plugin classes are internal.
 */
class LayoutOneColumn extends LayoutEsnBase {

  /**
   * {@inheritdoc}
   */
  protected function showGridProperties() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  protected function getColumnWidthOptions() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  protected function getDefaultColumnWidth() {
    return '';
  }

  /**
   * {@inheritdoc}
   */
  protected function columns() {
    return '1';
  }

}
