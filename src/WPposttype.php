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
 * WP post type
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPposttype extends WPaction
{
    protected $slug;
    protected $args;

    protected $taxonomies = array();

    public function __construct($slug, $args = array())
    {
        parent::__construct('init');
        $this->slug = $slug;

        $defaults = array();
        $this->args = wp_parse_args($args, $defaults);

    }

    public function setArg($arg, $value)
    {
        $this->args[$arg] = $value;

        return $this;
    }

    public function getArg($arg, $default = null)
    {
        if (isset($this->args[$arg])) {
            return $this->args[$arg];
        }

        return $default;
        
    }
    public function getSlug()
    {
        return $this->slug;
    }

    public function getLoop($args = array())
    {
        $defaults = array(
            'post_type' => $this->slug,
            'nopaging' => true
        );
        $args = wp_parse_args($args, $defaults);

        return new \WP_Query($args);
    }

    public function addTaxonomy($slug, $args = array())
    {
        $this->taxonomies[$slug] = new WPtaxonomy($slug, $this->getSlug(), $args);
        $this->setArg('taxonomies', array_keys($this->taxonomies));
    }

    public function register()
    {
        foreach ($this->taxonomies as $slug => $taxonomy) {
            $taxonomy->register();
        }
        parent::register();
    }

    public function action()
    {
        register_post_type($this->slug, $this->args);
    }
}
