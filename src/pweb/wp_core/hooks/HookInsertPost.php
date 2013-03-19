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
namespace pweb\wp_core\hooks;


/**
 *
 * @package     pweb
 * @subpackage  wp_core
 */

class HookThemeScript extends WPhook
{

  protected $scripts = array();
  protected $styles  = array();

  public function __construct()
  {
    $this->hook_type = 'action';
    $this->tag       = 'wp_insert_post';
    $this->priority  = 100;
    $this->accepted_args = 1;
  }

  public function hook_action()
  {
    return null;
  }
}