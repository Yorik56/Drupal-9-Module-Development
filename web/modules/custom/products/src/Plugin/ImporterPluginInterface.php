<?php

namespace Drupal\products\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\products\Entity\ImporterInterface;


/**
 * Defines an interface for Importer plugins.
 */
interface ImporterPluginInterface extends PluginInspectionInterface {

	/**
	 * Performs the import.
	 *
	 * @return bool
	 *   Whether the import was successful.
	 */
	public function import(): bool;

	/**
	 * Returns the Importer configuration entity.
	 *
	 * @return ImporterInterface
	 *   The importer config entity used by this plugin.
	 */
	public function getConfig(): ImporterInterface;

}
