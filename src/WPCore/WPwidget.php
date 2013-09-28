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
 * WP widget
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
abstract class WPwidget extends \WP_Widget
{
    public function __construct($id_base = false, $name, $widget_options = array(), $control_options = array())
    {
        parent::__construct($id_base, $name, $widget_options = array(), $control_options = array());
    }

    //TONOTICE Should be abstract but cannot because it is not abstract in WP_Widget
    // Widget output
    public function widget($args, $instance){}

    // Save widget options
    public function update($new_instance, $old_instance){}

    // Output admin widget options form
    public function form($instance){}
}
