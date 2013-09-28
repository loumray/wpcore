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
 * WP plugin
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
abstract class WPplugin extends WPfeature
{

    public static $instance;

    protected $reqPHPVersion  = '5.3.0';
    protected $reqWPVersion   = '3.0.0';
    protected $langDir        = '/lang';
    protected $errors  = array();

    protected $reqPlugins = array();

    abstract public function install();
    
    public function __construct($file, $name, $slug)
    {
        parent::__construct($name, $slug);

        $this->setBaseUrl(plugin_dir_url($file));
        $this->setBasePath(plugin_dir_path($file));

        register_activation_hook($file, array($this, 'install'));
    }

    public function getLangDir()
    {
        return $this->langDir;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setLangDir($langDir)
    {
        $this->langDir = $langDir;
    }

    public function setReqPhpVersion($reqPHPVersion)
    {
        $this->reqPHPVersion = $reqPHPVersion;
    }

    public function setReqWpVersion($reqWPVersion)
    {
        $this->reqWPVersion = $reqWPVersion;
    }

    public function requires($pluginMainFile)
    {
        $this->reqPlugins[] = $pluginMainFile;
    }

    //TODO hook this on any plugin desactivation
    public function checkPluginsRequirements()
    {
        $return = true;

        //Custom plugins requirements
        foreach ($this->reqPlugins as $pluginMainFile) {
            if (!in_array($pluginMainFile, apply_filters('active_plugins', get_option('active_plugins')))) {
                $this->errors[] = $pluginMainFile;
                $return = false;
            }
        }

        return $return;
    }

    //Errors & requirements
    public function checkServerRequirements()
    {
        $return = true;
        //PHP version requirements
        if (version_compare(PHP_VERSION, $this->reqPHPVersion, '<')) {
            $this->errors[] = 'PHP';
            $return = false;
        }

        //WP version requirements
        if (version_compare($GLOBALS['wp_version'], $this->reqWPVersion, '<')) {
            $this->errors[] = 'WP';
            $return = false;
        }

        return $return;
    }
}
