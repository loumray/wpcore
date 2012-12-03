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

  protected $feature_slug = 'pweb';

  protected $scripts = array();
  protected $styles  = array();

  protected $hooks  = array();

  protected $script_hooks = array();

  protected $enabled = false;

  public function __construct($name)
  {
    $this->name = $name;
    $this->feature_slug .= '-'.$this->name;

    $this->script_hook['theme'] = null;
    $this->script_hook['admin'] = null;
    $this->script_hook['login'] = null;

  }

  public function enable()
  {
    $this->enabled = true;
    add_theme_support($this->feature_slug);
  }

  public function disable()
  {
    $this->enabled = true;
    remove_theme_support($this->feature_slug);
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


  public function add_hook(WPhook $hook)
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
  public function base_url()
  {
    if ( !empty($this->theme_url) ) return $this->theme_url;

    return $this->theme_url = get_template_directory_uri();
  }

}