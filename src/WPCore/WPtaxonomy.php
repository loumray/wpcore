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
 * WP taxonomy
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
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