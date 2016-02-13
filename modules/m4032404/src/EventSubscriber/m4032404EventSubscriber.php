<?php

/**
 * @file
 * Contains \Drupal\m4032404\EventSubscriber.
 */

namespace Drupal\m4032404\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Provides a subscriber to set the properly exception.
 *
 * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event
 *   The event exception to process.
 */
class m4032404EventSubscriber implements EventSubscriberInterface {

  /**
   * Set the properly exception for event.
   */
  public function onAccessDeniedException(GetResponseForExceptionEvent $event) {
    if ($event->getException() instanceof AccessDeniedHttpException) {
      $admin_only = \Drupal::config('m4032404.settings')->get('admin_only');

      $route = \Drupal::routeMatch()->getRouteObject();
      $is_admin = \Drupal::service('router.admin_context')->isAdminRoute($route);

      if ($admin_only && !$is_admin) {
        // @todo revisit this when r4032login is ready for 8.x.
        if (function_exists('r4032login_redirect')) {
          return r4032login_redirect();
        }
      }
      else {
        $event->setException(new NotFoundHttpException);
      }
    }
  }

  /**
   * Registers the methods in this class that should be listeners.
   *
   * @return array
   *   An array of event listener definitions.
   */
  static function getSubscribedEvents(){
    $events[KernelEvents::EXCEPTION][] = array('onAccessDeniedException', 50);
    return $events;
  }
}
