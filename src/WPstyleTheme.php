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
 * WP style theme
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
class WPstyleTheme extends WPstyle
{
    protected $loadCondition = true;
    protected $allowOverride = false;
    protected $overrideDir = 'assets/css/';

    public function __construct($loadCondition, $handle, $src = "", $deps = array(), $ver = false, $media = 'all', $allowOverride = false)
    {
        parent::__construct($handle, $src, $deps, $ver, $media);

        $this->loadCondition = $loadCondition;
        $this->allowOverride = $allowOverride;
    }

    public function isNeeded()
    {
        switch ($this->loadCondition) {
            case 'comments':
                return is_single() && comments_open() && get_option('thread_comments');
            case 'always':
            default:
                return true;
        }

        return true;
    }

    public function setOverrideDir($subDir)
    {
        $this->overrideDir = $subdir.'/';
        return $this;
    }

    public function enqueue()
    {
        if ($this->isNeeded()) {
            if ($this->allowOverride === true) {
                $name = basename($this->src);
                if ($override = locate_template($this->overrideDir.$name)) {
                    $this->src = get_template_directory_uri() . '/'.$this->overrideDir.$name;
                }
            }
            parent::enqueue();
        }
    }
}
