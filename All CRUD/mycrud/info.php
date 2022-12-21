<?php

/**
 * 2:49s | ২৪.৭ - WPDB দিয়ে এক্সিস্টিং ডেটাবেজ রেকর্ড এডিট করা => https://learnwith.hasinhayder.com/wp/course/wordpress-plugin-development/
 * 
 * 2:49s | ২৪.৮ - আমাদের ডেটা ফর্মটার লুক চেঞ্জ করা =>  
 * 
 *  / 15:35s | ২৪.৯ - ডেটাবেজ থেকে ডেটা নিয়ে সেটা WP List Table এ দেখানো =>  
 *  / 7:18s | ২৪.১০ - wp_nonce_url ফাংশনের সাহায্যে ইউআরএল কে সিকিউর করা এবং নন্স ভেরিফাই করা =>  
 *  / 10:19s | ২৪.১১ - WP_List_Table এর রো অ্যাকশন লিঙ্ক তৈরী করা =>  
 * / 5:01s | ২৪.১২ - WP_List_Table এ পেজিনেশন তৈরী করা =>  
 * 
 * // 24.1 > 24.2 > 24.3
 *  / 6:05s | ২৪.১ - প্লাগইনে ডেটাবেজ নিয়ে কাজ করা - নতুন টেবিল তৈরি করা =>  
 * :05s / 5:48s | ২৪.৩ - প্লাগইন অ্যাকটিভেশনের সময় টেবিলে ডেটা ইনসার্ট করা এবং ডিঅ্যাকটিভেশনের সময় টেবিল ফ্লাশ করা =>  
 * 
 * 
 * 
 * 
 * 
 * 
*/

exit();
require_once('wp-config.php');

$html='<html xmlns:v="urn:schemas-microsoft-com:vml">
<body>
<table width="600">
  <tr>
    <td bgcolor="#363636" style="background-image: url(\'https://svens.is/wp-content/uploads/2022/11/e1-1.png\');"
      background="https://svens.is/wp-content/uploads/2022/11/e1-1.png" width="600" height="178">
      <!--[if gte mso 9]>
      <v:rect style="width:600px;height:178px;" strokecolor="none">
        <v:fill type="tile" color="#363636" src="https://svens.is/wp-content/uploads/2022/11/e1-1.png" /></v:fill>
      </v:rect>
      <v:shape id="NameHere" style="position:absolute;width:600px;height:178px;">
      <![endif]-->
        <h2>This text should appear on top <br/>of your background image.</h2>
      <!--[if gte mso 9]>
      </v:shape>
      <![endif]--></td>
  </tr>
</table> ';
$headers = array( 'Content-Type: text/html; charset=UTF-8' );
wp_mail('greensabuj@leikbreytir.com','Test mail',$html,$headers);
echo'<hr/>';
wp_mail('greensabuj350@gmail.com','Test mail',$html,$headers);