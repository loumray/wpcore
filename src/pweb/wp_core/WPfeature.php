<?php
/**
 * This is a WP feature container
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
namespace pweb\wp_core;

/**
 *
 * @package     pweb
 * @subpackage  wp_core
 */
class WPfeature
{

  protected $scripts = array();
  protected $styles  = array();

  protected $hooks  = array();

  protected $enabled = false;

  public function __construct()
  {
    $this->hooks['front_end_js'] = new \pweb\EggWhite\HookThemeScript();
    $this->init_js();
  }

  public function enable()
  {
    $this->enabled = true;
  }

  public function disable()
  {
    $this->enabled = true;
  }

  public function init()
  {
    if($this->enable === true)
    {
      $this->init_js();
      $this->init_css();
    }

  }

  public function init_js()
  {
    $main_script = new WPscriptTheme("true", 'main-theme', $this->url() . '/js/main.js');
    $this->hooks['front_end_js']->add_script($main_script);
    $this->hooks['front_end_js']->register();
//     add_action('admin_enqueue_scripts', array($this,'admin_scripts'), 100);
  }
  public function init_css()
  {
//     add_action('wp_enqueue_scripts', array($this,'theme_styles'), 100);
//     add_action('admin_enqueue_scripts', array($this,'admin_styles'), 100);
  }


  /**
   * Get the theme path
   */
  public function path()
  {
    if ( !empty($this->theme_path) ) return $this->theme_path;

    return $this->theme_path = get_template_directory();
  }
  /**
   * Get the theme path
   */
  public function url()
  {
    if ( !empty($this->theme_url) ) return $this->theme_url;

    return $this->theme_url = get_template_directory_uri();
  }

}