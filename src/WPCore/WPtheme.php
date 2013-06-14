<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore;

/**
 * WP theme
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
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