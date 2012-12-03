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
class WPstyle
{
  protected $handle;
  protected $src       = "";
  protected $deps      = array();
  protected $ver       = false;
  protected $media     = 'all';

  public function __construct($handle, $src = "", $deps = array(),$ver = false, $media = 'all')
  {
    $this->handle    = $handle;
    $this->src       = $src;
    $this->deps      = $deps;
    $this->ver       = $ver;
    $this->media     = $media;
  }


  public function enqueue()
  {
    wp_enqueue_style(
                    $this->handle,
                    $this->src,
                    $this->deps,
                    $this->ver,
                    $this->media
                    );
  }

}