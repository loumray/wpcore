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

use WPCore\WPfilter;

class DefaultWalkerNavMenu extends WPfilter
{
    protected $walker;

    public function __construct(\Walker_Nav_Menu $walker)
    {
        parent::__construct('wp_nav_menu_args');
        $this->walker = $walker;
    }

    public function action()
    {
        $args = func_get_arg(0);

        if (empty($args['walker'])) {
            $args['walker'] = $this->walker;
        }
        return $args;
    }
}