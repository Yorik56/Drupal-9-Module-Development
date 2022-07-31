<?php
	namespace Drupal\hello_world;

	use Symfony\Component\EventDispatcher\Event;

	/**
	 * Event class to be dispatched from the HelloWorldSalutation service.
	 */
	class SalutationEvent extends Event {
		const EVENT = 'hello_world.salutation_event';

		/**
		 * The salutation message.
		 *
		 * $var string
		 */
		protected mixed $message;

		/**
		 * @return mixed
		 */
		public function getValue(): mixed
		{
			return $this->message;
		}

		/**
		 * @param @mixed $message
		 */
		public function setValue($message) {
			$this->message = $message;
		}

	}
