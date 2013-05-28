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

use pweb\wp_core\WPaction;

use pweb\wp_core\WPscript;
use pweb\wp_core\WPstyle;

/**
 *
 * @package     pweb
 * @subpackage  wp_core
 */

class AdminScript extends WPaction
{

  protected $scripts = array();
  protected $styles  = array();

  public function __construct()
  {
    parent::__construct('admin_enqueue_scripts',100,1);
  }

  public function addScript(WPscript $script)
  {
    $this->scripts[] = $script;
  }

  public function addStyle(WPstyle $style)
  {
    $this->styles[] = $style;
  }

  public function action()
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