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
 * WP submenu page
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPsubmenuPage extends WPaction
{
    protected $parent_slug;
    protected $page_title;
    protected $menu_title;
    protected $menu_slug;
    protected $capability;

    protected $view       = null;

    public function __construct(
        View $view,
        $parent_slug = 'options-general.php',
        $page_title = 'Custom Menu',
        $menu_title = 'Custom Menu',
        $menu_slug = 'custom-menu',
        $capability = 'manage_options'
    ) {
        //Low priority so that all options from other features are loaded before panel is displayed
        parent::__construct('admin_menu', 10000);

        $this->view = $view;

        $this->setParentSlug($parent_slug);
        $this->setPageTitle($page_title);
        $this->setMenuTitle($menu_title);
        $this->setMenuSlug($menu_slug);
        $this->setCapability($capability);

        $this->register();
    }

    public function setParentSlug($value)
    {
        $this->parent_slug = $value;
    }

    public function setPageTitle($value)
    {
        $this->page_title = $value;
    }
    public function setMenuTitle($value)
    {
        $this->menu_title = $value;
    }
    public function setCapability($value)
    {
        $this->capability = $value;
    }
    public function setMenuSlug($value)
    {
        $this->menu_slug = $value;
    }

    public function action()
    {
        add_submenu_page(
            $this->parent_slug,
            $this->page_title,
            $this->menu_title,
            $this->capability,
            $this->menu_slug,
            array($this,'view')
        );
    }

    public function view()
    {
        $this->view->show();
    }
}
