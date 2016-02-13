<?php

/**
 * @file
 * Definition of Drupal\securelogin\Tests\SecureLoginTest.
 */

namespace Drupal\securelogin\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Base class for Secure login module tests.
 *
 * @group Secure login
 */
abstract class SecureLoginTestBase extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['securelogin'];

  /**
   * Builds a URL for submitting a mock HTTPS request to HTTP test environments.
   */
  protected function httpsUrl($url) {
    return 'core/modules/system/tests/https.php/' . $url;
  }

  /**
   * Builds a URL for submitting a mock HTTP request to HTTPS test environments.
   */
  protected function httpUrl($url) {
    return 'core/modules/system/tests/http.php/' . $url;
  }

}
