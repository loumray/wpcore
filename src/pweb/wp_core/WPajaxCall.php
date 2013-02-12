<?php
/**
 * Define a WP ajax Call class
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
abstract class WPajaxCall implements WPaction
{
  protected $js_handle;
  protected $slug;
  protected $admin;
  protected $mustBeLoggedIn;

  public function __construct($call_slug, $js_handle, $admin = false, $mustBeLoggedIn = false)
  {
    $this->slug      = $call_slug;
    $this->js_handle = $js_handle;
    $this->admin = $admin;
    $this->mustBeLoggedIn = $mustBeLoggedIn;
  }

  public function getSlug()
  {
    return $this->slug;
  }

  /*
   *
   * Note: Must be low priority to ensure wp_localize_scripts are run after scripts enqueues
   */
  public function register()
  {
    if($this->admin === true)
    {
      add_action( 'admin_enqueue_scripts', array($this,'init'),10000 );
    }
    else
    {
      add_action( 'wp_enqueue_scripts', array($this,'init'),10000 );
    }
    add_action( 'wp_ajax_'.$this->slug, array($this,'callback') );
    if(!$this->mustBeLoggedIn)
    {
      add_action('wp_ajax_nopriv_'.$this->slug, array($this,'callback'));
    }
  }

  public function remove()
  {
    if($this->admin === true)
    {
      remove_action( 'admin_enqueue_scripts', array($this,'init') );
    }
    else
    {
      remove_action( 'wp_enqueue_scripts', array($this,'init') );
    }

    remove_action('wp_ajax_'.$this->slug, array($this,'hook_action'));
  }

  abstract public function init();
  abstract public function callback();

}