<?php 
add_shortcode('p_other_slid','p_other_slid_section_func');
function p_other_slid_section_func($jekono){
	$result = shortcode_atts(array(
		'other_slid_group' =>'',
        'other_slid_style' => 1,
        's_bg_img' => '',
        'description' => '',
        
        'head' => '',
        'title' => '',
        'des' => '',
        'author_img' => '',
		
	),$jekono);

	extract($result);

	ob_start();



	?>

<?php



// For Back Ground Image

$s_bg_img_array = wp_get_attachment_image_src($s_bg_img, 'large');
// For desc Or Paragraph
$des_allowed_tags = array(
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

if($other_slid_style == 1) {


echo '
<!--Start testimonial section-->
<section class="testimonial-section" style = "background-image:url('.esc_url($s_bg_img_array[0]).')">
    <div class="container">
        <div class="row">
           <div class="manager_text">';

           $testimonials = vc_param_group_parse_atts($other_slid_group);
           foreach ($testimonials as $item): 
            
// For Author Image

$author_img_array = wp_get_attachment_image_src($item['author_img'], 'large');

echo '
                <div class="single-manager_text">
                    <img src="'.esc_url($author_img_array[0]).'" alt="Images">
                    <p>'.wp_kses(wpautop($item['des']), $des_allowed_tags).'</p>
                    <div class="manager">
                        <h4>'.esc_html($item['head']).'</h4>
                        <h6>'.esc_html($item['title']).'</h6>
                    </div>
                </div>
    ';
            endforeach; 

                echo'
            </div>
           
        </div>
    </div>
</section>  
';

} else {
    
echo '

<!-- Start testimonial section -->
<section class="testimonials_about_area" style = "background-image:url('.esc_url($s_bg_img_array[0]).')">
    <div class="container">
        <div class="section-title">
            <h2>'.esc_html($description).'</h2>
        </div>
        <div class="testimonials-wrap row">';

        $testimonials = vc_param_group_parse_atts($other_slid_group);
        foreach ($testimonials as $item): 
         
// For Author Image

$author_img_array = wp_get_attachment_image_src($item['author_img'], 'thumbnail');


        echo '
                <div class="item">
                    <!-- Startsingle-testimonials -->
                    <div class="single_testimonials">
                        <!-- Start text-box -->
                        <div class="text_box">
                            <p>
                                <span class="qoute">“</span>
                                '.wp_kses(wpautop($item['des']), $des_allowed_tags).'
                            </p>
                        </div>
                        <!-- End text-box -->
                        <!-- Start client-box -->
                        <div class="client-box">
                            <!-- Start img-box -->
                            <div class="img-box">
                                <img src="'.esc_url($author_img_array[0]).'" alt="">
                            </div>
                            <!--End img-box -->
                            <!--Start info-box -->
                            <div class="info-box">
                                <h4>'.esc_html($item['head']).'</h4>
                                <span>'.esc_html($item['title']).'</span>
                            </div><!--End info-box -->
                        </div>
                        <!--End client-box -->
                    </div>
                    <!-- End single-testimonials -->
                </div>
                ';
        endforeach;      
     echo '      
        
        </div>
    </div>
</section>
<!--End testimonial section -->




';


} ?>

                    
	<?php
	return ob_get_clean();

}
