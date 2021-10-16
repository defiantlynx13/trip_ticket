<?php

defined("ABSPATH") || exit;

add_shortcode('TT_changepass' , 'TT_changepass_function');

function TT_changepass_function(){ 

if( !is_user_logged_in() ){
    wp_redirect( home_url() .'/tt_login' );
}

$user = wp_get_current_user();

if( isset($_POST['changepass']) ){
    
    
    if( !empty( $_POST['password'] ) && !empty( $_POST['cpassword'] ) ){
        $newPass = sanitize_text_field( $_POST['password'] );
        $cnewPass = sanitize_text_field( $_POST['cpassword'] );
        
        if( $newPass == $cnewPass ){
            wp_set_password( $newPass, $user->ID );
        
            // Log-in again.
            wp_set_auth_cookie($user->ID);
            wp_set_current_user($user->ID);
            $change = do_action('wp_login', $user->user_login, $user);
        }
        
    }
    
}

global $wpdb;

 require_once( plugin_dir_path(__FILE__) . 'sidebar.php' ); ?>
    
    <div style="width:75%;float:right">

        <form action="" method="post" class="newpass-sho">
            
            <label for="password">رمز عبور جدید:</label><br>
            <input name="password" type="password" id="password" /><br>
            
            <label for="cpassword">تایید رمز عبور جدید:</label><br>
            <input name="cpassword" type="password" id="cpassword" /><br><br>
            
            <input type="submit" style="font-family:IRANSansWeb;background:rgba(69,90,100 ,1);font-family:17px;" name="changepass" value="به روز رسانی" />
            
            
        </form>
                
        
    </div>
    
<?php
}
?>