<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore\Theme;

use WPCore\WPfilter;
use WPCore\WPfeature;

class SingleTemplate extends WPfilter
{
    protected $postType;
    protected $template;

    public function __construct($template, $postType)
    {
        parent::__construct('template_include');
        $this->postType = $postType;
        $this->template = $template;
    }

    public function action()
    {
        $template = func_get_arg(0);
        $templateFile = basename($template);

        if (is_single() &&
            ($templateFile != "single-{$this->postType}.php")
        ) {
            $object = get_queried_object();
            if (!empty($object->post_type) &&
                ($object->post_type == $this->postType)
            ) {
                return $this->template;
            }
        }

        return $template;
    }
}
