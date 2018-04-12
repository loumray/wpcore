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
 * WP taxonomy
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
class WPtaxonomy extends WPaction
{
    protected $slug;
    protected $type;
    protected $args;

    public function __construct($slug, $type, $args = array())
    {
        parent::__construct('init');

        $this->slug = $slug;
        $this->type = $type;

        //TODO setup common defaults
        $defaults = array();
        $this->args = wp_parse_args($args, $defaults);
    }

    public function action()
    {
        register_taxonomy($this->slug, $this->type, $this->args);

        //As per WP doc: https://codex.wordpress.org/Function_Reference/register_taxonomy
        // Better be safe than sorry when registering custom taxonomies for
        // custom post types. Use register_taxonomy_for_object_type() right
        // after the function to interconnect them. Else you could run into
        // minetraps where the post type isn't attached inside filter callback
        // that run during parse_request or pre_get_posts.
        register_taxonomy_for_object_type($this->slug, $this->type);
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getType()
    {
        return $this->type;
    }
}
