<?php

namespace Drupal\esn_layouts\Plugin\Layout;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\Element\EntityAutocomplete;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Layout\LayoutDefault;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;
use Drupal\media\Entity\Media;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Base class of layouts with configurable class width - container.
 *
 * @internal
 *   Plugin classes are internal.
 */
abstract class LayoutEsnBase extends LayoutDefault implements ContainerFactoryPluginInterface {

  /**
   * Drupal configuration service container.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $configuration = parent::defaultConfiguration();
    return $configuration + [
      'column_gap' => '',
      'row_gap' => '',
      'align_items' => '',
      'background_color' => '',
      'region_first_classes' => '',
      'region_second_classes' => '',
      'top_padding' => '',
      'bottom_padding' => '',
      'left_right_paddings' => '',
      'top_bottom_paddings' => '',
      'top_margin' => '',
      'bottom_margin' => '',
      'left_right_margins' => '',
      'top_bottom_margins' => '',
      'container_type' => '',
      'content_container' => 'content-container-default',
      'text_color' => 'text-default',
      'alignment' => '',
      'section_classes' => '',
      'section_id' => '',
      'section_scroll_effect' => '',
      'two_column_widths' => $this->getDefaultColumnWidth(),
      'three_column_widths' => $this->getDefaultColumnWidth(),
      'number_tabs' => '',
      'orientation' => '',
      'tabs' => [],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    if ($this->columns() == 'tabs') {
      $form['tabs_properties'] = [
        '#type' => 'details',
        '#title' => $this->t('Propiedades de Tabs'),
      ];

      $form['tabs_properties']['orientation'] = [
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

      $form['tabs_properties']['number_tabs'] = [
        '#type' => 'select',
        '#title' => $this->t('Número de tabs'),
        '#default_value' => $this->configuration['number_tabs'],
        '#required' => TRUE,
        '#options' => $this->getNumberOfTabsOptions(),
        '#ajax' => [
          'callback' => [$this, 'getNumberofTabs'],
          'event' => 'change',
          'wrapper' => 'tabs-properties',
        ],
      ];

      $form['tabs_properties']['tabs_details'] = [
        '#type' => 'details',
        '#title' => $this->t('Información de las tabs'),
        '#attributes' => ['id' => 'tabs-properties'],
      ];

      $number_tabs = $form['tabs_properties']['number_tabs']['#default_value'];
      $triggering_element = $form_state->getTriggeringElement();
      $tabs = (int) (empty($triggering_element) ? $number_tabs ? $number_tabs : 0 : $triggering_element['#value']);

      for ($i = 0; $i < $tabs; $i += 1) {

        $form['tabs_properties']['tabs_details']['tab_' . $i] = [
          '#type' => 'textfield',
          '#title' => $this->t('TAB @number', ['@number' => $i + 1]),
          '#required' => TRUE,
          '#default_value' => $this->configuration['tabs'][$i] ? $this->configuration['tabs'][$i] : "",
        ];

        $form['tabs_properties']['tabs_details']['icon_' . $i] = [
          '#type' => 'details',
          '#title' => $this->t('Icon'),
        ];

        $media = $this->configuration['media'][$i] ? Media::load($this->configuration['media'][$i]) : NULL;

        $form['tabs_properties']['tabs_details']['icon_' . $i]['media_' . $i] = [
          '#type' => 'entity_autocomplete',
          '#title' => $this->t('Media Icon'),
          '#description' => $this->t('Digite el nombre del SVG.'),
          '#target_type' => 'media',
          '#selection_settings' => [
            'target_bundles' => ['vector_image'],
          ],
          '#default_value' => $media,
        ];

        $form['tabs_properties']['tabs_details']['link_' . $i] = [
          '#type' => 'entity_autocomplete',
          '#target_type' => 'node',
          '#title' => $this->t('URL TAB @number', ['@number' => $i + 1]),
          '#default_value' => $this->configuration['links'][$i] ? static::getUriAsDisplayableString($this->configuration['links'][$i]) : "",
          '#element_validate' => [[static::class, 'validateUriElement']],
          '#description' => $this->t('Si ingresa este campo la TAB dejará de ser contenido para ser un enlace.'),
          '#process_default_value' => FALSE,
          '#attributes' => [
            'data-autocomplete-first-character-blacklist' => '/#?',
          ],
          '#maxlength' => 255,
        ];

        $form['tabs_properties']['tabs_details']['attribute_link_' . $i] = [
          '#type' => 'select',
          '#title' => $this->t('Destino'),
          '#default_value' => $this->configuration['attribute_link'][$i] ? $this->configuration['attribute_link'][$i] : "",
          '#options' => [
            NULL => $this->t('- Ninguno -'),
            '_self' => $this->t('Same window (_self)'),
            '_blank' => $this->t('New window (_blank)'),
          ],
        ];
      }
    }

    if ($this->showGridProperties()) {
      $form['grid_properties'] = [
        '#type' => 'details',
        '#title' => $this->t('Propiedades del Grid'),
      ];
      if ($this->columns() == '2') {
        $form['grid_properties']['two_column_widths'] = [
          '#type' => 'select',
          '#title' => $this->t('Ancho de Columnas'),
          '#default_value' => $this->configuration['two_column_widths'],
          '#options' => $this->getColumnWidthOptions(),
        ];
        $form['grid_properties']['region_first_classes'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Classes Columna Izquierda'),
          '#default_value' => $this->configuration['region_first_classes'],
          '#description' => $this->t('Utilice clases utilitarias si desea personalizar esta columna.'),
        ];
        $form['grid_properties']['region_second_classes'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Classes Columna Derecha'),
          '#default_value' => $this->configuration['region_second_classes'],
          '#description' => $this->t('Utilice clases utilitarias si desea personalizar esta columna.'),
        ];
      }
      if ($this->columns() == '3') {
        $form['grid_properties']['three_column_widths'] = [
          '#type' => 'select',
          '#title' => $this->t('Ancho de Columnas'),
          '#default_value' => $this->configuration['three_column_widths'],
          '#options' => $this->getColumnWidthOptions(),
        ];
      }
      $form['grid_properties']['column_gap'] = [
        '#type' => 'select',
        '#title' => $this->t('Espaciado entre Columnas'),
        '#default_value' => $this->configuration['column_gap'],
        '#options' => $this->getColumnGapOptions(),
      ];
      $form['grid_properties']['row_gap'] = [
        '#type' => 'select',
        '#title' => $this->t('Espaciado entre filas'),
        '#default_value' => $this->configuration['row_gap'],
        '#options' => $this->getRowGapOptions(),
      ];
      $form['grid_properties']['align_items'] = [
        '#type' => 'select',
        '#title' => $this->t('Alineación de items'),
        '#default_value' => $this->configuration['align_items'],
        '#options' => $this->getAlignItems(),
      ];
    }

    $form['background'] = [
      '#type' => 'details',
      '#title' => $this->t('Color de Fondo'),
    ];
    $form['background']['background_color'] = [
      '#type' => 'select',
      '#title' => $this->t('Color de fondo'),
      '#default_value' => $this->configuration['background_color'],
      '#options' => $this->getBackgroundColor(),
      '#description' => $this->t('Elija el color de fondo para la sección'),
    ];

    $form['padding'] = [
      '#type' => 'details',
      '#title' => $this->t('Relleno'),
    ];
    $form['padding']['top_padding'] = [
      '#type' => 'select',
      '#title' => $this->t('Superior'),
      '#default_value' => $this->configuration['top_padding'],
      '#options' => $this->getTopPaddingOptions(),
    ];
    $form['padding']['bottom_padding'] = [
      '#type' => 'select',
      '#title' => $this->t('Inferior'),
      '#default_value' => $this->configuration['bottom_padding'],
      '#options' => $this->getBottomPaddingOptions(),
    ];
    $form['padding']['left_right_paddings'] = [
      '#type' => 'select',
      '#title' => $this->t('Izquierda - Derecha'),
      '#default_value' => $this->configuration['left_right_paddings'],
      '#options' => $this->getEqualLeftRightPaddingsOptions(),
    ];
    $form['padding']['top_bottom_paddings'] = [
      '#type' => 'select',
      '#title' => $this->t('Superior - Inferior'),
      '#default_value' => $this->configuration['top_bottom_paddings'],
      '#options' => $this->getEqualTopBottomPaddingsOptions(),
    ];

    $form['margin'] = [
      '#type' => 'details',
      '#title' => $this->t('Margen'),
    ];
    $form['margin']['top_margin'] = [
      '#type' => 'select',
      '#title' => $this->t('Superior'),
      '#default_value' => $this->configuration['top_margin'],
      '#options' => $this->getTopMarginOptions(),
    ];
    $form['margin']['bottom_margin'] = [
      '#type' => 'select',
      '#title' => $this->t('Inferior'),
      '#default_value' => $this->configuration['bottom_margin'],
      '#options' => $this->getBottomMarginOptions(),
    ];
    $form['margin']['left_right_margins'] = [
      '#type' => 'select',
      '#title' => $this->t('Izquierda - Derecha'),
      '#default_value' => $this->configuration['left_right_margins'],
      '#options' => $this->getEqualLeftRightMarginsOptions(),
    ];
    $form['margin']['top_bottom_margins'] = [
      '#type' => 'select',
      '#title' => $this->t('Superior - Inferior'),
      '#default_value' => $this->configuration['top_bottom_margins'],
      '#options' => $this->getEqualTopBottomMarginsOptions(),
    ];

    $form['container'] = [
      '#type' => 'details',
      '#title' => $this->t('Contenedor'),
    ];
    $form['container']['container_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Contenedor de sección'),
      '#default_value' => $this->configuration['container_type'],
      '#options' => $this->getDefaultContainerType(),
    ];
    $form['container']['content_container'] = [
      '#type' => 'select',
      '#title' => $this->t('Contenedor de contenido'),
      '#default_value' => $this->configuration['content_container'],
      '#options' => $this->getContentContainerOptions(),
      '#description' => $this->t('Elija el tamaño del contenedor para el contenido de este diseño. Es bastante útil si desea un fondo de ancho completo y su contenido en el medio.'),
    ];

    // Text Styles.
    $form['styles'] = [
      '#type' => 'details',
      '#title' => $this->t('Estilos'),
    ];

    if ($this->columns() != 'tabs') {
      $form['styles']['text_color'] = [
        '#type' => 'select',
        '#title' => $this->t('Color texto'),
        '#default_value' => $this->configuration['text_color'],
        '#options' => $this->getTextColor(),
        '#description' => $this->t('Elija el color predeterminado para el texto de este diseño.'),
      ];

      $form['styles']['alignment'] = [
        '#type' => 'select',
        '#title' => $this->t('Alineación de texto'),
        '#default_value' => $this->configuration['alignment'],
        '#options' => $this->getAlignmentOptions(),
        '#description' => $this->t('Elija la alineación predeterminada para el texto de este diseño.'),
      ];
    }
    $form['styles']['section_classes'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Clases CSS'),
      '#default_value' => $this->configuration['section_classes'],
    ];
    $form['styles']['section_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ID de sección'),
      '#default_value' => $this->configuration['section_id'],
    ];
    $form['styles']['section_scroll_effect'] = [
      '#type' => 'select',
      '#title' => $this->t('Efecto Scroll'),
      '#default_value' => $this->configuration['section_scroll_effect'],
      '#options' => $this->getScrollEffect(),
      '#description' => $this->t('Seleccione un efecto de scroll'),
    ];

    return $form;
  }

  /**
   * Get Number of Tabs.
   */
  public function getNumberofTabs(array &$form, $form_state) {
    $response = new AjaxResponse();
    $response->addCommand(new ReplaceCommand(NULL, $form["layout_settings"]['tabs_properties']['tabs_details']));
    return $response;
  }

  /**
   * Gets the URI without the 'internal:' or 'entity:' scheme.
   */
  protected static function getDisplayableAsUri($uri) {
    $scheme = parse_url($uri, PHP_URL_SCHEME);

    $displayable_string = $uri;

    if ($scheme === 'internal') {
      $uri_reference = explode(':', $uri, 2)[1];

      $path = parse_url($uri, PHP_URL_PATH);
      if ($path === '/') {
        $uri_reference = '<front>' . substr($uri_reference, 1);
      }

      $displayable_string = $uri_reference;
    }
    elseif ($scheme === 'entity') {
      [$entity_type, $entity_id] = explode('/', substr($uri, 7), 2);
      if ($entity_type == 'node') {
        $displayable_string = '/' . $entity_type . '/' . $entity_id;
      }
    }
    elseif ($scheme === 'route') {
      $displayable_string = ltrim($displayable_string, 'route:');
    }

    return $displayable_string;
  }

  /**
   * Gets the URI without the 'internal:' or 'entity:' scheme.
   */
  protected static function getUriAsDisplayableString($uri) {
    $scheme = parse_url($uri, PHP_URL_SCHEME);

    $displayable_string = $uri;

    if ($scheme === 'internal') {
      $uri_reference = explode(':', $uri, 2)[1];

      $path = parse_url($uri, PHP_URL_PATH);
      if ($path === '/') {
        $uri_reference = '<front>' . substr($uri_reference, 1);
      }

      $displayable_string = $uri_reference;
    }
    elseif ($scheme === 'entity') {
      [$entity_type, $entity_id] = explode('/', substr($uri, 7), 2);
      if ($entity_type == 'node' && $entity = \Drupal::entityTypeManager()->getStorage($entity_type)->load($entity_id)) {
        $displayable_string = EntityAutocomplete::getEntityLabels([$entity]);
      }
    }
    elseif ($scheme === 'route') {
      $displayable_string = ltrim($displayable_string, 'route:');
    }

    return $displayable_string;
  }

  /**
   * Form element validation handler for the 'uri' element.
   *
   * Disallows saving inaccessible or untrusted URLs.
   */
  public static function validateUriElement($element, FormStateInterface $form_state, $form) {
    $uri = static::getUserEnteredStringAsUri($element['#value']);
    $form_state->setValueForElement($element, $uri);

    if (parse_url($uri, PHP_URL_SCHEME) === 'internal' && !in_array($element['#value'][0], [
      '/',
      '?',
      '#',
    ], TRUE) && substr($element['#value'], 0, 7) !== '<front>') {
      $form_state->setError($element, t('Manually entered paths should start with one of the following characters: / ? #'));
      return;
    }
  }

  /**
   * Gets the user-entered string as a URI.
   *
   * The following two forms of input are mapped to URIs:
   * - entity autocomplete ("label (entity id)") strings: to 'entity:' URIs;
   * - strings without a detectable scheme: to 'internal:' URIs.
   *
   * This method is the inverse of ::getUriAsDisplayableString().
   *
   * @param string $string
   *   The user-entered string.
   *
   * @return string
   *   The URI, if a non-empty $uri was passed.
   *
   * @see static::getUriAsDisplayableString()
   */
  protected static function getUserEnteredStringAsUri($string) {
    $uri = trim($string);
    $entity_id = EntityAutocomplete::extractEntityIdFromAutocompleteInput($string);
    if ($entity_id !== NULL) {
      $uri = 'entity:node/' . $entity_id;
    }
    elseif (in_array($string, ['<nolink>', '<none>', '<button>'], TRUE)) {
      $uri = 'route:' . $string;
    }
    elseif (!empty($string) && parse_url($string, PHP_URL_SCHEME) === NULL) {
      if (strpos($string, '<front>') === 0) {
        $string = '/' . substr($string, strlen('<front>'));
      }
      $uri = 'internal:' . $string;
    }

    return $uri;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(
        array &$form,
        FormStateInterface $form_state
    ) {
    parent::submitConfigurationForm($form, $form_state);

    $grid_properties = $form_state->getValue('grid_properties');
    $this->configuration['two_column_widths'] = $grid_properties['two_column_widths'] ?? NULL;
    $this->configuration['three_column_widths'] = $grid_properties['three_column_widths'] ?? NULL;
    $this->configuration['column_gap'] = $grid_properties['column_gap'] ?? NULL;
    $this->configuration['row_gap'] = $grid_properties['row_gap'] ?? NULL;
    $this->configuration['align_items'] = $grid_properties['align_items'] ?? NULL;
    $this->configuration['region_first_classes'] = $grid_properties['region_first_classes'] ?? NULL;
    $this->configuration['region_second_classes'] = $grid_properties['region_second_classes'] ?? NULL;

    $background = $form_state->getValue('background');
    $this->configuration['background_color'] = $background['background_color'];
    if ($this->columns() != 'tabs') {
      $background_file = !empty($background['background_image']) ? $background['background_image'] : 0;
      if (isset($background_file[0]) && !empty($background_file[0])) {
        $file = File::load($background_file[0]);
        $file->setPermanent();
        $file->save();
      }
      $image_background_style = $background['background_image_style'];
      $this->configuration['background_image'] = !empty($file) ? $file->id() : '';
      $this->configuration['background_image_style'] = !empty($image_background_style) ? $image_background_style : '';
      $this->configuration['background_attachment'] = $background['background_attachment'];
      $this->configuration['background_position'] = $background['background_position'];
      $this->configuration['background_size'] = $background['background_size'];
      $this->configuration['background_overlay'] = $background['background_overlay'];
    }

    $background = $form_state->getValue('background_container');
    $this->configuration['background_container_color'] =
            $background['background_container_color'];

    $padding = $form_state->getValue('padding');
    $this->configuration['top_padding'] = $padding['top_padding'];
    $this->configuration['bottom_padding'] = $padding['bottom_padding'];
    $this->configuration['left_right_paddings'] = $padding['left_right_paddings'];
    $this->configuration['top_bottom_paddings'] = $padding['top_bottom_paddings'];

    if ($this->columns() != 'tabs') {
      $margin = $form_state->getValue('margin');
      $this->configuration['top_margin'] = $margin['top_margin'];
      $this->configuration['bottom_margin'] = $margin['bottom_margin'];
      $this->configuration['left_right_margins'] = $margin['left_right_margins'];
      $this->configuration['top_bottom_margins'] = $margin['top_bottom_margins'];
    }

    $container = $form_state->getValue('container');
    $this->configuration['container_type'] = $container['container_type'];
    $this->configuration['content_container'] = $container['content_container'];

    $styles = $form_state->getValue('styles');
    $this->configuration['section_classes'] = $styles['section_classes'];

    $this->configuration['section_id'] = $styles['section_id'];
    $this->configuration['section_scroll_effect'] = $styles['section_scroll_effect'];
    $this->configuration['text_color'] = $styles['text_color'];
    $this->configuration['aligment'] = $styles['aligment'];

    $tabs_properties = $form_state->getValue('tabs_properties');
    $this->configuration['orientation'] = $tabs_properties['orientation'] ?? NULL;
    $this->configuration['number_tabs'] = $tabs_properties['number_tabs'] ?? 0;

    // Load the configuration settings.
    for ($i = 0; $i < $tabs_properties['number_tabs']; $i += 1) {
      $this->configuration['tabs'][$i] = $tabs_properties['tabs_details']['tab_' . $i] ?? NULL;

      $this->configuration['settings'][$i] = $tabs_properties['tabs_details']['icon_' . $i]['settings_' . $i] ?? NULL;

      $this->configuration['media'][$i] = $tabs_properties['tabs_details']['icon_' . $i]['media_' . $i] ?? NULL;
      $this->configuration['media_icon'][$i] = '';
      if ($this->configuration['media'][$i]) {
        $media = Media::load($this->configuration['media'][$i]);
        if ($media->hasField('field_media_svg')) {
          $fid = $media->get('field_media_svg')->target_id;
          $file = File::load($fid);
          $this->configuration['media_icon'][$i] = $file->createFileUrl();
        }
      }

      $this->configuration['links'][$i] = $this->getDisplayableAsUri($tabs_properties['tabs_details']['link_' . $i]) ?? NULL;
      $this->configuration['attribute_link'][$i] = $tabs_properties['tabs_details']['attribute_link_' . $i] ?? NULL;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build(array $regions) {
    $build = parent::build($regions);
    if (!empty($this->configuration['background_image'])) {
      $image = File::load($this->configuration['background_image']);
      if (!empty($image)) {
        $uri = $image->uri->value;
        $style = $this->configuration['background_image_style'];
        if (!empty($style)) {
          $uri = ImageStyle::load($style)->buildUrl($image->getFileUri());
        }
        $url = file_create_url($uri);
        $build['#attributes']['style'] = 'background-image: url("' . $url . '")';
      }
    }

    return $build;
  }

  /**
   * Get the default background option.
   *
   * @return string
   *   Return the default background option.
   */
  protected function getDefaultImageBackground() {
    return '';
  }

  /**
   * Get the default image style background option.
   *
   * @return string
   *   Return the default image style background option.
   */
  protected function getDefaultBackgroundImageStyle() {
    return '';
  }

  /**
   * Get the default attachment background option.
   *
   * @return string
   *   Return the default attachment background option.
   */
  protected function getDefaultBackgroundAttachment() {
    return '';
  }

  /**
   * Get the default attachment background option.
   *
   * @return string
   *   Return the default position background option.
   */
  protected function getDefaultBackgroundPosition() {
    return '';
  }

  /**
   * Get the default attachment background option.
   *
   * @return string
   *   Return the default size background option.
   */
  protected function getDefaultBackgroundSize() {
    return '';
  }

  /**
   * Get the default attachment background option.
   *
   * @return string
   *   Return the default size background option.
   */
  protected function getDefaultBackgroundOverlay() {
    return '';
  }

  /**
   * Provides a default value for the gab options.
   *
   * @return array[stringstring]
   *   Return Options for getColumnGapOptions
   */
  protected function getColumnGapOptions() {
    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Ninguno'),
      'gap-x-sm' => $this->t('Pequeño'),
      'gap-x-md' => $this->t('Mediano'),
      'gap-x-lg' => $this->t('Grande'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the gab options.
   *
   * @return array[stringstring]
   *   Return Options for getRowGapOptions
   */
  protected function getRowGapOptions() {
    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Ninguno'),
      'gap-y-sm' => $this->t('Pequeño'),
      'gap-y-md' => $this->t('Mediano'),
      'gap-y-lg' => $this->t('Grande'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the padding options.
   *
   * @return array[stringstring]
   *   Return Options for getTopPaddingOptions
   */
  protected function getTopPaddingOptions() {
    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Seleccione'),
      'pt-none' => $this->t('Ninguno'),
      'pt-sm' => $this->t('Pequeño'),
      'pt-md' => $this->t('Mediano'),
      'pt-lg' => $this->t('Grande'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the padding options.
   *
   * @return array[stringstring]
   *   Return Options for getBottomPaddingOptions
   */
  protected function getBottomPaddingOptions() {
    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Seleccione'),
      'pb-none' => $this->t('Ninguno'),
      'pb-sm' => $this->t('Pequeño'),
      'pb-md' => $this->t('Mediano'),
      'pb-lg' => $this->t('Grande'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the padding options.
   *
   * @return array[stringstring]
   *   Return Options for getEqualLeftRightPaddingsOptions
   */
  protected function getEqualLeftRightPaddingsOptions() {

    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Seleccione'),
      'px-none' => $this->t('Ninguno'),
      'px-sm' => $this->t('Pequeño'),
      'px-md' => $this->t('Mediano'),
      'px-lg' => $this->t('Grande'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the padding options.
   *
   * @return array[stringstring]
   *   Return Options for PaddingsContentContainerOptions
   */
  protected function paddingsContentContainerOptions() {

    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Seleccione'),
      'p-c-none' => $this->t('Ninguno'),
      'p-c-sm' => $this->t('Pequeño'),
      'p-c-md' => $this->t('Mediano'),
      'p-c-lg' => $this->t('Grande'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the padding options.
   *
   * @return array[stringstring]
   *   Return Options for getEqualTopBottomPaddingsOptions
   */
  protected function getEqualTopBottomPaddingsOptions() {

    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Seleccione'),
      'py-none' => $this->t('Ninguno'),
      'py-sm' => $this->t('Pequeño'),
      'py-md' => $this->t('Mediano'),
      'py-lg' => $this->t('Grande'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the margin options.
   *
   * @return array[stringstring]
   *   Return Options for getEqualTopBottomPaddingsOptions
   */
  protected function getTopMarginOptions() {
    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Seleccione'),
      'mt-none' => $this->t('Ninguno'),
      'mt-sm' => $this->t('Pequeña'),
      'mt-md' => $this->t('Mediana'),
      'mt-lg' => $this->t('Grande'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the margin options.
   *
   * @return array[stringstring]
   *   Return Options for getBottomMarginOptions
   */
  protected function getBottomMarginOptions() {
    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Seleccione'),
      'mb-none' => $this->t('Ninguno'),
      'mb-sm' => $this->t('Pequeña'),
      'mb-md' => $this->t('Mediana'),
      'mb-lg' => $this->t('Grande'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the margin options.
   *
   * @return array[stringstring]
   *   Return Options for getEqualLeftRightMarginsOptions
   */
  protected function getEqualLeftRightMarginsOptions() {
    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Seleccione'),
      'mx-none' => $this->t('Ninguno'),
      'mx-sm' => $this->t('Pequeña'),
      'mx-md' => $this->t('Mediana'),
      'mx-lg' => $this->t('Grande'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the margin options.
   *
   * @return array[stringstring]
   *   Return Options for getEqualTopBottomMarginsOptions
   */
  protected function getEqualTopBottomMarginsOptions() {
    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Seleccione'),
      'my-none' => $this->t('Ninguno'),
      'my-sm' => $this->t('Pequeña'),
      'my-md' => $this->t('Mediana'),
      'my-lg' => $this->t('Grande'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the layout options.
   *
   * @return array[stringstring]
   *   Return Options for getDefaultContainerType
   */
  protected function getDefaultContainerType() {
    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Ninguno'),
      'container-sm' => $this->t('Contenedor pequeño'),
      'container-default' => $this->t('Contenedor predeterminado'),
      'container-lg' => $this->t('Contenedor grande'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the layout options.
   *
   * @return array[stringstring]
   *   Return Options for getDefaultContainerType
   */
  protected function getContentContainerOptions() {
    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Ninguno'),
      'content-container-sm' => $this->t('Pequeño'),
      'content-container-default' => $this->t('Predeterminado'),
      'content-container-lg' => $this->t('Grande'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the Background Color options.
   *
   * @return array[stringstring]
   *   Return Options for getContainerType
   */
  protected function getBackgroundContainer() {
    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Ninguno'),
      'bg-yellow' => $this->t('Amarillo'),
      'bg-blue' => $this->t('Azul Liberty'),
      'bg-teal' => $this->t('Teal'),
      'bg-teal-dark' => $this->t('Teal oscuro'),
      'bg-white' => $this->t('Blanco'),
      'bg-gray-dark' => $this->t('Gris oscuro'),
      'bg-lightgray' => $this->t('Gris claro'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the Background Color options.
   *
   * @return array[stringstring]
   *   Return Options for getContainerType
   */
  protected function getBackgroundColor() {
    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Ninguno'),
      'bg-yellow' => $this->t('Amarillo'),
      'bg-blue' => $this->t('Azul Liberty'),
      'bg-teal' => $this->t('Teal'),
      'bg-teal-dark' => $this->t('Teal oscuro'),
      'bg-white' => $this->t('Blanco'),
      'bg-gray-dark' => $this->t('Gris oscuro'),
      'bg-lightgray' => $this->t('Gris claro'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the Scroll Effect options.
   *
   * @return array[stringstring]
   *   Return Options for getContainerType
   */
  protected function getScrollEffect() {
    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Ninguno'),
      'fade-up' => $this->t('Fade Up'),
      'fade-down' => $this->t('Fade Down'),
      'fade-left' => $this->t('Fade Left'),
      'fade-right' => $this->t('Fade Right'),
      'fade-up-right' => $this->t('Fade Up Right'),
      'fade-up-left' => $this->t('Fade Up Left'),
      'fade-down-right' => $this->t('Fade Down Right'),
      'fade-down-left' => $this->t('Fade Left'),
      'flip-left' => $this->t('Flip Left'),
      'flip-right' => $this->t('Flip Right'),
      'flip-up' => $this->t('Flip Up'),
      'flip-down' => $this->t('Flip Down'),
      'zoom-in' => $this->t('Zoom In'),
      'zoom-in-up' => $this->t('Zoom In Up'),
      'zoom-in-down' => $this->t('Zoom In Down'),
      'zoom-in-left' => $this->t('Zoom In Left'),
      'zoom-in-right' => $this->t('Zoom In Right'),
      'zoom-out' => $this->t('Zoom Out'),
      'zoom-out-up' => $this->t('Zoom Out Up'),
      'zoom-out-down' => $this->t('Zoom Out Down'),
      'zoom-out-left' => $this->t('Zoom Out Left'),
      'zoom-out-right' => $this->t('Zoom Out Right'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the Background Color options.
   *
   * @return array[stringstring]
   *   Return Options for getContainerType
   */
  protected function getTextColor() {
    // Return the first available key from the list of options.
    $options = [
      'text-light' => $this->t('Gris (predeterminado)'),
      'text-dark' => $this->t('Gris oscuro'),
      'text-white' => $this->t('Blanco'),
      'text-white-atmosphere' => $this->t('Blanco atmósfera'),
      'text-blue' => $this->t('Azul Liberty'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the Height options.
   *
   * @return array[stringstring]
   *   Return Options for getContainerType
   */
  protected function getHeightOptions() {
    $options = [
      '' => $this->t('Predeterminado'),
      'h-100vh' => $this->t('100vh'),
      'h-80vh' => $this->t('80vh'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the align items options.
   *
   * @return array[stringstring]
   *   Return Options for getAlignItems
   */
  protected function getAlignItems() {
    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Normal'),
      'items-start' => $this->t('Start'),
      'items-end' => $this->t('End'),
      'items-center' => $this->t('Center'),
      'items-baseline' => $this->t('Baseline'),
      'items-stretch' => $this->t('Stretch'),
    ];
    return $options;
  }

  /**
   * Provides a default value for the align items options.
   *
   * @return array[stringstring]
   *   Return Options for getAlignItems
   */
  protected function getAlignmentOptions() {
    // Return the first available key from the list of options.
    $options = [
      '' => $this->t('Ninguno'),
      'alignment-left' => $this->t('Izquierda'),
      'alignment-right' => $this->t('Derecha'),
      'alignment-center' => $this->t('Centrado'),
      'alignment-justify' => $this->t('Justificado'),
    ];
    return $options;
  }

  /**
   * Gets the background image style options for the configuration form.
   *
   * @return string[]
   *   The background image style options array where the keys are strings that
   *   will be added to the CSS classes and the values are the human readable
   *   labels.
   */
  protected function getBackgroundImageStyleOptions() {
    $image_styles = ImageStyle::loadMultiple();
    $options = [
      '' => $this->t('None'),
    ];
    foreach ($image_styles as $style) {
      $options[$style->id()] = $style->label();
    }

    return $options;
  }

  /**
   * Get the default background attachment option.
   *
   * @return string
   *   Return the default background attachment option.
   */
  protected function getBackgroundAttachmentOptions() {
    $options = [
      '' => $this->t('Ninguno'),
      'bg-local' => $this->t('Local'),
      'bg-scroll' => $this->t('Scroll'),
      'bg-fixed' => $this->t('Fixed'),
    ];
    return $options;
  }

  /**
   * Get the default background position option.
   *
   * @return string
   *   Return the default background position option.
   */
  protected function getBackgroundPositionOptions() {
    $options = [
      '' => $this->t('Ninguno'),
      'bg-bottom' => $this->t('Bottom'),
      'bg-center' => $this->t('Center'),
      'bg-left' => $this->t('Left'),
      'bg-left-bottom' => $this->t('Left bottom'),
      'bg-left-top' => $this->t('Left top'),
      'bg-right' => $this->t('Right'),
      'bg-right-bottom' => $this->t('Right bottom'),
      'bg-right-top' => $this->t('Right top'),
      'bg-top' => $this->t('Top'),
    ];
    return $options;
  }

  /**
   * Get the default background size option.
   *
   * @return string
   *   Return the default background size option.
   */
  protected function getBackgroundSizeOptions() {
    $options = [
      '' => $this->t('Ninguno'),
      'bg-auto' => $this->t('Auto'),
      'bg-cover' => $this->t('Cover'),
      'bg-contain' => $this->t('Contain'),
    ];
    return $options;
  }

  /**
   * Get the default background overlay option.
   *
   * @return string
   *   Return the default background overlay option.
   */
  protected function getBackgroundOverlayOptions() {
    $options = [
      '' => $this->t('None'),
      'bg-overlay-dark-light' => $this->t('Light Dark'),
      'bg-overlay-dark' => $this->t('Dark'),
      'bg-overlay-darker' => $this->t('Darker'),
    ];

    return $options;
  }

  /**
   * Provides a default value for the Number of tabs options.
   *
   * @return array[stringstring]
   *   Return Options for getAlignItems
   */
  protected function getNumberOfTabsOptions() {
    // Return the first available key from the list of options.
    $options = [
      NULL => $this->t('Seleccionar'),
      1 => $this->t('1'),
      2 => $this->t('2'),
      3 => $this->t('3'),
      4 => $this->t('4'),
      5 => $this->t('5'),
    ];

    return $options;
  }

  /**
   * Gets the width options for the configuration form.
   *
   * The first option will be used as the default 'column_widths' configuration
   * value.
   *
   * @return string
   *   The width options array where the keys are strings that will be added to
   *   the CSS classes and the values are the human readable labels.
   */
  abstract protected function getDefaultColumnWidth();

  /**
   * Gets the width options for the configuration form.
   *
   * The first option will be used as the default 'column_widths' configuration
   * value.
   *
   * @return string[]
   *   The width options array where the keys are strings that will be added to
   *   the CSS classes and the values are the human readable labels.
   */
  abstract protected function getColumnWidthOptions();

  /**
   * Gets the Show Grid Properties  for the configuration form.
   *
   * @return bool
   *   Show Grid Properties
   */
  abstract protected function showGridProperties();

  /**
   * Columns Properties for the configuration form.
   *
   * @return string
   *   We get the columns of layouts
   */
  abstract protected function columns();

}
