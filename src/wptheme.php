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
 * @package     Fuel
 * @subpackage  Core
 */
class WPtheme
{
  protected $req_php_version  = '5.3.0';
  protected $req_wp_version   = '3.0.0';

  protected $core_path;
  protected $theme_path;

  public function __construct()
  {
    $this->init();
  }

  public function init()
  {

  }

  /**
   * Get the theme core path
   */
  public function core_path()
  {
    if ( !empty($this->core_path) ) return $this->core_path;

    return $this->core_path = get_template_directory().'/pweb/core';
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