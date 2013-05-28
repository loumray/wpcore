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

use pweb\wp_core\hooks\AdminScript;
use pweb\wp_core\hooks\ThemeScript;

/**
 *
 * @package     pweb
 * @subpackage  wp_core
 */
abstract class WPfeature implements WPhook
{

  static $instance;

  public $name;

  protected $slug = 'pweb';

  protected $scripts = array();
  protected $styles  = array();

  protected $hooks   = array();

  protected $HThemeScript;
  protected $HAdminScript;

  protected $features = array();

  protected $enabled;

  protected $base_path;
  protected $base_url;

  protected $asset_path = 'assets/';
  protected $css_path   = 'css/';
  protected $js_path    = 'js/';

  protected $views_path = 'views/';

  public function __construct($name, $slug)
  {
    $this->name = $name;
    $this->slug = $slug;

    $this->enable();

    $this->base_url  = get_template_directory_uri();
    $this->base_path = get_template_directory();

    $this->HThemeScript = new ThemeScript();
    $this->HadminScript = new AdminScript();
    $this->hook($this->HThemeScript);
    $this->hook($this->HadminScript);
  }

  abstract public static function getInstance();

  public function enable()
  {
    $this->enabled = true;
    add_theme_support($this->slug);
  }

  public function disable()
  {
    $this->enabled = true;
    remove_theme_support($this->slug);
  }

  public function register()
  {
    if($this->enabled === true)
    {
      if(!empty($this->hooks))
      {
        foreach($this->hooks as $hook)
        {
          $hook->register();
        }
      }
    }
  }

  public function remove()
  {
    if($this->enabled === true)
    {
      if(!empty($this->hooks))
      {
        foreach($this->hooks as $hook)
        {
          $hook->remove();
        }
      }
    }
  }

  public function addScript(WPscript $script)
  {
    if($script instanceof WPscriptTheme)
    {
      $this->HThemeScript->addScript($script);
    }
    elseif($script instanceof WPscriptAdmin)
    {
      $this->HadminScript->addScript($script);
    }
  }

  public function addStyle(WPstyle $style)
  {
    if($style instanceof WPstyleTheme)
    {
      $this->HThemeScript->addStyle($style);
    }
    elseif($style instanceof WPstyleAdmin)
    {
      $this->HadminScript->addStyle($style);
    }
  }

  public function hook(WPhook $hook)
  {
    $this->hooks[] = $hook;
  }

  /**
   * Get the theme path
   */
  public function path()
  {
    if ( !empty($this->base_path) ) return $this->base_path;

    return $this->base_path = get_template_directory();
  }
  /**
   * Get the theme assets path
   */
  public function assets_path()
  {
//     if ( !empty($this->base_path) ) return $this->base_path;

//     return $this->base_path = get_template_directory();
  }

  /**
   * Get the theme path
   */
  public function views_path()
  {
    return $this->path().'/'.$this->views_path;
  }
  /**
   * Get the theme path
   */
  public function base_url()
  {
    if ( !empty($this->base_url) ) return $this->base_url;

    return $this->base_url = get_template_directory_uri();
  }
  /**
   * Get the theme assets url
   */
  public function assets_url()
  {
    return $this->base_url().'/'.$this->asset_path;
  }

  /**
   * Get the theme css url
   */
  public function css_url()
  {
    if ( !empty($this->css_url) ) return $this->css_url;

    return $this->css_url = $this->base_url().'/'.$this->asset_path.$this->css_path;
  }
  /**
   * Get the theme js url
   */
  public function js_url()
  {
    if ( !empty($this->js_url) ) return $this->js_url;

    return $this->js_url = $this->base_url().'/'.$this->asset_path.$this->js_path;
  }

}