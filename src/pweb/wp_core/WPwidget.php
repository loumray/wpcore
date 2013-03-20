<?php
namespace pweb\wp_core;

abstract class WPwidget extends \WP_Widget implements WPaction
{
  protected $class;
  // Instantiate the parent object
	public function __construct($class, $id_base = false, $name, $widget_options = array(), $control_options = array())
	{
	  $this->class = $class;
	  parent::__construct($id_base = false, $name, $widget_options = array(), $control_options = array());
	}

	//TONOTICE Should be abstract but cannot because it is not in WP_Widget
	// Widget output
	public function widget( $args, $instance ){}

	// Save widget options
	public function update( $new_instance, $old_instance ){}

	// Output admin widget options form
	public function form( $instance ){}

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