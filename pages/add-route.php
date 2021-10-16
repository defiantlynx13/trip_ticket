<?php
/* add Inroute page 
** Add a new Inroute for parent route
*/

defined("ABSPATH") || exit;

global $wpdb;
$table = $wpdb->prefix .'routes';

//redirect when url is wrong!
if( !current_user_can('administrator')){
    wp_redirect( admin_url() . 'admin.php?page=all-routes' );
}

if( isset($_POST['addroute']) ){
    $begining = isset($_POST['begining']) ? sanitize_text_field($_POST['begining']) : '' ;
    $destination = isset($_POST['destination']) ? sanitize_text_field($_POST['destination']) : '' ;
    
    $add_Inroute = $wpdb->insert($table , array(
        'begining'    => $begining,
        'destination' => $destination
        ));
    
    if( $add_Inroute ){
        wp_redirect(admin_url() . 'admin.php?page=all-routes' );
    }
}

?>

<div class="wrap">
    <h1 class="wp-heading-inline">افزودن مسیر</h1>
    <a href="admin.php?page=all-routes" class="page-title-action">همه مسیرها</a>
    <br /><br />
    <form method="post">
        <table class="form-table">
            <tbody>
                <tr>
                    <th>
                        <lable>مبدا</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="begining" type="text"/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>مقصد</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="destination" type="text"/>
                    </td>
                </tr>
                
            </tbody>
            
        </table>
        <br>
        <input type="submit" value="افزودن مسیر" name="addroute" class="button-primary" />
    
    </form> 
</div>