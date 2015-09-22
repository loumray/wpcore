<?php
namespace WPCore;

use WPCore\admin\WPpostSaveable;

trait WPpostImpl
{
    protected $postId;
    protected $post;
    protected $meta = array();
    protected $metaprefix = '';

    public static function getInstance($pid)
    {
        $post = new self($pid);
        $post->setPost(\WP_Post::get_instance($pid));
        $post->fetch();
        return $post;
    }

    public static function create($postId)
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
        $this->postId = $post->ID;
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

    /**
    *
    * Note: actually meta value with prefixed key is return over native non prefixed metakey
    */
    public function get($key, $default = null)
    {
        $metakey = $this->key($key);
        if (isset($this->meta[$metakey])) {
            return $this->meta[$metakey];
        }

        if (isset($this->post->$metakey)) {
            return $this->post->$metakey;
        }

        //if prefixed meta data is not present return meta value of non prefixed metakey
        if (isset($this->post->$key)) {
            return $this->post->$key;
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
        foreach ($this->meta as $key => $value) {
            $key = $this->key($key);
            $changed = update_post_meta($this->postId, $key, $value) || $changed;
        }
        return $changed;
    }
}
