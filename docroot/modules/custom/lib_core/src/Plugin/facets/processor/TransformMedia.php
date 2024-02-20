<?php

namespace Drupal\lib_core\Plugin\facets\processor;

use Drupal\facets\FacetInterface;
use Drupal\facets\Processor\BuildProcessorInterface;
use Drupal\facets\Processor\ProcessorPluginBase;

/**
 * Provides a processor for TransformMedia.
 *
 * @FacetsProcessor(
 *   id = "transform_media",
 *   label = @Translation("TransformMedia"),
 *   description = @Translation("Transform media labels"),
 *   stages = {
 *     "build" = 35
 *   }
 * )
 */
class TransformMedia extends ProcessorPluginBase implements BuildProcessorInterface {

  /**
   * {@inheritdoc}
   */
  public function build(FacetInterface $facet, array $results) {
    $config = $this->getConfiguration();
    /** @var \Drupal\facets\Result\Result $result */
    foreach ($results as $result) {
      $display = '';
      switch ($result->getRawValue()) {
        case 'lender':
          $display = 'Prestador de salud';
          break;

        case 'landing_page':
          $display = 'Pagina de entrada';
          break;

        case 'office':
          $display = 'Sucursales';
          break;

        case 'product':
          $display = 'Productos';
          break;

        case 'page':
          $display = 'Pagina basica';
          break;

        case 'faq':
          $display = 'Preguntas frecuentes';
          break;

        case 'document':
          $display = 'Documento';
          break;
      }
      if (!empty($display)) {
        $result->setDisplayValue($display);
      }
    }
    return $results;
  }

}
