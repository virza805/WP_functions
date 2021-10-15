<?php

 vc_map(
     array(
        "name" => esc_html__( "Pricing Plan Box VC Addon", "pricing_plan" ),
        "base" => "pricing_plan_box",
        "category" => esc_html__( "PricingPlanVCAddon", "pricing_plan"),
        "params" => array(
                array(
                "type" => "textfield",
                "heading" => esc_html__( "Title", "pricing_plan" ),
                "param_name" => "title",
                "description" => esc_html__( "Enter your title/Heading.", "pricing_plan" )
                ),
                array(
                "type" => "textfield",
                "heading" => esc_html__( "Price", "pricing_plan" ),
                "param_name" => "price",
                "description" => esc_html__( "Enter your Price.", "pricing_plan" )
                ),
                
                
                array(
                "type" => "dropdown",
                "heading" => esc_html__( "Link type", "pricing_plan" ),
                "param_name" => "type",
                "std" => esc_html__( "1", "pricing_plan" ),
                "value" => array(
                    esc_html__('Link to page', 'pricing-plan') => 1,
                    esc_html__('External link', 'pricing-plan') => 2,
                    ),
                "description" => esc_html__( "Select Link.", "pricing_plan" )
                ),
                array(
                "type" => "dropdown",
                "heading" => esc_html__( "Link to page", "pricing_plan" ),
                "param_name" => "link_to_page",
                "value" => pricing_plan_get_page_as_list(),
                "description" => esc_html__( "Select Link.", "pricing_plan" ),
                "dependency" => array(
                    "element" => "type",
                    "value" => array("1"),
                    )
                ),
                array(
                "type" => "textfield",
                "heading" => esc_html__( "External link", "pricing_plan" ),
                "param_name" => "external_link",
                "description" => esc_html__( "Wright external Link.", "pricing_plan" ),
                "dependency" => array(
                    "element" => "type",
                    "value" => array("2"),
                    )
                ),
                array(
                "type" => "textfield",
                "heading" => esc_html__( "Link text", "pricing_plan" ),
                "param_name" => "link_text",
                "std" => esc_html__( "See more", "pricing_plan" ),
                "description" => esc_html__( "Wright Text Link..", "pricing_plan" )
                ),
                array(
                "type" => "dropdown",
                "heading" => esc_html__( "Pricing Style", "pricing_plan" ),
                "param_name" => "style",
                "std" => esc_html__( "1", "pricing_plan" ),
                "value" => array(
                    esc_html__('Style-1  Beginner', 'pricing-plan') => 1,
                    esc_html__('Style-2 Personal', 'pricing-plan') => 2,
                    esc_html__('Style-3 Unlimited', 'pricing-plan') => 3,
                    ),
                "description" => esc_html__( "Select Pricing Style.", "pricing_plan" )
                ),

             // This is while loop .. Start Now ... ..
                array(
                    'type' => 'param_group',
                    'param_name' => 'other_slid_group',
                    // Note params is mapped inside param-group:
                    'params' => array(
                        array(
                            "type" => "textarea",
                            "heading" => __( "description", "pricing_plan" ),
                            "param_name" => "des",
                            "std" => esc_html__( "Enter your Pricing description { Tanvir }", "pricing_plan" ),
                     ),
                     
                )  
            )
        )

    )
);

