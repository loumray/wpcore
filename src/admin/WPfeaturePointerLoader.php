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
    protected $pointersJsVar;
    
    public function __construct($jsBaseUrl, $pointersJsVar)
    {
        parent::__construct('admin_enqueue_scripts', 500);

        $this->pointersJsVar = $pointersJsVar;
        $this->script = new WPscriptFeaturePointer('installPointer'.$this->pointersJsVar, $jsBaseUrl.'installPointer.js', $jsBaseUrl.'installPointer.min.js');
        
        $this->pointers =  array();
    }

    public function addPointer(WPfeaturePointer $pointer)
    {
        $this->pointers[] = $pointer;
    }

    public function action()
    {
        if (empty($this->pointers)) {
            return false;
        }

        $this->script->enqueue(array());

        $params = array(
            'pointers' => array()
        );
        
        $currentScreenId = get_current_screen();
        $currentScreenId = $currentScreenId->id;
        $userId = get_current_user_id();

        foreach ($this->pointers as $pointer) {
            if ($pointer->isDisplayable($currentScreenId, $userId)) {
                $params['pointers'][] = $pointer->toArray();
            }
        }

        if (empty($params['pointers'])) {
            $this->script->dequeue();
            return false;
        }
        wp_localize_script($this->script->getHandle(), $this->pointersJsVar, $params);

        $pointerStyle = new WPstyleAdmin(array(), 'wp-pointer');
        $pointerStyle->enqueue(array());
    }
}
