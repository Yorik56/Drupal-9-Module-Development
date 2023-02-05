<?php

namespace Drupal\products\Plugin;

use Drupal\Component\Plugin\Exception\PluginException;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\products\Entity\ImporterInterface;
use Traversable;

/**
 * Provides the Importer plugin manager.
 */
class ImporterManager extends DefaultPluginManager
{

	/**
	 * @var EntityTypeManagerInterface
	 */
	protected EntityTypeManagerInterface $entityTypeManager;

	/**
	 * Constructs a new ImporterManager object.
	 *
	 * @param Traversable $namespaces
	 *   An object that implements \Traversable which contains the root paths
	 *   keyed by the corresponding namespace to look for plugin implementations.
	 * @param CacheBackendInterface $cache_backend
	 *   Cache backend instance to use.
	 * @param ModuleHandlerInterface $module_handler
	 *   The module handler to invoke the alter hook with.
	 */
	public function __construct(Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler, EntityTypeManagerInterface $entity_type_manager)
	{
		parent::__construct('Plugin/Importer', $namespaces, $module_handler, 'Drupal\products\Plugin\ImporterPluginInterface', 'Drupal\products\Annotation\Importer');

		$this->alterInfo('products_importer_info');
		$this->setCacheBackend($cache_backend, 'products_importer_plugins');
		$this->entityTypeManager = $entity_type_manager;
	}

	/**
	 * Creates a plugin instance from a given Importer config.
	 *
	 * @param string $id
	 *   Configuration entity ID.
	 *
	 * @return object|null
	 *   The plugin.
	 * @throws PluginException
	 */
	public function createInstanceFromConfig(string $id): ?object
	{
		$config = $this->entityTypeManager->getStorage('importer')->load($id);
		if (!$config instanceof ImporterInterface) {
			return NULL;
		}

		return $this->createInstance($config->getPluginId(), ['config' => $config]);
	}

	/**
	 * Creates plugin instances from all the available Importer configs.
	 *
	 * @return array
	 *   An array of instantiated plugins.
	 * @throws PluginException
	 */
	public function createInstanceFromAllConfigs(): array
	{
		$configs = $this->entityTypeManager->getStorage('importer')->loadMultiple();
		if (!$configs) {
			return [];
		}
		$plugins = [];
		foreach ($configs as $config) {
			$plugin = $this->createInstanceFromConfig($config->id());
			if (!$plugin) {
				continue;
			}
			$plugins[] = $plugin;
		}

		return $plugins;
	}

}
