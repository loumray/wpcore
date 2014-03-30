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
 * WP nav menu
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
class WPimageSize extends WPaction
{
    protected $name;
    protected $width;
    protected $height;
    protected $crop;

    protected $label = '';

    public function __construct($name, $width = 0, $height = 0, $crop = false)
    {
        parent::__construct('init');

        $this->name   = $name;
        $this->width  = $width;
        $this->height = $height;
        $this->crop   = $crop;
    }

    public function addToAdminChoices($label)
    {
        $this->label = $label;
    }

    public function action()
    {
        add_image_size($this->name, $this->width, $this->height, $this->crop);

        if (!empty($this->label)) {
            add_filter('image_size_names_choose', array($this, 'showSizes'));
        }
    }

    public function showSizes()
    {
        $sizes = func_get_arg(0);
        $sizes[$this->name] = $this->label;
        return $sizes;
    }
}
