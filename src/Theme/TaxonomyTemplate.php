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

class TaxonomyTemplate extends WPfilter
{
    protected $taxonomy;
    protected $term;
    protected $template;

    public function __construct($template, $taxonomy, $term = '')
    {
        parent::__construct('template_include');
        $this->template = $template;
        $this->taxonomy = $taxonomy;
        $this->term = $term;
    }

    public function action()
    {
        $template = func_get_arg(0);
        $templateFile = basename($template);

        if (is_tax() &&
            ($templateFile != "taxonomy-{$this->taxonomy}.php")
        ) {
            $term = get_queried_object();
            if (!empty($term->slug) &&
                $templateFile != "taxonomy-{$this->taxonomy}-{$term->slug}.php" &&
                ($this->taxonomy == $term->taxonomy) &&
                ((empty($this->term)) || ($this->term == $term->slug))
            ) {
                return $this->template;
            }
        }
        return $template;
    }
}