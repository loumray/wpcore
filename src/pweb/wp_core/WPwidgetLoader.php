<?php
namespace pweb\wp_core;

class WPwidgetLoader extends WPaction
{
  protected $class;

	public function __construct($class)
	{
	  parent::__construct('widgets_init');

	  $this->class = $class;
	}

	public function action()
	{
	  register_widget($this->class);
	}
}