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

class WPtaxonomy implements WPaction
{
  protected $slug;
  protected $type;
  protected $args;

  public function __construct($slug , $type, $args = array() )
  {
    $this->slug = $slug;
    $this->type = $type;

    $defaults = array(
//           'label' => __( 'People' ),
//       'rewrite' => array( 'slug' => 'person' ),
//       'capabilities' => array(
//         'assign_terms' => 'edit_guides',
//         'edit_terms' => 'publish_guides'
//               )
//       )
      );
    $this->args = wp_parse_args($args, $defaults);

  }

  public function init()
  {
      register_taxonomy( $this->slug, $this->type, $this->args);
  }

  public function getSlug()
  {
    return $this->slug;
  }

  public function getType()
  {
    return $this->type;
  }
  public function register()
  {
    add_action('init', array($this, 'init'));
  }

  public function remove()
  {
    remove_action('init', array($this, 'init'));
  }
}