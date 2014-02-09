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
use WPCore\Forms\AbstractField;

/**
 * WP admin head
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPsettingsSection
{
    protected $id;
    protected $title;
    protected $pageMenuSlug;
    protected $view;

    protected $settings = array();

    public function __construct(
        $id,
        $title,
        $pageMenuSlug,
        View $view = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->pageMenuSlug = $pageMenuSlug;
        $this->view = $view;
    }

    public function add()
    {
        add_settings_section(
            $this->id,
            $this->title,
            array($this, 'view'),
            $this->pageMenuSlug 
        );

        foreach ($this->settings as $setting) {
            $setting->add();
            $setting->register();
        }
    } 

    public function addSetting($id, $title, AbstractField $field = null, $args = array())
    {
        $setting = new WPsetting(
            $id,
            $title,
            $this->pageMenuSlug,
            $this->id,
            $field,
            $args
        );
        $this->settings[] = $setting;
    }

    public function view()
    {
        if (!is_null($this->view)) {
            $this->view->show();
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
     * Gets the value of view.
     *
     * @return mixed
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Sets the value of view.
     *
     * @param mixed $view the view
     *
     * @return self
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }
}
