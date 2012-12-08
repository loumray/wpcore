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
class WPstyleAdmin extends WPstyle
{
  protected $admin_page = array();


  public function __construct($admin_page, $handle, $src = "", $deps = array(),$ver = false, $media = 'all')
  {
    parent::__construct($handle, $src, $deps, $ver, $media);

    if(!is_array($admin_page))
    {
      $this->admin_page[] = $admin_page;
    }
    else
    {
      $this->admin_page = $admin_page;
    }

  }

  public function is_needed($page)
  {
    if(empty($this->admin_page)) return true;

    return in_array($page, $this->admin_page);
  }

  public function enqueue($page)
  {
    if($this->is_needed($page))
    {
      parent::enqueue();
    }
  }
}