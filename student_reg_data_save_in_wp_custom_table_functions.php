<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

add_filter( 'site_transient_update_plugins', 'remove_update_notifications' );
function remove_update_notifications( $value ) {

    if ( isset( $value ) && is_object( $value ) ) {
        unset( $value->response[ 'elementor-pro/elementor-pro.php' ] );
        unset( $value->response[ 'elementor/elementor.php' ] );
    }

    return $value;
}

add_filter('use_block_editor_for_post', '__return_false', 10); // user old post editor
add_filter( 'use_widgets_block_editor', '__return_false' ); // user for old widgets panel



// add javaScript hook for footer 
add_action('wp_footer', 'get_footer_custom_script');
function get_footer_custom_script(){
  ?>
<script src='https://cloneona.com/wp-includes/js/jquery/jquery.min.js?ver=3.6.1' id='jquery-core-js'></script>
<script>
    let active_step = 1;
    let max_step = 4;
    jQuery(document).ready(function () {


    });

    function show_pre() {

        if (active_step != 1) {
            active_step -= 1;
            jQuery(".msf-step-input.active").removeClass("active");
            jQuery("#step" + active_step + "").addClass("active");
        }

        if (active_step == 1) {
            jQuery(".step.pre,#submit_form").removeClass("current");
            jQuery(".step.next").addClass("current");
        }

        if (active_step == 2) {
            jQuery("#submit_form").removeClass("current");
            jQuery(".step.pre,.step.next").addClass("current");
        }

        if (active_step == 3) {
            jQuery("#submit_form").removeClass("current");
            jQuery(".step.pre,.step.next").addClass("current");
        }

        if (active_step == 4) {
            jQuery("#submit_form").addClass("current");
            jQuery(".step.pre").addClass("current");
            jQuery(".step.next").removeClass("current");
        }
    }

    function show_next() {
        jQuery("#message_area").html("");
        if (active_step != 4) {
            // validation
            let progress = true;
            jQuery(".msf-step-input.active .data-input-element").each(function () {
                let required = jQuery(this).attr("required");
                let value = jQuery(this).val().trim();
                if (required && !value) {
                    progress = false;
                    let label = jQuery(this).parent().find("label").text().replace('*', '').replace(':', '');
                    jQuery("#message_area").append(`<p class="error">${label} is required.</p>`);
                }
            })

            if (!progress) {
                return false;
            }

            active_step += 1;
            jQuery(".msf-step-input.active").removeClass("active");
            jQuery("#step" + active_step + "").addClass("active");
        }

        if (active_step == 1) {
            jQuery(".step.pre,#submit_form").removeClass("current");
            jQuery(".step.next").addClass("current");
        }

        if (active_step == 2) {
            jQuery("#submit_form").removeClass("current");
            jQuery(".step.pre,.step.next").addClass("current");
        }

        if (active_step == 3) {
            jQuery("#submit_form").removeClass("current");
            jQuery(".step.pre,.step.next").addClass("current");
        }
        if (active_step == 4) {
            jQuery("#submit_form").addClass("current");
            jQuery(".step.pre").addClass("current");
            jQuery(".step.next").removeClass("current");
        }
    }

    // validation email
    function isEmail(email) {
        let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);

    }

    function msf_submit() {
        jQuery("#message_area").html("");
        if (active_step == 4) {
            // validation
            let progress = true;

            jQuery(".data-input-element").each(function () {
                let required = jQuery(this).attr("required");
                let emailtyp = jQuery(this).attr("type");
                let value = jQuery(this).val().trim();

                if (required && !value) {
                    progress = false;
                    let label = jQuery(this).parent().find("label").text().replace('*', '').replace(':', '');
                    jQuery("#message_area").append(`<p class="error">${label} is required.</p>`);

                }

                if (emailtyp == "email" && value) {
                    if (!isEmail(value)) {
                        progress = false;
                        let label = jQuery(this).parent().find("label").text().replace('*', '').replace(':',
                        '');
                        jQuery("#message_area").append(`<p class="error">${label} is must be valid.</p>`);
                    }
                }

            })

            if (!progress) {
                return false;
            }

            // call ajax

            let data = jQuery(".data-input-element").serialize();
            // console.log(data);
            jQuery("#message_area").html(`<p class="info">Please wait! we are processing...</p>`);
            jQuery.post("<?=admin_url( 'admin-ajax.php' )?>",data,function(result) {
                    let obj = JSON.parse(result);
                    console.log(obj);
                    if (obj.status == 'ok') {
                        window.location.href = obj.url;
                    } else {
                        alert("Something went wrong!");
                    }
                });


        }

    }
</script>

<script>

</script>

<?php 
}

// add Multi Step Form Short Code
add_shortcode('multi_step_form','multi_step_fun');
function multi_step_fun(){
	ob_start(); ?>
<div class="full-width">
    <div class="msf-container">
        <div class="msf-wrap">

            <div class="msf-single-step">
                <div class="msf-step-title">
                    <h2>Multi Step Form</h2>
                    <p>Ajax Practice</p>
                </div>

                <div class="msf-step-input active" id="step1">
                    <h3>Step 1</h3>
                    <input type="hidden" id="formid" name="formid" value="2" class="data-input-element">
                    <input type="hidden" name="action" value="w1d_msf_process" class="data-input-element">
                    <div class="msf-step-input-field flex-column">
                        <label for="name">Name *</label>
                        <input type="text" name="Name" id="name" required="required" class="data-input-element">
                    </div>
                    <div class="msf-step-input-field flex-column">
                        <label for="role">Role *</label>
                        <input type="text" name="Role" id="role" required="required" class="data-input-element">
                    </div>
                </div>

                <div class="msf-step-input" id="step2">
                    <h3>Step 2</h3>
                    <div class="msf-step-input-field flex-column">
                        <label for="class">Class *:</label>
                        <input type="text" name="Class" id="class" required="required" class="data-input-element">
                    </div>
                    <div class="msf-step-input-field flex-column">
                        <label for="subject">Subject *:</label>
                        <input type="text" name="Subject" id="subject" required="required" class="data-input-element">
                    </div>
                </div>

                <div class="msf-step-input" id="step3">
                    <h3>Step 3</h3>
                    <div class="msf-step-input-field flex-column">
                        <label for="age">Age *:</label>
                        <input type="text" name="Age" id="age" required="required" class="data-input-element">
                    </div>
                    <div class="msf-step-input-field flex-column">
                        <label for="phone">Phone *:</label>
                        <input type="text" name="Phone" id="phone" required="required" class="data-input-element">
                    </div>
                </div>

                <div class="msf-step-input" id="step4">
                    <h3>Step 4</h3>
                    <div class="msf-step-input-field flex-column">
                        <label for="comment">Your Comment *:</label>
                        <input type="text" name="Comment" id="comment" required="required" class="data-input-element">
                    </div>
                    <div class="msf-step-input-field flex-column">
                        <label for="email">Your Email *:</label>
                        <input type="email" name="Email" id="email" required="required" class="data-input-element">
                    </div>
                </div>

            </div>
            <div id="message_area"> </div>
            <div class="msf-single-step msf-buttons">
                <button type="button" class="step pre target-btn" onclick="show_pre()">Previous</button>
                <button type="button" class="step next current target-btn" onclick="show_next()">Next</button>
                <button type="button" class="target-btn" id="submit_form" onclick="msf_submit()">Submit</button>
            </div>

        </div>
    </div>
</div>
<?php
return ob_get_clean();
}


// ajax process
function w1d_msf_process(){

    $html='<table>';
        foreach($_POST as $k=>$val){

            if($k=='formid'||$k=='action') continue;

            
                $html.='<tr>
                    <th>'.$k.'</th>
                    <td>:</td>
                    <td>'.$val.'</td>
                </tr>';
            
        }
        
    $html.='</table>';

    $headers = array('Content-Type: text/html;');
    $formid=$_POST["formid"];
    if($formid==1){
        // return form
        $subject='A return request received - Cloneona';
    }
    if($formid==2){
        // return form
        $subject='A file has been claimed - Cloneona';
    }
	
	if($formid==1){
        // return form
        $thanks_url='https://cloneona.com/return-submission-confirmation/';
    }
    if($formid==2){
        // return form
        $thanks_url='https://cloneona.com/warranty-submission-confirmation/';
    }
	

    $to=get_bloginfo('admin_email');
    
    //$to='shahk06@gmail.com';

    wp_mail($to,$subject,$html,$headers);

    echo json_encode(['status'=>'ok','url'=> $thanks_url ]);

    
    $f_id=$_POST["formid"];
    $f_name=$_POST["Name"];
    $f_role=$_POST["Role"];
    $f_class=$_POST["Class"];
    $f_sub=$_POST["Subject"];
    $f_age=$_POST["Age"];
    $f_pho=$_POST["Phone"];
    $f_com=$_POST["Comment"];
    $f_email=$_POST["Email"];

    // $db=new mysqli('localhost','root','','test');
    // $result = mysqli_query($db,"INSERT INTO student (name, role, class, sub, age, pho, com, email, formid) VALUES('$f_name','$f_role','$f_class','$f_sub','$f_age','$f_pho','$f_com','$f_email','$f_id')");

    global $wpdb;
    $sql="INSERT INTO student (name, role, class, sub, age, pho, com, email, formid) VALUES('$f_name','$f_role','$f_class','$f_sub','$f_age','$f_pho','$f_com','$f_email','$f_id')";
    $wpdb->query($sql);

    exit();
}

add_action("wp_ajax_w1d_msf_process", "w1d_msf_process");
add_action("wp_ajax_nopriv_w1d_msf_process", "w1d_msf_process");

//do_action('wp_ajax_'.$_POST["action"]);

// remove updated widgets style
function example_theme_support() {
    remove_theme_support( 'widgets-block-editor' );
}

// ######## >>>> Custom Post Register <<<< ########

add_action( 'init', 'student_reg_data' );

function student_reg_data() {

    register_post_type( 'protfolio',

    array(

        'labels'    => array(
            'name' => __('Student'),
            'all_items' => __('All'),
            'edit_item' => __('use this code [protfolio_slid count="5"] for Divi [project_slid]'),
            'singular_name' => __('Work')
            ),

        'supports'  => array('title', 'editor', 'author', 'thumbnail', 'comments', 'excerpt', 'page-attributes'),

        'public'    => true,
        'menu_icon' => 'dashicons-pressthis', // Right side bar menu icon. https://developer.wordpress.org/resource/dashicons/#heart 

        )
    );
}

