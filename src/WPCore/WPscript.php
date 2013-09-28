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
 * WP script
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPscript
{
    protected $handle;
    protected $src       = "";
    protected $deps      = array();
    protected $ver       = false;
    protected $in_footer  = true;

    public function __construct($handle, $src = false, $deps = array(),$ver = false, $in_footer = true)
    {
        $this->handle    = $handle;
        $this->src       = $src;
        $this->deps      = $deps;
        $this->ver       = $ver;
        $this->in_footer = $in_footer;
    }

    public function enqueue()
    {
        wp_enqueue_script(
            $this->handle,
            $this->src,
            $this->deps,
            $this->ver,
            $this->in_footer
        );
    }

    public function register()
    {
        wp_register_script( 
            $this->handle, 
            $this->src, 
            $this->deps, 
            $this->ver, 
            $this->in_footer 
        );
    }

}