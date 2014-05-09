<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore\admin;

use WPCore\View;
use WPCore\WPaction;

class WPadminNotice extends WPaction
{
    protected $msg;
    protected $classtype;
    protected $view;

    public function __construct($msg, $classtype = 'message error')
    {
        parent::__construct('admin_notices');

        $this->msg       = $msg;
        $this->classtype = $classtype;
    }

    public function setView(\View $view)
    {
        $this->view = $view;

        return $this;
    }

    public function action()
    {
        $current_user = wp_get_current_user();
        if (isset($current_user->data->wp_capabilities['administrator'] ) ||
            in_array("administrator", $current_user->roles)
        ) {
            if (!empty($this->view)) {
                $this->view->show();
            } else {
                $this->defaultDisplay();
            }
        }
    }

    public function defaultDisplay()
    {
        ?>
        <div class="<?php echo $this->classtype; ?>"><?php echo $this->msg; ?></div>
        <?php
    }
}
