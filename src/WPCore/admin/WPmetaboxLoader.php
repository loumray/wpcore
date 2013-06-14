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
use WPcore\admin\WPmetabox;

/**
 * WP metabox loader
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPmetaboxLoader extends WPaction
{
  protected $metabox;
  protected $view;
  protected $saveaction;
  protected $id;
  protected $title;
  protected $post_type; //'post', 'page', 'link', 'attachment' or 'custom_post_type_slug'
  protected $context;  //'normal', 'advanced', or 'side'
  protected $priority; //'high', 'core', 'default' or 'low'
  protected $callback_args;

  public function __construct(View $view,
                              WPSaveMetabox $saveaction,
                              $id,
                              $title,
                              $post_type,
                              $context  = 'advanced',
                              $priority = 'default',
                              $callback_args = null)
  {
    parent::__construct(array('load-post.php','load-post-new.php'));
    $this->view  = $view;
    $this->saveaction  = $saveaction;
    $this->id    = $id;
    $this->title = $title;
    $this->post_type = $post_type;
    $this->context   = $context;
    $this->priority  = $priority;
    $this->callback_args = $callback_args;

  }

  public function action()
  {
    $this->metabox = new WPmetabox(
                            $this->view,
                            $this->id,
                            $this->title,
                            $this->post_type,
                            $this->context,
                            $this->priority,
                            $this->callback_args
                            );

    $this->metabox->register();
    $this->saveaction->setMetabox($this->metabox);
    $this->saveaction->register();
  }
}