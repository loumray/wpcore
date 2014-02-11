<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore\admin\Customizer;

/**
 * SliderControl
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class SliderControl extends \WP_Customize_Control
{
    protected $step = 1;
    protected $min = 1;
    protected $max = 10;

    public function __construct($manager, $id, $args = array())
    {
        parent::__construct( $manager, $id, $args );

        if (isset($args['step'])) {
            $this->step = $args['step'];
        }
        if (isset($args['min'])) {
            $this->min = $args['min'];
        }
        if (isset($args['max'])) {
            $this->max = $args['max'];
        }
    }

    public function enqueue() {
        wp_enqueue_script('jquery-ui-slider');
        // wp_enqueue_style('jquery-ui-core');
    }

    public function render_content()
    {
        $inputId  = 'input_'.$this->id;
        $sliderId = 'slider_'.$this->id;
        ?>
        <div class="customize-control-slider">    
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <input id="<?php echo $inputId;?>" style="width: 13%; margin-right: 3%; float: left; text-align: center;" type="text" <?php $this->link(); ?>>
            </label>
            <div class="wp-slider" id="<?php echo $sliderId;?>"></div>
            <script>
            jQuery(document).ready(function($) {
                $("#<?php echo $sliderId;?>").slider({
                    value: <?php echo intval($this->value()); ?>,
                    min: <?php echo $this->min; ?>,
                    max: <?php echo $this->max; ?>,
                    step: <?php echo $this->step; ?>,
                    slide: function( event, ui ) {
                        $("#<?php echo $inputId;?>").val(ui.value).keyup();
                    }
                });
                $("#<?php echo $inputId;?>").val($("#<?php echo $sliderId;?>").slider("value"));
            });
            </script>
        </div>
        <?php
    }
}