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

class WPpluginTextDomain extends WPaction
{
    protected $domain;
    protected $abs_rel_path;
    protected $plugin_rel_path;

    public function __construct($domain, $abs_rel_path, $plugin_rel_path)
    {
        parent::__construct('plugins_loaded');

        $this->domain = $domain;
        $this->abs_rel_path = $abs_rel_path;
        $this->plugin_rel_path = $plugin_rel_path;
    }

    public function action()
    {
        load_plugin_textdomain($this->domain, $this->abs_rel_path, $this->plugin_rel_path);
    }
}
