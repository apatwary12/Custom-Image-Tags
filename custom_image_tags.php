<?php
/* 
Plugin Name: Custom Image Tags
Plugin URI: https://ari-senpai.ninja/ 
Description: Plugin For adding image tags to images. Copyright Ari Patwary 2018. No duplication or redistributing.
Version: 1.0
Author: Ari Patwary
Author URI: https://ari-senpai.ninja/
*/


define( 'CUSTOMIMAGETAGS_URL', plugin_dir_url(__FILE__) );
define( 'CUSTOMIMAGETAGS_PATH', plugin_dir_path(__FILE__) );
define( 'CUSTOMIMAGETAGS_BASENAME', plugin_basename( __FILE__ ) );
//include( plugin_dir_path( __FILE__ ) . 'custom_ready_meta_options.php');

 


add_action( 'add_meta_boxes', 'design_studio_metaboxes' );


//Start add Design Center custom post types
add_action('init','design_center_init');
function design_center_init(){
     design_center_post_types();
}
function design_center_post_types(){
     register_post_type('design_center', array(
          'labels' => array(
               'name' => __( 'Design Center' ),
               'singular_name' => __( 'Design Center Category' ),
               'menu_name' => 'Design Center',
               'add_new'=>'Add Design Center Category',
               'add_new_item'=>'Add Design Center Category'
          ),
          'public' => true,
          'show_ui' => true,
          'show_in_menu'=>true,
          'menu_position'=>4,
          'menu_icon' => 'dashicons-awards',     
          'capability_type' => 'post',
          'hierarchical' => false,
          'rewrite' => array('slug' => 'design-center'),
          'query_var' => true,
          'supports' => array(
          'title',
          'thumbnail',
          'page-attributes',
          'editor'
          )
     ) );
}
//End add Design Center custom post types

//Start add Design Center Ajax 
function get_design_center_images() {
     $pageid = $_POST['pageid'];
     global $wpdb;
     global $post;
     $result = '';
     $image_map_photos = array();
     if (get_post_meta( $pageid,'custom_ready_meta_design_studio_fields', true) != '' && get_post_meta( $pageid,'custom_ready_meta_design_studio_fields', true) > 0) { 
         $image_map_count = get_post_meta( $pageid,'custom_ready_meta_design_studio_fields', true);
       for ($i=1; $i <= $image_map_count; $i++) { 
        //print_r(get_post_meta( $pageid,'custom_ready_meta_design_studio_fields_image_map_'.$i, true));
         if (get_post_meta( $pageid,'custom_ready_meta_design_studio_fields_image_map_'.$i, true) != '') {
         $image_map_array = get_post_meta( $pageid,'custom_ready_meta_design_studio_fields_image_map_'.$i, true);
          $finalarray= json_decode($image_map_array);
          $image_map_photos[] = $finalarray; 

        }
      }                    
   }
         $photos = get_post_meta($pageid, 'adv_ss_slideshow', true);  
         $i = 0;  
         if (!empty($image_map_photos)) {  
              ob_start();
              foreach ($image_map_photos as $img) {
                   $photoimgid = $img->image_id;
                   $photoimgthumbsrc = wp_get_attachment_image_src($photoimgid, 'large');
                   $photoimgsrc = wp_get_attachment_image_src($photoimgid, 'large');
         ?>         
                   <div class="design_center_img" style="background-image: url(<?php echo $photoimgthumbsrc[0]?>);background-color: #000;" data-src="<?php echo $photoimgsrc[0]?>" data-ajax_pos = "<?php echo $i+1 ?>" lightbox_pos="<?php  echo $i?>"></div>
         <?php
                 $i++; 
              } 
              $result = ob_get_contents();
              ob_clean();                          
         }else{
              $result = 'Currently there are no '.get_the_title($pageid).' design center images.<br>Please Sign up below to be informed about '.get_the_title($pageid).' design center updates.';
         }
        echo $result;
        die();
    }
add_action('wp_ajax_get_design_center_images', 'get_design_center_images');
add_action('wp_ajax_nopriv_get_design_center_images', 'get_design_center_images');
//End add Design Center Ajax 

//Start add Design Center content not page Ajax 
function get_design_center_feed() {
     $pageid = $_POST['pageid'];
     global $wpdb;
     global $post;
     $result = '';
     $image_map_photos = array();
     if (get_post_meta( $pageid,'custom_ready_meta_design_studio_fields', true) != '' && get_post_meta( $pageid,'custom_ready_meta_design_studio_fields', true) > 0) { 
         $image_map_count = get_post_meta( $pageid,'custom_ready_meta_design_studio_fields', true);
       for ($i=1; $i <= $image_map_count; $i++) { 
        //print_r(get_post_meta( $pageid,'custom_ready_meta_design_studio_fields_image_map_'.$i, true));
         if (get_post_meta( $pageid,'custom_ready_meta_design_studio_fields_image_map_'.$i, true) != '') {
         $image_map_array = get_post_meta( $pageid,'custom_ready_meta_design_studio_fields_image_map_'.$i, true);
          $finalarray= json_decode($image_map_array);
          $image_map_photos[] = $finalarray; 

        }
      }                    
   }
         $photos = get_post_meta($pageid, 'adv_ss_slideshow', true);  
         $i = 0;  
         if (!empty($image_map_photos)) {  
              ob_start();
              foreach ($image_map_photos as $img) {
                   $photoimgid = $img->image_id;
                   $photoimgthumbsrc = wp_get_attachment_image_src($photoimgid, 'medium');
                   $photoimgsrc = wp_get_attachment_image_src($photoimgid, 'large');
         ?>         
                   <div class="design_center_img" style="background-image: url(<?php echo $photoimgthumbsrc[0]?>);background-color: #000;" data-src="<?php echo $photoimgsrc[0]?>" data-ajax_pos = "<?php echo $i+1 ?>" lightbox_pos="<?php  echo $i ?>"></div>
         <?php
                 $i++; if ($i == 3){break;}
              } echo '<div style="display: flex;align-items:  center;justify-content:  center;"><a class="primary_btn" href="/design-studio-gallery/?cat_id='.$pageid.' ">MORE</a></div>';
              $result = ob_get_contents();
              ob_clean();                          
         }else{
              $result = 'Currently there are no '.get_the_title($pageid).' design center images.<br>Please Sign up below to be informed about '.get_the_title($pageid).' design center updates.';
         }
        echo $result;
        die();
    }
add_action('wp_ajax_get_design_center_feed', 'get_design_center_feed');
add_action('wp_ajax_nopriv_get_design_center_feed', 'get_design_center_feed');
//End add Design Center content not page Ajax 



//Start Add design Studio Fields
add_action( 'add_meta_boxes', 'design_image_maps_metaboxes' );
function design_image_maps_metaboxes() {
    add_meta_box('design_image_maps_metaboxes_details', 'Design Studio Tags', 'design_image_maps_metaboxes_details', 'design_center', 'normal', 'low');   
}
     


function design_image_maps_metaboxes_details() {  
     if (function_exists('custom_ready_meta_createinput')) {
          $sections = array(                              
               array('title'=>'Home Page Map Area', 'id'=>'home', 
                    'fields'=>array(                  
                         array('name'=>'design_studio_fields', 'type'=>'dynamic_fields','label' => 'Tagged Image Gallery', 'instructions' => 'Drag and Drop Boxes To Gallery Order', 
                              'selections' => array(       
                                   array('name'=>'image_map', 'type'=>'imagemap', 'label' => 'Gallery Image', 'instructions' => '', 'attributes' => array('order'=> 1, 'static_image_map_point' => CUSTOMIMAGETAGS_URL.'/images/image_map_marker.png', 'image_map_thumb_size' => 'large-wide'),
                                        'selections' => array(                                                                            
                                             array('name'=>'title', 'type'=>'input_text', 'label' => 'Tag Title', 'instructions' => '', 'selections' => NULL, 'attributes' => array('order'=> 1)
                                             ),
                                             array('name'=>'text', 'type'=>'input_text', 'label' => 'Tag Text', 'instructions' => '', 'selections' => NULL, 'attributes' => array('order'=> 2)
                                             )                                                                                                                    
                                        )
                                   ), 
                              )
                         ),                                                                                                                              
                    )
               )             
          );                      
          echo '<input type="hidden" name="custom_ready_meta_metaboxes_noncename" id="custom_ready_meta_metaboxes_noncename" value="'.wp_create_nonce('custom_ready_meta_metaboxes_verify') .'" />';                             
          foreach ($sections as $section) {
               $fields = $section['fields'];
               echo '<fieldset class="crm_fieldset">';
               echo '<legend class="legend">'.$section['title'].' Section</legend>';
               foreach($fields as $field){
                    echo custom_ready_meta_createinput($field['type'], $field['name'], $field['label'], $field['instructions'], $field['selections'], $field['attributes'] );
               }
               echo '</fieldset>';
               $i++;
          }       
     }
}
//End Add Design Studio Fields
function custom_ready_meta_display_image_tags_ajax(){
     custom_image_tags_display_load();
     $image_map_id = $_POST['image_map_id'];
     $page_id = $_POST['page_id'];
     $image_map_array = get_post_meta( $page_id,'custom_ready_meta_design_studio_fields_image_map_'.$image_map_id, true); 
     $id = $_POST['element_id'];
     $attributes = $_POST['attributes'];
     $category_id = $_POST['cat_id']; 
     $pic_pos_id = $_POST['pic_pos'];
     $options = array('category_id' => $category_id, 'pic_pos_id' => $pic_pos_id);
     custom_ready_meta_display_image_map($image_map_array, $id, $attributes, $options);
     die();

}

add_action('wp_ajax_custom_ready_meta_display_image_tags_ajax', 'custom_ready_meta_display_image_tags_ajax');
add_action('wp_ajax_nopriv_custom_ready_meta_display_image_tags_ajax', 'custom_ready_meta_display_image_tags_ajax');

function custom_image_tags_display_load() {
     require_once 'custom_image_tags_display.php';
     wp_register_script('magnific_js', CUSTOMIMAGETAGS_URL.'/js/jquery.magnific-popup.min.js', array('jquery') );
     wp_enqueue_script('magnific_js');
     wp_register_style('magnific_css', CUSTOMIMAGETAGS_URL.'/css/magnific-popup.css',false );
     wp_enqueue_style('magnific_css'); 
     wp_register_script('image_tags_display_js', CUSTOMIMAGETAGS_URL.'/js/custom_image_tags_display.js', array('jquery', 'magnific_js' ) );
     wp_enqueue_script('image_tags_display_js');
     wp_register_style('image_tags_display_css', CUSTOMIMAGETAGS_URL.'/css/custom_image_tags_display.css',false );
     wp_enqueue_style('image_tags_display_css');                    
}

add_image_size( 'design_gallery', 1200, 600, false);

/*Start Add Attachment Sizes To WP.Media JS*/
function custom_image_tags_wp_media_image_sizes_js( $response, $attachment, $meta ){

        $size_array = array( 'design_gallery') ;

        foreach ( $size_array as $size ):

            if ( isset( $meta['sizes'][ $size ] ) ) {
                $attachment_url = wp_get_attachment_url( $attachment->ID );
                $base_url = str_replace( wp_basename( $attachment_url ), '', $attachment_url );
                $size_meta = $meta['sizes'][ $size ];

                $response['sizes'][ $size ] = array(
                    'height'        => $size_meta['height'],
                    'width'         => $size_meta['width'],
                    'url'           => $base_url . $size_meta['file'],
                    'orientation'   => $size_meta['height'] > $size_meta['width'] ? 'portrait' : 'landscape',
                );
            }

        endforeach;

        return $response;
}
add_filter ( 'wp_prepare_attachment_for_js',  'custom_image_tags_wp_media_image_sizes_js' , 10, 3  );
/*End Add Attachment Sizes To WP.Media JS*/


?>