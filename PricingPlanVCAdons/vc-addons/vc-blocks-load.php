<?php

//================Vc block load code ==============================
	if( ! defined('ABSPATH' ) ) die('-1');
 	// Class started
 	Class pricingPlanVCExtendAddonClass{

 		function __construct(){
 			// we safely integrate with VC with this hook
 			add_action('init', array( $this, 'pricingPlanIntegrateWithVC'));
 		}

 		public function pricingPlanIntegrateWithVC() {
             // Checks if Visual Composer is not installed
 			if( ! defined( 'WPB_VC_VERSION' ) ){
 				add_action('admin_notices', array( $this, 'pricingPlanShowVcVersionNotice' ));
 				return;
             }
             

 			// vissual composer addons
			 include  PRICING_PLAN_ACC_PATH . '/vc-addons/vc-p-servic.php';
			 include  PRICING_PLAN_ACC_PATH . '/vc-addons/vc-p-other-slid.php';
			 include  PRICING_PLAN_ACC_PATH . '/vc-addons/vc-pricing-plan-box.php';
			 
			 // Load pricingPlan Default Templates
            //  include  FACTORY_ACC_PATH . '/vc-addons/vc-templates.php';
             			
 			}

 		// show visual composer version
 		public function pricingPlanShowVcVersionNotice() {
 			$theme_data = wp_get_theme();
 			echo '
	 			<div class="notice notice-warning">
				    <p>'.sprintf(__('<strong>%s</strong> recommends <strong><a href="'.site_url().'/wp-admin/themes.php?page=tgmpa-install-plugins" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'strock-crazycafe'), $theme_data->get('Name')).'</p>
				</div>
 			';
 		}
 	}

// Finally initialize code
new pricingPlanVCExtendAddonClass();