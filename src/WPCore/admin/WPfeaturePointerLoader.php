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

use WPCore\WPaction;
use WPCore\WPstyleAdmin;

/**
 * WP feature pointer Loader
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPfeaturePointerLoader extends WPaction
{
    protected $script;

    protected $pointers;

    public function __construct($jsBaseUrl)
    {
        parent::__construct('admin_enqueue_scripts', 500);


        $this->script = new WPscriptFeaturePointer('installPointer', $jsBaseUrl.'installPointer.js');

        $this->pointers =  array();
    }

    public function addPointer(WPfeaturePointer $pointer)
    {
        $this->pointers[] = $pointer;
    }

    public function action()
    {
        $this->script->enqueue(array());

        $params = array(
            'pointers' => array()
        );
        
        foreach ($this->pointers as $pointer) {
            if (!$pointer->isDismissed()) {
                $params['pointers'][] = $pointer->toArray();
            }
        }
        wp_localize_script($this->script->getHandle(), 'pointersParams', $params);

        $pointerStyle = new WPstyleAdmin(array(), 'wp-pointer');
        $pointerStyle->enqueue(array());
    }
}
