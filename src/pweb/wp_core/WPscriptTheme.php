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
class WPscriptTheme extends WPscript
{
  protected $load_condition = true;


  public function __construct($load_condition, $handle, $src = false, $deps = array(),$ver = false, $in_footer = true)
  {
    parent::__construct($handle, $src, $deps, $ver, $in_footer);

    $this->load_condition = $load_condition;

  }

  //This is unsafe but will do for now
  public function is_needed()
  {
    $is_needed = $this->load_condition;
    eval("\$is_needed = $is_needed;");
    return $is_needed;
  }

  public function enqueue()
  {
    if($this->is_needed())
    {
      parent::enqueue();
    }
  }
}