<?php

/**
 * @file
 * Definition of Drupal\securelogin\Tests\SecureLoginTestBlockCache.
 */

namespace Drupal\securelogin\Tests;

use Drupal\Core\Extension\ExtensionDiscovery;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tests Secure login with user login block enabled.
 *
 * @group Secure login
 */
class SecureLoginTestBlockCache extends SecureLoginTestBlock {

  /**
   * Use a profile that enables the cache modules.
   */
  protected $profile = 'testing';

}
