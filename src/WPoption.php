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
 * WP option
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPoption
{
    protected $name;
    protected $value;
    protected $default;
    protected $autoload = true;
    protected $fetched  = false;

    public function __construct($optionName, $default = false)
    {
        $this->name    = $optionName;
        $this->default = $default;
    }

    public function getAutoload()
    {
        return $this->autoload;
    }

    public function setAutoload($autoload)
    {
        $this->autoload = $autoload;

        return $this;
    }

    public function getValue()
    {
        if ($this->fetched === false) {
            $this->fetch();
        }

        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function fetch()
    {
        $this->value = get_option($this->name, $this->default);
        $this->fetched = true;
    }
    /*
     * @return True if option has been deleted, false if not or if deletion failed.
    */
    public function delete()
    {
        return delete_option($this->name);
    }

    public function save()
    {
        if (get_option($this->name) !== false) {
            return update_option($this->name, $this->value);
        } else {
            // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
            $autoload = ($this->autoload === true) ? 'yes' : 'no';

            return add_option($this->name, $this->value, null, $autoload);
        }
    }
}
