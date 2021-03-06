<?php

/**
 * @file
 * Contains \Drupal\Core\Cache\Context\UrlCacheContext.
 */

namespace Drupal\securelogin;

use Drupal\Core\Cache\Context\UrlCacheContext;
use Drupal\Core\Url;

/**
 * Defines the SecureLoginCacheContext service for "per request URL" caching.
 *
 * Cache context ID: 'securelogin'.
 */
class SecureLoginCacheContext extends UrlCacheContext {

  /**
   * {@inheritdoc}
   */
  public static function getLabel() {
    return t('Secure login');
  }

  /**
   * {@inheritdoc}
   */
  public function getContext() {
    return $this->requestStack->getMasterRequest()->getUri();
  }

}
