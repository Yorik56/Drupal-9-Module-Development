<?php

namespace Drupal\products\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Represents a product entity.
 */
interface ProductInterface extends ContentEntityInterface, EntityChangedInterface {
	/**
	 * Gets the product name.
	 *
	 * @return string
	 */
	public function getName(): string;

	/**
	 * Sets the product name.
	 *
	 * @param string $name
	 * 	The product name.
	 *
	 * @return ProductInterface
	 * 	The called product entity.
	 */
	public function setName(string $name): ProductInterface;

	/**
	 * Gets the product number.
	 *
	 * @return int
	 */
	public function getProductNumber(): int;

	/**
	 * Sets the product number.
	 *
	 * @param int $product_number
	 * 	The product number.
	 *
	 * @return ProductInterface
	 * 	The called product entity.
	 */
	public function setProductNumber(int $product_number): ProductInterface;

	/**
	 * Get the product remote ID.
	 *
	 * @return string
	 */
	public function getRemoteId(): string;

	/**
	 * Set the product remote ID.
	 *
	 * @param string $id
	 *
	 * @return ProductInterface
	 * 	The called product entity.
	 */
	public function setRemoteId(string $id): ProductInterface;

	/**
	 * Get the product source.
	 *
	 * @return string
	 */
	public function getSource(): string;

	/**
	 * Set the product source.
	 *
	 * @param string $source
	 *
	 * @return ProductInterface
	 * 	The called product entity.
	 */
	public function setSource(string $source): ProductInterface;

	/**
	 * Get the product creation timestamp.
	 *
	 * @return int
	 */
	public function getCreatedTime(): int;

	/**
	 * Set the product creation timestamp.
	 *
	 * @param int $timestamp
	 *
	 * @return ProductInterface
	 */
	public function setCreatedTime(int $timestamp): ProductInterface;
}
