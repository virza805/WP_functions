<?php 
add_shortcode('services','service_section_func');
function service_section_func($jekono){
	$result = shortcode_atts(array(
		'icon' =>'',
		'servicetitle' =>'',
		'desc' =>'',
		
	),$jekono);

	extract($result);

	ob_start();

	?>
	
       <div class="single-service">
         <i class="<?php echo esc_html($icon);?>"></i>
         <h3><?php echo $servicetitle;?></h3>
         <p><?php echo $desc;?></p>
       </div>

	<?php
	return ob_get_clean();

}

add_action( 'vc_before_init', 'service_section_el' );
function service_section_el() {
 vc_map( array(
  "name" => __( "service", "praxis" ),
  "base" => "services",
  "category" => __( "Praxis", "praxis"),
  "params" => array(
  	array(
	  "type" => "iconpicker",
	  "heading" => __( "service Icon", "praxis" ),
	  "param_name" => "icon",
	 ),
	 array(
	  "type" => "textfield",
	  "heading" => __( "Service Title", "praxis" ),
	  "param_name" => "servicetitle",
	 ),
	 array(
	  "type" => "textfield",
	  "heading" => __( "Content", "praxis" ),
	  "param_name" => "desc",
	 ),
	
	
  )
 ) );
}
 ?>