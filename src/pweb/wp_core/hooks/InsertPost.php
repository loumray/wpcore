<?php
/**
 * PWEB WP Theme framework
 *
 * @package    PWEB WP Theme framework
 *
 * @version    1.0
 * @author     Louis-Michel Raynauld
 * @copyright  Louis-Michel Raynauld
 * @link       http://graphem.ca
 */
namespace pweb\wp_core\hooks;

use pweb\wp_core\WPaction;

/**
 *
 * @package     pweb
 * @subpackage  wp_core
 */

class InsertPost extends WPaction
{

  public function __construct()
  {
    parent::__construct('wp_insert_post',100,1);
  }

  //In dev todo
  public function action()
  {
    return null;
  }
}