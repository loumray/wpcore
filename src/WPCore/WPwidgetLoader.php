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
 * WP widget loader
 *
 * This loader is to make sure WPwidget constructor is loaded once and in the widgets_init action hook
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

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