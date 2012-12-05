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

use pweb\wp_core\hooks\HookThemeScript;
use pweb\wp_core\hooks\AdminThemeScript;

/**
 *
 * @package     pweb
 * @subpackage  wp_core
 */
class WPfeature
{

  public $name;

  protected $slug = 'pweb';

  protected $scripts = array();
  protected $styles  = array();

  protected $hooks  = array();

  protected $script_hooks = array();

  protected $features = array();

  protected $enabled = true;

  protected $asset_path = 'assets/';
  protected $css_path   = 'css';
  protected $js_path    = 'js';

  protected $views_path = 'pweb/views/';

  public function __construct($name, $slug)
  {
    $this->name = $name;
    $this->slug = $slug;

    $this->script_hook['theme'] = null;
    $this->script_hook['admin'] = null;
    $this->script_hook['login'] = null;

  }

  public function enable()
  {
    $this->enabled = true;
//     add_theme_support($this->feature_slug);
  }

  public function disable()
  {
    $this->enabled = true;
//     remove_theme_support($this->feature_slug);
  }

  public function add_feature(WPfeature $feature)
  {
    $this->features[] = $feature;
  }

  public function run()
  {
    if(!empty($this->features))
    {
      foreach($this->features as $feature)
      {
        $feature->register();
      }
    }

    $this->register();
  }

  public function register()
  {
    if($this->enabled === true)
    {
      $this->register_hooks();
    }
  }

  public function add_script(WPscript $script)
  {
    if($script instanceof WPscriptTheme)
    {
      if(is_null($this->script_hook['theme']))
      {
        $this->script_hook['theme'] = new HookThemeScript();
      }

      $this->script_hook['theme']->add_script($script);
    }
    elseif($script instanceof WPscriptAdmin)
    {
      if(is_null($this->script_hook['admin']))
      {
        $this->script_hook['admin'] = new HookAdminScript();
      }

      $this->script_hook['admin']->add_script($script);
    }
  }

  public function add_style(WPstyle $style)
  {
    if($style instanceof WPstyleTheme)
    {
      if(is_null($this->script_hook['theme']))
      {
        $this->script_hook['theme'] = new HookThemeScript();
      }

      $this->script_hook['theme']->add_style($style);
    }
    elseif($style instanceof WPstyleAdmin)
    {
      if(is_null($this->script_hook['admin']))
      {
        $this->script_hook['admin'] = new HookAdminScript();
      }

      $this->script_hook['admin']->add_style($style);
    }
  }


  public function add_hook($hook)
  {
    $this->hooks[] = $hook;
  }

  public function register_hooks()
  {
    if(!empty($this->hooks))
    {
      foreach($this->hooks as $hook)
      {
        $hook->register();
      }
    }

    //script hooks
    foreach($this->script_hook as $script_hook)
    {
      if(!empty($script_hook))
      {
        $script_hook->register();
      }
    }

    //TODO style hook

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
  public function views_path()
  {
    return $this->path().'/'.$this->views_path;
  }
  /**
   * Get the theme path
   */
  public function base_url()
  {
    if ( !empty($this->theme_url) ) return $this->theme_url;

    return $this->theme_url = get_template_directory_uri();
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