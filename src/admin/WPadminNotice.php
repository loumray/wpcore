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

class WPadminNotice extends WPaction
{
    protected $errormsg;
    protected $view;

    public function __construct(View $view, $errormsg)
    {
        parent::__construct('admin_notices');

        $this->errormsg = $errormsg;
        $this->view = $view;
    }

    public function action()
    {
        if (!empty($this->errormsg)) {
            $current_user = wp_get_current_user();
            if (isset($current_user->data->wp_capabilities['administrator'] ) ||
                in_array("administrator", $current_user->roles)) {
                if (is_array($this->errormsg)) {
                    foreach ($this->errormsg as $errormsg) {
                        $this->view->setData(array('errormsg' => $errormsg));
                        $this->view->show();
                    }
                } else {
                    $this->view->setData(array('errormsg' => $this->errormsg));
                    $this->view->show();
                }
            }
        }
    }
}
