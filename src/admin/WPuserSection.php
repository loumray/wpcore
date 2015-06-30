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

use WPCore\Config;
use WPCore\View;
use WPCore\WPaction;
use WPCore\Forms\FieldSetInterface;

/**
 * WP user section
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPuserSection extends WPaction
{
    protected $fieldSet;
    protected $metas = array();
    protected $view;
    protected $showOnProfile = true;

    public function __construct($showOnProfile = true)
    {
        parent::__construct('admin_init');

        $this->showOnProfile = $showOnProfile;
    }

    public function setFieldSet(FieldSetInterface $fieldset)
    {
        $this->fieldSet = $fieldset;

        return $this;
    }

    public function addmetafield($metakey)
    {
        $this->metas[] = $metakey;

        return $this;
    }

    public function addcapfield($capkey)
    {
        $this->caps[] = $capkey;

        return $this;
    }

    public function setView(View $view)
    {
        $this->view = $view;

        return  $this;
    }

    public function action()
    {
        add_action('edit_user_profile_update', array($this, 'save'));
        add_action('edit_user_profile', array($this, 'display'));

        if ($this->showOnProfile === true || current_user_can('edit_users')) {
            add_action('personal_options_update', array($this, 'save'));
            add_action('show_user_profile', array($this, 'display'));
        }
    }

    public function save($userId)
    {
        if (!empty($this->fieldSet)) {
            foreach ($this->fieldSet as $field) {
                if (isset($_POST[$field->attr('name')])) {
                    update_user_meta($userId, $field->attr('name'), sanitize_text_field($_POST[$field->attr('name')]));
                } else {
                    delete_user_meta($userId, $field->attr('name'));
                }
                
            }
        }

        foreach ($this->metas as $meta) {
            if (isset($_POST[$meta])) {
                update_user_meta($userId, $meta, sanitize_text_field($_POST[$meta]));
            } else {
                delete_user_meta($userId, $meta);
            }
        }

        if (!empty($this->caps)) {
            $user = new \WP_User($userId);
            foreach ($this->caps as $cap) {
                if (!empty($_POST[$cap])) {
                    $user->add_cap($cap);
                } else {
                    $user->remove_cap($cap);
                }
            }
        }

    }


    public function display($user)
    {
        if (!is_null($this->view)) {
            $data = $this->view->getData();
            $data['fieldSet'] = $this->fieldSet;
            $data['user'] = $user;

            $this->view->setData($data);
            $this->view->show();

        } elseif (!empty($this->fieldSet)) {
            foreach ($this->fieldSet as $field) {
                $field->attr('value', esc_attr(get_the_author_meta($field->attr('name'), $user->ID)));
            }
            $this->fieldSet->render();
        }
        /*
        ?>
        <h3>New User Profile Links</h3>

        <table class="form-table">
            <tr>
                <th><label for="facebook_profile">Facebook Profile</label></th>
                <td><input type="text" name="facebook_profile" value="<?php echo esc_attr(get_the_author_meta('facebook_profile', $user->ID)); ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th><label for="twitter_profile">Twitter Profile</label></th>
                <td><input type="text" name="twitter_profile" value="<?php echo esc_attr(get_the_author_meta('twitter_profile', $user->ID)); ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th><label for="google_profile">Google+ Profile</label></th>
                <td><input type="text" name="google_profile" value="<?php echo esc_attr(get_the_author_meta('google_profile', $user->ID)); ?>" class="regular-text" /></td>
            </tr>
        </table>
        <?php
        */
    }

}
