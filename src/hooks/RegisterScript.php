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

/**
 * WP theme scripts hook
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class RegisterScript extends WPaction
{
    protected $script;

    public function __construct(WPscript $script)
    {
        $this->script = $script;

        parent::__construct('wp_enqueue_scripts', 5, 1);
    }

    public function action()
    {
        $this->script->register();
    }
}
