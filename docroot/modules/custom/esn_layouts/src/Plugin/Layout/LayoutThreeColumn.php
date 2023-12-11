<?php

namespace Drupal\esn_layouts\Plugin\Layout;

/**
 * Configurable three column layout plugin class.
 *
 * @internal
 *   Plugin classes are internal.
 */
class LayoutThreeColumn extends LayoutEsnBase {

  /**
   * {@inheritdoc}
   */
  protected function showGridProperties() {
    return TRUE;
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
    return [
      '25-50-25' => $this->t('25% / 50% / 25%'),
      '33-34-33' => $this->t('33% / 34% / 33%'),
      '25-25-50' => $this->t('25% / 25% / 50%'),
      '50-25-25' => $this->t('50% / 25% / 25%'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function getDefaultColumnWidth() {
    return '33-34-33';
  }

  /**
   * {@inheritdoc}
   */
  protected function columns() {
    return '3';
  }

}
