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

    protected $mbId;
    protected $title;
    protected $postType; //'post', 'page', 'link', 'attachment' or 'custom_post_type_slug'
    protected $context;  //'normal', 'advanced', or 'side'
    protected $priority; //'high', 'core', 'default' or 'low'
    protected $callbackArgs;
    protected $nonceAction;
    protected $nonceName;

    public function __construct(
        View $view,
        $mbId,
        $title,
        $postType,
        $context = 'advanced',
        $priority = 'default',
        $callbackArgs = null
    ) {

        parent::__construct('add_meta_boxes', 10, 2);

        $this->view  = $view;
        $this->mbId    = $mbId;
        $this->title = $title;
        $this->postType = $postType;
        $this->context  = $context;
        $this->priority = $priority;
        $this->callbackArgs = $callbackArgs;

        $this->nonceAction = $this->mbId.'_nonceaction';
        $this->nonceName   = $this->mbId.'_noncename';

    }

    public function getNonceAction()
    {
        return $this->nonceAction;
    }
    public function getNonceName()
    {
        return $this->nonceName;
    }

    public function action()
    {

        add_meta_box(
            $this->mbId,
            $this->title,
            array( $this, 'view' ),
            $this->postType,
            $this->context,
            $this->priority,
            $this->callbackArgs
        );
    }

    public function verify()
    {
        if (isset($_POST[$this->getNonceName()]) &&
            wp_verify_nonce($_POST[$this->getNonceName()], $this->getNonceAction())
        ) {
            return true;
        }

        return false;
    }

    public function view($post, $metabox)
    {
        $data = array();
        $data['post'] = $post;
        $data['metabox'] = $metabox;
        $data['hidden_nonce'] = wp_nonce_field($this->nonceAction, $this->nonceName, true, false);

        $this->view->setData($data);
        $this->view->show();
    }
}
