<?php

namespace Drupal\dpl_pretix\Hook;

use Drupal\Core\Extension\InfoParser;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Url;
use Drupal\dpl_pretix\Settings;

/**
 * Toolbar hooks.
 */
class ToolbarHooks {
  use StringTranslationTrait;

  public function __construct(
    private readonly ModuleHandlerInterface $moduleHandler,
    private readonly Settings $settings,
  ) {}

  /**
   * Implements hook_toolbar_alter().
   */
  public function toolbarAlter(array &$items): void {
    try {
      $settings = $this->settings->getModule();
      if (!empty($settings->releaseUrlTemplate)) {
        $project = 'dpl_pretix';
        $module = $this->moduleHandler->getModule($project);
        $info = (new InfoParser())->parse($module->getFileInfo()
          ->getPathname());

        if (isset($info['version'])) {
          $info['project'] = $project;
          $url = (string) preg_replace_callback(
            '/%(?P<key>[a-z]+)/',
            static fn(array $match): string => $info[$match[1]] ?? $match[0],
            $settings->releaseUrlTemplate
          );

          $items['dpl_pretix_version'] = [
            '#type' => 'toolbar_item',
            'tab' => [
              '#type' => 'link',
              '#title' => $this->t('@name version: @version',
                ['@name' => $info['name'], '@version' => $info['version']],
                ['context' => 'dpl_pretix']
              ),
              '#url' => Url::fromUri($url),
            ],
          ];
        }
      }
    }
    catch (\Exception) {
      // Silently ignore any errors.
    }
  }

}
