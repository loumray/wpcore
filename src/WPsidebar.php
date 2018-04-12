<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore;

/**
 * WP sidebar
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPsidebar extends WPaction
{
    protected $sbId;
    protected $name;
    protected $before_widget;
    protected $after_widget;
    protected $before_title;
    protected $after_title;

    public function __construct(
        $sbId,
        $name,
        $before_widget = "",
        $after_widget = "",
        $before_title = "",
        $after_title = ""
    ) {
        parent::__construct('widgets_init');

        $this->sbId   = $sbId;
        $this->name = $name;

        $this->before_widget = $before_widget;
        $this->after_widget  = $after_widget;
        $this->before_title  = $before_title;
        $this->after_title   = $after_title;
    }

    public function action()
    {
        register_sidebar(
            array(
              'name' => $this->name,
              'id'   => $this->sbId,
              'before_widget' => $this->before_widget,
              'after_widget'  => $this->after_widget,
              'before_title'  => $this->before_title,
              'after_title'   => $this->after_title,
            )
        );
    }

    public function display()
    {
        dynamic_sidebar($this->sbId);
    }
    
    /**
     * Gets the value of sbId.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->sbId;
    }

    /**
     * Sets the value of sbId.
     *
     * @param mixed $sbId the sb id
     *
     * @return self
     */
    public function setId($sbId)
    {
        $this->sbId = $sbId;

        return $this;
    }

    /**
     * Gets the value of name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param mixed $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the value of before_widget.
     *
     * @return mixed
     */
    public function getBeforeWidget()
    {
        return $this->before_widget;
    }

    /**
     * Sets the value of before_widget.
     *
     * @param mixed $before_widget the before_widget
     *
     * @return self
     */
    public function setBeforeWidget($before_widget)
    {
        $this->before_widget = $before_widget;

        return $this;
    }

    /**
     * Gets the value of after_widget.
     *
     * @return mixed
     */
    public function getAfterWidget()
    {
        return $this->after_widget;
    }

    /**
     * Sets the value of after_widget.
     *
     * @param mixed $after_widget the after_widget
     *
     * @return self
     */
    public function setAfterWidget($after_widget)
    {
        $this->after_widget = $after_widget;

        return $this;
    }

    /**
     * Gets the value of before_title.
     *
     * @return mixed
     */
    public function getBeforeTitle()
    {
        return $this->before_title;
    }

    /**
     * Sets the value of before_title.
     *
     * @param mixed $before_title the before_title
     *
     * @return self
     */
    public function setBeforeTitle($before_title)
    {
        $this->before_title = $before_title;

        return $this;
    }

    /**
     * Gets the value of after_title.
     *
     * @return mixed
     */
    public function getAfterTitle()
    {
        return $this->after_title;
    }

    /**
     * Sets the value of after_title.
     *
     * @param mixed $after_title the after_title
     *
     * @return self
     */
    public function setAfterTitle($after_title)
    {
        $this->after_title = $after_title;

        return $this;
    }
}
