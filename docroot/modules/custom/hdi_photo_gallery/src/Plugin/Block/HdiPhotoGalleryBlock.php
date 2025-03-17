<?php

namespace Drupal\hdi_photo_gallery\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\File\FileUrlGenerator;
use Drupal\Core\File\FileSystem;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\image\Entity\ImageStyle;

/**
 * Provides a 'HdiPhotoGalleryBlock' block.
 *
 * @Block(
 *   id = "hdi_photo_gallery_block",
 *   admin_label = @Translation("HDI Photo Gallery Block"),
 *   category = @Translation("Custom")
 * )
 */
class HdiPhotoGalleryBlock extends BlockBase implements
  ContainerFactoryPluginInterface
{
  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * File URL generator service
   *
   * @var \Drupal\Core\File\FileUrlGenerator
   */
  protected $fileUrlGenerator;

  /**
   * File system service
   *
   * @var \Drupal\Core\File\FileSystem
   */
  protected $fileSystem;

  /**
   * {@inheritdoc}
   */
  public static function create(
    ContainerInterface $container,
    array $configuration,
    $plugin_id,
    $plugin_definition
  ): HdiPhotoGalleryBlock {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->entityTypeManager = $container->get("entity_type.manager");
    $instance->fileUrlGenerator = $container->get("file_url_generator");
    $instance->fileSystem = $container->get("file_system");
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array
  {
    $media_items = $this->entityTypeManager
      ->getStorage("media")
      ->loadByProperties(["bundle" => "photo_gallery"]);
    $images = [];

    if (empty($media_items)) {
      return [
        "#markup" => "No se encontraron elementos de galería.",
      ];
    }

    foreach ($media_items as $media) {
      $images_list = $media->get("field_photo_gallery")->getvalue();

      foreach ($images_list as $image) {
        $photo = $this->entityTypeManager
          ->getStorage("media")
          ->load($image["target_id"]);

        $photo_array = $photo->toArray();

        $file = $this->entityTypeManager
          ->getStorage("file")
          ->load($photo_array["image"][0]["target_id"]);

        if ($file instanceof \Drupal\file\Entity\File) {
          $file_uri = $file->getFileUri();
          $file_url = $this->fileUrlGenerator->generateAbsoluteString(
            $file_uri
          );
          $file_name = $this->fileSystem->basename($file_uri);

          $thumbnail = ImageStyle::load("medium")->buildUrl($file_uri);
          $large = ImageStyle::load("banner_768x600")->buildUrl($file_uri);

          $images[] = [
            "url" => $file_url,
            "name" => $file_name,
            "alt" => $photo_array["image"][0]["alt"] ?? $file_name,
            "thumbnail" => $thumbnail,
            "large" => $large,
          ];
        }
      }
    }

    if (empty($images)) {
      return [
        "#markup" => "No se pudieron encontrar imágenes válidas.",
      ];
    }

    return [
      "#theme" => "photo_gallery",
      "#images" => $images,
      "#attached" => [
        "library" => ["hdi_photo_gallery/zooming"],
      ],
    ];
  }
}
