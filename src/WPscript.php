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
    protected $inFooter  = true;

    public function __construct($handle, $src = false, $deps = array(), $ver = false, $inFooter = true)
    {
        $this->handle    = $handle;
        $this->src       = $src;
        $this->deps      = $deps;
        $this->ver       = $ver;
        $this->inFooter = $inFooter;
    }

    public function enqueue()
    {
        if (defined('SCRIPT_DEBUG') &&
            SCRIPT_DEBUG !== false
        ) {
            if (!empty($this->src)) {
                $nonminUrl = str_replace(".min.js", ".js", $this->src);
                if (@fopen($nonminUrl, "r") !== false) {
                    $this->src = $nonminUrl;
                }

            }
        }
        wp_enqueue_script(
            $this->handle,
            $this->src,
            $this->deps,
            $this->ver,
            $this->inFooter
        );
    }

    public function dequeue()
    {
        wp_dequeue_script($this->handle);
    }

    public function register()
    {
        wp_register_script(
            $this->handle,
            $this->src,
            $this->deps,
            $this->ver,
            $this->inFooter
        );
    }

    /**
     * Gets the value of handle.
     *
     * @return mixed
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * Sets the value of handle.
     *
     * @param mixed $handle the handle
     *
     * @return self
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;

        return $this;
    }

    /**
     * Gets the value of src.
     *
     * @return mixed
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Sets the value of src.
     *
     * @param mixed $src the src
     *
     * @return self
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Gets the value of deps.
     *
     * @return mixed
     */
    public function getDeps()
    {
        return $this->deps;
    }

    /**
     * Sets the value of deps.
     *
     * @param mixed $deps the deps
     *
     * @return self
     */
    public function setDeps($deps)
    {
        $this->deps = $deps;

        return $this;
    }

    /**
     * Gets the value of ver.
     *
     * @return mixed
     */
    public function getVer()
    {
        return $this->ver;
    }

    /**
     * Sets the value of ver.
     *
     * @param mixed $ver the ver
     *
     * @return self
     */
    public function setVer($ver)
    {
        $this->ver = $ver;

        return $this;
    }

    /**
     * Gets the value of inFooter.
     *
     * @return mixed
     */
    public function getInFooter()
    {
        return $this->inFooter;
    }

    /**
     * Sets the value of inFooter.
     *
     * @param mixed $inFooter the inFooter
     *
     * @return self
     */
    public function setInFooter($inFooter)
    {
        $this->inFooter = $inFooter;

        return $this;
    }
}
