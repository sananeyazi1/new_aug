<?php

namespace Drupal\simpleads;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * SimpleAdsType plugin manager.
 *
 * @package Drupal\simpleads
 */
class SimpleAdsTypeManager extends DefaultPluginManager {

  /**
   * Constructs an SimpleAdsTypeManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations,
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/SimpleAds/Type', $namespaces, $module_handler, 'Drupal\simpleads\SimpleAdsTypeInterface', 'Drupal\simpleads\Annotation\SimpleAdsType');
    $this->alterInfo('simpleads_type_info');
    $this->setCacheBackend($cache_backend, 'simpleads_type');
  }

}
