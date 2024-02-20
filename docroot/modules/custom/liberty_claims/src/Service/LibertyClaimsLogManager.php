<?php

namespace Drupal\liberty_claims\Service;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\File\FileSystemInterface;

/**
 * Servicio para gestionar el archivo de trazas JSON.
 */
class LibertyClaimsLogManager {

  /**
   * El nombre del archivo de trazas.
   *
   * @var string
   */
  protected $nombreArchivo;

  /**
   * El sistema de archivos de Drupal.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * El constructor del servicio.
   */
  public function __construct(FileSystemInterface $file_system) {
    $this->fileSystem = $file_system;
    $this->initNombreArchivo();
  }

  /**
   * Create file.
   */
  protected function initNombreArchivo() {
    $day = new DrupalDateTime('now');
    $day = $day->format('Y-m-d');

    $this->nombreArchivo = 'public://claims_log_correo_hurto/log_correo_hurto_' . $day . '.json';
    if (!file_exists($this->fileSystem->realpath($this->nombreArchivo))) {
      $contenido_inicial = json_encode([]);
      $this->fileSystem->saveData($contenido_inicial, $this->nombreArchivo, FileSystemInterface::EXISTS_REPLACE);
    }
  }

  /**
   * Agrega una nueva traza al archivo de trazas JSON.
   *
   * @param array $data
   *   Los datos para la nueva traza.
   */
  public function agregarNuevaTraza(array $data) {
    $contenido_actual = file_get_contents($this->fileSystem->realpath($this->nombreArchivo));
    $trazas_existente = json_decode($contenido_actual, TRUE);
    $trazas_existente[] = $data;
    $nuevo_contenido = json_encode($trazas_existente);
    file_put_contents($this->fileSystem->realpath($this->nombreArchivo), $nuevo_contenido);
  }

}
