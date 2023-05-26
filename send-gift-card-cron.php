<?php
require_once ('wp-config.php');

function xxsend_sms($number,$message){
	$message=strip_tags($message);
    $message=str_replace(array("\r", "\n"), '', $message);
    $sender='Kringlan';
    $userId='24';
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://sms.leikbreytir.is/sms/api.php',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => array('token' => '1q2w3e4r5t6y7uq1w2e3r4t5y6u7','number' => $number,
      'message' => $message,'sender'=>$sender,'userId'=>$userId),
	));

	curl_exec($curl);

	curl_close($curl);

}



global $wpdb;
$table_name = $wpdb->prefix . 'gift_card_email_queue';
$sql= "SELECT id,order_id,order_line_item_id FROM $table_name WHERE status=0 and prefered_date_time<now() order by id asc limit 5";
$result = $wpdb->get_results($sql);
//print_r($result);
$entryType = 'plastkort';        
if($result){
    $i=0;
	foreach($result as $row){
		
        $order = wc_get_order( $row->order_id );
        $name=$order->get_billing_first_name();
        $email=$order->get_billing_email();

        $output=true;
        $orderLineItemId=$row->order_line_item_id;
        $recepient_email=wc_get_order_item_meta( $orderLineItemId, 'recipient_email', true)[0];
        $recepient_name=wc_get_order_item_meta( $orderLineItemId, 'recipient_name', true)[0];
        $pass_link=wc_get_order_item_meta( $orderLineItemId, 'pass_link', true);
        if($pass_link!=null){
            $card_sender=wc_get_order_item_meta( $orderLineItemId, 'Nafn sendanda', true);
            $Message=wc_get_order_item_meta( $orderLineItemId, 'Message', true);

            $phone=wc_get_order_item_meta( $orderLineItemId, 'Símanúmer', true);

            $_email=(is_email($recepient_email)?$recepient_email:$email);
            $_name=($recepient_name!=NULL?$recepient_name:$name);
            
            $send_mail_to_recipient=wc_get_order_item_meta( $orderLineItemId, 'send_mail_to_recipient', true)[0];

            if(in_array($send_mail_to_recipient,[1,3])){

                include('wp-content/plugins/gift-card-item/gift-card-pdf.php');

                send_mail_to_user($_name,$_email,$pass_link,0,$pdf_file_name);

                @unlink($pdf_file_name);
            }

            if(in_array($send_mail_to_recipient,[2,3])){
                $message=$_name.', þú varst að fá sent gjafakort frá Kringlan. Sendandi er '.$card_sender.' með kveðjunni: '.$Message.' Smelltu á hlekkinn til að bæta gjafakortinu í Wallet hjá þér: '.$pass_link.'';

                if(strlen($phone)==7){
                    xxsend_sms($phone,$message);
                }
            }

            $wpdb->query("update $table_name set status=1, send_at=now() where id=$row->id");
        }else{
            $wpdb->query("delete from $table_name where id=$row->id");
        }

    }
}

echo'ok';