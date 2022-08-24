<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore\Exceptions;

/**
 * WP exception
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
class WPexception extends \Exception
{
    public function __construct(\WP_Error $wperror)
    {
        $code    = $wperror->get_error_code();
        $message = $wperror->get_error_message();

        parent::__construct($message, $code);
    }
}
