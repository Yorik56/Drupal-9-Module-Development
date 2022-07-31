<?php
	namespace Drupal\hello_world\Logger;

	use Drupal\Core\Logger\RfcLoggerTrait;
	use Psr\Log\LoggerInterface;

	/**
	 * A Logger that send an email when the log type is "error".
	 */
	class MailLogger implements LoggerInterface {
		use RfcLoggerTrait;

		/**
		 * {@inheritdoc}
		 */
		public function log($level, $message, array $context = []) {
			// Log our messsage to the logging system.
		}
	}
