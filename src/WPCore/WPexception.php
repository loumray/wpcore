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
 * WP exception
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
class WPexception extends \Exception
{
  public function __construct($message, $code = 0, Exception $previous = null) {
    $message = "WP exception: ".$message;

    parent::__construct($message, $code, $previous);
  }

}