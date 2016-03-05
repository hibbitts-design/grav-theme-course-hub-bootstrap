<?php
namespace Grav\Theme;

use Grav\Common\Theme;

class CourseHubBootstrap extends Theme
{
  public function onThemeInitialized() {
    // Check for Bootstrapper plugin status
    if (!$this->grav['config']->get('plugins.bootstrapper.enabled')) {
      echo '<script language="javascript">';
      echo 'alert("Please enable the Bootstrapper plugin when using this theme.")';
      echo '</script>';
    }
  }
}
?>
