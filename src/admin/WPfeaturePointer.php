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
    const METAKEY = 'dismissed_wp_pointers';
    
    protected $pointerId;
    protected $targetId;
    protected $content;
    protected $position;
    protected $screenId;

    /**
    * targetID could be wp-admin-bar-new-content, menu-settings, menu-appearance
    * position should contain edge and align index
    * 
    * pointerId must be lowercase
    */
    public function __construct(
        $pointerId,
        $content,
        $targetId = 'menu-settings',
        $position = array('edge' => 'left', 'align' => 'center'),
        $screenId = ''
    ) {
        $this->pointerId = strtolower($pointerId);
        $this->targetId = $targetId;
        $this->content = $content;
        $this->position = $position;
        $this->screenId = $screenId;
    }

    public function isDismissed($userId)
    {
        $dismissedArray = explode(',', (string) get_user_meta($userId, self::METAKEY, true));
        return in_array($this->pointerId, $dismissedArray);
    }

    public function clearDismissed($userId)
    {
        if ($this->isDismissed($userId)) {
            $dismissedList =  str_replace($this->pointerId, '', (string) get_user_meta($userId, self::METAKEY, true));
            $dismissedList =  str_replace(',,', ',', $dismissedList);

            if ($dismissedList[0] === ',') {
                $dismissedList = substr($dismissedList, 1);
            }

            $length = strlen($dismissedList);
            if ($dismissedList[$length-1] === ',') {
                $dismissedList = substr($dismissedList, 0, $length-1);
            }
            
            return update_user_meta($userId, self::METAKEY, $dismissedList);
        }

        return false;
    }

    public function isDisplayable($currentScreenId, $userId)
    {
        if ((empty($this->screenId) || ($this->screenId === $currentScreenId)) &&
            (!$this->isDismissed($userId))) {
            return true;
        }

        return false;
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
