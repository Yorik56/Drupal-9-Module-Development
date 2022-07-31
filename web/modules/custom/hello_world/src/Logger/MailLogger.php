<?php
	namespace Drupal\hello_world\Logger;

	use Drupal\Component\Render\FormattableMarkup;
	use Drupal\Core\Config\ConfigFactoryInterface;
	use Drupal\Core\Logger\LogMessageParserInterface;
	use Drupal\Core\Logger\RfcLoggerTrait;
	use Drupal\Core\Logger\RfcLogLevel;
	use Psr\Log\LoggerInterface;

	/**
	 * A Logger that send an email when the log type is "error".
	 */
	class MailLogger implements LoggerInterface {
		use RfcLoggerTrait;

		/**
		 * @var LogMessageParserInterface
		 */
		protected LogMessageParserInterface $parser;

		/**
		 * @var ConfigFactoryInterface
		 */
		protected ConfigFactoryInterface $configFactory;

		/**
		 * MailLogger constructor.
		 *
		 * @param LogMessageParserInterface $parser
		 * The parser for log messages.
		 * @param ConfigFactoryInterface $config_factory
		 */
		public function __construct(LogMessageParserInterface $parser, ConfigFactoryInterface $config_factory) {
			$this->parser = $parser;
			$this->configFactory = $config_factory;
		}

		/**
		 * {@inheritdoc}
		 */
		public function log($level, $message, array $context = []) {
			// Log our messsage to the logging system.
			if ($level !== RfcLogLevel::ERROR) {
				return;
			}

			$to = $this->configFactory->get('system.site')->get('mail');
			$langcode = $this->configFactory->get('system.site')->get('langcode');
			$variables = $this->parser->parseMessagePlaceholders($message, $context);
			$markup = new FormattableMarkup($message, $variables);
			\Drupal::service('plugin.manager.mail')
				->mail(
					'hello_world',
					'hello_world_log',
					$to,
					$langcode,
					['message' => $markup]
				);
		}

		/**
		 * Implements hook_mail().
		 */
		function hello_world_mail($key, &$message, $params) {
			switch ($key) {
				case 'hello_world_log':
					$message['from'] = \Drupal::config('system.site')->get('mail');
					$message['subject'] = t('There is an error on your website');
					$message['body'][] = $params['message'];

					break;
			}
		}
	}
