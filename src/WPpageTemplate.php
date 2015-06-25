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
 * WP page template
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPpageTemplate extends WPaction
{

    protected $title;
    protected $path;

    protected $allowOverride = false;
    protected $overrideName = '';
    protected $overrideDir = '';

    public function __construct($title, $path)
    {
        $this->title = $title;
        $this->path = $path;

        parent::__construct('plugins_loaded');
    }

    public function setAllowOverride($allow = true, $overrideName = '')
    {
        $this->allowOverride = $allow;
        $this->overrideName = basename($this->path);
        if (!empty($overrideName)) {
            $this->overrideName = $overrideName;
        }
        return $this;
    }

    public function action()
    {
        add_filter('page_attributes_dropdown_pages_args', array($this, 'add'));
        add_filter('wp_insert_post_data', array($this, 'add'));
        add_filter('template_include', array($this, 'view'));
    }

    public function add($atts)
    {
        $cache_key = 'page_templates-'. md5(get_theme_root().'/'.get_stylesheet());

        $templates = wp_get_theme()->get_page_templates();
        if (empty($templates)) {
            $templates = array();
        }

        wp_cache_delete($cache_key, 'themes');

        $templates = array_merge($templates, array(basename($this->path) => $this->title));
        
        wp_cache_add($cache_key, $templates, 'themes', 1800);

        return $atts;
    }

    public function view($template)
    {
        global $post;

        if (is_null($post)) {
            return $template;
        }
        
        $pagetemplate = get_post_meta($post->ID, '_wp_page_template', true);

        if ($pagetemplate != basename($this->path)) {
            return $template;
        }

        if (($this->allowOverride === true) &&
            $override = locate_template($this->overrideDir.$this->overrideName)
        ) {
            return $override;
        }

        return $this->path;
    }
}
