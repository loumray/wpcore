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

use pweb\wp_core\WPscriptTheme;
use pweb\wp_core\WPstyleTheme;


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
    $this->tag       = 'wp_enqueue_scripts';
    $this->priority  = 100;
    $this->accepted_args = 1;
  }

  public function add_script(WPscriptTheme $script)
  {
    $this->scripts[] = $script;
  }

  public function add_style(WPstyleTheme $style)
  {
    $this->styles[] = $style;
  }

  public function hook_action()
  {
    if(!empty($this->scripts))
    {
      foreach($this->scripts as $script)
      {
          $script->enqueue();
      }
    }

    if(!empty($this->styles))
    {
      foreach($this->styles as $script)
      {
        $script->enqueue();
      }
    }
    //clear memory after the hook action is run?
    return null;
  }
}