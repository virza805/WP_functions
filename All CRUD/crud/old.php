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
        jQuery("#message_area").html("");
        if(active_step!=3){
            // validation
            let progress = true;
            jQuery(".msf-step-input.active .data-input-element").each(function(){
                let required = jQuery(this).attr("required");
                let value = jQuery(this).val().trim(); 
                if(required && !value){
                    progress = false;
                    let label = jQuery(this).parent().find("label").text().replace('*','').replace(':','');
                    jQuery("#message_area").append(`<p>${label} is required.</p>`);
                }
            })

            if(!progress){
                return false;
            }
            

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

    // validation email
    function isEmail(email) {
        let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
        
    }
    function msf_submit(){
        jQuery("#message_area").html("");
        if(active_step==3){
            // validation
            let progress = true;

            jQuery(".data-input-element").each(function(){
                let required = jQuery(this).attr("required");
                let emailtyp = jQuery(this).attr("type");
                let value = jQuery(this).val().trim(); 

                if(required && !value){ 
                    progress = false;
                    let label = jQuery(this).parent().find("label").text().replace('*','').replace(':','');
                    jQuery("#message_area").append(`<p>${label} is required.</p>`);
                    
                } 

                if (emailtyp == "email" && value) {
                        if(!isEmail(value)) {
                            progress = false;
                            let label = jQuery(this).parent().find("label").text().replace('*','').replace(':','');
                            jQuery("#message_area").append(`<p>${label} is must be valid.</p>`);
                        }
                    }

            })

            if(!progress){
                return false;
            }
            


            // call ajax

            // jQuery(".data-input-element").serialize(function(){
            //     let value_form = jQuery(this).val().trim(); 
                
            // });

            // call ajax

            let data = jQuery("div#"+uid+" .data-input-element").serialize();
            jQuery("div#"+uid+" .message_area").html(`<p class="info">Please wait! we are processing...</p>`);
            jQuery.post('<?=admin_url( 'admin-ajax.php' )?>',data,function(result){
                let obj = JSON.parse(result);
                if(obj.status=='ok'){
                    window.location.href=obj.url;
                }else{
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



// add Multi Step return form Short Code
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
                            <input type="text" name="serial" id="serial" required="required" class="data-input-element">
                            <label for="serial">Serial # *</label>
                        </div>
                        <div class="msf-step-input-field flex-column input-c">
                            <input type="text" name="order" id="order" required="required" class="data-input-element">
                            <label for="order">Order # *</label>
                        </div>
                    </div>
                    
                    <div class="msf-step-input" id="step2">
                        <div class="msf-step-input-field">
                            <label for="reason">Reason for return *:</label>
                            <select name="reason" id="reason" required="required" class="data-input-element">
                                <option value=""> </option>
                                <option value="Didn’t meet expectations">Didn’t meet expectations</option>
                                <option value="Didn’t fit my needs">Didn’t fit my needs</option>
                                <option value="Arrived damaged">Arrived damaged</option>
                                <option value="Item is defective">Item is defective</option>
                                <option value="Simply changed my mind">Simply changed my mind</option>
                            </select>
                        </div>
                    </div>

                    <div class="msf-step-input" id="step3">
                        <div class="msf-step-input-field">
                            <label for="name">Your Name *:</label>
                            <input type="text" name="name" id="name" required="required" class="data-input-element">
                        </div>
                        <div class="msf-step-input-field">
                            <label for="email">Your Email *:</label>
                            <input type="email" name="email" id="email" required="required" class="data-input-element">
                        </div>
                    </div>

                </div>
                <div id="message_area">

                </div>
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


// add Multi Step File A Claim form Short Code
add_shortcode('ms_claim_form','multi_step_claim_fun');
function multi_step_claim_fun(){
	ob_start(); ?>

<div class="msf-wrap">

                <div class="msf-single-step">
                    <div class="msf-step-title">
                        <h2>File A Claim</h2>
                        <p>We need just a few details to begin</p>
                    </div>

                    <div class="msf-step-input active" id="step1">
                        <input type="hidden" id="custId" name="custId" value="2">
                        <div class="msf-step-input-field flex-column">
                            <input type="text" name="serial" id="serial" required="required" class="data-input-element">
                            <label for="serial">Serial # *</label>
                        </div>
                        <div class="msf-step-input-field flex-column input-c">
                            <input type="text" name="order" id="order" required="required" class="data-input-element">
                            <label for="order">Order # *</label>
                        </div>
                    </div>
                    
                    <div class="msf-step-input" id="step2">
                      <div>
                        <div class="msf-step-input-checkbox">
                            <h4>Reason for Claim:</h4>
                            <p>(select all that apply)</p>

                            <div class="pare pare-1">
                                <div class="c-option">
                                  <input type="checkbox" name="checkbox[]" value="Item displays an error message" id="c-1" class="data-input-element">
                                  <label for="c-1">Item displays an error message</label>
                                </div>
                                <div class="c-option">
                                  <input type="checkbox" name="checkbox[]" value="Item has a broken component from normal use" id="c-2" class="data-input-element">
                                  <label for="c-2">Item has a broken component from normal use</label>
                                </div>
                              </div>
                              <div class="pare pare-2">
                                  <div class="c-option">
                                    <input type="checkbox" name="checkbox[]" value="Item is deviating from set factory specifications" id="c-3" class="data-input-element">
                                    <label for="c-3">Item is deviating from set factory specifications</label>
                                  </div>
                                  <div class="c-option">
                                    <input type="checkbox" name="checkbox[]" value="Item has an open recallI I’ve been notified of" id="c-4" class="data-input-element">
                                    <label for="c-4">Item has an open recallI I’ve been notified of</label>
                                  </div>
                              </div>
                              <div class="pare pare-3">
                                  <div class="c-option">
                                    <input type="checkbox" name="checkbox[]" value="Item appears to be inaccurate or uncalibrated" id="c-5" class="data-input-element">
                                    <label for="c-5">Item appears to be inaccurate or uncalibrated</label>
                                  </div>
                                  <div class="c-option">
                                    <input type="checkbox" name="checkbox[]" value="Item is unusable due to a specific defective part" id="c-6" class="data-input-element">
                                    <label for="c-6">Item is unusable due to a specific defective part</label>
                                  </div>
                              </div>
                              <div class="pare pare-4">
                                  <div class="c-option">
                                    <input type="checkbox" name="checkbox[]" value="Item has been damaged from an accident" id="c-7" class="data-input-element">
                                    <label for="c-7">Item has been damaged from an accident</label>
                                  </div>
                                  <div class="c-option">
                                    <input type="checkbox" name="checkbox[]" value="Item does not power on, or complete startup" id="c-8" class="data-input-element">
                                    <label for="c-8">Item does not power on, or complete startup</label>
                                  </div>
                              </div>
                              
                        </div>

                        <div class="msf-step-input-field checkbox-describe">
                            <label for="describe">Describe what’s going wrong below *:</label>
                            <input type="text" name="describe" id="describe" required="required" class="data-input-element">
                        </div>
                       </div>
                    </div>

                    <div class="msf-step-input" id="step3">
                        <div class="msf-step-input-field">
                            <label for="name">Your Name *:</label>
                            <input type="text" name="name" id="name" required="required" class="data-input-element">
                        </div>
                        <div class="msf-step-input-field">
                            <label for="email">Your Email *:</label>
                            <input type="email" name="email" id="email" required="required" class="data-input-element">
                        </div>
                    </div>

                </div>
                <div id="message_area">

                </div>
                <div class="msf-single-step msf-buttons">
                    <button type="button" class="step pre target-btn" onclick="show_pre()">Previous</button>
                    <button type="button" class="step next current target-btn" onclick="show_next()">Next</button>
                    <button type="button" class="target-btn" id="submit_form" onclick="msf_submit()">Submit</button>
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

            if(is_array($val)){
                $html.='<tr>
                    <th>'.$k.'</th>
                    <td>:</td>
                    <td>';
                    foreach($val as $i=>$line){
                        $html.=($i+1).'. '.$line.'<br/>';
                    }
                    $html.='</td>
                </tr>';
            }else{
                $html.='<tr>
                    <th>'.$k.'</th>
                    <td>:</td>
                    <td>'.$val.'</td>
                </tr>';
            }
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

    exit();
}

add_action("wp_ajax_w1d_msf_process", "w1d_msf_process");
add_action("wp_ajax_nopriv_w1d_msf_process", "w1d_msf_process");


// remove updated widgets style
function example_theme_support() {
    remove_theme_support( 'widgets-block-editor' );
}