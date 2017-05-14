<?php
namespace Grav\Theme;

use Grav\Common\Theme;

class CourseHubBootstrap extends Theme
{
  public function onThemeInitialized() {

    if ($this->isAdmin()) {
        return;
    }

    // Check for External_Links plugin status
    if ($this->grav['config']->get('plugins.external_links.built_in_css')) {
	  echo '<div class="alert alert-warning" role="alert" style="margin-bottom: 0;">Please set the Use Built-in CSS option for the External Links plugin to No (i.e. False) before using this theme, in <code>user/config/plugins/external_links.yaml</code>: <code>built_in_css: false</code>.</div>';
      return;
    }
    // Check for Bootstrapper plugin status
    if (!$this->grav['config']->get('plugins.bootstrapper.enabled') &&
        $this->grav['config']->get('plugins.bootstrapper.always_load') &&
        !$this->grav['config']->get('plugins.bootstrapper.load_theme_css')) {
	  echo '<div class="alert alert-warning" role="alert" style="margin-bottom: 0;">Please enable the Bootstrapper plugin before using this theme, in <code>user/config/plugins/bootstrapper.yaml</code>: <code>enabled: true</code>.</div>';
    } elseif (!$this->grav['config']->get('plugins.bootstrapper.enabled') ||
          !$this->grav['config']->get('plugins.bootstrapper.always_load') ||
          $this->grav['config']->get('plugins.bootstrapper.load_theme_css')) {
		echo '<div class="alert alert-warning" role="alert" style="margin-bottom: 0;">Please set the following Bootstrapper plugin options before using this theme, in <code>user/config/plugins/bootstrapper.yaml</code>: <code>enabled: true</code>, <code>always_load: true</code>, <code>load_theme_css: false</code>.</div>';
      }
  }
}
?>
