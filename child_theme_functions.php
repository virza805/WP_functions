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
// add javaScript hook for footer 
add_action('wp_footer', 'get_footer_custom_script');
function get_footer_custom_script(){
  ?>
<style>
.empty_btn {
    font-family: "Poppins", Sans-serif;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    fill: #333232;
    color: #333232;
    background-color: #FFD529;
    padding: 8px 16px;
    border-radius: 3px;
    margin-top: 20px;
    display: inline-block;
}
</style>
<script>
	
    const el = document.createElement("div");
    el.innerHTML = `<a href="https://svens.is/collections/frontpage/" class="empty_btn">Fara í vefverslun</a>`;
    const box = document.getElementsByClassName("woocommerce-mini-cart__empty-message");
    // const boxId = document.getElementsById("IdName");
    // boxId.appendChild(el);
    box[0].appendChild(el);


    // class add Or remove relation with focus
    
    //  onfocus="addF()"
    document.getElementById("amount").addEventListener("focus", addF);
    function addF() {
        let element = document.getElementById("amount-icon");
        element.classList.add("carrancy");
    }
    
    // onfocusout="removeF()"
    document.getElementById("amount").addEventListener("focusout", removeF);
    function removeF() {
        let element = document.getElementById("amount-icon");
        element.classList.remove("carrancy");
    }


</script>

  <script src='https://cloneona.com/wp-includes/js/jquery/jquery.min.js?ver=3.6.1' id='jquery-core-js'></script>
<script>
	jQuery(document).ready(function () {

		// add code here 
	});
</script>

<?php
}

// add notification_bar Short Code
add_shortcode('multi_step_form','multi_step_fun');
function multi_step_fun(){
	ob_start(); ?>

<div>Notification</div>

<?php
    return ob_get_clean();
}

// WooCommerc hook My Account page 
add_action( 'woocommerce_before_customer_login_form', 'notification_add');
function notification_add() {

    // echo do_shortcode('[notification_bar]');
    // if(isset($_GET['abcd'])){  url ?abcd dea hit korta hoba
    //     echo do_shortcode('[notification_bar]');
    // }

}


// Redirect Woocommerce to a custom page after checkout
add_action('woocommerce_thankyou', 'redirect_after_checkout');
function redirect_after_checkout($order_id) {
    $order = wc_get_order($order_id);
    $cname = $order->get_billing_first_name();
    $user = base64_encode($cname);
    $url = 'Your url link /?thanks='.$user;
    if(!$order->has_status('failed')) {
        wp_safe_redirect($url);
        exit;
    }
}

// add notification home Or Thanks page Short Code
add_shortcode('notification_thanks','n_thanks_fun');
function n_thanks_fun(){
	ob_start(); ?>
<?php if(isset($_GET['thanks'])) {
    $username = base64_decode($_GET['thanks']);
    // $websiteAddress="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    // $end = end(explode('/', $websiteAddress));
    echo '
    <div class="n_left">
        <h2>Takk fyrir viðskiptin, ('.$username.').</h2>
        <p>Nú tökum við saman pöntunina. Má bjóða þér að skoða eitthvað fleira?</p>
    </div>
    ';
}; ?>
    

<?php
    return ob_get_clean();
}

// backend from validation with phone & Email

    // validation logic here
    $g_name=trim($_POST["gift_card_recipient_name"]);
    $g_sms=trim($_POST["gift_card_custome_message"]);
    $g_email=trim($_POST["gift_card_recipient_email"]);
    $g_phone=trim($_POST["gift_card_phone"]);

    if (empty($g_name)) {
        wc_add_notice( __( 'Viðtakanda Nafn Áskilið.', 'woocommerce' ), 'error' );
        $passed = false;
    }elseif(empty($g_email)){
        wc_add_notice( __( 'Viðtakanda Netfang Áskilið.', 'woocommerce' ), 'error' );
        $passed = false;
    }elseif(!$g_email){
        wc_add_notice( __( 'Email is requerd.', 'woocommerce' ), 'error' );
        $passed = false;
    }elseif (!$g_email || !is_email($g_email)) {
        wc_add_notice( sprintf( 'Viðtakanda Netfang not valid.'), 'error' );
        $passed = false; // don't add the new product to the cart
        
    }elseif(empty($g_phone)){
        wc_add_notice( __( 'Viðtakanda Símanúmer Áskilið.', 'woocommerce' ), 'error' );
        $passed = false;
    }elseif(strlen($g_phone)!=7 || !is_numeric($g_phone)){
        wc_add_notice( sprintf( 'Viðtakanda Símanúmer Áskilið'), 'error' );
        $passed = false; // don't add the new product to the cart
        // break;
    }elseif(empty($g_sms)){
        wc_add_notice( __( 'Viðtakanda Skilaboð Áskilið.', 'woocommerce' ), 'error' );
        $passed = false;
    }else{
        $passed = true;
    }