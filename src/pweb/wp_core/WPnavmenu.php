<?php

namespace pweb\wp_core;

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