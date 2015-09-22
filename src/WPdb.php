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
 * WPDb
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPdb extends \PDO
{
    static $instance;

    protected $dbhost;
    protected $dbname;
    protected $dbuser;
    protected $dbpass;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {

        if (defined('DB_HOST')) {
            $this->dbhost = DB_HOST;
        }
        if (defined('DB_NAME')) {
            $this->dbname = DB_NAME;
        }
        if (defined('DB_USER')) {
            $this->dbuser = DB_USER;
        }
        if (defined('DB_PASSWORD')) {
            $this->dbpass = DB_PASSWORD;
        }

        try {
            parent::__construct('mysql:host='.$this->dbhost.';dbname='.$this->dbname, $this->dbuser, $this->dbpass);

        } catch (\PDOException $e) {
            error_log("WPDb error: ".$e->getMessage());
            die();
        }
    }
}