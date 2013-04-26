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

use pweb\wp_core\WPfeature;
/**
 *
 * @package     pweb
 * @subpackage  wp_core
 */
class WPtheme
{
  protected $req_php_version  = '5.3.0';
  protected $req_wp_version   = '3.0.0';

  protected $theme_name;

  protected $features = array();

  public function __construct($name)
  {
    $this->theme_name = $name;
  }

  public function addFeature(WPfeature $feature)
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
  }

}