<?php
/**
 * Define a WP ajax Call class
 *
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
abstract class WPshortcode implements WPaction
{

  protected $slug;

  public function __construct($shortcode)
  {
    $this->slug      = $shortcode;
  }

  public function register()
  {
    add_shortcode( $this->slug, array($this,'callback') );
  }

  public function remove()
  {
    remove_shortcode($this->slug);
  }

  abstract public function callback($atts);

}