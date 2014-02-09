<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore\admin;

use WPCore\Config;
use WPCore\View;
use WPCore\WPaction;

/**
 * WP admin head
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPsettingsLoader extends WPaction
{
    static $instance;

    protected $sections = array();
    protected $settings = array();

    protected $patched = false;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        parent::__construct('admin_init');
    }

    public function addPatch()
    {
        if ($this->patched === false) {
            add_filter('wp_redirect', array($this, 'permalinkSaveSettings'), 10, 2);
            $this->patched = true;
        }
    }

    public function permalinkSaveSettings()
    {
        $location = func_get_arg(0);
        $status = func_get_arg(1);
        if ($location == admin_url( 'options-permalink.php?settings-updated=true' )) {
            $whitelist_options = apply_filters( 'whitelist_options', array() );

            if (isset($whitelist_options['permalink'])) {
                foreach ($whitelist_options['permalink'] as $option ) {
                    $option = trim($option);
                    $value = null;
                    if (isset($_POST[$option])) {
                        $value = $_POST[ $option ];
                        if (!is_array($value)) {
                            $value = trim($value);
                        }
                        $value = wp_unslash($value);
                    }
                    update_option($option, $value);
                }
            }
        }
        return $location;
    }

    public function addSection(WPsettingsSection $section)
    {
        $this->sections[] = $section;
    }

    public function addSetting(WPsetting $setting)
    {
        $this->settings[] = $setting;
    }
    public function action()
    {
        foreach ($this->sections as $section) {
            $section->add();
        }

        foreach ($this->settings as $setting) {
            //WP Permalink page does not save custom settings
            //See https://core.trac.wordpress.org/ticket/9296
            //This patch save the options while WP works to solve this issue
            if ($setting->getPageMenuSlug() == 'permalink') {
                $this->addPatch();
            }
            $setting->add();
            $setting->register();
        }
    }
}