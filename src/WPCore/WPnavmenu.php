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
 * WP nav menu
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
class WPnavmenu extends WPaction
{
  protected $location;
  protected $description;

  public function __construct($location, $description)
  {
    parent::__construct('init');

    $this->location    = $location;
    $this->description = $description;
  }

  public function action()
  {
    register_nav_menu($this->location, $this->description);
  }
}