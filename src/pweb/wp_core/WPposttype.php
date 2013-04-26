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

class WPposttype implements WPaction
{
  protected $slug;
  protected $args;

  public function __construct($slug , $args = array() )
  {
    $this->slug = $slug;

    //TODO add common defaults
    $defaults = array(
//           'label' => 'Slides',
//           'singular_label' => 'Slide',
//           'public' => true,
//           'show_ui' => true,
//           'capability_type' => 'post',
//           'hierarchical' => false,
//           'rewrite' => true,
//           'menu_position' => 5,
//           'supports' => array('title', 'editor', 'thumbnail')
      );
    $this->args = wp_parse_args($args, $defaults);

  }

  public function getSlug()
  {
    return $this->slug;
  }

  public function action()
  {
      register_post_type( $this->slug , $this->args );
  }

}