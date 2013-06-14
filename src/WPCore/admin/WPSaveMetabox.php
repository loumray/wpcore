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
 * WP save metabox action
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPSaveMetabox extends WPaction
{
  protected $metabox;

  public function __construct()
  {
    parent::__construct('save_post',10,2);
  }

  public function setMetabox(WPmetabox $metabox)
  {
    $this->metabox = $metabox;
  }

  public function action()
  {
    $post_id = func_get_arg(0);
    $post    = func_get_arg(1);

    if(!$this->metabox->verify())
    {
      return false;
    }

    // First we need to check if the current user is authorised to do this action.
    if ( 'page' == $_POST['post_type'] ) {
      if ( ! current_user_can( 'edit_page', $post_id ) )
          return false;
    } else {
      if ( ! current_user_can( 'edit_post', $post_id ) )
          return false;
    }

    return true;
  }
}