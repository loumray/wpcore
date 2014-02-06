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
 * WP hook interface
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
interface WPhook
{
    public function register();
    public function remove();
}
