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
 * WP menu page
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPmenuPage extends WPaction
{
    protected $pageTitle  = 'Custom Menu';
    protected $menuTitle  = 'Custom Menu';
    protected $menuSlug   = 'custom-menu';
    protected $capability  = 'manage_options';
    protected $iconUrl    = '';
    protected $position    = null;

    protected $view       = null;

    public function __construct(
        View $view,
        $pageTitle = null,
        $menuTitle = null,
        $menuSlug = null,
        $capability = null,
        $iconUrl = null,
        $position = null
    ) {

        //Low priority so that all options from other features are loaded before panel is displayed
        parent::__construct('admin_menu', 10000);

        $this->view = $view;

        if (!empty($pageTitle)) {
            $this->setPageTitle($pageTitle);
        }
        if (!empty($menuTitle)) {
            $this->setMenuTitle($menuTitle);
        }
        if (!empty($menuSlug)) {
            $this->setMenuSlug($menuSlug);
        }
        if (!empty($capability)) {
            $this->setCapability($capability);
        }
        if (!empty($iconUrl)) {
            $this->setIconUrl($iconUrl);
        }
        if (!empty($position)) {
            $this->setPosition($position);
        }
    }

    public function getUrl()
    {
        return admin_url('admin.php?page='.$this->menuSlug);
    }

    public function setPageTitle($value)
    {
        $this->pageTitle = $value;
    }
    public function setMenuTitle($value)
    {
        $this->menuTitle = $value;
    }
    public function setCapability($value)
    {
        $this->capability = $value;
    }
    public function setMenuSlug($value)
    {
        $this->menuSlug = $value;
    }
    public function setIconUrl($url)
    {
        $this->iconUrl = $url;
    }
    /*
       2 Dashboard
       4 Separator
       5 Posts
       10 Media
       15 Links
       20 Pages
       25 Comments
       59 Separator
       60 Appearance
       65 Plugins
       70 Users
       75 Tools
       80 Settings
       99 Separator
     */
    public function setPosition($int)
    {
        $this->position = $int;
    }

    public function action()
    {
        add_menu_page(
            $this->pageTitle,
            $this->menuTitle,
            $this->capability,
            $this->menuSlug,
            array($this,'view'),
            $this->iconUrl,
            $this->position
        );
    }

    public function view()
    {
        $this->view->show();
    }
}
