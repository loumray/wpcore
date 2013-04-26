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

class WPsubmenuPage
{
  protected $parent_slug;
  protected $page_title;
  protected $menu_title;
  protected $menu_slug;
  protected $capability;

  protected $view       = null;

  public function __construct(View $view,
                                $parent_slug = 'options-general.php',
                                $page_title = 'Custom Menu',
                                $menu_title = 'Custom Menu',
                                $menu_slug  = 'custom-menu',
                                $capability = 'manage_options')
  {

    $this->view = $view;

    $this->setParentSlug($parent_slug);
    $this->setPageTitle($page_title);
    $this->setMenuTitle($menu_title);
    $this->setMenuSlug($menu_slug);
    $this->setCapability($capability);

    $this->register();
  }

  public function setParentSlug($value)
  {
    $this->parent_slug = $value;
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
  public function register()
  {
    //Low priority so that all options from other features are loaded before panel is displayed
    add_action('admin_menu', array($this,'hook_action'),10000);
  }

  public function hook_action() {
    add_submenu_page( $this->parent_slug, $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, array($this,'view') );
  }

  public function view()
  {
    $this->view->show();
  }

}