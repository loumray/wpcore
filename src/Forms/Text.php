<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore\Forms;

class Text extends AbstractField
{
  /**
   * __toString
   *
   * @return string
   */
  public function __toString()
  {

    $html = "";
    if (!empty($this->attributes['label'])) {
      $html = "<label>".$this->attributes['label']."</label>";
    }
    $value = "";
    if (!empty($this->attributes['value'])) {
      $value = ' value="'.$this->attributes['value'].'"';
    }

    $class = "";
    if (!empty($this->attributes['class'])) {
      $class = ' class="'.$this->attributes['class'].'"';
    }

    $html.= '<input type="text" '.(isset($this->attributes['id']) ? 'id="'.$this->attributes['id'].'"': "").' name="'.$this->attributes['name'].'"'.$value.$class.' />';

    return $html;
  }

}
