<?php

namespace Drupal\products\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\Messenger;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form for creating and editing product entities.
 * Book Page 224
 * https://github.com/PacktPublishing/Drupal-9-Module-Development-Third-Edition/blob/master/packt/chapter7/products/src/Form/ProductForm.php
 */
class ProductForm extends ContentEntityForm {

	/**
	 * {@inheritdoc}
	 */
	public function save(array $form, FormStateInterface $form_state) {
		$entity = $this->entity;

		$status = parent::save($form, $form_state);

		switch ($status) {
			case SAVED_NEW:
				$this->messenger()->addMessage($this->t('Created the %label Product.', [
					'%label' => $entity->label(),
				]));
				break;

			default:
				$this->messenger()->addMessage($this->t('Saved the %label Product.', [
					'%label' => $entity->label(),
				]));
		}
		$form_state->setRedirect(
			'entity.product.canonical', ['product' => $entity->id()]
		);
	}

}
