<?php

namespace Drupal\esn_layouts\Plugin\Layout;

/**
 * Configurable two column layout plugin class.
 *
 * @internal
 *   Plugin classes are internal.
 */
class LayoutTwoColumn extends LayoutEsnBase {

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
      '50-50' => $this->t('50% / 50%'),
      '33-67' => $this->t('33% / 67%'),
      '67-33' => $this->t('67% / 33%'),
      '25-75' => $this->t('25% / 75%'),
      '75-25' => $this->t('75% / 25%'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function getDefaultColumnWidth() {
    return '50-50';
  }

  /**
   * {@inheritdoc}
   */
  protected function columns() {
    return '2';
  }

}
