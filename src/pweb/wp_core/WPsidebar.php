<?php
/**
 * PWEB WP Theme framework
 *
 * @package    PWEB WP Theme framework
 *
 * @version    1.0
 * @author     Louis-Michel Raynauld
 * @copyright  Louis-Michel Raynauld
 * @link       http://graphem.ca
 */
namespace pweb\wp_core;

/**
 *
 * @package     pweb
 * @subpackage  wp_core
 */

class WPsidebar extends WPaction
{
  protected $id;
  protected $name;
  protected $before_widget;
  protected $after_widget;
  protected $before_title;
  protected $after_title;

  public function __construct(
                        $id,
                        $name,
                        $before_widget = '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
                        $after_widget = "</div></section>",
                        $before_title = "<h3>",
                        $after_title = "</h3>"
                      )
  {
    parent::__construct('widgets_init');

    $this->id   = $id;
    $this->name = $name;

    $this->before_widget = $before_widget;
    $this->after_widget  = $after_widget;
    $this->before_title  = $before_title;
    $this->after_title   = $after_title;
  }

  public function action()
  {
      register_sidebar(array(
        'name' => $this->name,
        'id'   => $this->id,
        'before_widget' => $this->before_widget,
        'after_widget'  => $this->after_widget,
        'before_title'  => $this->before_title,
        'after_title'   => $this->after_title,
        ));
  }
}