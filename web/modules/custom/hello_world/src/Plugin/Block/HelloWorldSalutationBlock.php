<?php

namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\hello_world\HelloWorldSalutation;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Hello World salutation block.
 *
 * @Block(
 *     id = "hello_world_salutation_block",
 *     admin_label = @Translation("Hello World salutation"),
 *  )
 */
class HelloWorldSalutationBlock extends BlockBase implements ContainerFactoryPluginInterface {

	/**
	 * The salutation service.
	 */
	protected HelloWorldSalutation $salutation;

	/**
	 * Construct a  HelloWorldSalutationBlock.
	 */
	public function __construct(array $configuration, $plugin_id, $plugin_definition, HelloWorldSalutation $salutation) {
		parent::__construct($configuration, $plugin_id, $plugin_definition);
		$this->salutation = $salutation;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): HelloWorldSalutationBlock|ContainerFactoryPluginInterface|static
	{
		return new static(
			$configuration,
			$plugin_id,
			$plugin_definition,
			$container->get('hello_world.salutation')
		);
	}

	/**
	 * {@inheritdoc}
	 */
	#[ArrayShape(['#markup' => "mixed"])] public function build(): array {
		return [
			'#markup' => $this->salutation->getSalutation()
		];
	}

	/**
	 * {@inheritdoc}
	 */
	#[ArrayShape(['enabled' => "int"])] public function defaultConfiguration(): array {
		return [
			'enabled' => 1,
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function blockForm($form, FormStateInterface $form_state): array
	{
		$config = $this->getConfiguration();

		$form['enabled'] = [
			'#type' => 'checkbox',
			'#title' => $this->t('Enabled'),
			'#description' => $this->t('Check this box if you want to enable this feature.'),
			'#default_value' => $config['enabled'],
		];

		return $form;
	}

	/**
	 * {@inheritdoc}
	 */
	public function blockSubmit($form, FormStateInterface $form_state): void
	{
		$this->configuration['enabled'] = $form_state->getValue('enabled');
	}
}

