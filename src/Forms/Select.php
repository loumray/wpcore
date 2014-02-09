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

class Select extends AbstractField
{
  /**
   * to_html
   *
   * @return string
   */
  public function __toString()
  {
    $html = "";
    if(!empty($this->attributes['label']))
    {
      $html.= "<label>".$this->attributes['label']."</label>";
    }

    $html.= '<select';
    if(!empty($this->attributes['class']))
    {
      $html.= ' class="'.$this->attributes['class'].'"';
    }
    if(!empty($this->attributes['id']))
    {
      $html.= ' id="'.$this->attributes['id'].'"';
    }
    if(!empty($this->attributes['name']))
    {
      $html.= ' name="'.$this->attributes['name'].'"';
    }
    if(!empty($this->attributes['multiple']) && $this->attributes['multiple'] === true)
    {
      $html.= ' multiple';
    }
    $html.= '>';

    if(!empty($this->attributes['options']))
    {
      foreach($this->attributes['options'] as $val => $text)
      {
        $selected = "";
        if($this->attributes['value'] == $val)
        {
          $selected = "selected=\"selected\"";
        }
        $html .= "<option value=\"$val\" $selected>$text</option>";
      }
    }
    $html.= '</select>';
    return $html;
  }

}
