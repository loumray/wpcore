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

class WPtaxonomy extends WPaction
{
  protected $slug;
  protected $type;
  protected $args;

  public function __construct($slug , $type, $args = array() )
  {
    parent::__construct('init');

    $this->slug = $slug;
    $this->type = $type;

    //TODO setup common defaults
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

  public function action()
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
}