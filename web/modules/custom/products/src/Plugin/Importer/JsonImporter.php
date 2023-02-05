<?php

namespace Drupal\products\Plugin\Importer;

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Utility\Error;
use Drupal\products\Entity\ImporterInterface;
use Drupal\products\Entity\ProductInterface;
use Drupal\products\Plugin\ImporterBase;

/**
 * Product importer from a JSON format.
 *
 * @Importer(
 *   id = "json",
 *   label = @Translation("JSON Importer")
 * )
 */
class JsonImporter extends ImporterBase {

	/**
	 * {@inheritdoc}
	 * @throws EntityStorageException
	 */
	public function import():bool {
		$data = $this->getData();
		if (!$data) {
			return FALSE;
		}

		if (!isset($data->products)) {
			return FALSE;
		}
		$products = $data->products;
		foreach ($products as $product) {
			$this->persistProduct($product);
		}
		return TRUE;
	}

	/**
	 * Loads the product data from the remote URL.
	 *
	 * @return object
	 *   The loaded data.
	 */
	private function getData():object {
		/** @var ImporterInterface $config */
		$config = $this->configuration['config'];
		try{
			$request = $this->httpClient->get($config->getUrl()->toString());
			$string = $request->getBody()->getContents();
		} catch (\Exception $e){
			print $_SERVER['SERVER_PORT'];
			print $_SERVER['SERVER_ADDR'];
			print "<pre>";
			print_r($e);
			print "</pre>";
			die();
		}
		return json_decode($string);
	}

	/**
	 * Saves a Product entity from the remote data.
	 *
	 * @param object $data
	 *   The loaded data to import.
	 * @throws EntityStorageException
	 */
	private function persistProduct(object $data) {
		/** @var ImporterInterface $config */
		$config = $this->configuration['config'];

		try {
			$existing = $this->entityTypeManager
				->getStorage('product')
				->loadByProperties([
					'remote_id' => $data->id, 'source' => $config->getSource()
				]);
			if (!$existing) {
				$values = [
					'remote_id' => $data->id,
					'source' => $config->getSource(),
					'type' => $config->getBundle(),
				];
				/** @var ProductInterface $product */
				$product = $this->entityTypeManager->getStorage('product')->create($values);
				$product->setName($data->name);
				$product->setProductNumber($data->number);
				$product->save();
				return;
			}
		} catch (InvalidPluginDefinitionException|PluginNotFoundException|EntityStorageException $e) {
		}

		if (!$config->updateExisting()) {
			return;
		}

		/** @var ProductInterface $product */
		$product = reset($existing);
		$product->setName($data->name);
		$product->setProductNumber($data->number);
		$product->save();
	}

}
