<?php
/**
 * Ekko functions file
 *
 * @package ekko
 * by KeyDesign
 */

 add_action( 'wp_enqueue_scripts', 'kd_enqueue_parent_theme_style', 5 );
 if ( ! function_exists( 'kd_enqueue_parent_theme_style' ) ) {
     function kd_enqueue_parent_theme_style() {
         wp_enqueue_style( 'bootstrap' );
         wp_enqueue_style( 'keydesign-style', get_template_directory_uri() . '/style.css', array( 'bootstrap' ) );
		 wp_enqueue_style( 'custom-fonts', get_stylesheet_directory_uri() . '/fonts/fonts.css', array() );
         wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('keydesign-style') );
     }
 }

 add_action( 'after_setup_theme', 'kd_child_theme_setup' );
 if ( ! function_exists( 'kd_child_theme_setup' ) ) {
     function kd_child_theme_setup() {
         load_child_theme_textdomain( 'ekko', get_stylesheet_directory() . '/languages' );
     }
 }

 // -------------------------------------
 // Edit below this line
 // -------------------------------------
 
 // edit single product page 
 add_action( 'woocommerce_before_add_to_cart_button', 'product_info_add_text');
 function product_info_add_text() {
    global $product;
    echo $product->post->post_excerpt;
 }

// Stock status 
add_shortcode( 'stock_status', 'display_product_stock_status' );

function display_product_stock_status( $atts) {
    $atts = shortcode_atts(
        array('id'  => get_the_ID() ),
        $atts, 'stock_status'
    );
 
if( intval( $atts['id'] ) > 0 && function_exists( 'wc_get_product' ) ){
    $product = wc_get_product( $atts['id'] );
 
    $stock_status = $product->get_stock_status();
 
    if ( 'instock' == $stock_status) {        
$html = '<span class="stock in-stock">in-stock</span>';  
    } elseif ( 'outofstock' == $stock_status){
$html = '<span class="stock out-of-stock">out-of-stock</span>';      
    } else {
$html = '<span class="stock on-backorder">on-backorder</span>'; 		
	}
}
return $html;
}

// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Buy Online', 'woocommerce' ); 
}

//woo gallery thumbnail full size
add_filter( 'woocommerce_gallery_thumbnail_size', function( $size ) {
return 'full';
} );


// add javaScript hook for footer 
add_action('wp_footer', 'get_footer_custom_script');
function get_footer_custom_script(){
  ?>
  <script>
    let active_step = 1;
    let max_step=3;
    jQuery(document).ready(function(){
        

    });

    function show_pre(){
        if(active_step!=1){
            active_step-=1;
            jQuery(".msf-step-input.active").removeClass("active");
            jQuery("#step"+active_step+"").addClass("active");
        }

        if(active_step==1){
            jQuery(".step.pre,#submit_form").removeClass("current");
            jQuery(".step.next").addClass("current");
        }
        
        if(active_step==2){
            jQuery("#submit_form").removeClass("current");
            jQuery(".step.pre,.step.next").addClass("current");
        }
        
        if(active_step==3){
            jQuery("#submit_form").addClass("current");
            jQuery(".step.pre").addClass("current");
            jQuery(".step.next").removeClass("current");
        }
    }

    function show_next(){
        if(active_step!=3){
            active_step+=1;
            jQuery(".msf-step-input.active").removeClass("active");
            jQuery("#step"+active_step+"").addClass("active");
        }
        
        if(active_step==1){
            jQuery(".step.pre,#submit_form").removeClass("current");
            jQuery(".step.next").addClass("current");
        }
        
        if(active_step==2){
            jQuery("#submit_form").removeClass("current");
            jQuery(".step.pre,.step.next").addClass("current");
        }
        
        if(active_step==3){
            jQuery("#submit_form").addClass("current");
            jQuery(".step.pre").addClass("current");
            jQuery(".step.next").removeClass("current");
        }
    }
</script>
<?php 
}



// add Multi Step form Short Code
add_shortcode('ms_return_form','multi_step_fun');
function multi_step_fun(){
	ob_start(); ?>

    <div class="full-width">
        <div class="msf-container">

            <div class="msf-wrap">

                <div class="msf-single-step">
                    <div class="msf-step-title">
                        <h2>Start a Return</h2>
                        <p>We need just a few details to begin</p>
                    </div>

                    <div class="msf-step-input active" id="step1">
                        <input type="hidden" id="custId" name="custId" value="1">
                        <div class="msf-step-input-field flex-column">
                            <input type="text" name="serial" id="serial">
                            <label for="serial">Serial # *</label>
                        </div>
                        <div class="msf-step-input-field flex-column input-c">
                            <input type="text" name="order" id="order">
                            <label for="order">Order # *</label>
                        </div>
                    </div>
                    
                    <div class="msf-step-input" id="step2">
                        <div class="msf-step-input-field">
                            <label for="reason">Reason for return *:</label>
                            <select name="reason" id="reason">
                                <option value="#"> </option>
                                <option value="#">Didn’t meet expectations</option>
                                <option value="#">Didn’t fit my needs</option>
                                <option value="#">Arrived damaged</option>
                                <option value="#">Item is defective</option>
                                <option value="#">Simply changed my mind</option>
                            </select>
                        </div>
                    </div>

                    <div class="msf-step-input" id="step3">
                        <div class="msf-step-input-field">
                            <label for="name">Your Name *:</label>
                            <input type="text" name="name" id="name">
                        </div>
                        <div class="msf-step-input-field">
                            <label for="email">Your Email *:</label>
                            <input type="text" name="email" id="email">
                        </div>
                    </div>

                </div>
                <div id="message_area">

                </div>
                <div class="msf-single-step msf-buttons">
                    <button type="button" class="step pre target-btn" onclick="show_pre()">Previous</button>
                    <button type="button" class="step next current target-btn" onclick="show_next()">Next</button>
                    <button type="button" class="target-btn" id="submit_form">Submit</button>
                </div>
                
            </div>

    </div>
</div>

<?php
return ob_get_clean();
}

// Use old editor for post
add_filter('use_block_editor_for_post', '__return_false', 10);

