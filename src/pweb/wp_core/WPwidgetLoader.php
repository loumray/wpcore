<?php
namespace pweb\wp_core;

class WPwidgetLoader implements WPaction
{
  protected $class;
  // Instantiate the parent object
	public function __construct($class)
	{
	  $this->class = $class;
	}

	public function registerWidget()
	{
	  register_widget($this->class);
	}

	public function register()
	{
	  add_action( 'widgets_init', array($this,'registerWidget'));
	}

	public function remove()
	{
	  remove_action( 'widgets_init', array($this,'registerWidget'));
	}
}