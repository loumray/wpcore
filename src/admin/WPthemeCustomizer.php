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

use WPCore\View;
use WPCore\WPaction;
use WPCore\WPScript;
use WPCore\WPStyle;

/**
 * WP Theme Customizer
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

abstract class WPthemeCustomizer extends WPaction
{
    protected $prefix = '';
    protected $livePreviewScript;
    protected $scripts = array();
    protected $styles  = array();

    protected $sections = array();
    protected $settings = array();
    protected $controls = array();

    public function __construct(WPScript $livePreviewScript = null)
    {
        parent::__construct('customize_register', 10, 1);

        if (!is_null($livePreviewScript)) {
            $this->livePreviewScript = $livePreviewScript;
        }

        
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function register()
    {
        add_action('customize_preview_init', array($this , 'loadScript'));
        add_action('customize_save_after', array($this , 'save'));
        add_action('customize_controls_enqueue_scripts', array($this, 'enqueueAssets'));
        add_action('customize_register', array($this, 'customizeDefault'));
        parent::register();
    }

    public function loadScript()
    {
        if (!is_null($this->livePreviewScript)) {
            $this->livePreviewScript->enqueue();
        }
    }

    public function customizeDefault($wpCustomizer)
    {
        return;
    }

    public function addSection($sectionId, $properties)
    {
        $defaults = array(
            'capability' => 'edit_theme_options'
        );
        $this->sections[$sectionId] = wp_parse_args($properties, $defaults);
    }

    /*
    * @param default
    *   A default value for the setting if none is defined
    * @param type
    *   Optional. Specifies the TYPE of setting this is. Options are 'option' or 'theme_mod' (defaults to 'theme_mod')
    * @param capability
    *   Optional. You can define a capability a user must have to modify this setting
    * @param theme_supports
    *   Optional. This can be used to hide a setting if the theme lacks support for a specific feature (using add_theme_support).
    * @param transport
    *   Optional. This can be either 'refresh' (default) or 'postMessage'. Only set this to 'postMessage' if you are writing custom Javascript to control the Theme Customizer's live preview.
    * @param sanitize_callback
    *   Optional. A function name to call for sanitizing the input value for this setting. The function should be of the form of a standard filter function, where it accepts the input data and returns the sanitized data.
    * @param sanitize_js_callback
    *   Optional. A function name to call for sanitizing the value for this setting for the purposes of outputting to javascript code. The function should be of the form of a standard filter function, where it accepts the input data and returns the sanitized data. This is only necessary if the data to be sent to the customizer window has a special form.
    */
    public function addSetting($settingId, $properties)
    {
        $defaults = array(
            'capability' => 'edit_theme_options',
            'transport' => 'postMessage'
        );
        $this->settings[$settingId] = wp_parse_args($properties, $defaults);
    }

    public function addControl($controlId, $class, $properties)
    {
        $defaults = array();
        $this->controls[$controlId]['class'] = $class;
        $this->controls[$controlId]['properties'] = wp_parse_args($properties, $defaults);
    }

    abstract public function init();

    public function action()
    {
        $wpCustomize = func_get_arg(0);
        $this->init();
        foreach ($this->sections as $id => $properties) {
            $wpCustomize->add_section($this->prefix.$id, $properties);
        }

        foreach ($this->settings as $id => $properties) {
            $wpCustomize->add_setting($this->prefix.$id, $properties);
        }

        foreach ($this->controls as $id => $control) {
            $class = $control['class'];
            if (isset($control['properties']['section'])) {
                switch ($control['properties']['section']) {
                    case 'title_tagline':
                    case 'colors':
                    case 'header_image':
                    case 'background_image':
                    case 'nav':
                    case 'static_front_page':
                        break;
                    default:
                        $control['properties']['section'] = $this->prefix.$control['properties']['section'];
                }
            }
            if (isset($control['properties']['settings'])) {
                if (isset($this->settings[$control['properties']['settings']])) {
                    $control['properties']['settings'] = $this->prefix.$control['properties']['settings'];
                }
            }
            $wpCustomize->add_control(
                new $class(
                    $wpCustomize,
                    $this->prefix.$id,
                    $control['properties']
                )
            );
        }
    }

    public function save($customizer)
    {
        return;
    }

    public function getMod($modId, $default = null)
    {
        $mod = get_theme_mod($this->prefix.$modId, $default);
        if (!empty($mod)) {
            return $mod;
        }
        return $default;
    }

    /**
     * Sets the value of livePreviewScript.
     *
     * @param mixed $livePreviewScript the live preview script
     *
     * @return self
     */
    public function setLivePreviewScript(WPScript $livePreviewScript)
    {
        $this->livePreviewScript = $livePreviewScript;

        return $this;
    }

    public function addScript(WPscript $script)
    {
        $this->scripts[] = $script;
    }

    public function addStyle(WPstyle $style)
    {
        $this->styles[] = $style;
    }
    public function enqueueAssets()
    {
        foreach ($this->scripts as $script) {
            $script->enqueue();
        }
        foreach ($this->styles as $style) {
            $style->enqueue();
        }
    }
}
