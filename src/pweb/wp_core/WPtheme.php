<?php
/**
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
class WPtheme
{
  protected $req_php_version  = '5.3.0';
  protected $req_wp_version   = '3.0.0';

  protected $core_path;
  protected $theme_path;

  protected $scripts = array();
  protected $styles  = array();

  public function __construct()
  {

  }

  public function init()
  {
    $this->clear();

  }

  public function clear()
  {
    //clear useless memory stuff after init
  }

  /**
   * Get the theme path
   */
  public function path()
  {
    if ( !empty($this->theme_path) ) return $this->theme_path;

    return $this->theme_path = get_template_directory();
  }

}