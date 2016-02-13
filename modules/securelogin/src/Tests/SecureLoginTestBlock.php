<?php

/**
 * @file
 * Definition of Drupal\securelogin\Tests\SecureLoginTest.
 */

namespace Drupal\securelogin\Tests;

use Drupal\Core\Extension\ExtensionDiscovery;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tests Secure login with user login block enabled.
 *
 * @group Secure login
 */
class SecureLoginTestBlock extends SecureLoginTestBase {

  /**
   * Use a profile that disables the cache modules.
   */
  protected $profile = 'testing_config_import';

  public static $modules = ['block', 'node', 'views'];

  /**
   * A user with the 'administer blocks' permission.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $adminUser;

  /**
   * Boolean true if the test environment is HTTPS.
   */
  protected $isSecure;

  protected function setUp() {
    parent::setUp();

    $this->adminUser = $this->drupalCreateUser(['administer blocks', 'administer site configuration']);
    $this->isSecure = Request::createFromGlobals()->isSecure();

    if (!$this->isSecure) {
      $this->disableModules(['securelogin']);
    }

    $this->drupalLogin($this->adminUser);
    $this->drupalPlaceBlock('user_login_block');
    $this->drupalLogout($this->adminUser);

    if (!$this->isSecure) {
      $this->enableModules(['securelogin']);
    }
  }

  /**
   * Enables modules for this test.
   */
  protected function enableModules(array $modules) {
    // Perform an ExtensionDiscovery scan as this function may receive a
    // profile that is not the current profile, and we don't yet have a cached
    // way to receive inactive profile information.
    // @todo Remove as part of https://www.drupal.org/node/2186491
    $listing = new ExtensionDiscovery(\Drupal::root());
    $module_list = $listing->scan('module');
    // In ModuleHandlerTest we pass in a profile as if it were a module.
    $module_list += $listing->scan('profile');

    // Set the list of modules in the extension handler.
    $module_handler = $this->container->get('module_handler');

    // Write directly to active storage to avoid early instantiation of
    // the event dispatcher which can prevent modules from registering events.
    $active_storage = $this->container->get('config.storage');
    $extension_config = $active_storage->read('core.extension');

    foreach ($modules as $module) {
      if ($module_handler->moduleExists($module)) {
        throw new \LogicException("$module module is already enabled.");
      }
      $module_handler->addModule($module, $module_list[$module]->getPath());
      // Maintain the list of enabled modules in configuration.
      $extension_config['module'][$module] = 0;
    }
    $active_storage->write('core.extension', $extension_config);

    // Update the kernel to make their services available.
    $extensions = $module_handler->getModuleList();
    $this->container->get('kernel')->updateModules($extensions, $extensions);

    // Ensure isLoaded() is TRUE in order to make
    // \Drupal\Core\Theme\ThemeManagerInterface::render() work.
    // Note that the kernel has rebuilt the container; this $module_handler is
    // no longer the $module_handler instance from above.
    $module_handler = $this->container->get('module_handler');
    $module_handler->reload();
    foreach ($modules as $module) {
      if (!$module_handler->moduleExists($module)) {
        throw new \RuntimeException("$module module is not enabled after enabling it.");
      }
    }
  }

  /**
   * Disables modules for this test.
   */
  protected function disableModules(array $modules) {
    // Unset the list of modules in the extension handler.
    $module_handler = $this->container->get('module_handler');
    $module_filenames = $module_handler->getModuleList();
    $extension_config = $this->config('core.extension');
    foreach ($modules as $module) {
      if (!$module_handler->moduleExists($module)) {
        throw new \LogicException("$module module cannot be disabled because it is not enabled.");
      }
      unset($module_filenames[$module]);
      $extension_config->clear('module.' . $module);
    }
    $extension_config->save();
    $module_handler->setModuleList($module_filenames);
    $module_handler->resetImplementations();
    // Update the kernel to remove their services.
    $this->container->get('kernel')->updateModules($module_filenames, $module_filenames);

    // Ensure isLoaded() is TRUE in order to make _theme() work.
    // Note that the kernel has rebuilt the container; this $module_handler is
    // no longer the $module_handler instance from above.
    $module_handler = $this->container->get('module_handler');
    $module_handler->reload();
    foreach ($modules as $module) {
      if ($module_handler->moduleExists($module)) {
        throw new \RuntimeException("$module module is not disabled after disabling it.");
      }
    }
  }

  protected function testUserLoginBlock() {
    global $base_url;
    global $base_path;

    // Disable redirect following.
    $maximum_redirects = $this->maximumRedirects;
    $this->maximumRedirects = 0;

    $this->drupalGet($this->httpUrl('node'));
    $headers = $this->drupalGetHeaders(TRUE);
    $this->assertTrue(strpos($headers[0][':status'], '301'), 'Status header contains 301.');
    $this->assertIdentical($headers[0]['location'], str_replace('http://', 'https://', $base_url) . '/index.php/node', 'Location header uses the secure base URL.');

    // Fetch the same URL again as it may be cached.
    $this->drupalGet($this->httpUrl('node'));
    $headers = $this->drupalGetHeaders(TRUE);
    $this->assertTrue(strpos($headers[0][':status'], '301'), 'Status header contains 301.');
    $this->assertIdentical($headers[0]['location'], str_replace('http://', 'https://', $base_url) . '/index.php/node', 'Location header uses the secure base URL.');

    $this->drupalGet($this->httpUrl('admin'));
    $headers = $this->drupalGetHeaders(TRUE);
    $this->assertTrue(strpos($headers[0][':status'], '301'), 'Status header contains 301.');
    $this->assertIdentical($headers[0]['location'], str_replace('http://', 'https://', $base_url) . '/index.php/admin', 'Location header uses the secure base URL.');

    $this->drupalGet($this->httpUrl('admin/config'));
    $headers = $this->drupalGetHeaders(TRUE);
    $this->assertTrue(strpos($headers[0][':status'], '301'), 'Status header contains 301.');
    $this->assertIdentical($headers[0]['location'], str_replace('http://', 'https://', $base_url) . '/index.php/admin/config', 'Location header uses the secure base URL.');

    $this->drupalGet($this->httpUrl('no-page-by-this-name'));
    $headers = $this->drupalGetHeaders(TRUE);
    $this->assertTrue(strpos($headers[0][':status'], '301'), 'Status header contains 301.');
    $this->assertIdentical($headers[0]['location'], str_replace('http://', 'https://', $base_url) . '/index.php/no-page-by-this-name', 'Location header uses the secure base URL.');

    $this->drupalGet($this->httpUrl('nor-this-one'));
    $headers = $this->drupalGetHeaders(TRUE);
    $this->assertTrue(strpos($headers[0][':status'], '301'), 'Status header contains 301.');
    $this->assertIdentical($headers[0]['location'], str_replace('http://', 'https://', $base_url) . '/index.php/nor-this-one', 'Location header uses the secure base URL.');

    $config = $this->config('securelogin.settings');
    $this->assertTrue($config->get('secure_forms'), 'Secure forms settings is enabled by default.');

    // Disable secure forms.
    if ($this->isSecure) {
      $this->drupalLogin($this->adminUser);
      $edit['secure_forms'] = FALSE;
      $this->drupalPostForm('admin/config/people/securelogin', $edit, t('Save configuration'));
      $config = $this->config('securelogin.settings');
      $this->assertFalse($config->get('secure_forms'), 'Secure forms is disabled.');
      $this->drupalGet('user/logout');
    }
    else {
      $this->config('securelogin.settings')->set('secure_forms', FALSE)->save();
      drupal_flush_all_caches();
    }

    $this->drupalGet($this->httpUrl('node'));
    $headers = $this->drupalGetHeaders(TRUE);
    $this->assertTrue(strpos($headers[0][':status'], '200'), 'Status header contains 200.');
    $this->assertFieldByXPath('//form/@action', str_replace('http://', 'https://', $base_url) . "/index.php/node?destination={$base_path}index.php/node", 'The action attribute uses the secure base URL.');

    $this->drupalGet($this->httpUrl('admin'));
    $headers = $this->drupalGetHeaders(TRUE);
    $this->assertTrue(strpos($headers[0][':status'], '403'), 'Status header contains 403.');
    $this->assertFieldByXPath('//form/@action', str_replace('http://', 'https://', $base_url) . "/index.php/system/403?destination={$base_path}index.php/admin", 'The action attribute uses the secure base URL.');

    $this->drupalGet($this->httpUrl('admin/config'));
    $headers = $this->drupalGetHeaders(TRUE);
    $this->assertTrue(strpos($headers[0][':status'], '403'), 'Status header contains 403.');
    $this->assertFieldByXPath('//form/@action', str_replace('http://', 'https://', $base_url) . "/index.php/system/403?destination={$base_path}index.php/admin/config", 'The action attribute uses the secure base URL.');

    $this->drupalGet($this->httpUrl('no-page-by-this-name'));
    $headers = $this->drupalGetHeaders(TRUE);
    $this->assertTrue(strpos($headers[0][':status'], '404'), 'Status header contains 404.');
    $this->assertFieldByXPath('//form/@action', str_replace('http://', 'https://', $base_url) . "/index.php/system/404?destination={$base_path}index.php/", 'The action attribute uses the secure base URL.');

    $this->drupalGet($this->httpUrl('nor-this-one'));
    $headers = $this->drupalGetHeaders(TRUE);
    $this->assertTrue(strpos($headers[0][':status'], '404'), 'Status header contains 404.');
    $this->assertFieldByXPath('//form/@action', str_replace('http://', 'https://', $base_url) . "/index.php/system/404?destination={$base_path}index.php/", 'The action attribute uses the secure base URL.');

    $this->maximumRedirects = $maximum_redirects;
  }

}
