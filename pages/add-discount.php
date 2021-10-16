<?php
/* add Inroute page 
** Add a new Inroute for parent route
*/

defined("ABSPATH") || exit;

global $wpdb;
$table = $wpdb->prefix .'discount';

//redirect when url is wrong!
if( !current_user_can('administrator')){
    wp_redirect( admin_url() . 'admin.php?page=all-discount' );
}

if( isset($_POST['adddiscount']) ){
    $code = isset($_POST['tt_code']) ? sanitize_text_field($_POST['tt_code']) : '' ;
    $percent = isset($_POST['tt_percent']) ? sanitize_text_field($_POST['tt_percent']) : '' ;
    
    $add_Inroute = $wpdb->insert($table , array(
        'code'    => $code,
        'percent' => $percent
        ));
    
    if( $add_Inroute ){
        wp_redirect(admin_url() . 'admin.php?page=all-discount' );
    }
}

?>

<div class="wrap">
    <h1 class="wp-heading-inline">افزودن تخفیف</h1>
    <a href="admin.php?page=all-routes" class="page-title-action">همه تخفیف ها</a>
    <br /><br />
    <form method="post">
        <table class="form-table">
            <tbody>
                <tr>
                    <th>
                        <lable>کد تخفیف</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="tt_code" type="text"/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>درصد</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="tt_percent" type="text"/>
                    </td>
                </tr>
                
            </tbody>
            
        </table>
        <br>
        <input type="submit" value="افزودن تخفیف" name="adddiscount" class="button-primary" />
    
    </form> 
</div>