<?php

defined("ABSPATH") || exit;

add_shortcode('TT_number' , 'TT_number_function');

function TT_number_function(){ 

if( !is_user_logged_in() ){
    wp_redirect( home_url() .'/tt_login' );
}

global $wpdb;
$user = wp_get_current_user();
 

require_once( plugin_dir_path(__FILE__) . 'sidebar.php' ); ?>
    
    <div style="width:75%;float:right">
        
        Hello
        
    </div>
    
<?php
}
?>