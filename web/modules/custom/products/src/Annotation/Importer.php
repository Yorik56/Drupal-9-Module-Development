<?php

namespace Drupal\products\Annotation;

use Drupal\Component\Annotation\Plugin;
use Drupal\Core\Annotation\Translation;

/**
 * Defines an Importer item annotation object.
 *
 * @see \Drupal\products\Plugin\ImporterManager
 *
 * @Annotation
 */
class Importer extends Plugin {

	/**
	 * The plugin ID.
	 *
	 * @var string
	 */
	public string $id;

	/**
	 * The label of the plugin.
	 *
	 * @var Translation
	 *
	 * @ingroup plugin_translatable
	 */
	public Translation $label;

}
