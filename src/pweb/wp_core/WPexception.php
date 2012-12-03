<?php
/**
 * Define a WP exception class
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
class WPexception extends \Exception
{
  // Redefine the exception so message isn't optional
  public function __construct($message, $code = 0, Exception $previous = null) {
    $message = "WP exception: ".$message;

    // make sure everything is assigned properly
    parent::__construct($message, $code, $previous);
  }

}