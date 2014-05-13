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
 * WP style
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
class WPstyle
{
    protected $handle;
    protected $src       = "";
    protected $deps      = array();
    protected $ver       = false;
    protected $media     = 'all';

    public function __construct($handle, $src = "", $deps = array(), $ver = false, $media = 'all')
    {
        $this->handle = $handle;
        $this->src    = $src;
        $this->deps   = $deps;
        $this->ver    = $ver;
        $this->media  = $media;
    }

    public function enqueue()
    {
        if (defined('SCRIPT_DEBUG') &&
            SCRIPT_DEBUG !== false
        ) {
            if (!empty($this->src)) {
                $nonminUrl = str_replace(".min.css", ".css", $this->src);
                if (@fopen($nonminUrl, "r") !== false) {
                    $this->src = $nonminUrl;
                }

            }
        }
        wp_enqueue_style(
            $this->handle,
            $this->src,
            $this->deps,
            $this->ver,
            $this->media
        );
    }

    public function dequeue()
    {
        wp_dequeue_style($this->handle);
    }
    
    public function deregister()
    {
        wp_deregister_style($this->handle);
    }
}
