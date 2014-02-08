<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore\admin;

use WPCore\View;
use WPCore\WPaction;

/**
 * WP admin head
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPadminHead extends WPaction
{
    protected $view;

    public function __construct(View $view)
    {
        parent::__construct('admin_head');
        $this->view = $view;
    }

    public function action()
    {
        $this->view->show();
    }
}