<?php 


add_shortcode('pricing_plan_service_box', 'pricing_plan_service_box_shortcode');
function pricing_plan_service_box_shortcode($atts, $content = null) {

    extract( shortcode_atts( array(
        'title' => '',
        'desc' => '',
        'type' => 1,
        'link_to_page' => '',
        'external_link' => '',
        'link_text' => 'See more',
        'service_style' => 1,
        'icon_type' => 1,
        'upload_icon' => '',
        'choose_icon' => '',
        'box_background' => '',
    ), $atts));

    ob_start(); 

?>

<?php 
$box_bg_array = wp_get_attachment_image_src($box_background, 'large');

// For Source link
if($type == 1){
    $link_source = get_page_link($link_to_page);
}else{
    $link_source = $external_link;
}

// For desc Or Paragraph
$stock_cta_desc_allowed_tags = array(
    'a' => array(
        'href' => array(),
        'title' => array(),
        'class' => array()
    ),
    'img' => array(
        'alt' => array(),
        'src' => array()
    ),
    'br' => array(),
    'em' => array(),
    'strong' => array(),
);
if($service_style == 1) {
 echo '
 <!--Start service section-->  
        <section class="service-section">
            <div class="container">

                <div class="row">

                    <div class="col-md-12 col-sm-6 col-md-xs-12">
                        <div class="service-column item-margin-bot-60">

                            
                            <div class="service-columnbox">
                                <img src="'.esc_url($box_bg_array[0]).'" alt="">
                                <div class="overlay">
                                    <a href="'.esc_url($link_source).'"><h4>'.esc_html($title).'</h4></a>
                                    <p>'.wp_kses(wpautop($desc), $stock_cta_desc_allowed_tags).'</p>
                                </div>
                            </div>
                            <div class="details"><a href="'.esc_url($link_source).'" class="theme-btn skew-btn"><span class="btn-text">'.esc_html($link_text).'</span></a></div>
                        </div>
                    </div> 
            
                </div>
            </div>
        </section>   
        <!--End service section--> 
 ';
}else{
 echo '
 <!--Start service section-->  
        <section class="service-section">
            <div class="container">

                <div class="row">

                    <!--Start single  item-->
                    <div class="col-md-12 col-sm-6 col-xs-12">
                        <div class="service-column item-margin-bot-60">

                            
                            <div class="service-image-box">
                                <img src="'.esc_url($box_bg_array[0]).'" alt="">
                                <div class="overlay">
                                    <div class="text">
                                        <a href="'.esc_url($link_source).'"><h4>'.esc_html($title).'</h4></a>
                                        <p>
                                        '.wp_kses(wpautop($desc), $stock_cta_desc_allowed_tags).'<a href="'.esc_url($link_source).'">'.esc_html($link_text).'</a></p>
                                    </div>
                                    <div class="inner-image-box">
                            ';
               
                            if($icon_type == 1){
                                $service_icon_array = wp_get_attachment_image_src($upload_icon, 'thumbnail');
                                echo '<img src="'.esc_url($service_icon_array[0]).'" alt=""/>';
                            }else{
                                echo '<i class="'.esc_attr($choose_icon).'"></i>';
                            }

                             echo '
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <!--End single  item-->

                   

                    

                    

                    
                    
                </div>
            </div>   
        </section>   
        <!--End service section--> 
 ';
}
?>






<?php
	return ob_get_clean();
}
