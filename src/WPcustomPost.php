<?php
namespace WPCore;

use WPCore\admin\WPpostSaveable;

class WPcustomPost implements WPpostSaveable
{
    protected $postId;
    protected $post;
    protected $meta = array();
    protected $metakey = 'wpcmeta';

    public static function getInstance($id)
    {
        $post = new self($id);
        $post->setPost(\WP_Post::get_instance($id));
        $post->fetch();
        return $post;
    }

    static public function create($postId)
    {
        return new self($postId);
    }

    public function __construct($postId)
    {
        $this->postId = $postId;
    }

    public function setPost(\WP_Post $post)
    {
        $this->post = $post;
        return $this;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function get($key, $default = null)
    {
        if (isset($this->meta[$key])) {
            return $this->meta[$key];
        }
        return $default;
    }

    public function set($key, $value)
    {
        $this->meta[$key] = $value;

        return $this;
    }

    public function fetch()
    {
        $this->meta = get_post_meta($this->postId, $this->metakey, true);
        if (empty($this->meta)) {
            $this->meta = array();
        } else {
            $this->meta = unserialize($this->meta);
        }
        return true;
    }

    public function save()
    {
        return update_post_meta($this->postId, $this->metakey, serialize($this->meta));
    }
}