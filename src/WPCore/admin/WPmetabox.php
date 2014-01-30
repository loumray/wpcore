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

    protected $saveableClass;

    public function __construct(
        View $view,
        $mbId,
        $title,
        $postType,
        $context = 'advanced',
        $priority = 'default',
        $saveableClass = null,
        $callbackArgs = null
    ) {

        parent::__construct('add_meta_boxes', 10, 2);

        $this->view     = $view;
        $this->mbId     = $mbId;
        $this->title    = $title;
        $this->postType = $postType;
        $this->context  = $context;
        $this->priority = $priority;
        $this->saveableClass = $saveableClass;
        $this->callbackArgs  = $callbackArgs;

        $this->nonceAction = $this->mbId.'_nonceaction';
        $this->nonceName   = $this->mbId.'_noncename';

        if (!is_null($saveableClass) &&
            !in_array('WPCore\admin\WPpostSaveable',class_implements($saveableClass))
        ) {
            throw new \InvalidArgumentException("WPmetabox saveableClass must be the name of a class that implements WPCore\WPpostSaveable interface");
        }
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

    /**
    * By default
    */
    public function save($postId, $post)
    {
        if (is_null($this->saveableClass)) {
            return false;
        }

        $class = $this->saveableClass;
        $instance = $class::create($postId);

        $instance->fetch();

        if (isset($_POST[$this->mbId])) {
            foreach ($_POST[$this->mbId] as $key => $value) {
              $instance->set($key, sanitize_text_field($value));
            }
        }
        
        return $instance->save();
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

        $class = $this->saveableClass;
        $instance = $class::create($post->ID);

        $instance->fetch();
        $data['obj'] = $instance;

        $this->view->setData($data);
        $this->view->show();
    }
}
