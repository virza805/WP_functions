<?php 

add_shortcode('pricing_plan_box', 'pricing_plan_box_shortcode');
function pricing_plan_box_shortcode($atts, $content = null) {

    extract( shortcode_atts( array(
        'title' => '',
        'price' => '',
        'type' => 1,
        'link_to_page' => '',
        'external_link' => '',
        'link_text' => 'See more',
        'style' => 1,

        
        'other_slid_group' =>'',
        'des' => '',

    ), $atts));

    ob_start(); 

?>

<?php 

// For Source link
if($type == 1){
    $link_source = get_page_link($link_to_page);
}else{
    $link_source = $external_link;
}

// For desc Or Paragraph
$desc_allowed_tags = array(
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

echo '

        <div class="col-md-12">
            <div class="single-pricing-item theme-'.$style.'">
              <h3>'.esc_html($title).'</h3>
              <div class="pricing-price">
                <p class="pricing-price-text">$'.esc_html($price).'</p> per month
              </div>
              <div class="pricing-content">
                ';
                
                $testimonials = vc_param_group_parse_atts($other_slid_group);
                foreach ($testimonials as $item): 
                 
                    echo '<p>'.wp_kses(wpautop($item['des']), $desc_allowed_tags).'</p>';

                 endforeach; 
     
                     echo'
              </div>
              <a href="'.esc_url($link_source).'" class="bordered-btn boxed-btn btn-blue">'.esc_html($link_text).'</a>
            </div>
        </div>
                        ';

	return ob_get_clean();
}
