<?php

namespace Drupal\lib_login_corredores\Middleware;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Custom Login Middleware.
 */
class CustomLoginMiddleware implements HttpKernelInterface, EventSubscriberInterface {

  /**
   * HttpKernel variable.
   *
   * @var array
   */
  protected $httpKernel;

  /**
   * Constuct persistent.
   */
  public function __construct(HttpKernelInterface $http_kernel) {
    $this->httpKernel = $http_kernel;
  }

  /**
   * Handle custom login middleware.
   */
  public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = TRUE) {
    if (strpos($request->getPathInfo(), '/blog') !== FALSE) {
      if (!$request->hasSession() || !$request->getSession()->isStarted()) {
        if (strpos($request->getPathInfo(), '/blog/login') === FALSE) {
          return new RedirectResponse('/blog/login');
        }
      }
    }

    return $this->httpKernel->handle($request, $type, $catch);
  }

  /**
   * Get Subscribed Events.
   */
  public static function getSubscribedEvents() {
    return [KernelEvents::REQUEST => 'onKernelRequest'];
  }

  /**
   * On Kernel Request.
   */
  public function onKernelRequest($event) {
    $request = $event->getRequest();

    if (strpos($request->getPathInfo(), '/blog') !== FALSE) {
      $response = $this->handle($request);
      $event->setResponse($response);
    }
  }

}
