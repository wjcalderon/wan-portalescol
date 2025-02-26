<?php

namespace Drupal\strategic_dialogue_gallery\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'StrategicDialogueGalleryBlock' block.
 *
 * @Block(
 *   id = "strategic_dialogue_gallery_block",
 *   admin_label = @Translation("Strategic Dialogue Gallery Block"),
 *   category = @Translation("Custom")
 * )
 */
class StrategicDialogueGalleryBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $media_items = \Drupal::entityTypeManager()->getStorage('media')
      ->loadByProperties(['bundle' => 'imagen_strategic_dialogue']);

    if (!empty($media_items)) {
      $images = [];

      foreach ($media_items as $media) {

        $file = $media->get('field_media_image')->entity;

        if ($file instanceof \Drupal\file\Entity\File) {
          $file_uri = $file->getFileUri();
          $file_url = \Drupal::service('file_url_generator')->generateAbsoluteString($file_uri);
          $file_name = \Drupal::service('file_system')->basename($file_uri);
          $images[] = [
            'url' => $file_url,
            'name' => $file_name,
          ];
        }
      }

      if (!empty($images)) {
        return [
          '#theme' => 'strategic_dialogue_gallery_block',
          '#images' => $images,
          '#attached' => [
            'library' => [
              'strategic_dialogue_gallery/slick_carousel',
            ],
          ],
        ];
      }
      else {
        return [
          '#markup' => 'No se pudieron encontrar imágenes válidas.',
        ];
      }
    }
    else {
      return [
        '#markup' => 'No se encontraron elementos de galería.',
      ];
    }
  }
}
