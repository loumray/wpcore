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
 * Basic Config
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
class Config
{
    public static $instance;

    protected $prefix = '';

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getOptionKey($key)
    {
        return $this->prefix.$key;
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this->prefix;
    }

    /*
    * @return var if value option does not exist
    */
    public function get($key, $default = null)
    {
        $option = new WPoption($this->getOptionKey($key));
        $option = $option->getValue();

        //Return null instead of false if option is not set
        if ($option === false) {
            return $default;
        }

        return $option;
    }

    public function set($key, $value)
    {
        $option = new WPoption($this->getOptionKey($key));
        $option = $option->setValue($value);

        return $option->save();
    }
}
