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

use pweb\domlib\forms\Field;

class File extends AbstractField
{

  public function __toString()
  {

    $html = "";
    if(!empty($this->attributes['label']))
    {
      $html = "<label>".$this->attributes['label']."</label>";
    }
    $html.= '<input type="file" '.(isset($this->attributes['id']) ? 'id="'.$this->attributes['id'].'"': "").' name="'.$this->attributes['name'].'" />';

    return $html;
  }
}
