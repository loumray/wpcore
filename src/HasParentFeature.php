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

trait HasParentFeature
{
    protected $parentFeature;

    public function setParentFeature(WPFeature $feature)
    {
        $this->parentFeature = $feature;
    }

    public function getParentFeature()
    {
        return $this->parentFeature;
    }
}
