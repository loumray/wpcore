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
 * WP shortcode
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
abstract class WPshortcode implements WPhook
{

  protected $slug;

  public function __construct($shortcode)
  {
    $this->slug = $shortcode;
  }

  public function register()
  {
    add_shortcode( $this->slug, array($this,'callback') );
  }

  public function remove()
  {
    remove_shortcode($this->slug);
  }

  abstract public function callback();

}