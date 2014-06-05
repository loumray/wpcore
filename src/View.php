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
 * Basic views
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
class View
{
    protected $file;
    protected $name;
    protected $data;

    protected $allowOverride = false;
    protected $overrideName = '';
    protected $overrideDir = '';

    public function __construct($file, $data = array())
    {
        $this->file = $file;
        $this->name = basename($file);
        $this->data = $data;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getContent()
    {
        ob_start();
        $this->show();
        $out = ob_get_clean();

        return $out;
    }

    public function setAllowOverride($allow = true, $overrideName = '')
    {
        $this->allowOverride = $allow;
        $this->overrideName = $this->name;
        if (!empty($overrideName)) {
            $this->overrideName = $overrideName;
        }
        return $this;
    }
    public function setOverrideDir($subDir)
    {
        $this->overrideDir = $subDir.'/';
        return $this;
    }

    public function show()
    {
        if (($this->allowOverride === true) &&
            $override = locate_template($this->overrideDir.$this->overrideName)
        ) {
            $this->file = $override;
        }

        if (file_exists($this->file)) {
            //load WP context
            global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

            if (is_array($wp_query->query_vars)) {
                extract($wp_query->query_vars, EXTR_SKIP);
            }
            //load view data
            extract($this->data);
            include($this->file);
            return true;
        } else {
            throw new \Exception("File not found on ".$this->file);
        }

        return false;
    }

    /**
     * Gets the value of data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
