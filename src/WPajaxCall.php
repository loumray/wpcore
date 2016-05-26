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
 * WP ajax call
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
abstract class WPajaxCall implements WPhook
{
    protected $jsHandle;
    protected $slug;
    protected $admin;
    protected $mustBeLoggedIn;
    protected $jsvar;
    protected $nonceSlug;
    protected $disableNonceCheck;

    protected $nonceQueryVar = 'security';
    protected $currentUser;

    protected $formData = array();

    public function __construct(
        $call_slug,
        $js_handle,
        $admin = false,
        $mustBeLoggedIn = false,
        $nonceSlug = "",
        $disableNonceCheck = false
    ) {
        $this->slug     = $call_slug;
        $this->jsHandle = $js_handle;
        $this->admin    = $admin;
        $this->mustBeLoggedIn = $mustBeLoggedIn || $admin;
        $this->disableNonceCheck = $disableNonceCheck;

        $this->jsvar = str_replace('-', '_', $this->slug).'_params';
        $this->nonceSlug = $nonceSlug;
        if (empty($this->nonceSlug)) {
            $this->nonceSlug = $this->slug.'-action';
        }
    }

    abstract public function callback($data);

    public function safeCallback()
    {
        $this->verify();

        $data = array();
        if (!empty($_POST['data'])) {
            foreach ($_POST['data'] as $info) {
                if (!isset($info['name'])) {
                    continue;
                }
                $data[$info['name']] = $info['value'];
            }
        }

        return $this->callback($data);
    }

    public function getActionSlug()
    {
        return $this->slug;
    }

    public function getJsVar()
    {
        return $this->jsvar;
    }

    public function getScriptParams()
    {
        $defaultParams = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce($this->nonceSlug)
        );

        return $defaultParams;
    }

    public function init()
    {
        $params = $this->getScriptParams();
        if (empty($params)) {
            return;
        }
        wp_localize_script($this->jsHandle, $this->jsvar, $this->getScriptParams());
    }

    /*
     * If logged in needed  sets current user or die if no user are logged
     */
    protected function verify()
    {
        if ($this->disableNonceCheck !== true) {
            $check = check_ajax_referer($this->nonceSlug, $this->nonceQueryVar, false);
            if ($check === false) {
                header('HTTP/1.0 401 Unauthorized');
                die('-1');
            }

        }
        if ($this->mustBeLoggedIn === true) {
            $this->setCurrentUser();
            if (0 == $this->currentUser->ID) {
                die();
            }
        }
    }

    protected function setCurrentUser()
    {
        $this->currentUser = wp_get_current_user();
    }

    /*
     *
     * Note: Must be low priority to ensure wp_localize_scripts are run after scripts enqueues
     */
    public function register()
    {
        if ($this->admin === true) {
            add_action('admin_enqueue_scripts', array($this, 'init'), 10000);
        } else {
            add_action('wp_enqueue_scripts', array($this, 'init'), 10000);
        }
        add_action('wp_ajax_'.$this->slug, array($this, 'safeCallback'));

        if (!$this->mustBeLoggedIn) {
            add_action('wp_ajax_nopriv_'.$this->slug, array($this, 'safeCallback'));
        }
    }

    public function remove()
    {
        if ($this->admin === true) {
            remove_action('admin_enqueue_scripts', array($this, 'init'));
        } else {
            remove_action('wp_enqueue_scripts', array($this, 'init'));
        }

        remove_action('wp_ajax_'.$this->slug, array($this, 'safeCallback'));

        if (!$this->mustBeLoggedIn) {
            remove_action('wp_ajax_nopriv_'.$this->slug, array($this, 'safeCallback'));
        }
    }
}
