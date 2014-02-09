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

class Checkbox extends AbstractField
{
  /**
   * to_html
   *
   * @return string
   */
  public function __toString()
  {

    $html = "";
    $value = "";
    if(!empty($this->attributes['value']))
    {
      $value = ' value="'.$this->attributes['value'].'"';
    }
    $html.= '<input';
    if(!empty($this->attributes['class']))
    {
      $html.= ' class="'.$this->attributes['class'].'"';
    }
    $html.= ' type="checkbox" '.(isset($this->attributes['id']) ? 'id="'.$this->attributes['id'].'"': "").' name="'.$this->attributes['name'].'"'.$value.' />';

    if(!empty($this->attributes['label']))
    {
      $html.= "<label for=\"".$this->attributes['name']."\">".$this->attributes['label']."</label>";
    }

    return $html;
  }

}
