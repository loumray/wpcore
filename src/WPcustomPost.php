<?php
namespace WPCore;

use WPCore\admin\WPpostSaveable;

class WPcustomPost implements WPpostSaveable
{
    protected $postId;
    protected $post;
    protected $meta = array();
    protected $metaprefix = '';

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

    protected function key($key)
    {
        return $this->metaprefix.$key;
    }

    public function setMetaPrefix($prefix)
    {
        $this->metaprefix = $prefix;
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

    public function clear()
    {
        $this->meta = array();
        return $this;
    }

    public function getAll()
    {
        return $this->meta;
    }

    public function get($key, $default = null)
    {
        if(isset($this->post->$key)) {
            return $this->post->$key;
        }
        $key = $this->key($key);
        if(isset($this->post->$key)) {
            return $this->post->$key;
        }

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
        $this->meta = get_post_meta($this->postId);
        if (empty($this->meta)) {
            $this->meta = array();
        }
        foreach ($this->meta as $key => $value) {
            if (is_array($value) && count($value) === 1) {
                $this->meta[$key] = $value[0];
            } 
        }
        return true;
    }

    public function save()
    {
        $changed = true;
        foreach($this->meta as $key => $value) {
            $key = $this->key($key);
            $changed = update_post_meta($this->postId, $key, $value) || $changed;
        }
        return $changed;
    }
}
