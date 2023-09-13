<?php


$cferror=[];
// add gjafakort-from Short code
add_shortcode('gjafakort-from','gjafakort_from_fun');
function gjafakort_from_fun($jekono){ 
	$result = shortcode_atts(array( 
	'title' =>'',
	),$jekono);
	extract($result);
	ob_start();

	global $cferror;

	$name='';
	if(isset($_POST["card_name"])) $name=$_POST["card_name"];
	$phone='';
	if(isset($_POST["card_phone"])) $phone=$_POST["card_phone"];
	$email='';
	if(isset($_POST["card_email"])) $email=$_POST["card_email"];
	$card='';
	if(isset($_POST["cardnumber"])) $card=$_POST["cardnumber"];
	$checkbox=false;
	if(isset($_POST["subscrib_to_mail_list"])) $checkbox=true;


?>
<!-- Start html code here  -->
<div class="pform_area">
	<div class="form_group">
		<?php
			if(count($cferror)>0){
		?>
		<ul>
			<?php
            foreach($cferror as $k=>$val){
                switch ($k) {
                    case "name":
                        echo "<li>Nafn is required!</li>";
                        break;
                    case "phone":
                        echo "<li>Símanúmer is required!</li>";
                        break;
                    case "email":
                        echo "<li>Netfang is required!</li>";
                        break;
                    case "email_invalid":
                        echo "<li>Netfang invalid!</li>";
                        break;
                    case "card":
                        echo "<li>Númer gjafakorts is required!</li>";
                        break;
                    default:
                        
                    }
            }
			?>
		</ul>
		<?php
			}

			if(isset($_GET["res"])){
				if($_GET["res"]==true){
					$url=trim($_GET['url']);
					//print_r($url);
					if(!empty($url))$url=base64_decode($url);
					echo'<h3>Gjafakort uppfært</h3>';
					if($url){
						echo '<p class="add_to_wlt"><a href="'.$url.'" target="_blank">Bæta korti við í farsíma</a></p>';
					}else{
						echo'<p>Pass url missing in GTW system.</p>';
					}
				}else{
					echo'<h3>Ops! something went wrong, Gjafakort has not been updated!</h3>';
				}
			}
		?>
		<style>
			p.add_to_wlt a{
				background-color: #000000 !important;
				font-family: 'DINNextLTPro-Condensed' !important;
				font-size: 18px;
				padding:15px;
				color:#fff;
				outline:none;
			}
            .pform_area p.add_to_wlt, .pform_area h3 {
                text-align: center;
            }

            .pform_area h3 {
                margin-top: 20px;
            }

			@media only screen and (min-width:992px){ 

				.btn-text-wrap {
					display: flex;
					flex-wrap: wrap;
				}
				.btn-right-text {
					width: calc(100% - 150px);
					padding-left: 10px;
					padding-top: 16px;
				}

			}
            
		</style>
		<form id="gift-card-form" action="" method="POST">
			<input type="text" name="card_name" id="card_name" value="<?php echo $name;?>" placeholder="Nafn *" required=""><br>
			<input type="text" name="card_phone" id="card_phone" value="<?php echo $phone;?>" placeholder="Símanúmer *" required="" maxlength="7" minlength="7"><br>
			<input type="email" name="card_email" id="card_email" value="<?php echo $email;?>" placeholder="Netfang *" required=""><br>
			<input type="text" name="cardnumber" id="cardnumber" value="<?php echo $card;?>" placeholder="Númer gjafakorts xxxxxxxx *" required=""><br>
			<!-- <label>
				<input type="checkbox" name="subscrib_to_mail_list" <?php // echo ($checkbox?'checked':'');?>> Ég hef áhuga á að skrá mig á póstlista Kringlunnar.
			</label> -->
			

			<div class="btn-text-wrap">
				<div class="btn-form">
					<input type="submit" name="card_submit" id="card_submit" value="Staðfesta" style="padding-left:28px;">
				</div>
				<div class="btn-right-text">
					<p>Athugaðu að þótt gjafakortið hafi verið sett í veskið í símann þá er QR-og strikamerki enn virkt á útprentaða gjafakortinu. Passa skal því upp á að farga því eða geyma á vísum stað.</p>
				</div>
			</div>


		</form>
		
	</div>
</div>
<!-- End html code here  -->
<?php
return ob_get_clean();
}


// submit card update form
add_action('init',function(){
	if(isset($_POST["card_submit"])){
		global $cferror;
		$card_holder_name=sanitize_text_field($_POST["card_name"]);
		if(!$card_holder_name){
			$cferror['name']=true;
		}
		$card_holder_phone=sanitize_text_field($_POST["card_phone"]);
		if(!$card_holder_phone){
			$cferror['phone']=true;
		}

		if(strlen($card_holder_phone)!=7){
			$cferror['phone']=true;
		}

		$card_holder_email=sanitize_text_field($_POST["card_email"]);
		if(!$card_holder_email){
			$cferror['email']=true;
		}else{
			if(!is_email($card_holder_email)){
				$cferror['email_invalid']=true;
			}
		}
		$cardnumber=sanitize_text_field($_POST["cardnumber"]);
		if(!$cardnumber){
			$cferror['card']=true;
		}

		if(count($cferror)>0){

		}else{
			// valid
			$subscribe=false;
			if(isset($_POST["subscrib_to_mail_list"]))$subscribe=true;
			// call gift card transaction list checkup
			$res=gift_card_transactionlist_lookup($card_holder_name,$card_holder_phone,$card_holder_email,$cardnumber,$subscribe);
			// print_r($res);
			// exit();

			wp_safe_redirect(site_url().'/nyskraning/?res='.$res['status'].'&url='.base64_encode($res['url']));
			exit();

		}
	}
});

function gift_card_transactionlist_lookup($name,$phone,$email,$card,$subscribe){
	$token=get_option('gift_to_wallet_token');
	$url='https://admin.gifttowallet.com/api/transactionlist?card_number='.$card;
	if($token){
		$args = array(
			'headers' => array(
				'Authorization' => 'Bearer '.$token
			)
		);
		$response = wp_remote_get( $url,$args );
		
		$body     = wp_remote_retrieve_body( $response );
		/* Kristofer debugging  */
		//$logMessage = $body;
    	//file_put_contents("./debug_log.txt", $logMessage, FILE_APPEND);
		/* ----------------------*/
		if($body){
			$body = json_decode($body,true);
			if(isset($body["success"])){
				// update card details
				$res=gtw_update_card_information($name,$phone,$email,$card,$subscribe);
				//print_r($res);

				if($res['status']==1){
					return ['status'=>1,'url'=>$res['url']];
				}
			}
		}
	}

	return ['status'=>0,'url'=>' - '];
}


// gtw update card information
function gtw_update_card_information($name,$phone,$email,$card,$subscribe){
	$token=get_option('gift_to_wallet_token');
	$url='https://admin.gifttowallet.com/api/card/update-detail';
	if($token){
		$args = array(
			'headers' => array(
				'Authorization' => 'Bearer '.$token
			),
			'body' => array(
				'card_number'=>$card,
				'phone'=>$phone,
				'email'=>$email,
				'name'=>$name
			)
		);
		$response = wp_remote_post( $url,$args );
		
		$body     = wp_remote_retrieve_body( $response );
		/* Kristofer debugging  */
		//$logMessage = $body;
    	//file_put_contents("./debug_log.txt", $logMessage, FILE_APPEND);
		/* ----------------------*/
		if($body){
			$body = json_decode($body,true);
			//print_r($body);
			if(isset($body["success"])){
				// update pass details card details
				if($subscribe) mailchimp_subscription($name,$email);
				return ['status'=>1,'url'=>$body['result']['pass_link']];
			}
		}
	}
	return ['status'=>0,'url'=>' - '];
}




add_action('wp_footer', 'gift_card_reg_script');
function gift_card_reg_script(){
?>
<script>
/*
 jQuery('#gift-card-form').submit(function(e){
	
	jQuery('#gift-card-form').find('.btn-form').html(`<input type="submit" name="card_submit" id="card_submit" value="Staðfesta" style="padding:10px;"> <span class="btn_loding">&#10044;</spa>`);
  	// e.preventDefault(); // Stop the form submitting

  	//e.currentTarget.submit();
	// console.log('sdfkslfdjs');
	

});
*/
</script>
<?php 
}




