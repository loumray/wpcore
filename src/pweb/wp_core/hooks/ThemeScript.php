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

class themeScript extends WPaction
{

  protected $scripts = array();
  protected $styles  = array();

  public function __construct()
  {
    parent::__construct('wp_enqueue_scripts',100,1);
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