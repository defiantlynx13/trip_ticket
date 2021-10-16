<?php

defined("ABSPATH") || exit;

add_shortcode('TT_reset' , 'TT_reset_function');

function TT_reset_function(){

if( is_user_logged_in() ){
    wp_redirect( home_url(). '/tt_panel' );
}

if( isset($_POST['tt_reset']) ){
	$melli = sanitize_text_field( $_POST['tt_melli'] );
	$email = sanitize_text_field( $_POST['tt_email'] );

	global $wpdb;
	$get_users = $wpdb->get_results( "select * from {$wpdb->prefix}users where user_login='$melli' and user_email='$email' " );
	if( $wpdb->num_rows > 0 ){

		$user_id = get_user_by( 'email' , $email )->ID;
		$new =  wp_rand(1,9999999);
		$change = wp_set_password( $new , $user_id );

		require_once( ROOT . '/shortcodes/sms-class.php' );
				
		try {
		
		date_default_timezone_set("Asia/Tehran");
	
		
		// your sms.ir panel configuration
		$APIKey = "e7faa04884fa68114a048";
		$SecretKey = "gfgd2g5dg1f5g2w5rrw2er6we2re";
	
		
		// message data
	
		$data = array(
			"ParameterArray" => array(
				array(
	
					"Parameter" => "newpass",
					"ParameterValue" => $new
				)
			),
			"Mobile" => get_user_by( 'email' , $email )->phone,
			"TemplateId" => "5275"
		);

			$SmsIR_UltraFastSend = new SmsIR_UltraFastSend($APIKey,$SecretKey);
			$UltraFastSend = $SmsIR_UltraFastSend->UltraFastSend($data);
		// 	var_dump($UltraFastSend);
			
		} catch (Exeption $e) {
			echo 'Error UltraFastSend : '.$e->getMessage();
		}

		echo '<div class="exist_reset">رمز عبور جدید به تلفن همراه شما پیامک گردید. <a href="'.home_url().'/tt_login">ورود به سایت</a></div>';
		
	}else{
		echo '<div class="dont_exist_reset">کاربری با این مشخصات وجود ندارد. <a href="'.home_url().'/tt_register">ثبت نام در سایت</a></div>';
	}

}

?> 
   <h5>بازیابی رمز عبور</h5>
   <hr>
   <br>
   <form action="" method="post">

    <p>
        <label for="melli"><span style="color:red">*</span> شماره ملی:</label><br>
        <input type="text" name="tt_melli" id="email" placeholder="" required></p>
    <p>

    <p>
        <label for="email"><span style="color:red">*</span> ایمیل:</label><br>
        <input type="email" name="tt_email" id="email" placeholder="" required></p>
    <p>
  
    <p>
    <input type="submit" name="tt_reset" value="ارسال" id="wp-submit"></p>
    <p>
        
    </form>
   
<?php



}
?>