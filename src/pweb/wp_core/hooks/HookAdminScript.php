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

use pweb\wp_core\WPscript;
use pweb\wp_core\WPstyle;

/**
 *
 * @package     pweb
 * @subpackage  wp_core
 */

class HookAdminScript extends WPhook
{

  protected $scripts = array();
  protected $styles  = array();

  public function __construct($priority = 100, $accepted_args = 1)
  {
    $this->hook_type = 'action';
    $this->tag       = 'admin_enqueue_scripts';

    $this->priority      = $priority;
    $this->accepted_args = $accepted_args;
  }

  public function add_script(WPscript $script)
  {
    $this->scripts[] = $script;
  }

  public function add_style(WPstyle $style)
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