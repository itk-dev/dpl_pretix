<?php

declare(strict_types=1);

namespace Drupal\dpl_event_undo\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Undo what \Drupal\dpl_event\Routing\RouteSubscriber does.
 *
 * @see \Drupal\dpl_event\Routing\RouteSubscriber
 */
final class UndoRouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection): void {
    // Remove the requirement set in \Drupal\dpl_event\RoutingRouteSubscriber.
    if ($route = $collection->get('view.event_instance_list.page_1')) {
      $requirements = $route->getRequirements();
      unset($requirements['_access_event_series_instances_tab']);
      $route->setRequirements($requirements);
    }
  }

}
