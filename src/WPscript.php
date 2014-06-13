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
    protected $src      = "";
    protected $debugsrc = "";
    protected $deps     = array();
    protected $ver      = false;
    protected $inFooter = true;
    protected $forceSource = false;

    public function __construct(
        $handle,
        $src = false,
        $debugsrc = false,
        $deps = array(),
        $ver = false,
        $inFooter = true,
        $forceSource = false
    ) {
        $this->handle   = $handle;
        $this->src      = $src;
        $this->debugsrc = $debugsrc;
        $this->deps     = $deps;
        $this->ver      = $ver;
        $this->inFooter = $inFooter;
        $this->forceSource = $forceSource;
    }

    public function fetch()
    {
        global $wp_scripts;
        if (!empty($wp_scripts->registered[$this->handle])) {
            $this->src = $wp_scripts->registered[$this->handle]->src;
            $this->deps = $wp_scripts->registered[$this->handle]->deps;
            $this->ver = $wp_scripts->registered[$this->handle]->ver;
        }
    }

    public function enqueue()
    {
        if (defined('SCRIPT_DEBUG') &&
            SCRIPT_DEBUG !== false &&
            !empty($this->debugsrc)
        ) {
            $this->src = $this->debugsrc;
        }

        if ($this->forceSource === true) {
            $this->deregister();
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
        if (defined('SCRIPT_DEBUG') &&
            SCRIPT_DEBUG !== false &&
            !empty($this->debugsrc)
        ) {
            $this->src = $this->debugsrc;
        }
        wp_register_script(
            $this->handle,
            $this->src,
            $this->deps,
            $this->ver,
            $this->inFooter
        );
    }

    public function deregister()
    {
        wp_deregister_script($this->handle);
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
