<?php

defined("ABSPATH") || exit;

add_shortcode('TT_register' , 'TT_register_function');

function TT_register_function(){

global $wpdb;
$user = wp_get_current_user();


if( isset($_GET['empty']) && wp_verify_nonce($_GET['nonce'] , 'empty') ){
    echo '<span style="color:red">all filed should fill!</span>';
    echo '<br>';
}
else if( isset($_GET['melli']) && wp_verify_nonce($_GET['nonce'] , 'melli') ){
    echo '<p style="box-shadow:0 0 5px #ddd;border-right:3px solid rgba(229,57,53 ,1);padding:8px 15px">شماره ملی شما قبلا ثبت شده است. اگر قبلا حساب کاربری ساخته اید، لطفا وارد شوید. &nbsp;<a href="'.home_url().'/tt_login" style="color:#4086AA">ورود به پنل</a></p>';
    echo '<br>';
}
if( isset($_GET['email']) && wp_verify_nonce($_GET['nonce'] , 'email') ){
    echo '<p style="box-shadow:0 0 5px #ddd;border-right:3px solid rgba(229,57,53 ,1);padding:8px 15px">ایمیل وارد شده قبلا وجود دارد. اگر قبلا حساب کاربری ساخته اید، لطفا وارد شوید. &nbsp;<a href="'.home_url().'/tt_login" style="color:#4086AA">ورود به پنل</a></p>';
    echo '<br>';
}


?>
<h5>ثبت نام در سایت</h5>
   <hr>
   <br>
<form id="wp_signup_form" action="" method="post">
      
    <p>
        <label for="melli"><span style="color:red">*</span> شماره ملی:</label><br>
        <input type="text" name="tt_melli" id="melli" placeholder="" required></p>
    <p>
        <label for="phone"><span style="color:red">*</span> تلفن همراه:</label><br>
        <input type="text" name="tt_phone" id="phone" placeholder="" required></p>
    <p>
        <label for="name"><span style="color:red">*</span> نام:</label><br>
        <input type="text" name="tt_name" id="name" placeholder="" required></p>
    <p>
        <label for="family"><span style="color:red">*</span> نام خانوادگی:</label><br>
        <input type="text" name="tt_family" id="family" placeholder="" required></p>
    <p> <label for="birthday" style="margin-bottom:12px;display:inline-block"><span style="color:red">*</span> تاریخ تولد:</label><br>
        <select name="tt_day" required style="width:70px;">
                <option value="" hidden>روز</option>
                <?php
                
                for( $i=1 ; $i<32 ; $i++ ){
                    echo '<option value="'.$i.'">'.$i.'</option>';
                }
                
                ?>
            </select>
            &nbsp;&nbsp;&nbsp;
                <select id="date" required name="tt_month" required >
                    <option value="" hidden>ماه</option>
                    <option value="01">فروردین</option>
                    <option value="02">اردیبهشت</option>
                    <option value="03">خرداد</option>
                    <option value="04">تیر</option>
                    <option value="05">مرداد</option>
                    <option value="06">شهریور</option>
                    <option value="07">مهر</option>
                    <option value="08">آبان</option>
                    <option value="09">آذر</option>
                    <option value="10">دی</option>
                    <option value="11">بهمن</option>
                    <option value="12">اسفند</option>
                </select>

            &nbsp;&nbsp;&nbsp;
            <select name="tt_year" required  style="width:70px;">
                <option value="" hidden>سال</option>
                <?php
                
                $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
                $num = range(0, 9);
                $x = str_replace($persian, $num, jdate("Y") );
                
                while($x>1300){
                    echo '<option value="'.$x.'">'.$x.'</option>';
                    $x--;
                }
                ?>
            </select>
    </p>
    <p>
        <label for="email">ایمیل:</label><br>
        <input type="email" name="tt_email" id="email" placeholder=""></p>
    
    <p><label for="sex"><span style="color:red">*</span> جنسیت:</label><br>
    <input type="radio" name="tt_sex" id="sex" required value="مرد"/> مرد
    &nbsp;&nbsp;&nbsp;
    <input type="radio" name="tt_sex" id="sex" value="زن"/> زن</p>

    <input type="submit" id="wp-submit" name="register" value="ثبت نام" /> 
    
</form>
<?php

if( isset($_POST['register']) ){
    
            $melli = sanitize_text_field( $_POST['tt_melli'] );
            $name = sanitize_text_field( $_POST['tt_name'] );
            $family = sanitize_text_field( $_POST['tt_family'] );
            $phone = sanitize_text_field( $_POST['tt_phone'] );
            $email = sanitize_text_field( $_POST['tt_email'] );
            $birthday = sanitize_text_field( $_POST['tt_year'] ).sanitize_text_field( $_POST['tt_month'] ).sanitize_text_field( $_POST['tt_day'] );
            $sex = sanitize_text_field( $_POST['tt_sex'] );
            
			$password = wp_rand(0,9999999);
            
            if( empty( $melli ) || empty( $email ) || empty( $name ) || empty( $family ) || empty( $phone ) || empty( $sex ) ){
                wp_redirect(home_url() . '/tt_register?empty=1&nonce='.wp_create_nonce('empty') );
                $has_error = true;
            }
            
            if( username_exists( $melli ) ){
                wp_redirect( home_url(). '/tt_register?melli=1&nonce='.wp_create_nonce('melli') );
                $has_error = true;
            }
            if( email_exists( $email ) || !filter_var( $email , FILTER_VALIDATE_EMAIL ) ){
                wp_redirect(home_url(). '/tt_register?email=1&nonce='.wp_create_nonce('email'));
                $has_error = true;
            }
            
            if( !isset($has_error) ){
                
                $user = array(
                        'user_login' =>  $melli,
                        'user_email' =>  $email,
                        'user_pass' => $password,
                        'first_name' => $name,
                        'last_name' => $family,
                    );
                
                $userid = wp_insert_user($user);
                
                if( !is_wp_error( $userid ) ){
                    
                    add_user_meta($userid, 'phone' , $phone);
                    add_user_meta($userid, 'birthday' , $birthday);
                    add_user_meta($userid, 'sex' , $sex);
                    
                    //mail password
                    $to = $email;
                    $subject = 'رمز عبور ورود به سایت';
                    $body = 'رمز عبور شما: '.$password;
                     
                    wp_mail( $to, $subject, $body );
                    
                    
                    $add_pass = $wpdb->insert($wpdb->prefix.'passenger', array(
                        'melli'    => $melli,
                        'phone'    => $phone,
                        'name'     => $name,
                        'family'   => $family,
                        'birthday' => $birthday,
                        'sex'      => $sex,
                        'user_id'  => $userid,
                        'parent'   => 0,
                        'status'   => 1,
                        'dated'     => jdate('Y/m/j'),
                        'ip'       => $_SERVER['REMOTE_ADDR']
                        ));
                        
                    if( $add_pass ){
                        wp_redirect( home_url(). '/tt_login?register=1&nonce='.wp_create_nonce('login') );
                    }
                    
                    
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
                
                				"Parameter" => "name_family",
                				"ParameterValue" => $name . ' ' . $family
                			)
							,
							array(
								"Parameter" => "pass",
								"ParameterValue" => $password

							)
                		),
                		"Mobile" => $phone,
                		"TemplateId" => "5274"
                	);
                
                	$SmsIR_UltraFastSend = new SmsIR_UltraFastSend($APIKey,$SecretKey);
                	$UltraFastSend = $SmsIR_UltraFastSend->UltraFastSend($data);
                // 	var_dump($UltraFastSend);
                	
                } catch (Exeption $e) {
                	echo 'Error UltraFastSend : '.$e->getMessage();
                }
                    
                    //redirect to login page
                    
                }
            }
    
    
}

}
?>