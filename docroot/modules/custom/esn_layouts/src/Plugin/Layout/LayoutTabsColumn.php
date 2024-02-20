<?php

namespace Drupal\esn_layouts\Plugin\Layout;

/**
 * Configurable two column layout plugin class.
 *
 * @internal
 *   Plugin classes are internal.
 */
class LayoutTabsColumn extends LayoutEsnBase {

  /**
   * {@inheritdoc}
   */
  protected function showGridProperties() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  protected function isMultipleColumnsLayout() {
    return TRUE;
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
    return 'tabs';
  }

}
