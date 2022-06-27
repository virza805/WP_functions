<?php  

// remove updated widgets style
function example_theme_support() {
    remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'example_theme_support' );

add_filter('use_block_editor_for_post', '__return_false', 10); // user old post editor
add_filter( 'use_widgets_block_editor', '__return_false' ); // user for old widgets panel


add_filter( 'site_transient_update_plugins', 'remove_update_notifications' );
function remove_update_notifications( $value ) {

    if ( isset( $value ) && is_object( $value ) ) {
        unset( $value->response[ 'elementor-pro/elementor-pro.php' ] );
    }

    return $value;
}






// add code for Text Slider now 

add_action('wp_head', 'get_custom_script_init');
function get_custom_script_init(){
	?>
    	<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script>
    	<script>
			jQuery(document).ready(function () {
				document.querySelector('.hero_title h2 span').textContent = '';

				var typed = new Typed('.hero_title h2 span', {
					strings: ["Be Smart","Be Safe","Be Connected", "SEO", "PPC", "Web Design", "Social Media", "Content"],
					typeSpeed: 70,
					startDelay: 0,
					backSpeed: 60,
					backDelay: 1400,
					loop: true,
					showCursor: true,
					cursorChar: '',
					autoInsertCss: false
				});

				//mobile
			});
		</script>
    <?php
}


