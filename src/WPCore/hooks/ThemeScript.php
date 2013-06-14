<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore\hooks;

use WPCore\WPaction;
use WPCore\WPscript;
use WPCore\WPstyle;

/**
 * WP theme scripts hook
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
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
    return null;
  }
}