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

use WPCore\Config;
use WPCore\View;
use WPCore\Forms\FieldInterface;

/**
 * WP admin head
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPsetting
{
    protected $id;
    protected $title;
    protected $pageMenuSlug;
    protected $field;
    protected $section;
    protected $args = array();

    public function __construct(
        $id,
        $title,
        $pageMenuSlug,
        $section = 'default',
        FieldInterface $field = null,
        $args = array()
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->pageMenuSlug = $pageMenuSlug;
        $this->field = $field;
        $this->section = $section;
        $this->args = $args;
    }

    public function add()
    {
        add_settings_field(
            $this->id,
            $this->title,
            array($this, 'view'),
            $this->pageMenuSlug,
            $this->section,
            $this->args
        );
    }

    public function register($sanitizeCallback = 'esc_attr')
    {
        
        // $this->section = 'optional';
        // echo $this->id.'<br>';
        // echo $this->section.'<br>';
        register_setting(
            $this->pageMenuSlug,
            $this->id,
            $sanitizeCallback
        );
    }

    public function view($args)
    {
        if (!is_null($this->field)) {
            $this->field->attr('name', $this->id);
            $this->field->render();
        }
    }

    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of title.
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the value of title.
     *
     * @param mixed $title the title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Gets the value of pageMenuSlug.
     *
     * @return mixed
     */
    public function getPageMenuSlug()
    {
        return $this->pageMenuSlug;
    }

    /**
     * Sets the value of pageMenuSlug.
     *
     * @param mixed $pageMenuSlug the page menu slug
     *
     * @return self
     */
    public function setPageMenuSlug($pageMenuSlug)
    {
        $this->pageMenuSlug = $pageMenuSlug;

        return $this;
    }

    /**
     * Gets the value of section.
     *
     * @return mixed
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Sets the value of section.
     *
     * @param mixed $section the section
     *
     * @return self
     */
    public function setSection($section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Gets the value of args.
     *
     * @return mixed
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * Sets the value of args.
     *
     * @param mixed $args the args
     *
     * @return self
     */
    public function setArgs($args)
    {
        $this->args = $args;

        return $this;
    }
}
