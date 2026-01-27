<?php

namespace Drupal\liberty_claims\Controller;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LoggerReportController.
 */
class LoggerReportController extends ControllerBase
{

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container)
  {
    $instance = parent::create($container);
    $instance->database = $container->get('database');
    return $instance;
  }

  /**
   * Report.
   *
   * @return array
   *   Return Hello string.
   */
  public function report(Request $request)
  {
    $private_file_path = \Drupal::service('settings')->get('file_private_path', '/private');
    $path = $private_file_path . '/claims_logs/';

    $output = [];
    $header = [
      'logs' => 'Logs',
      'link' => 'Descarga',
    ];

    $file_list = array_diff(scandir($path, 1), ['..', '.']);

    foreach ($file_list as $file) {
      $url = $path . $file;

      $output[] = [
        'plate' => $file,
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

  /**
   * Log detail controller.
   *
   * @param string $token
   *   Token primary key.
   * @param string $option
   *   Option to render.
   *
   * @return array
   *   Output of option.
   */
  public function detail($token, $option)
  {
    $query = $this->database->select('liberty_log', 'l');
    $query->fields('l', [$option])->condition('token', $token);
    $result = $query->execute()->fetchAll();
    $result = reset($result);

    $output['json'] = [
      '#type' => 'textarea',
      '#cols' => 30,
      '#rows' => 30,
      '#value' => json_encode(json_decode($result->$option), JSON_PRETTY_PRINT),
    ];
    
    return $output;
  }

}
