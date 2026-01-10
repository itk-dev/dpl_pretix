<?php

declare(strict_types=1);

namespace Drupal\dpl_event_undo\EventSubscriber;

use Drupal\dpl_event\EventSubscriber\EventInstanceEditRedirect;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Undo what EventInstanceEditRedirect does.
 *
 * @see \Drupal\dpl_event\EventSubscriber\EventInstanceEditRedirect
 */
final class UndoEventInstanceEditRedirect implements EventSubscriberInterface {

  /**
   * Constructor.
   */
  public function __construct(
    private readonly EventDispatcherInterface $eventDispatcher,
    #[Autowire(service: 'dpl_event.event_instance_edit_redirect')]
    private readonly EventInstanceEditRedirect $eventInstanceEditRedirect,
  ) {}

  /**
   * Kernel request event handler.
   */
  public function onKernelRequest(RequestEvent $event): void {
    // Remove the EventInstanceEditRedirect event subscriber.
    $this->eventDispatcher->removeSubscriber($this->eventInstanceEditRedirect);
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      // Set a very high priority to make sure that we run before the listener
      // in \Drupal\dpl_event\EventSubscriber\EventInstanceEditRedirect.
      KernelEvents::REQUEST => [['onKernelRequest', 1000]],
    ];
  }

}
