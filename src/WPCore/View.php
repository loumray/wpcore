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
 * Basic views
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
class View
{
  protected $file;
  protected $data;

  public function __construct($file,$data = array())
  {

    $this->file = $file;
    $this->data = $data;
  }

  public function setData($data)
  {
    $this->data = $data;
  }

  public function getContent()
  {
    ob_start();
    $this->show();
    $out = ob_get_clean();
    return $out;
  }

  public function show()
  {
    if(file_exists($this->file))
    {
      extract($this->data);
      include($this->file);
      return true;
    }
    else
    {
      throw new \Exception("File not found on ".$this->file);
    }

    return false;
  }

}