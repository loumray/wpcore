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

/**
 * WP submenu page
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class InsertPost extends WPaction
{
    public function __construct()
    {
        parent::__construct('wp_insert_post', 100, 1);
    }

    //In dev todo
    public function action()
    {
        return null;
    }
}
