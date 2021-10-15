<?php 
add_shortcode('title-section','title_section_func');
function title_section_func($jekono){
	$result = shortcode_atts(array(
		'sec_tit' =>'',
		'sec_des' =>'',
	),$jekono);

	extract($result);


	ob_start();
	?>
	<div class="section-header text-center">
         <h2><?php echo $sec_tit; ?></h2>
         <p><?php echo $sec_des; ?></p>
    </div>

	<?php
	return ob_get_clean();
}

add_action( 'vc_before_init', 'title_section_el' );
function title_section_el() {
 vc_map( array(
  "name" => __( "Section Title", "praxis" ),
  "base" => "title-section",
  "category" => __( "Praxis", "praxis"),
  "params" => array(
	 array(
	  "type" => "textfield",
	  "heading" => __( "Section Title", "praxis" ),
	  "param_name" => "sec_tit",
	  "value" => __( "Enter Your Section Title", "praxis" ),
	  "description" => __( "Description for foo param.", "praxis" )
	 ),
	 array(
	  "type" => "textfield",
	  "heading" => __( "Section Description", "praxis" ),
	  "param_name" => "sec_des",
	 ),

  )
 ) );
}
 ?>