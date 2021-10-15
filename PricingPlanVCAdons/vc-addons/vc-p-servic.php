<?php

 vc_map(
     array(
        "name" => esc_html__( "PricingPlanVCAddon service box", "pricing_plan" ),
        "base" => "pricing_plan_service_box",
        "category" => esc_html__( "PricingPlanVCAddon", "pricing_plan"),
        "params" => array(
                array(
                "type" => "textfield",
                "heading" => esc_html__( "Title", "pricing_plan" ),
                "param_name" => "title",
                "description" => esc_html__( "Enter your title/Heading.", "pricing_plan" )
                ),
                array(
                "type" => "textarea",
                "heading" => esc_html__( "Content", "pricing_plan" ),
                "param_name" => "desc",
                "description" => esc_html__( "Enter your description.", "pricing_plan" )
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
                "heading" => esc_html__( "Service Style", "pricing_plan" ),
                "param_name" => "service_style",
                "std" => esc_html__( "1", "pricing_plan" ),
                "value" => array(
                    esc_html__('Style-1 without icon', 'pricing-plan') => 1,
                    esc_html__('Style-2 with icon', 'pricing-plan') => 2,
                    ),
                "description" => esc_html__( "Select Service Style.", "pricing_plan" )
                ),
                
                array(
                "type" => "dropdown",
                "heading" => esc_html__( "Icon type", "pricing_plan" ),
                "param_name" => "icon_type",
                "std" => esc_html__( "1", "pricing_plan" ),
                "value" => array(
                    esc_html__('Upload', 'pricing-plan') => 1,
                    esc_html__('FontAwesome', 'pricing-plan') => 2,
                    ),
                "description" => esc_html__( "Select Icon type.", "pricing_plan" ),
                "dependency" => array(
                    "element" => "service_style",
                    "value" => array("2"),
                    )
                ),
                array(
                "type" => "attach_image",
                "heading" => esc_html__( "Upload icon", "pricing_plan" ),
                "param_name" => "upload_icon",
                "description" => esc_html__( "upload imag as your wish.", "pricing_plan" ),
                "dependency" => array(
                    "element" => "icon_type",
                    "value" => array("1"),
                    )
                ),
                array(
                "type" => "iconpicker",
                "heading" => esc_html__( "Choose icon", "pricing_plan" ),
                "param_name" => "choose_icon",
                "description" => esc_html__( "Choose icon.", "pricing_plan" ),
                "dependency" => array(
                    "element" => "icon_type",
                    "value" => array("2"),
                    )
                ),
                array(
                    "type" => "attach_image",
                    "heading" => esc_html__( "Box Background", "pricing_plan" ),
                    "param_name" => "box_background",
                    "description" => esc_html__( "upload imag as your wish.", "pricing_plan" ),
                ),
            )
        )
);

