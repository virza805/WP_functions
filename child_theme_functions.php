<?php  
// for ubuntu os wordpress localhost asking for ftp
// define('FS_METHOD', 'direct');

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
    <style>
    .spin {
        text-align: center;
        height: 320px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .spin img {
        animation: rotet 3s linear infinite;
        width: 150px;
        height: 150px;
    }
    @keyframes rotet {
        0%{
            transform: rotate(360deg);
        }
        100%{
            transform: rotate(0deg);
        }
    }
    </style>
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
	
    let title_js = "";
    let dec_js = "";
    window.wp.media.editor.insert( '[ short_code'+ '  '+'title="' + title_js + '"'+' '+ 'dec="' + dec_js + '" ]');



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


// check login user with relation redirect page url
add_action('init', 'check_login_function');
function check_login_function() {
	
	$postID = url_to_postid( $_SERVER['REQUEST_URI'] , '_wpg_def_keyword', true ); 
	if(in_array($postID,[5218,5285,5286]) && !is_user_logged_in()){
		wp_safe_redirect('https://www.convair.net.au/user');
		exit();
	}

	if(in_array($postID,[5339,5202]) && is_user_logged_in()){
		wp_safe_redirect('https://www.convair.net.au/userprofile');
		// wp_safe_redirect(get_permalink( wc_get_page_id( 'myaccount' ) )); // my account page
		exit();
	}
	
}



// category link by product id 

// global $product;
// $product_id = $product->get_id();
$product_id = get_the_ID();
$_product = wc_get_product($product_id);
// echo "<pre>";
// print_r($_product);
// echo "</pre>";

$cats = $_product->get_category_ids();
foreach ($cats as $key => $value) {
	$catLink = get_category_link($value);
	?>

	<a class="back-to-all" href="<?php echo $catLink ?>">&#8592; back to all devices</a><br>

	<?php
}


// wooCommerce my-account 

add_filter( 'woocommerce_account_menu_items', 'my_account_menu_order_label', 999 );

function my_account_menu_order_label( $items ) {

    $items['orders'] = __( 'My entries/orders', 'woocommerce' );

    return $items;
}


add_filter( 'woocommerce_before_account_orders', 'order_page_title');
function order_page_title() {

    echo 'My entries/orders <br>';
    // echo get_post_meta( 3292, 'total_tickets', true); | test post meta

}
/*
add_filter( 'woocommerce_my_account_my_orders_columns', 'add_entrie_column_in_orders' );
function add_entrie_column_in_orders( $columns ) {
    $columns['entries_column'] = __( 'Entries', 'woocommerce' ); // number_of_tickets
    return $columns;
}
*/

# url Redirect
add_action( 'template_redirect', 'custom_redirects' );
function custom_redirects() {
   if ( function_exists( 'wp_redirect' ) ) {
       $redirects = array(
           '/dev/gjafakaup.is/shop/' => 'https://leikbreytir.com/dev/gjafakaup.is/kaupa/',
         //   '/old-post-slug' => 'https://example.com/new-post-slug',
           // Add more redirection rules here
       );

       foreach ( $redirects as $old_url => $new_url ) {
           if ( $_SERVER['REQUEST_URI'] == $old_url ) {
               wp_redirect( $new_url, 301 );
               exit();
           }
       }
   }
}

// add order table th 
add_filter( 'woocommerce_my_account_my_orders_columns', 'rearrange_my_account_orders_column' );
function rearrange_my_account_orders_column( $columns ) {

    $new_columns = array();

    foreach ( $columns as $key => $name ) {

        $new_columns[ $key ] = $name;

        // add ship-to after order status column
        if ( 'order-total' === $key ) {  //this is the line!
            $new_columns['entries_column'] = __( 'Entries', 'woocommerce' );
        }
    }

    return $new_columns;
}

// add order table td with value from get_post_meta 
add_filter( 'woocommerce_my_account_my_orders_column_entries_column', 'add_entries_data_to_my_account_orders' );
function add_entries_data_to_my_account_orders( $order ) {
    // return $order->get_order_number();

    // echo get_post_meta( $order_id, 'total_tickets', true);
    if ( $value = $order->get_meta( 'total_tickets' ) ) {
        echo esc_html( $value );
    }
}



// use wp default text editor
    $content = $id ? $r->popup : "Enter your popup text";
    // html_entity_decode(stripcslashes($content));
    // wp_editor( $content, $editor_id, $settings );
    wp_editor( $content, 'popup', array(
        'wpautop'       => true,
        'media_buttons' => false, // true | false
        'textarea_name' => 'popup',
        'editor_class'  => 'tpdm-input',
        'textarea_rows' => 10
    ) );



add_filter( 'gettext', 'wpdocs_translate_text', 10, 3 );
function wpdocs_translate_text( $translated_text, $untranslated_text, $domain ) {

	switch ( $translated_text ) {

		case '[Remove]' :

			$translated_text = '[Fjarlægja]';
			break;

		case 'Coupon has been removed.' :

			$translated_text = 'Afsláttarkóðinn hefur verið fjarlægt';
			break;

	}


    return $translated_text;
}


// allowed to upload .jfif file type
add_filter('mime_types', 'add_support_jfif_files');
function add_support_jfif_files($mimes){
    $mimes['svg'] = "image/jpeg";
    return $mimes;
}


// Gift Card cart page

if($values['wdm_user_custom_data_value']['gift_card_time']!='00:00:00'){
    $return_string .= "<tr><td>Dagsetning: " . $values['wdm_user_custom_data_value']['gift_card_date'] . " @ " . $values['wdm_user_custom_data_value']['gift_card_time'] . "</td></tr>";
}else{
    $return_string .= "<tr><td>Dagsetning: " . $values['wdm_user_custom_data_value']['gift_card_date'] . "</td></tr>";
}

// wp Pagenation
$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;

$limit = 10; // number of rows in page
$offset = ( $pagenum - 1 ) * $limit;
$total = $wpdb->get_var( "SELECT COUNT(`id`) FROM {$wpdb->prefix}books" );
$num_of_pages = ceil( $total / $limit );
$entries = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}books LIMIT $offset, $limit" );




$page_links = paginate_links( array(
    'base' => add_query_arg( 'pagenum', '%#%' ),
    'format' => '',
    'prev_text' => __( '&laquo;', 'text-domain' ),
    'next_text' => __( '&raquo;', 'text-domain' ),
    'total' => $num_of_pages,
    'current' => $pagenum
) );

if ( $page_links ) {
    echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
}

/*
// Tanvir test 
https://tastewp.com/#!

Site name: Bear Knowledge
URL: https://bearknowledge.s3-tastewp.com
Username: admin
Password: KnX8NABsvRM


*/
// <input value="" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="gift_card_phone" maxlength="7" minlength="7">
