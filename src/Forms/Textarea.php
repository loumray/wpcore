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

class Textarea extends AbstractField
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
      $html = "<label for=\"".$this->attributes['name']."\">".$this->attributes['label']."</label>";
    }
    $value = "";

    $html.= '<textarea '.(isset($this->attributes['id']) ? 'id="'.$this->attributes['id'].'"': "").' name="'.$this->attributes['name'].'" ></textarea>';

    return $html;
  }

}
