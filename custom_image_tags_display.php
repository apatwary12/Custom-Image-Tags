<?php 
function custom_ready_meta_display_image_map($image_map_array, $id, $attributes, $options) {
     global $post;
     if ($image_map_array != '') {
          $finalarray= json_decode($image_map_array);
          $regened_img = wp_get_attachment_image_src($finalarray->image_id, 'large-wide');
          $primary_image = ($regened_img[0] != '' ? '<img src="" data-src="'.$regened_img[0].'" class="lazyload" data_id="'.$finalarray->image_id.'" data_width="'.$finalarray->image_width.'" data_height="'.$finalarray->image_height.'" data_max_width="'.$finalarray->image_max_width.'" data_max_height="'.$finalarray->image_max_height.'"/>'  : '');
          if ($primary_image != '') {
               $points = $finalarray->points;
               $show_points = '';
               foreach ($points as $point) {
                    $point_html = '';
                    $point_title = '';
                    $point_text = '';
                    $point_styles = '';
                    foreach ($point as $attr => $value) {
                         $point_html .= $attr.'="'.htmlspecialchars($value).'"';
                         if($attr == 'data_point_parameter_title') {$point_title = $value;}
                         if($attr == 'data_point_parameter_text') {$point_text = $value;}
                         if ($attr == 'style'){$point_styles = $value;}
                    }

                    $show_points .= '<img '.$point_html.'/>';
                    $show_points .= '<div '.$point_html .' class="info_parent"><p class=info_title>'.$point_title. '</p><p>'.$point_text. '</p></div>';
               }    
               $attr_str = '';
               if (isset($attributes)) {
                    
                    if (is_array($attributes)) {
                         foreach ($attributes as $attr => $value) {
                             $attr_str .= ' '.$attr.'="'.$value.'"'; 
                         }
                    }else{
                         $attr_str = $attributes; 
                    }
               }
               $category_id = ($options['category_id'] != '' ? $options['category_id'] : '');
               $pic_pos_id = ($options['pic_pos_id'] != '' ? $options['pic_pos_id'] : '');
               $base_URL = ($post->ID != '' ? get_permalink($post->ID) : $_SERVER['HTTP_REFERER']);
               $image_source_share = $finalarray->image_url;
               ?>   
                    <div class="custom_ready_meta_image_map_wrapper">
                         <div class="custom_ready_meta_image_map" id="<?php echo $id?>" <?php echo $attr_str?>>
                              <div class="custom_ready_meta_image_map_primary_image">
                                   <?php echo $primary_image?>
                                   <div class="social_div">
                                        <head><meta property="og:image" content="<?php echo $image_source_share ?>" /></head>
                                             <i class="fa fa-heart social_toggle" aria-hidden="true"></i>
                                             <div class="social_bbox">
                                            <div><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $base_URL?>?cat_id=<?php echo $category_id ?>%26pic_pos=<?php echo $pic_pos_id ?>%23ppersonalize%20" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i> Share on Facebook</a></div>
                                                <div><a href="https://pinterest.com/pin/create/button/?url=<?php echo $base_URL?>?cat_id=<?php echo $category_id ?>%26pic_pos=<?php echo $pic_pos_id ?>%23ppersonalize%20&media=<?php echo $image_source_share ?>" target="_blank"><i class="fa fa-pinterest-square" aria-hidden="true"></i> Pin to Pinterest</a></div>
                                                  <div><a href="mailto:" target="_blank"><i class="fa fa-envelope-square" aria-hidden="true"></i> Email</a>
                                                  </div> 
                                             </div>
                                   </div>
                              </div>
                              <div class="custom_ready_meta_image_map_show_points hide">
                                   <?php echo $show_points?>
                              </div>                    
                         </div>
                         <div id="SplashScreen" class="grid-100">
                              <div class="Loader col l12 m12 s12">
                                   <div class="line1"></div>
                                <div class="line2"></div>
                                <div class="line3"></div>
                              </div>
                         </div>
                    </div>
               <?php          
          }
     }
}


?>