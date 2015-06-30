<?php
namespace WPCore;

use WPCore\admin\WPpostSaveable;

interface WPpostInterface
{
    public function setPost(\WP_Post $post);
    public function getPost();
    public function clear();
    public function getAll();

    public function get($key, $default = null);
    public function set($key, $value);
    public function fetch();
}
