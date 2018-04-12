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
 * WP script admin
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
class WPscriptAdmin extends WPscript
{
    protected $admin_page = array();

    public function __construct(
        $admin_page,
        $handle,
        $src = false,
        $debugsrc = false,
        $deps = array(),
        $ver = false,
        $in_footer = true,
        $force = false
    ) {
        parent::__construct($handle, $src, $debugsrc, $deps, $ver, $in_footer, $force);

        if (!is_array($admin_page)) {
            $admin_page[] = $admin_page;
        }
        $this->admin_page = $admin_page;
    }

    public function isNeeded($page)
    {
        if (empty($this->admin_page)) {
            return true;
        }

        if (in_array($page, $this->admin_page)) {
            return true;
        } elseif (isset($this->admin_page[$page])) {
            if (empty($this->admin_page[$page])) {
                return true;
            } elseif (isset($this->admin_page[$page]['post_type'])) {
                global $post;
                if ($post->post_type === $this->admin_page[$page]['post_type']) {
                    return true;
                }
            }
        }

        return false;
    }

    public function enqueue()
    {
        $page = func_get_arg(0);
        if ($this->isNeeded($page)) {
            parent::enqueue();
        }
    }
}
