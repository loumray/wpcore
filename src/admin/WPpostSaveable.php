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

/**
 * WP post saveable interface
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
interface WPpostSaveable
{
    public static function create($postId);
    public function get($key);
    public function set($key, $value);
    public function fetch();
    public function save();
}
