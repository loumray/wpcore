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

class WPpageColumn extends WPpostColumn
{
    public function action()
    {
        add_action("manage_pages_custom_column", array($this, 'content'), 10, 2);
        add_filter("manage_edit-page_columns", array($this, 'header'));
    }
}
