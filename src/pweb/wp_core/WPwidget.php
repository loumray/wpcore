<?php
namespace pweb\wp_core;

abstract class WPwidget extends \WP_Widget
{
  // Instantiate the parent object
	public function __construct($id_base = false, $name, $widget_options = array(), $control_options = array())
	{
	  parent::__construct($id_base, $name, $widget_options = array(), $control_options = array());
	}

	//TONOTICE Should be abstract but cannot because it is not in WP_Widget
	// Widget output
	public function widget( $args, $instance ){}

	// Save widget options
	public function update( $new_instance, $old_instance ){}

	// Output admin widget options form
	public function form( $instance ){}

}