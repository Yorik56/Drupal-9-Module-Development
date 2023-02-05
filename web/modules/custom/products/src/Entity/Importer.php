<?php

namespace Drupal\products\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Url;
use \Drupal\products\Entity\ImporterInterface;

/**
 * Defines the Importer entity.
 *
 * @ConfigEntityType(
 *   id = "importer",
 *   label = @Translation("Importer"),
 *   handlers = {
 *     "list_builder" = "Drupal\products\ImporterListBuilder",
 *     "form" = {
 *       "default" = "Drupal\products\Form\ImporterForm",
 *       "add" = "Drupal\products\Form\ImporterForm",
 *       "edit" = "Drupal\products\Form\ImporterForm",
 *       "delete" = "Drupal\products\Form\ImporterDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "importer",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/importer/add",
 *     "edit-form" = "/admin/structure/importer/{importer}/edit",
 *     "delete-form" = "/admin/structure/importer/{importer}/delete",
 *     "collection" = "/admin/structure/importer",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "url",
 *     "plugin",
 *     "update_existing",
 *     "source",
 * 	   "bundle"
 *   }
 * )
 */
class Importer extends ConfigEntityBase implements ImporterInterface {
	/**
	 * The Importer ID.
	 *
	 * @var string
	 */
	protected string $id;

	/**
	 * The Importer label.
	 *
	 * @var string
	 */
	protected string $label;

	/**
	 * The URL from where the import file can be retrieved.
	 * @var null|string
	 */
	protected ?string $url = null;

	/**
	 * The plugin ID of the plugin to be used for processing this import.
	 *
	 * @var null|string
	 */
	protected ?string $plugin = null;

	/**
	 * Whether to update existing products if they have already been imported.
	 *
	 * @var bool
	 */
	protected bool $update_existing = TRUE;

	/**
	 * The source of the products.
	 *
	 * @var null|string
	 */
	protected ?string $source = null;

	/**
	 * The product bundle.
	 *
	 * @var null|string
	 */
	protected ?string $bundle = null;

	/**
	 * {@inheritdoc}
	 */
	public function getUrl(): ?Url
	{
		return $this->url ? Url::fromUri($this->url) : NULL;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPluginId(): ?string
	{
		return $this->plugin;
	}

	/**
	 * {@inheritdoc}
	 */
	public function updateExisting(): bool
	{
		return $this->update_existing;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSource(): ?string
	{
		return $this->source;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBundle(): ?string
	{
		return $this->bundle;
	}

}
