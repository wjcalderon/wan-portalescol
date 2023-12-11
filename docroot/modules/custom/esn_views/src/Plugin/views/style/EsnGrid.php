<?php

namespace Drupal\ur_views\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * Style plugin to render each item in a css grid.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "ur_grid",
 *   title = @Translation("ESN Grid"),
 *   help = @Translation("Displays rows in a css grid."),
 *   theme = "esn_views_grid",
 *   display_types = { "normal" }
 * )
 */
class EsnGrid extends StylePluginBase {
  /**
   * {@inheritdoc}
   */
  protected $usesRowPlugin = TRUE;

  /**
   * Does the style plugin support custom css class for the rows.
   *
   * @var bool
   */
  protected $usesRowClass = TRUE;

  /**
   * Set default options.
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['columns'] = ['default' => '3'];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
    $form['columns'] = [
      '#type' => 'number',
      '#title' => $this->t('Number of columns'),
      '#default_value' => $this->options['columns'],
      '#required' => TRUE,
      '#min' => 1,
    ];
  }

}
