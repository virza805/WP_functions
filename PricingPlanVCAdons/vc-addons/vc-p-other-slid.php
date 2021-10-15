<?php 

vc_map(
    array(
     "name" => __( "Pricing Other Slider", "pricing_plan" ),
     "base" => "p_other_slid",
     "category" => __( "PricingPlanVCAddon", "pricing_plan"),
     "params" => array(
         
        
        array(
            "type" => "attach_image",
            "heading" => esc_html__( "Slider back ground image", "pricing_plan" ),
            "param_name" => "s_bg_img",
            "description" => esc_html__( "upload Your bg img.", "pricing_plan" )
            ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__( "PricingPlanVCAddon Service Details other_slid", "pricing_plan" ),
            "param_name" => "other_slid_style",
            "std" => esc_html__( "1", "pricing_plan" ),
            "value" => array(
                esc_html__('Review Slider', 'pricing-plan') => 1,
                esc_html__('Testimonial Slider', 'pricing-plan') => 2,
                ),
            "description" => esc_html__( "Select other_slid Style.", "pricing_plan" )
        ),
        array(
        "type" => "textfield",
        "heading" => esc_html__( "Short Description about Review", "pricing_plan" ),
        "param_name" => "description",
        "std" => esc_html__( "What People Say About Us", "pricing_plan" ),
        "description" => esc_html__( "Description About Membar", "pricing_plan" ),
        "dependency" => array(
            "element" => "other_slid_style",
            "value" => array("2"),
            )
        ),
        
        

        // Social icon & link.. Start Now ... ..
         array(
           'type' => 'param_group',
           'param_name' => 'other_slid_group',
           // Note params is mapped inside param-group:
           'params' => array(
            
                
                array(
                    "type" => "textfield",
                    "heading" => __( "Name", "pricing_plan" ),
                    "param_name" => "head",
                    "std" => esc_html__( "Tanvir Hasan", "pricing_plan" ),
                ),
                
                array(
                    "type" => "textfield",
                    "heading" => __( "title", "pricing_plan" ),
                    "param_name" => "title",
                    "std" => esc_html__( "Developer", "pricing_plan" ),
                ),
                array(
                    "type" => "textarea",
                    "heading" => __( "description", "pricing_plan" ),
                    "param_name" => "des",
                    "std" => esc_html__( "Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu <br>
                    feugiat nulla facilisis at vero. Duis autem vel eum iriure dolor in hendrerit in vulputate velit sse molestie consequatvelillum<br> dolore. eu feugiat nulla molestie consequat, vel illum facilisis at vero.", "pricing_plan" ),
                ),
                
                array(
                    "type" => "attach_image",
                    "heading" => esc_html__( "Author image", "pricing_plan" ),
                    "param_name" => "author_img",
                    "description" => esc_html__( "upload author img.", "pricing_plan" )
                ),
            


           )
         )
       
       )
   )
);