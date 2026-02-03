<?php

namespace Drupal\dpl_pretix\Settings;

/**
 * Module settings.
 */
class ModuleSettings extends AbstractSettings {

  /**
   * The release URL template.
   */
  public string $releaseUrlTemplate = 'https://www.drupal.org/project/%project/releases/%version';

}
