<?php

namespace Drupal\esn_layouts\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Layout\LayoutDefault;

/**
 * Configurable dinamic tab columns layout plugin class.
 *
 * @internal
 *   Plugin classes are internal.
 */
class Tabset extends LayoutDefault {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $parent = parent::defaultConfiguration();
    $parent['title'] = '';
    if (empty($this->configuration['tabs'])) {
      return $parent + [
        'tabs' => [
          ['detail' => ['icon' => '', 'label' => 'Tab 1'], 'weight' => 1],
          ['detail' => ['icon' => '', 'label' => 'Tab 2'], 'weight' => 2],
        ],
      ];
    }
    return $parent;
  }

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->pluginDefinition->setRegions($this->buildRegions($this->getConfiguration()['tabs']));
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\Core\Form\SubformStateInterface $form_state */
    $build = parent::buildConfigurationForm($form, $form_state);
    $config = $this->getConfiguration();
    $build['title'] = [
      '#type' => 'textfield',
      '#default_value' => $this->configuration['title'],
      '#title' => $this->t('Title'),
      '#description' => $this->t('Provide an optional title for this section'),
    ];
    $build['orientation'] = [
      '#type' => 'select',
      '#title' => $this->t('Orientación'),
      '#default_value' => $this->configuration['orientation'],
      '#options' => [
        NULL => $this->t('Seleccionar'),
        'horizontal' => $this->t('Horizontal'),
        'vertical' => $this->t('Vertical'),
      ],
      '#required' => TRUE,
    ];
    $tabs = $form_state->getCompleteFormState()->getValue(
      [
        'layout_settings',
        'tabs',
      ], $config['tabs'] ?: [
      [
        'detail' => [
          'icon' => '',
          'label' => 'Tab 1',
        ],
        'weight' => 1,
      ],
      [
        'detail' => [
          'icon' => '',
          'label' => 'Tab 2',
        ],
        'weight' => 2,
      ],
      ]);
    $build['tabs'] = [
      '#prefix' => '<div id="tabs-add-more">',
      '#suffix' => '</div>',
      '#type' => 'table',
      '#header' => [
        $this->t('Tabs'),
        $this->t('Weight'),
      ],
    ];
    $build['tabs']['#tabledrag'][] = [
      'action' => 'order',
      'relationship' => 'sibling',
      'group' => 'lb-tabs-weight',
    ];
    // $icons = $this->iconManager->getIconList();
    foreach ($tabs as $ix => $tab) {
      $detail = $tab['detail'];
      $build['tabs'][$ix] = [
        '#weight' => $tab['weight'] ?? 50,
        'detail' => [
          '#type' => 'container',
          'label' => [
            '#title_display' => 'invisible',
            '#type' => 'textfield',
            '#required' => TRUE,
            '#title' => $this->t('Label for tab %ix', ['%ix' => $ix + 1]),
            '#default_value' => $detail['label'],
          ],
          'remove' => [
            '#type' => 'submit',
            '#value' => $this->t('Remove %label', ['%label' => $detail['label']]),
            '#submit' => 'removeTabSubmit',
            '#ajax' => [
              'callback' => '::updateForm',
              'wrapper' => 'tabs-add-more',
              'effect' => 'fade',
              'method' => 'replaceWith',
            ],
          ],
        ],
        'weight' => [
          '#type' => 'weight',
          '#title' => $this->t('Weight for tab %ix', ['%ix' => $ix + 1]),
          '#title_display' => 'invisible',
          '#delta' => 50,
          '#default_value' => $tab['weight'] ?? 50,
          '#attributes' => [
            'class' => ['lb-tabs-weight'],
          ],
        ],
        '#attributes' => [
          'class' => ['draggable', 'js-form-wrapper'],
        ],
      ];
    }
    uasort($build['tabs'], [
      'Drupal\Component\Utility\SortArray',
      'sortByWeightProperty',
    ]);

    $build['add_another'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add another tab'),
      '#submit' => '::addMoreSubmit',
      '#ajax' => [
        'callback' => '::updateForm',
        'wrapper' => 'tabs-add-more',
        'effect' => 'fade',
        'method' => 'replaceWith',
      ],
    ];
    return $build;
  }

  /**
   * Submission handler for the "Add another tab" button.
   */
  public function addMoreSubmit(array $form, FormStateInterface $form_state) {
    $tabs = $form_state->getValue(['layout_settings', 'tabs'], []);
    $count = count($tabs) + 1;
    $tabs[] = [
      'detail' => ['icon' => '', 'label' => 'Tab ' . $count],
      'weight' => $count,
    ];
    $form_state->setValue(['layout_settings', 'tabs'], $tabs);
    $form_state->setRebuild();
  }

  /**
   * Submission handler for the "Remove tab" button.
   */
  public function removeTabSubmit(array $form, FormStateInterface $form_state) {
    $button = $form_state->getTriggeringElement();
    $tabs = $form_state->getValue(['layout_settings', 'tabs'], []);
    $parents = $button['#parents'];
    // Remove the button.
    array_pop($parents);
    // Remove the detail container.
    array_pop($parents);
    unset($tabs[end($parents)]);
    $form_state->setValue(['layout_settings', 'tabs'], $tabs);
    $form_state->setRebuild();
  }

  /**
   * Ajax callback for the "Add another tab" button.
   */
  public function updateForm(array $form, FormStateInterface $form_state) {
    return $form['layout_settings']['tabs'] ?? [];
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(
    array &$form,
    FormStateInterface $form_state
  ) {
    parent::submitConfigurationForm($form, $form_state);
    $this->configuration['tabs'] = $form_state->getValue(['tabs'], []);
    $this->configuration['title'] = $form_state->getValue(['title'], []);
    $this->configuration['orientation'] = $form_state->getValue(['orientation'], []);
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(
    array &$form,
    FormStateInterface $form_state
  ) {
    parent::validateConfigurationForm($form, $form_state);
    $tabs = $form_state->getValue(['tabs'], []);
    $labels = array_map(function (array $item) {
      return $item['detail']['label'];
    }, $tabs);
    if (count($labels) > count(array_unique($labels))) {
      $form_state->setErrorByName('layout_settings][tabs][0][detail][label', $this->t('Each tab name must be unique'));
    }
  }

  /**
   * Builds regions from tab configuration.
   *
   * @param array $tabs
   *   Tabs.
   *
   * @return array
   *   Regions.
   */
  protected function buildRegions(array $tabs): array {
    $regions = [];
    foreach (array_values($tabs) as $ix => $tab) {
      $regions['tab' . ($ix + 1)] = [
        'label' => $tab['detail']['label'] ?? 'Tab ' . ($ix + 1),
      ];
    }
    return $regions;
  }

}
