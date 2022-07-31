<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\hello_world\HelloWorldSalutation;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Controller for the salutation message.
 */
class HelloWorldController extends controllerBase {

	/**
	 * @var HelloWorldSalutation
	 */
	 protected $salutation;

	/**
	 * HelloWorldController constructor.
	 *
	 * @param HelloWorldSalutation $salutation
	 */
	public function __construct(HelloWorldSalutation $salutation) {
		$this->salutation = $salutation;
	}

	/**
	 * {inheritdoc}
	 */
	public static function create(ContainerInterface $container): HelloWorldController
	{
		return new static(
			$container->get('hello_world.salutation')
		);
	}

	/**
	 * Hello World.
	 *
	 * @return array
	 * 	Our message.
	 */
	public function helloWorld(): array
	{
		return array(
			'#markup' => $this->salutation->getSalutation()
		);
	}
}
