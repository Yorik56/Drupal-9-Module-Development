<?php

namespace Drupal\hello_world\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configuration form definition for the salutation message.
 */
class SalutationConfigurationForm extends ConfigFormBase {

	/**
	 * @var LoggerChannelInterface
	 */
	protected LoggerChannelInterface $logger;

	/**
	 * SalutationConfigurationForm constructor.
	 *
	 * @param ConfigFactoryInterface $config_factory
	 *  The factory for configuration objects.
	 * @param LoggerChannelInterface $logger
	 *  The logger.
	 */
	public function __construct(ConfigFactoryInterface $config_factory, LoggerChannelInterface $logger) {
		parent::__construct($config_factory);
		$this->logger = $logger;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function create(ContainerInterface $container) {
		return new static(
			$container->get('config.factory'),
			$container->get('hello_world.logger.channel.hello_world')
		);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getEditableConfigNames(): array {
		return ['hello_world.custom_salutation'];
	}

	/**
	* {@inheritdoc}
	*/
	public function getFormId(): string {
		return 'salutation_configuration_form';
	}

	/**
	* {@inheritdoc}
	*/
	public function buildForm(array $form, FormStateInterface $form_state): array {
		$config = $this->config('hello_world.custom_salutation');
		$form['salutation'] = [
		  	'#type' => 'textfield',
		  	'#title' => $this->t('Salutation'),
			'#description' => $this->t('Please provide the salutation you want to use.'),
		  	'#default_value' => $config->get('salutation'),
		];
		return parent::buildForm($form, $form_state);
	}

	/**
	* {@inheritdoc}
	*/
	public function submitForm(array &$form, FormStateInterface $form_state): void {
		$this->config('hello_world.custom_salutation')
		  ->set('salutation', $form_state->getValue('salutation'))
		  ->save();
		parent::submitForm($form, $form_state);
		$this->logger->info(
			'The Hello World salutation has been updated to: @message.',
			[
				'@message' => $form_state->getValue('salutation')
			]
		);
	}

}
