<?php

namespace Drupal\liberty_claims\Controller;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for liberty Claims routes.
 */
class LoggerReportHurtoController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The file system service.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The file URL generator service.
   *
   * @var \Drupal\Core\File\FileUrlGeneratorInterface
   */
  protected $fileUrlGenerator;

  /**
   * Constructs a new LoggerReportHurtoController object.
   *
   * @param \Drupal\Core\File\FileSystemInterface $file_system
   *   The file system service.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   * @param \Drupal\Core\File\FileUrlGeneratorInterface $file_url_generator
   *   The file URL generator service.
   */
  public function __construct(FileSystemInterface $file_system, ConfigFactoryInterface $config_factory, FileUrlGeneratorInterface $file_url_generator) {
    $this->fileSystem = $file_system;
    $this->configFactory = $config_factory;
    $this->fileUrlGenerator = $file_url_generator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('file_system'),
      $container->get('config.factory'),
      $container->get('file_url_generator')
    );
  }

  /**
   * Builds the response.
   */
  public function build() {
    $file_default_scheme = $this->configFactory->get('system.file')->get('default_scheme');
    $directory = $file_default_scheme . "://claims_log_correo_hurto";

    $output = [];
    $header = [
      'logs' => 'Logs',
      'link' => 'Descarga',
    ];
    $this->fileSystem->prepareDirectory($directory, FileSystemInterface::CREATE_DIRECTORY);
    $files = $this->fileSystem->scanDirectory($directory, '/.*/', ['key' => 'name']);
    uksort($files, function ($a, $b) {
      $dateA = substr($a, -10);
      $dateB = substr($b, -10);
      return strtotime($dateB) - strtotime($dateA);
    });

    foreach ($files as $file) {
      $url = $this->fileUrlGenerator->generateAbsoluteString($directory . '/' . $file->filename);

      $output[] = [
        'plate' => $file->filename,
        'link' => new FormattableMarkup(
            '<a  href=":link" target="_blank" rel="noreferrer" download>Descarga</a>',
            [
              ':link' => $url,
            ]
        ),
      ];
    }

    $form['table'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $output,
      '#empty' => $this->t('No logs found'),
    ];

    return $form;
  }

}
