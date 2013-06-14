<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore;

/**
 * WP action
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
abstract class WPaction implements WPhook
{
  protected $tag;
  protected $priority;
  protected $argsCount;

  abstract public function action();

  public function __construct($tag, $priority = 10, $acceptedArgs = 1)
  {
    $this->tag       = $tag;
    $this->priority  = $priority;
    $this->argsCount = $acceptedArgs;
  }

  public function register()
  {
    if(!is_array($this->tag))
    {
      add_action($this->tag, array($this,'action'),$this->priority,$this->argsCount);
    }
    else
    {
      foreach($this->tag as $tag)
      {
        add_action($tag, array($this,'action'),$this->priority,$this->argsCount);
      }
    }
  }

  public function remove()
  {
    if(!is_array($this->tag))
    {
      remove_action($this->tag, array($this,'action'),$this->priority,$this->argsCount);
    }
    else
    {
      foreach($this->tag as $tag)
      {
        remove_action($tag, array($this,'action'),$this->priority,$this->argsCount);
      }
    }

  }
}