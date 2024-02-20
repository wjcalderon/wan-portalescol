<?php

namespace Drupal\lib_core\Plugin\facets\processor;

<<<<<<< HEAD
use Drupal\Core\Form\FormStateInterface;
use Drupal\facets\FacetInterface;
use Drupal\facets\Processor\BuildProcessorInterface;
use Drupal\facets\Processor\ProcessorPluginBase;
=======
use Drupal\facets\FacetInterface;
use Drupal\facets\Processor\BuildProcessorInterface;
use Drupal\facets\Processor\ProcessorPluginBase;

>>>>>>> main
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
<<<<<<< HEAD
      $display = ''; 
=======
      $display = '';
>>>>>>> main
      switch ($result->getRawValue()) {
        case 'lender':
          $display = 'Prestador de salud';
          break;
<<<<<<< HEAD
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
=======

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

>>>>>>> main
        case 'document':
          $display = 'Documento';
          break;
      }
      if (!empty($display)) {
<<<<<<< HEAD
        $result->setDisplayValue($display);  
=======
        $result->setDisplayValue($display);
>>>>>>> main
      }
    }
    return $results;
  }
<<<<<<< HEAD
}
=======

}
>>>>>>> main
