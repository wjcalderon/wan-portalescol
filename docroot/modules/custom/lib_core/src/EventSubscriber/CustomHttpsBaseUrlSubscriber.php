<?php

namespace Drupal\lib_core\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Event subscriber to override the base URL with HTTPS.
 */
class CustomHttpsBaseUrlSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['onKernelRequest', 100];
    return $events;
  }

  /**
   * Modifies the base URL to always use HTTPS.
   *
   * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
   *   The event object.
   */
  public function onKernelRequest(RequestEvent $event) {
    $request = $event->getRequest();
    $request->server->set('HTTPS', 'on');
    $request->server->set('SERVER_PORT', 443);
    $GLOBALS['base_url'] = 'https://' . $_SERVER['HTTP_HOST'];
  }

}
