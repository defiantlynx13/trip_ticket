<?php

defined("ABSPATH") || exit;

add_shortcode('TT_myfamily' , 'TT_myfamily_function');

function TT_myfamily_function(){ 

if( !is_user_logged_in() ){
    wp_redirect( home_url() .'/tt_login' );
}

global $wpdb;
$user = wp_get_current_user();

require_once( plugin_dir_path(__FILE__) . 'sidebar.php' ); ?>
    
    <div style="width:75%;float:right">    
        
        <table class="list_table">
            <thead>
                <tr>
                    <th>نام</th>
                    <th>نام خانوادگی</th>
                    <th>شماره ملی</th>
                    <th>تلفن همراه</th>
                    <th>تاریخ تولد</th>
                    <th>جنسیت</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $table = $wpdb->prefix .'passenger';
                $get_pass = $wpdb->get_results( $wpdb->prepare( "select * from {$table} where user_id=%d", $user->ID) );
                if( $wpdb->num_rows > 0 ){
                    foreach( $get_pass as $pass ){
                        $birthday = substr($pass->birthday,0,4).'/'.substr($pass->birthday,4,2).'/'.substr($pass->birthday,6,2);
                        echo '<tr>';
                            echo '<td>'.$pass->name.'</td>';
                            echo '<td>'.$pass->family.'</td>';
                            echo '<td>'.$pass->melli.'</td>';
                            echo '<td>'.$pass->phone.'</td>';
                            echo '<td>'.$birthday.'</td>';
                            echo '<td>'.$pass->sex.'</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
        
       
        
        <a style="color:#4086AA" href="<?php echo home_url(); ?>/tt_newpass">+ ثبت مسافر جدید</a>
        
        
        
    </div>
    
<?php
}
?>