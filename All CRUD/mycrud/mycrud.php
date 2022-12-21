<?php 

/*

Plugin Name: My CRUD

Plugin URI: http://vir-za.com/

Description: This is CRUD plugin for every WordPress theme.

Version: 3.0

Author: WebOneDevs

Author URI: https://www.linkedin.com/in/1mdalamin1/

License: GPLv2 or later

Text Domain: database-demo

*/

// Exit if accessed directly

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
include 'class.dbdemousers.php';

// ######## >>>> Start MY CRUD <<<< ######## \\

// === >>>> Creat Database for MY CRUD <<<< === \\



define("DBDEMO_DB_VERSION", "3.0");
function dbdemo_init(){
    global $wpdb;
    $table_name = $wpdb->prefix.'student';
    $sql = "CREATE TABLE {$table_name} (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(250),
        email VARCHAR(250),
        PRIMARY KEY (id)
    );";
    require_once (ABSPATH."wp-admin/includes/upgrade.php");
    dbDelta($sql);

    add_option("dbdemo_db_version",DBDEMO_DB_VERSION);

    // name, email, age, role, pho, class, sub, com, formid
    if(get_option("dbdemo_db_version")!=DBDEMO_DB_VERSION){
        $sql = "CREATE TABLE {$table_name} (
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(250),
            email VARCHAR(250),
            age INT,
            role INT,
            pho INT,
            class VARCHAR(150),
            sub VARCHAR(150),
            com VARCHAR(250),
            formid INT,
            PRIMARY KEY (id)
            );";
            dbDelta($sql);
            update_option("dbdemo_db_version",DBDEMO_DB_VERSION);
    }

}
register_activation_hook(__FILE__, "dbdemo_init");


// this is for column remove

// function dbdemo_drop_column(){
//     global $wpdb;
//     $table_name = $wpdb->prefix.'persons';
//     if(get_option("dbdemo_db_version") !=DBDEMO_DB_VERSION){
//         $query = "ALTER TABLE {$table_name} DROP COLUMN age";
//         $wpdb->query($query);
//     }
//     update_option("dbdemo_db_version", DBDEMO_DB_VERSION);

// }
// add_action("plugins_loaded","dbdemo_drop_column");


// === >>>> Show Data form mysql Database & dashboard crud for MY CRUD <<<< === \\

add_action("admin_menu", "datatable_admin_page");
function datatable_admin_page() {
    add_menu_page(
        __('Student Data', 'tabledata'),
        __('Student Data', 'tabledata'),
        'manage_options',
        'dbdemo',
        'dbdemo_admin_page'
    );
}
function dbdemo_admin_page() { // this funtion show data in admin page

    global $wpdb;
    // nonce checking
    if(isset($_GET['pid'])) {
        if(!isset($_GET['n']) || !wp_verify_nonce($_GET['n'], "dbdemo_edit")){
            wp_die(__("Sorry you are not authorized to do this", "database-demo"));
        }

        if(isset($_GET['action']) && $_GET['action']=='delete'){
            $wpdb->delete("student", ['id'=> sanitize_key($_GET['pid'])]);
            $_GET['pid'] = null;
        }

    }

    global $wpdb;
    echo "<h2>Student</h2>";
    $id = $_GET['pid'] ?? 0;
    $id = sanitize_key($id); // sanitize for protect check

    if ($id) {
        $result = $wpdb->get_row("select * from student WHERE id='{$id}'");
        if($result) {
            echo "Name: {$result->name}<br/>";
            echo "Email: {$result->email}<br/>";
        }
    }
    ?>
    <div class="notice notice-success is-dismissible">
        <p>Some Error Information</p>
    </div>
<div class="form_box">
    <div class="form_box_header">
        <?php _e('Data Form', 'database-demo') ?>
    </div>
    <div class="form_box_content">
        <form action="<?php echo admin_url('admin-post.php'); ?>" method="POST">
            <?php 
            wp_nonce_field('dbdemo', 'nonce');
            ?>
            <input type="hidden" name="action" value="dbdemo_add_record">
            Name: <input type="text" value="<?php if($id) echo $result->name; ?>" name="name"><br/>
            Email: <input type="email" value="<?php if($id) echo $result->email; ?>" name="email"> <br/>
            <?php 
            if ($id) {
                # code...
                echo '<input type="hidden" name="id" value="'.$id.'">';
                submit_button("Update Record");
            }else {
                submit_button("Add Record");
            }
            ?>
        </form>
    </div>
</div>
<div class="form_box">
    <div class="form_box_header">
        <?php _e('Users', 'database-demo') ?>
    </div>
    <div class="form_box_content">
        <?php 
        //  {$wpdb->prefix}student
        
            global $wpdb;
            // $dbdemo_users = $wpdb->get_results("SELECT id, name, email FROM student ORDER BY id DESC", ARRAY_A);
            $dbdemo_users = $wpdb->get_results("SELECT id, name, email, age, role, pho, class, sub, com, formid FROM {$wpdb->prefix}student ORDER BY id DESC", ARRAY_A);

            // print_r($dbdemo_users);
            $dbtu = new DBTableUsers($dbdemo_users);
            $dbtu->prepare_items();
            $dbtu->display();
        ?>
    </div>
</div>

    
<?php

}


add_action('admin_post_dbdemo_add_record', function(){

global $wpdb;
$nonce = sanitize_text_field($_POST['nonce']);
if(wp_verify_nonce($nonce, 'dbdemo')) {
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_text_field($_POST['email']);
    $id = sanitize_text_field($_POST['id']);
    
    if ($id) {
        // This Update of CRUD.
        $wpdb->update("student", ['name' => $name, 'email' => $email], ['id'=>$id]);
        $nonce = wp_create_nonce("dbdemo_edit");

        wp_redirect(admin_url('admin.php?page=dbdemo&pid='.$id."&n={$nonce}"));
    } else {

        // This Creat of CRUD.
        $wpdb->insert("student", ['name' => $name, 'email' => $email]);
        wp_redirect(admin_url('admin.php?page=dbdemo'));

    }
}

});







// === >>>> Show frontend MSF with email send for MY CRUD <<<< === \\





// add javaScript hook for footer || MSF validation & ajex call
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


// ajax process for Multi Step Form
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

    // $wpdb->prefix.'student'

    global $wpdb;
    // $bdname = $wpdb->prefix.'student';
    $sql="INSERT INTO {$wpdb->prefix}student (name, role, class, sub, age, pho, com, email, formid) VALUES('$f_name','$f_role','$f_class','$f_sub','$f_age','$f_pho','$f_com','$f_email','$f_id')";
    // $sql="INSERT INTO student (name, role, class, sub, age, pho, com, email, formid) VALUES('$f_name','$f_role','$f_class','$f_sub','$f_age','$f_pho','$f_com','$f_email','$f_id')";
    $wpdb->query($sql);

    exit();
}

add_action("wp_ajax_w1d_msf_process", "w1d_msf_process");
add_action("wp_ajax_nopriv_w1d_msf_process", "w1d_msf_process");

//do_action('wp_ajax_'.$_POST["action"]);









?>