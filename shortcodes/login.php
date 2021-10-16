<?php

defined("ABSPATH") || exit;

add_shortcode('TT_login' , 'TT_login_function');

function TT_login_function(){

if( is_user_logged_in() ){
    wp_redirect( home_url(). '/tt_panel' );
}
    
if( isset($_GET['register']) && wp_verify_nonce($_GET['nonce'] , 'login') ){
    echo '<p style="box-shadow:0 0 5px #ddd;border-right:3px solid green;padding:8px 15px">ثبت نام شما با موفقیت انجام شد. رمز عبور به تلفن همراه شما پیامک گردید.</p>';
    echo '<br>';
}

if( isset($_GET['wrong']) && $_GET['wrong'] == 'true' ){
    echo '<p style="box-shadow:0 0 5px #ddd;border-right:3px solid rgba(229,57,53 ,1);padding:8px 15px">ایمیل یا رمز عبور اشتباه می باشد. <a href="'.home_url().'/tt_reset" style="color:#4086AA">بازیابی رمز عبور</a></p>';
    echo '<br>';
}
	?>
	<h5>ورود به سایت</h5>
   <hr>
   <br>
	<?php
    $args = array(
        'redirect' => home_url().'/tt_panel',
        'label_username' => __( 'شماره ملی:' ),
        'label_password' => __( 'رمز عبور:' ),
        // 'label_remember' => __( 'Remember my info' ),
        'label_log_in' => __( 'ورود به پنل' ),
        'remember' => false
    );
    wp_login_form($args);
    
    echo '';
    echo '<a style="font-size:12px;color:#4086AA" href="'.home_url().'/tt_register">+ ثبت نام در سایت</a>';
    echo '&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<a style="font-size:12px;color:#C25B56" href="'.home_url().'/tt_reset">بازیابی رمز عبور</a>';
    
}