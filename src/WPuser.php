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
 * WP user
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
class WPuser
{
    protected $uid;
    protected $wpuser;
    protected $meta = array();

    public static function getCurrent()
    {
        if (!function_exists('get_current_user_id')) {
            throw new \Exception('trying to get user info before wp data is available');
        }
        $uid = \get_current_user_id();
        if (empty($uid)) {
            return null;
        }
        return new self($uid);
    }

    public function __construct($uid)
    {
        $this->uid = $uid;
        $this->wpuser = new \WP_User($uid);
    }

    public function user()
    {
        return $this->wpuser;
    }

    public function get($metakey, $default = null)
    {
        if (isset($this->meta[$metakey])) {
            return $this->meta[$metakey];
        }

        if (isset($this->user()->$metakey)) {
            return $this->user()->$metakey;
        }

        return $default;
    }

    public function set($key, $value)
    {
        $this->meta[$key] = $value;

        return $this;
    }

    public function save()
    {
        $changed = true;
        foreach ($this->meta as $key => $value) {
            $changed = update_user_meta($this->uid, $key, $value) || $changed;
        }
        return $changed;
    }

    public function can($capability)
    {
        return $this->wpuser->has_cap($capability);
    }

    public function cant($capability)
    {
        return !$this->can($capability);
    }
}
