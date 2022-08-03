<?php
	namespace Drupal\hello_world;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Config\ConfigFactoryOverrideInterface;
use Drupal\Core\Config\StorageInterface;

/**
 * Overrides configuration for the hello_world module.
 */
class HelloWorldConfigOverrides implements ConfigFactoryOverrideInterface {

	/**
	 * {@inheritdoc}
	 */
	public function loadOverrides($names): array
	{
		$overrides = [];

		if (in_array('system.maintenance', $names)) {
			$overrides['system.maintenance'] = [
				'message' => 'Our own message for the site maintenance mode.'
			];
		}

		return $overrides;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCacheSuffix(): string {
		return 'HelloWorldConfigOverrider';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCacheableMetadata($name): CacheableMetadata {
		return new CacheableMetadata();
	}

	/**
	 * {@inheritdoc}
	 */
	public function createConfigObject($name, $collection = StorageInterface::DEFAULT_COLLECTION) {
		return NULL;
	}
}
