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

use pweb\wp_core\WPscriptAdmin;
use pweb\wp_core\WPstyleAdmin;

/**
 *
 * @package     pweb
 * @subpackage  wp_core
 */

class HookAdminScript extends WPhook
{

  protected $scripts = array();
  protected $styles  = array();

  public function __construct()
  {
    $this->hook_type = 'action';
    $this->tag       = 'admin_enqueue_scripts';
    $this->priority  = 100;
    $this->accepted_args = 1;
  }

  public function add_script(WPscriptAdmin $script)
  {
    $this->scripts[] = $script;
  }

  public function add_style(WPstyleAdmin $style)
  {
    $this->styles[] = $style;
  }

  public function hook_action()
  {
    if(!empty($this->scripts))
    {
      $hook = func_get_arg(0);
      foreach($this->scripts as $script)
      {
        //todo support page specific script
          $script->enqueue($hook);
      }
    }

    if(!empty($this->styles))
    {
      $hook = func_get_arg(0);
      foreach($this->styles as $script)
      {
        //todo support page specific script
          $script->enqueue($hook);
      }
    }

    return null;
  }
}