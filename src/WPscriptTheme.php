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
    protected $loadCondition = true;

    public function __construct(
        $loadCondition,
        $handle,
        $src = false,
        $debugsrc = false,
        $deps = array(),
        $ver = false,
        $in_footer = true,
        $force = false
    ) {
        parent::__construct($handle, $src, $debugsrc, $deps, $ver, $in_footer, $force);

        $this->loadCondition = $loadCondition;
    }

    public function isNeeded()
    {
        switch ($this->loadCondition) {
            case 'comments':
                return is_single() && comments_open() && get_option('thread_comments');
            case 'always':
            default:
                return true;
        }
    }

    public function enqueue()
    {
        if ($this->isNeeded()) {
            parent::enqueue();
        }
    }
}
