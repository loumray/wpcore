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
use WPCore\Forms\FieldSetInterface;

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
    protected $viewData = array();

    protected $saveableClass;
    protected $fieldSet;

    public function __construct(
        $mbId,
        $title,
        $postType,
        $context = 'advanced',
        $priority = 'default',
        $saveableClass = null,
        $callbackArgs = null
    ) {

        parent::__construct('add_meta_boxes', 10, 2);

        $this->mbId     = $mbId;
        $this->title    = $title;
        $this->postType = $postType;
        $this->context  = $context;
        $this->priority = $priority;
        $this->saveableClass = $saveableClass;
        $this->callbackArgs  = $callbackArgs;

        $this->nonceAction = $this->mbId.'_nonceaction';
        $this->nonceName   = $this->mbId.'_noncename';

        if (is_null($saveableClass)) {
            $this->saveableClass = '\WPCore\WPcustomPost';
        } elseif (!in_array('WPCore\admin\WPpostSaveable', class_implements($saveableClass))) {
            throw new \InvalidArgumentException("WPmetabox saveableClass must be the name of a class that implements WPCore\WPpostSaveable interface");
        }
    }

    public function getId()
    {
        return $this->mbId;
    }
    
    public function getNonceAction()
    {
        return $this->nonceAction;
    }
    public function getNonceName()
    {
        return $this->nonceName;
    }

    public function setFieldSet(FieldSetInterface $fieldset)
    {
        $this->fieldSet = $fieldset;

        return $this;
    }

    public function getFieldSet()
    {
        return $this->fieldSet;
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
        
        if (isset($_POST[$this->mbId])) {
            foreach ($_POST[$this->mbId] as $key => $value) {
                $instance->set($key, $value);
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

    public function setView(View $view)
    {
        $this->view = $view;

        return  $this;
    }
    public function setViewData($data)
    {
        foreach ($data as $key => $val) {
            switch ($key) {
                case 'obj':
                case 'post':
                case 'metabox':
                case 'savearray':
                case 'fieldSet':
                case 'hiddenNonce':
                    throw new \InvalidArgumentException('The index '.$key. ' is used and will be overwritten. Please use a different one.');
                    break;
                default:
                    break;
            }
        }
        
        $this->viewData = $data;

        return $this;
    }

    public function view($post, $metabox)
    {
        $class = $this->saveableClass;
        $instance = $class::create($post->ID);
        $instance->fetch();

        $hiddenNonce = wp_nonce_field($this->nonceAction, $this->nonceName, true, false);
        if (!is_null($this->view)) {
            $data = $this->view->getData();
            $data['obj'] = $instance;
            $data['post'] = $post;
            $data['metabox'] = $metabox;
            $data['savearray'] = $this->mbId;
            $data['fieldSet'] = $this->fieldSet;
            $data['hiddenNonce'] = $hiddenNonce;

            $this->view->setData($data);
            $this->view->show();

        } elseif (!empty($this->fieldSet)) {
            foreach ($this->fieldSet as $field) {
                $field->attr('value', $instance->get($field->attr('name')));
                $field->attr('name', $this->mbId.'['.$field->attr('name').']');
            }
            echo $hiddenNonce;
            $this->fieldSet->render();
        }
        
    }

    /**
     * Gets the value of view.
     *
     * @return mixed
     */
    public function getView()
    {
        return $this->view;
    }
}
