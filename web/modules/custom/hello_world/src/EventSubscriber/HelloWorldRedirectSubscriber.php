<?php
	namespace Drupal\hello_world\EventSubscriber;

	use Drupal\Core\Http\KernelEvent;
	use Drupal\Core\Routing\CurrentRouteMatch;
	use Drupal\Core\Routing\LocalRedirectResponse;
	use Drupal\Core\Session\AccountProxyInterface;
	use Drupal\Core\Url;
	use Symfony\Component\EventDispatcher\EventSubscriberInterface;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\HttpKernel\Event\GetResponseEvent;
	use Symfony\Component\HttpKernel\KernelEvents;

	/**
	 * Subscribe to the kernel request event and redirect to the home page.
 	 * when the user as the "non_grata" role.
	 */
	class HelloWorldRedirectSubscriber implements EventSubscriberInterface {

		/**
		 * @var CurrentRouteMatch
		 */
		protected CurrentRouteMatch $currentRouteMatch;

		/**
		 * @var AccountProxyInterface
		 */
		protected AccountProxyInterface $currentUser;

		/**
		 * HelloWorldRedirectSubscriber constructor.
		 *
		 * @param AccountProxyInterface $currentUser
		 * @param CurrentRouteMatch $currentRouteMatch
		 */
		public function __construct(AccountProxyInterface $currentUser, CurrentRouteMatch $currentRouteMatch) {
			$this->currentUser = $currentUser;
			$this->currentRouteMatch = $currentRouteMatch;
		}

		/**
		 * {@inheritdoc}
		 */
		public static function getSubscribedEvents(): array
		{
			$events[KernelEvents::REQUEST][] = ['onRequest', 0];
			return $events;
		}

		/**
		 * Handler for the kernel request event.
		 *
		 * @param GetResponseEvent $event
		 */
		public function onRequest(GetResponseEvent $event) {
			$route_name = $this->currentRouteMatch->getRouteName();

			if($route_name !== 'hello_world.hello') {
				return;
			}

			$roles = $this->currentUser->getRoles();

			if(in_array('non_grata', $roles)) {

				$url = Url::fromUri('internal:/');
				$event->setResponse(new LocalRedirectResponse($url->toString()));
			}
		}
	}
