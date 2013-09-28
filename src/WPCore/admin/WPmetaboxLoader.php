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

/**
 * WP metabox loader
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPmetaboxLoader extends WPaction
{
    protected $metabox;
    protected $saveaction;

    public function __construct(
        WPmetabox $metabox,
        WPSaveMetabox $saveaction
    ) {
        parent::__construct(array('load-post.php', 'load-post-new.php'));
        $this->saveaction = $saveaction;
        $this->metabox    = $metabox;
    }

    public function action()
    {
        $this->metabox->register();
        $this->saveaction->setMetabox($this->metabox);
        $this->saveaction->register();
    }
}
