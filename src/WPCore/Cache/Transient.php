<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore\Cache;

/**
 * Transient
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
class Transient
{
    protected $name;
    protected $value;
    protected $expiration;  //in seconds, 0 = never expires

    public function __construct($prefix, $params = "", $expInSeconds = 0)
    {
        if (empty($params)) {
            $this->setName($prefix);
        } else {
            $this->setName($this->createKey($prefix, $params));
        }
        $this->expiration = $expInSeconds;
    }

    public function createKey($prefix, $params)
    {
        return $prefix.sha1(json_encode($params));
    }

    public function set($value)
    {
        $this->value = $value;

        return set_site_transient($this->name, $this->value, $this->expiration);
    }

    /**
     * Gets the value of transient.
     *
     * @return mixed false if the transient does not exist, does not have a value, or has expired, then get_transient
     */
    public function get()
    {
        $this->value = get_site_transient($this->name);

        return $this->value;
    }

    public function delete()
    {
        return delete_site_transient($this->name);
    }

    /**
     * Gets the value of name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param mixed $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = substr($name, 0, 40);

        return $this;
    }

    /**
     * Gets the value of value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value of value.
     *
     * @param mixed $value the value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Gets the value of expiration.
     *
     * @return mixed
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * Sets the value of expiration.
     *
     * @param mixed $expiration the expiration
     *
     * @return self
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;

        return $this;
    }
}
