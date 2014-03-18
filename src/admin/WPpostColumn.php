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
use WPCore\WPposttype;

class WPpostColumn extends WPaction
{
    protected $postType;
    protected $position = 3;
    protected $slug  = 'slug';
    protected $title = 'custom title';
    protected $view;

    public function __construct(View $view)
    {
        parent::__construct("admin_init");

        $this->view = $view;
    }

    public function header($columns)
    {
        $position = $this->position-1;
        $columns = array_merge(array_slice($columns, 0, $position), array($this->slug => $this->title), array_slice($columns, $position));

        return $columns;
    }

    public function action()
    {
        //By default, add column to native post type
        if (is_null($this->postType)) {
            add_action("manage_posts_custom_column", array($this, 'content'), 10, 2);
            add_filter("manage_edit-post_columns", array($this, 'header'));
        } else {
            add_action("manage_".$this->postType->getSlug()."_posts_custom_column", array($this, 'content'), 10, 2);
            add_filter("manage_edit-".$this->postType->getSlug()."_columns", array($this, 'header'));
        }
        
    }

    public function content($columnSlug, $postId)
    {
        if ($columnSlug == $this->slug) {
            if (!is_null($this->view)) {
                $data = array(
                    'columnSlug' => $columnSlug,
                    'postId' => $postId
                );
                $this->view->setData($data);
                $this->view->show();
            } else {
                echo "Please Provide View";
            }
        }
    }

    /**
     * Gets the value of postType.
     *
     * @return mixed
     */
    public function getPostType()
    {
        return $this->postType;
    }

    /**
     * Sets the value of postType.
     *
     * @param mixed $postType the post type
     *
     * @return self
     */
    public function setPostType(WPposttype $postType)
    {
        $this->postType = $postType;

        return $this;
    }

    /**
     * Gets the value of position.
     *
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the value of position.
     *
     * @param mixed $position the position
     *
     * @return self
     */
    public function setPosition($position)
    {
        $this->position = (int) $position;

        return $this;
    }

    /**
     * Gets the value of slug.
     *
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Sets the value of slug.
     *
     * @param mixed $slug the slug
     *
     * @return self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

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
}