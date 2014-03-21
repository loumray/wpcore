<?php
/*
 * This file is part of WPForms project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore\Forms;

interface FieldInterface
{
    public function init();
    public function attr($name, $value);
    public function removeAttr($name);
    public function render();
}