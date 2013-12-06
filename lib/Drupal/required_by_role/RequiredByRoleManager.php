<?php

/**
 * @file
 * Contains \Drupal\required_by_role\RequiredByRoleManager.
 */

namespace Drupal\required_by_role;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Language\LanguageManager;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Manages required by role plugins.
 */
class RequiredByRoleManager extends DefaultPluginManager {

  /**
   * {@inheritdoc}
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, LanguageManager $language_manager, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/RequiredByRole', $namespaces, 'Drupal\required_by_role\Annotation\RequiredByRole');

    $this->alterInfo($module_handler, 'required_by_role_info');
    $this->setCacheBackend($cache_backend, $language_manager, 'required_by_role_plugins');
  }

  /**
   * {@inheritdoc}
   */
  public function getDefinition($plugin_id) {

    $definition = parent::getDefinition($plugin_id);

    if(empty($definition)){
      $definition = $this->definitions['default'];
    }

    return $definition;
  }

  /**
   * Overrides PluginManagerBase::getInstance().
   *
   */
  public function getInstance(array $options) {

    $plugin_id = $options['plugin_id'];

    return $this->createInstance($plugin_id, $options['field']);
  }

}
