<?php
/**
 * @file
 * Contains Drupal\views_slideshow\ViewsSlideshowSkinPluginManager.
 */

namespace Drupal\views_slideshow;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Class ViewsSlideshowSkinPluginManager
 * @package Drupal\views_slidehsow
 */
class ViewsSlideshowSkinPluginManager extends DefaultPluginManager {

  /**
   * Constructs a new ViewsSlideshowSkinPluginManager.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/ViewsSlideshowSkin', $namespaces, $module_handler, 'Drupal\views_slideshow\ViewsSlideshowSkinInterface', 'Drupal\views_slideshow\Annotation\ViewsSlideshowSkin');

    $this->alterInfo('views_slideshow_skin_info');
    $this->setCacheBackend($cache_backend, 'views_slideshow_skin');
  }
}