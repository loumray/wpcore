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

use WPCore\View;
use WPCore\admin\WPadminNotice;

/**
 * WP plugin
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
abstract class WPplugin extends WPfeature
{

    protected $reqPHPVersion = '5.3.0';
    protected $reqWPVersion  = '3.0.0';
    protected $reqPHPMsg     = '';
    protected $reqWPMsg      = '';
    protected $langDir       = '/lang';

    protected $errors  = array();

    protected $reqPlugins = array();

    protected $mainFeature;

    public function __construct($file, $name, $slug)
    {
        parent::__construct($name, $slug);

        $this->setBaseUrl(plugin_dir_url($file));
        $this->setBasePath(plugin_dir_path($file));

        register_activation_hook($file, array($this, 'install'));
        register_deactivation_hook($file, array($this, 'uninstall'));
    }

    public function init()
    {
        if ($this->checkServerRequirements() === false) {
            $errormsg = array();

            foreach ($this->getErrors() as $error) {
                if (($error == 'WP') && (!empty($this->reqWPMsg))) {
                    //sprintf(__('%s Requirements failed. WP version must at least %s', 'loumray-plugin-starter'),
                    //$this->getName(), $this->reqWPVersion);
                    $errormsg[] = $this->reqWPMsg;
                } elseif (($error == 'PHP') && (!empty($this->reqPHPMsg))) {
                    //sprintf(__(__('%s Requirements failed. PHP version must at least %s', 'loumray-plugin-starter')),
                    //$this->getName(), $this->reqPHPVersion);
                    $errormsg[] = $this->reqPHPMsg;
                }
            }
            $this->hook(new WPadminNotice($errormsg));

            return;
        }

        if (!is_null($this->mainFeature)) {
            $this->hook($this->mainFeature);
        }
    }

    public function setMainFeature(WPfeature $mainfeature)
    {
        $this->mainFeature = $mainfeature;

        $this->mainFeature->setBaseUrl($this->getBaseUrl());
        $this->mainFeature->setBasePath($this->getBasePath());
    }

    public function install()
    {
        if (!is_null($this->mainFeature)  &&
            method_exists($this->mainFeature, 'install')) {
            $this->mainFeature->install();
        }
    }

    public function uninstall()
    {
        if (!is_null($this->mainFeature)  &&
            method_exists($this->mainFeature, 'uninstall')) {
            $this->mainFeature->uninstall();
        }
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

    public function setReqPhpMsg($reqPHPMsg)
    {
        $this->reqPHPMsg = $reqPHPMsg;
    }

    public function setReqWpMsg($reqWPMsg)
    {
        $this->reqWPMsg = $reqWPMsg;
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
