<?php

declare(strict_types=1);

namespace Drupal\dpl_event_undo;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;

/**
 * Removes some Event (dpl_event) services.
 */
final class DplEventUndoServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    $container->removeDefinition('dpl_event.access_event_instances_tab');
    $container->removeDefinition('dpl_event.event_instance_edit_redirect');
  }

}
