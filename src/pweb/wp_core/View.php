<?php
/**
 * Define a view class
 *
 * PWEB WP Theme framework
 *
 * @package    PWEB WP Theme framework
 *
 * @version    1.0
 * @author     Louis-Michel Raynauld
 * @copyright  Louis-Michel Raynauld
 * @link       http://graphem.ca
 */
namespace pweb\wp_core;

/**
 *
 * @package     pweb
 * @subpackage  wp_core
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

  public function set_data($data)
  {
    $this->data = $data;
  }

  public function show()
  {

    if(file_exists($this->file))
    {
      extract($this->data);
      include($this->file);
    }
    else
    {
      throw new \Exception("File not found on ".$this->file);
    }
  }

}