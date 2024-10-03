<?php

namespace Drupal\esn_layouts\EventSubscriber;

use Drupal\Core\Ajax\AjaxHelperTrait;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ExtensionPathResolver;
use Drupal\Core\File\FileUrlGenerator;
use Drupal\Core\Render\Element;
use Drupal\Core\Render\Markup;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Url;
use Drupal\layout_builder\SectionStorageInterface;
use Drupal\section_library\Entity\SectionLibraryTemplate;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class LayoutBuilderBrowserEventSubscriber.
 *
 * Add layout builder css class layout-builder-browser.
 */
class LayoutBuilderBrowserEventSubscriber implements EventSubscriberInterface {
  use StringTranslationTrait;
  use AjaxHelperTrait;

  /**
   * Path resolver.
   *
   * @var \Drupal\Core\Extension\ExtensionPathResolver
   */
  private $pathResolver;

  /**
   * File url generator.
   *
   * @var \Drupal\Core\File\FileUrlGenerator
   */
  private $fileUrlGenerator;

  /**
   * The storage handler class for files.
   *
   * @var \Drupal\file\FileStorage
   */
  private $fileStorage;

  /**
   * Constructor.
   *
   * @param \Drupal\Core\Extension\ExtensionPathResolver $path_resolver
   *   Path resolver.
   * @param \Drupal\Core\File\FileUrlGenerator $file_url_generator
   *   File url generator.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity
   *   The Entity type manager service.
   */
  public function __construct(
    ExtensionPathResolver $path_resolver,
    FileUrlGenerator $file_url_generator,
    EntityTypeManagerInterface $entity,
  ) {
    $this->pathResolver = $path_resolver;
    $this->fileUrlGenerator = $file_url_generator;
    $this->fileStorage = $entity->getStorage('file');
  }

  /**
   * Add layout-builder-browser class layout_builder.choose_block build block.
   */
  public function onView(ViewEvent $event) {
    $request = $event->getRequest();
    $route = $request->attributes->get('_route');

    if ($route == 'layout_builder.choose_block') {
      $build = $event->getControllerResult();
      $build['#attached']['library'][] = 'esn_layouts/core';

      if (is_array($build) && !isset($build['add_block'])) {
        $build = $this->modifyBlockCategories($build);
        $event->setControllerResult($build);
      }
    }
  }

  /**
   * Function custom.
   */
  private function modifyBlockCategories(array $build): array {
    $build['block_categories']['#type'] = 'horizontal_tabs';

    foreach (Element::children($build['block_categories']) as $child) {
      $this->modifyLinks($build['block_categories'][$child]['links']);
    }

    $this->removeUnwantedAttributes($build);

    return $build;
  }

  /**
   * Function custom.
   */
  private function modifyLinks(array &$links): void {
    foreach (Element::children($links) as $link_id) {
      $link = &$links[$link_id];
      $this->updateLinkAttributes($link);
    }
  }

  /**
   * Function custom.
   */
  private function updateLinkAttributes(array &$link): void {
    $link['#attributes']['class'][] = 'ws-lb-link';
    $link['#title']['image']['#theme'] = 'esn_layouts_icon';
    $link['#title']['image']['#icon_type'] = 'block';
    $link['#title']['label']['#markup'] = '<div class="ws-lb-link__label">' .
        $link['#title']['label']['#markup'] . '</div>';

    $this->removeUnwantedClass($link);
  }

  /**
   * Function custom.
   */
  private function removeUnwantedClass(array &$element): void {
    $class_key = array_search('layout-builder-browser-block-item', $element['#attributes']['class']);
    if ($class_key !== FALSE) {
      unset($element['#attributes']['class'][$class_key]);
    }
  }

  /**
   * Function custom.
   */
  private function removeUnwantedAttributes(array &$build): void {
    $class_key = array_search('layout-builder-browser', $build['block_categories']['#attributes']['class']);
    if ($class_key !== FALSE) {
      unset($build['block_categories']['#attributes']['class'][$class_key]);
    }

    $build['block_categories']['#attributes']['class'][] = 'ws-lb';
  }

  /**
   * Gets a render array of section links.
   *
   * @param \Drupal\layout_builder\SectionStorageInterface $section_storage
   *   The section storage.
   * @param int $delta
   *   The region the section is going in.
   *
   * @return array
   *   The section links render array.
   */
  protected function getLibrarySectionLinks(
    SectionStorageInterface $section_storage,
    $delta,
  ) {
    $sections = SectionLibraryTemplate::loadMultiple();
    $links = [];
    foreach ($sections as $section_id => $section) {
      $attributes = $this->getAjaxAttributes();
      $attributes['class'][] = 'js-layout-builder-section-library-link';
      $attributes['class'][] = 'ws-lb-link';
      // Default library image.
      $img_path = $this->pathResolver->getPath('module', 'esn_layouts') .
        '/images/section-empty-icon.svg';
      if ($fid = $section->get('image')->target_id) {
        $file = $this->fileStorage->load($fid);
        $img_path = $file->getFileUri();
      }

      $icon_url = $this->fileUrlGenerator->transformRelative(
        $this->fileUrlGenerator->generateAbsoluteString($img_path)
      );
      $link = [
        '#type' => 'link',
        '#title' => Markup::create(
          '<div class="ws-lb__icon"><img src="' .
            $icon_url .
            '" class="section-library-link-img" /> </div>' .
            '<div class="ws-lb-link__label">' .
            $section->label() .
          '</div>'
        ),
        '#url' => Url::fromRoute(
          'section_library.import_section_from_library',
          [
            'section_library_id' => $section_id,
            'section_storage_type' => $section_storage->getStorageType(),
            'section_storage' => $section_storage->getStorageId(),
            'delta' => $delta,
          ]
        ),
        '#attributes' => $attributes,
      ];

      $links[] = $link;
    }
    return $links;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::VIEW][] = ['onView', 45];
    return $events;
  }

  /**
   * Get dialog attributes if an ajax request.
   *
   * @return array
   *   The attributes array.
   */
  protected function getAjaxAttributes() {
    if ($this->isAjax()) {
      return [
        'class' => ['use-ajax'],
        'data-dialog-type' => 'dialog',
        'data-dialog-renderer' => 'off_canvas',
      ];
    }
    return [];
  }

}
