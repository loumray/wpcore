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
 * WP sidebar
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPsidebar extends WPaction
{
    protected $sbId;
    protected $name;
    protected $before_widget;
    protected $after_widget;
    protected $before_title;
    protected $after_title;

    public function __construct(
        $sbId,
        $name,
        $before_widget = '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
        $after_widget = "</div></section>",
        $before_title = "<h3>",
        $after_title = "</h3>"
    ) {
        parent::__construct('widgets_init');

        $this->sbId   = $sbId;
        $this->name = $name;

        $this->before_widget = $before_widget;
        $this->after_widget  = $after_widget;
        $this->before_title  = $before_title;
        $this->after_title   = $after_title;
    }

    public function action()
    {
        register_sidebar(
            array(
              'name' => $this->name,
              'id'   => $this->sbId,
              'before_widget' => $this->before_widget,
              'after_widget'  => $this->after_widget,
              'before_title'  => $this->before_title,
              'after_title'   => $this->after_title,
            )
        );
    }
}
