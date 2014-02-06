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
 * WP script theme
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
class WPscriptTheme extends WPscript
{
    protected $load_condition = true;

    public function __construct($load_condition, $handle, $src = false, $deps = array(), $ver = false, $in_footer = true)
    {
        parent::__construct($handle, $src, $deps, $ver, $in_footer);

        $this->load_condition = $load_condition;
    }

    //TODO This might be unsafe to change
    public function isNeeded()
    {
        $isNeeded = $this->load_condition;
        eval("\$isNeeded = $isNeeded;");

        return $isNeeded;
    }

    public function enqueue()
    {
        if ($this->isNeeded()) {
            parent::enqueue();
        }
    }
}
