<?php

namespace Drupal\li_news\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LibNewsController.
 */
class LibNewsController extends ControllerBase {

  /**
   * Drupal\li_news\Services\NewsInterface definition.
   *
   * @var \Drupal\li_news\Services\NewsInterface
   */
  protected $liNewsDefault;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->liNewsDefault = $container->get('li_news.default');
    return $instance;
  }

  /**
   * Formatdate.
   *
   * @return string
   *   Return Hello string.
   */
  public function formatDate(Request $request) {

    $body = json_decode($request->getContent());

    $timezone = drupal_get_user_timezone();
    $timezoneObject = new \DateTimeZone($timezone);
    $date = \DateTime::createFromFormat('d-m-Y G:i:s', $body->date, $timezoneObject);
    $time = $date->getTimestamp();

    $formattedDate = \Drupal::service('date.formatter')->format($time, 'custom', 'd/M/Y');

    $response = [
      'formatted_date' => $formattedDate
    ];

    return new JsonResponse($response);
  }

}
