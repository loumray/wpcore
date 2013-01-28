<?php
/**
 *
 *
 * PWEB WP Theme framework
 *
 * @package    PWEB WP Theme framework
 *
 * @version    1.0
 * @author     Louis-Michel Raynauld
 * @copyright  Louis-Michel Raynauld
 * @link       http://graphem.ca
 */
namespace pweb\wp_core\admin;

use pweb\wp_core\View;

/**
 *
 * @package     pweb
 * @subpackage  wp_core\\admin
 */

class WPmenuPage
{
  protected $page_title  = 'Custom Menu';
  protected $menu_title  = 'Custom Menu';
  protected $menu_slug   = 'custom-menu';
  protected $capability  = 'manage_options';
  protected $icon_url    = '';
  protected $position    = null;

  protected $view       = null;

  public function __construct(View $view,
                                $page_title = null,
                                $menu_title = null,
                                $menu_slug  = null,
                                $capability = null,
                                $icon_url   = null,
                                $position   = null)
  {

    $this->view = $view;

    if(!empty($page_title))
    {
      $this->setPageTitle($page_title);
    }
    if(!empty($menu_title))
    {
      $this->setMenuTitle($menu_title);
    }
    if(!empty($menu_slug))
    {
      $this->setMenuSlug($menu_slug);
    }
    if(!empty($capability))
    {
      $this->setCapability($capability);
    }
    if(!empty($icon_url))
    {
      $this->setIconUrl($icon_url);
    }
    if(!empty($position))
    {
      $this->setPosition($position);
    }

    $this->register();
  }

  public function setPageTitle($value)
  {
    $this->page_title = $value;
  }
  public function setMenuTitle($value)
  {
    $this->menu_title = $value;
  }
  public function setCapability($value)
  {
    $this->capability = $value;
  }
  public function setMenuSlug($value)
  {
    $this->menu_slug = $value;
  }
  public function setIconUrl($url)
  {
    $this->icon_url = $url;
  }
  /*
     2 Dashboard
     4 Separator
     5 Posts
     10 Media
     15 Links
     20 Pages
     25 Comments
     59 Separator
     60 Appearance
     65 Plugins
     70 Users
     75 Tools
     80 Settings
     99 Separator
   */
  public function setPosition($int)
  {
    $this->position = $int;
  }

  public function register()
  {
    //Low priority so that all options from other features are loaded before panel is displayed
    add_action('admin_menu', array($this,'hook_action'),10000);
  }

  public function hook_action() {
    add_menu_page( $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, array($this,'view'), $this->icon_url, $this->position );
  }

  public function view()
  {
    $this->view->show();
  }

}