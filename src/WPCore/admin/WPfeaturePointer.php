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

/**
 * WP feature pointer
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPfeaturePointer
{
    protected $pointerId;
    protected $targetId;
    protected $content;
    protected $position;

    /**
    * targetID could be wp-admin-bar-new-content, menu-settings, menu-appearance
    * position should contain edge and align index
    */
    public function __construct(
        $pointerId,
        $content,
        $targetId = 'menu-settings',
        $position = array('edge' => 'left', 'align' => 'center')
    ) {
        $this->pointerId = $pointerId;
        $this->targetId = $targetId;
        $this->content = $content;
        $this->position = $position;
    }

    public function isDismissed()
    {
        $dismissedArray = explode(',', (string) get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));
        return in_array($this->pointerId, $dismissedArray);
    }

    public function toArray()
    {
        return array(
            'pointerId' => $this->pointerId,
            'content' => $this->content,
            'targetId' => $this->targetId,
            'position' => $this->position
        );
    }
}
