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
 * WP style admin
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
class WPstyleAdmin extends WPstyle
{
    protected $admin_page = array();

    public function __construct($admin_page, $handle, $src = "", $debugsrc = "", $deps = array(), $ver = false, $media = 'all')
    {
        parent::__construct($handle, $src, $debugsrc, $deps, $ver, $media);

        if (!is_array($admin_page)) {
            $this->admin_page[] = $admin_page;
        } else {
            $this->admin_page = $admin_page;
        }

    }

    public function isNeeded($page)
    {
        if (empty($this->admin_page)) {
            return true;
        }

        return in_array($page, $this->admin_page);
    }

    public function enqueue()
    {
        $page = func_get_arg(0);

        if ($this->isNeeded($page)) {
            parent::enqueue();
        }
    }
}
