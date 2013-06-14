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
 * WP metabox
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPmetabox extends WPaction
{

  protected $view;

  protected $id;
  protected $title;
  protected $post_type; //'post', 'page', 'link', 'attachment' or 'custom_post_type_slug'
  protected $context;  //'normal', 'advanced', or 'side'
  protected $priority; //'high', 'core', 'default' or 'low'
  protected $callback_args;
  protected $nonce_action;

  public function __construct(View $view,
                              $id,
                              $title,
                              $post_type,
                              $context  = 'advanced',
                              $priority = 'default',
                              $callback_args = null)
  {

    parent::__construct('add_meta_boxes');

    $this->view  = $view;
    $this->id    = $id;
    $this->title = $title;
    $this->post_type = $post_type;
    $this->context   = $context;
    $this->priority  = $priority;
    $this->callback_args = $callback_args;

    $this->nonce_action = $this->id.'_nonceaction';
    $this->nonce_name   = $this->id.'_noncename';

  }

  public function getNonceAction()
  {
    return $this->nonce_action;
  }
  public function getNonceName()
  {
    return $this->nonce_name;
  }

  public function action()
  {
    add_meta_box( $this->id,
                  $this->title,
                  array( $this, 'view' ),
                  $this->post_type,
                  $this->context,
                  $this->priority,
                  $this->callback_args
                );
  }

  public function verify()
  {
    if ( isset( $_POST[$this->getNonceName()] ) &&
         wp_verify_nonce( $_POST[$this->getNonceName()], $this->getNonceAction() ) )
      return true;

    return false;
  }

  public function view($post, $metabox)
  {
    $data = array();
    $data['post'] = $post;
    $data['metabox'] = $metabox;
    $data['hidden_nonce'] = wp_nonce_field( $this->nonce_action, $this->nonce_name, true, false );

    $this->view->setData($data);
    $this->view->show();
  }

}