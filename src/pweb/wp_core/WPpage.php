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