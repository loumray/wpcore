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
namespace pweb\wp_core;

/**
 *
 * @package     pweb
 * @subpackage  wp_core
 */

interface WPhook
{
  public function register();
  public function remove();
}