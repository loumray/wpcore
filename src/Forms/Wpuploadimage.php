<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore\Forms;

class Wpuploadimage extends AbstractField
{

    public function init()
    {
        parent::init();

        add_action('admin_enqueue_scripts',array($this,'initScripts'));
        add_action('admin_head', array($this, 'setup'));
        add_action('wp_ajax_photo_gallery_upload', array($this, 'ajax'));

    }

    public function initScripts()
    {
        wp_enqueue_script('plupload-all');
    }

    public function ajax()
    {
        check_ajax_referer('photo-upload');
       
        $status = wp_handle_upload($_FILES['async-upload'], array('test_form'=>true, 'action' => 'photo_gallery_upload'));
       
        if (!empty($status['error'])) {
            echo 'bob';
        }
        print_r($status);
       
        die();
    }
    public function setup()
    {
        $plupload_init = array(
            'runtimes'            => 'html5,silverlight,flash,html4',
            'browse_button'       => 'plupload-browse-button',
            'container'           => 'plupload-upload-ui',
            'drop_element'        => 'drag-drop-area',
            'file_data_name'      => 'async-upload',            
            'multiple_queues'     => true,
            'max_file_size'       => wp_max_upload_size().'b',
            'url'                 => admin_url('admin-ajax.php'),
            'flash_swf_url'       => includes_url('js/plupload/plupload.flash.swf'),
            'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
            'filters'             => array(array('title' => __('Allowed Files'), 'extensions' => '*')),
            'multipart'           => true,
            'urlstream_upload'    => true,
         
            // additional post data to send to our ajax hook
            'multipart_params'    => array(
                '_ajax_nonce' => wp_create_nonce('photo-upload'),
                'action'      => 'photo_gallery_upload',            // the ajax action name
            ),
        );
    ?>
   
    <script type="text/javascript">
   
      jQuery(document).ready(function($){
   
        // create the uploader and pass the config from above
        var uploader = new plupload.Uploader(<?php echo json_encode($plupload_init); ?>);
   
        // checks if browser supports drag and drop upload, makes some css adjustments if necessary
        uploader.bind('Init', function(up){
          var uploaddiv = $('#plupload-upload-ui');
   
          if(up.features.dragdrop){
            uploaddiv.addClass('drag-drop');
              $('#drag-drop-area')
                .bind('dragover.wp-uploader', function(){ uploaddiv.addClass('drag-over'); })
                .bind('dragleave.wp-uploader, drop.wp-uploader', function(){ uploaddiv.removeClass('drag-over'); });
   
          }else{
            uploaddiv.removeClass('drag-drop');
            $('#drag-drop-area').unbind('.wp-uploader');
          }
        });
   
        uploader.init();
   
        // a file was added in the queue
        uploader.bind('FilesAdded', function(up, files){
          var hundredmb = 100 * 1024 * 1024, max = parseInt(up.settings.max_file_size, 10);
   
          plupload.each(files, function(file){
            if (max > hundredmb && file.size > hundredmb && up.runtime != 'html5'){
              // file size error?
   
            }else{
   
              // a file was added, you may want to update your DOM here...
              console.log(file);
            }
          });
   
          up.refresh();
          up.start();
        });
   
        // a file was uploaded
        uploader.bind('FileUploaded', function(up, file, response) {
   
          // this is your ajax response, update the DOM with it or something...
          console.log(response);
   
        });
   
      });  
   
    </script>
    <?php
    }
    /**
     * to_html
     *
     * @return string
     */
    public function __toString()
    {
      ?>
      <div id="plupload-upload-ui" class="hide-if-no-js">
         <div id="drag-drop-area">
           <div class="drag-drop-inside">
            <p class="drag-drop-info"><?php _e('Drop files here'); ?></p>
            <p><?php _ex('or', 'Uploader: Drop files here - or - Select Files'); ?></p>
            <p class="drag-drop-buttons"><input id="plupload-browse-button" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="button" /></p>
          </div>
         </div>
      </div>
      <?php
      /*
      ?>
      <div id="plupload-upload-ui" class="customize-image-picker">
          <span class="customize-control-title"><?php echo esc_html( $this->attributes['label']); ?></span>

          <div class="customize-control-content">
              <div class="dropdown preview-thumbnail" tabindex="0">
                  <div class="dropdown-content">
                      <?php if ( empty( $this->attributes['src'] ) ): ?>
                          <img style="display:none;" />
                      <?php else: ?>
                          <img src="<?php echo esc_url(set_url_scheme($this->attributes['src'])); ?>" />
                      <?php endif; ?>
                      <div class="dropdown-status"></div>
                  </div>
                  <div class="dropdown-arrow"></div>
              </div>
          </div>

          <div class="library">
              <ul>
                  <?php /*foreach ( $this->tabs as $id => $tab ): ?>
                      <li data-customize-tab='<?php echo esc_attr($this->attributes['id']); ?>' tabindex='0'>
                          <?php echo esc_html( $tab['label'] ); ?>
                      </li>
                  <?php endforeach; *?>
              </ul>
              <?php //foreach ( $this->tabs as $id => $tab ): ?>
                  <div class="library-content" data-customize-tab='<?php echo esc_attr( $this->attributes['id'] ); ?>'>
                      <?php //call_user_func( $tab['callback'] ); ?>
                  </div>
              <?php //endforeach; ?>
          </div>

          <div class="actions">
              <a href="#" class="remove"><?php _e( 'Remove Image' ); ?></a>
          </div>
      </div>
      <?php
      */
    }

}
