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
 * WP admin script hook
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class AdminScript extends WPaction
{
    protected $scripts = array();
    protected $styles  = array();

    public function __construct()
    {
        parent::__construct('admin_enqueue_scripts', 100, 1);
    }

    public function registerScriptsStyles()
    {
        $this->registerStyles();
        $this->registerScripts();
    }

    public function registerScripts()
    {
        foreach ($this->scripts as $script) {
            $script->register();
        }
    }

    public function registerStyles()
    {
        foreach ($this->styles as $styles) {
            $styles->register();
        }
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
        if (!empty($this->scripts)) {
            $hook = func_get_arg(0);
            foreach ($this->scripts as $script) {
                //todo support page specific script
                $script->enqueue($hook);
            }
        }

        if (!empty($this->styles)) {
            $hook = func_get_arg(0);
            foreach ($this->styles as $script) {
                //todo support page specific script
                $script->enqueue($hook);
            }
        }

        return null;
    }
}
