<?php

namespace Drupal\products;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\products\Entity\Product;

/**
 * EntityListBuilderInterface implementation responsible for rhe Product entities
 */
class ProductListBuilder extends EntityListBuilder {
	/**
	 * {@inheritdoc}
	 */
	public function buildHeader(): array
	{
		$header['id'] = $this->t('Poduct ID');
		$header['name'] = $this->t('Name');

		return $header + parent::buildHeader();
	}

	/**
	 * {@inheritdoc}
	 * @throws EntityMalformedException
	 */
	public function buildRow(EntityInterface $entity): array
	{
		/* @var $entity Product */
		$row['id'] = $entity->id();
		$row['name'] = $entity->toLink();

		return $row + parent::buildRow($entity);
	}
}
