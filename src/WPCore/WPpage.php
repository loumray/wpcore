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
 * WP page
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPpage
{

  protected $wpPost;

  public function __construct($wpPost)
  {
    $defaults = array(
        'post_status' 		=> 'publish',
        'post_type' 		=> 'page',
        'post_author' 		=> 1,
        'comment_status' 	=> 'closed'
    );
    $this->wpPost = wp_parse_args($wpPost, $defaults);

    //TONOTICE this WP_Post is WP > 3.5
//     $this->wp_post = new \WP_Post($wpPost);

  }

  /*
   * return post id on success
   */
  public function insert()
  {
    global $wpdb;
    $page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE post_name = %s LIMIT 1;", $this->wpPost['post_name'] ) );
    if ( $page_found )
    {
      return $page_found;
    }

    return  wp_insert_post( $this->wpPost );
//     return  wp_insert_post( $this->post->to_array() );
  }

  //todo
//   public function save()
//   {

//   }

}