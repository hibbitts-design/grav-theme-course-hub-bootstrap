<?php
namespace Grav\Theme;

use Grav\Common\Grav;
use Grav\Common\Page\Page;
use Grav\Common\Theme;
use Grav\Common\Uri;
use RocketTheme\Toolbox\Event\Event;

class CourseHubBootstrap extends Theme
{
  public static function getSubscribedEvents()
  {
      return [
          'onThemeInitialized' => ['onThemeInitialized', 0]
      ];
  }

  public function onThemeInitialized() {

    if ($this->isAdmin()) {
        $this->enable([
            'onAdminSave' => ['replaceSummary', 0]
        ]);
        return;
    }

    $this->enable([
    'onPageContentRaw' => ['setSummary', 0]
    ]);

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

  public static function getSummary()
      {
          $grav = Grav::instance();
          $delimiter = $grav['config']->get('site.summary.delimiter', '===');
          $adminRoute = $grav['config']->get('plugins.admin.route', '/admin') . '/pages';

          $uri = new Uri();
          $adminPrefix = mb_strpos($uri->url(), $adminRoute) + mb_strlen($adminRoute);
          $route = preg_replace('/\/mode:.*/', '', mb_substr($uri->url(), $adminPrefix));

          $page = $grav['pages']->find($route);

          if ($page) {
              $divider_pos = mb_strpos($page->rawMarkdown(), $delimiter);
              return mb_substr($page->rawMarkdown(), 0, $divider_pos);
          }

          return '';
      }

      public function replaceSummary(Event $event)
      {
          $grav = Grav::instance();
          $page = $event['object'];

          if ($page instanceof Page) {
              // Find delimiter summary endpoint
              $delimiter = $grav['config']->get('site.summary.delimiter', '===');
              $content_start = mb_strpos($page->rawMarkdown(), $delimiter);

              // if delimiter content exists, remove it
              // the new custom summary will be used instead
              if ($content_start !== false && $page->template() === 'itemwithsummaryfield') {
                  $content = mb_substr($page->rawMarkdown(), $content_start + mb_strlen($delimiter));
                  $page->rawMarkdown($content);
              }

              return $page;
          }
      }

      public function setSummary(Event $event)
      {
          $page = $event['page'];

          $grav = Grav::instance();
          $delimiter = $grav['config']->get('site.summary.delimiter', '===');

          // if custom summary exists, use that instead of the default page summary
          if (!empty($page->header()->item_summary)) {
              $page->setRawContent(htmlspecialchars($page->header()->item_summary, ENT_QUOTES, 'UTF-8') . "\n{$delimiter}\n" . $page->getRawContent());
          }
      }
}
?>
