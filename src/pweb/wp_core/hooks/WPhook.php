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

abstract class WPhook
{
  protected $hook_type;
  protected $tag;
  protected $function_to_add;
  protected $priority;
  protected $accepted_args;

  abstract public function hook_action();

  public function __construct($hook_type, $tag, $priority = 10, $accepted_args = 1)
  {
    $this->hook_type = $hook_type;
    $this->tag       = $tag;
    $this->priority  = $priority;
    $this->accepted_args = $accepted_args;
  }

  public function register()
  {
    if(empty($this->tag))
    {
      throw new WPexception("Bad hook: tag empty");
    }

    if($this->hook_type == 'action')
    {
      add_action($this->tag, array($this,'hook_action'),$this->priority,$this->accepted_args);
    }
    else
    {
      add_filter($this->tag, array($this,'hook_action'),$this->priority,$this->accepted_args);
    }
  }

  public function remove()
  {
    if($this->hook_type == 'action')
    {
      remove_action($this->tag, array($this,'hook_action'),$this->priority,$this->accepted_args);
    }
    else
    {
      remove_filter($this->tag, array($this,'hook_action'),$this->priority,$this->accepted_args);
    }
  }
}