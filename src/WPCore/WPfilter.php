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
 * WP filter
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
abstract class WPfilter implements WPhook
{
  protected $tag;
  protected $priority;
  protected $argsCount;

  abstract public function action();

  public function __construct($tag, $priority = 10, $accepted_args = 1)
  {
    $this->tag       = $tag;
    $this->priority  = $priority;
    $this->argsCount = $accepted_args;
  }

  public function register()
  {
    add_filter($this->tag, array($this,'action'),$this->priority,$this->argsCount);
  }

  public function remove()
  {
    remove_filter($this->tag, array($this,'action'),$this->priority,$this->argsCount);
  }
}