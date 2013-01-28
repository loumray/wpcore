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
class WPscript
{
  protected $handle;
  protected $src       = "";
  protected $deps      = array();
  protected $ver       = false;
  protected $in_footer  = true;

  public function __construct($handle, $src = false, $deps = array(),$ver = false, $in_footer = true)
  {
    $this->handle    = $handle;
    $this->src       = $src;
    $this->deps      = $deps;
    $this->ver       = $ver;
    $this->in_footer = $in_footer;
  }


  public function enqueue()
  {
    wp_enqueue_script(
                      $this->handle,
                      $this->src,
                      $this->deps,
                      $this->ver,
                      $this->in_footer
                     );
  }

}