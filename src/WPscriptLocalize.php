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

use WPCore\WPaction;

/**
 * WP theme scripts hook
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPscriptLocalize extends WPaction
{
    protected $handle;
    protected $name;
    protected $data;

    public function __construct($handle, $name, $data)
    {
        if (is_admin()) {
            parent::__construct('admin_enqueue_scripts', 10000, 1);
        } else {
            parent::__construct('wp_enqueue_scripts', 10000, 1);
        }
        
        $this->handle = $handle;
        $this->name   = $name;
        $this->data   = $data;
    }

    public function action()
    {
        wp_localize_script($this->handle, $this->name, $this->data);

        return null;
    }
}
