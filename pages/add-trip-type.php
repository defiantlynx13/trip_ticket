<?php
/* add Inroute page 
** Add a new Inroute for parent route
*/

defined("ABSPATH") || exit;

global $wpdb;
$table = $wpdb->prefix .'trip_type';

//redirect when url is wrong!
if( !current_user_can('administrator')){
    wp_redirect( admin_url() . 'admin.php?page=all-routes' );
}

if( isset($_POST['addtrip']) ){
    
    $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '' ;
    $cat = isset($_POST['cat']) ? sanitize_text_field($_POST['cat']) : '' ;
    $capacity = isset($_POST['capacity']) ? sanitize_text_field($_POST['capacity']) : '' ;
    $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '' ;
    
    $add_trip_type = $wpdb->insert($table , array(
        
        'type'     => $type,
        'cat'      => $cat,
        'capacity' => $capacity,
        'status'   => $status
        
        ));
    
    if( $add_trip_type ){
        wp_redirect(admin_url() . 'admin.php?page=all-trip-type' );
    }
}

?>

<div class="wrap">
    <h1 class="wp-heading-inline">افزودن شناور</h1>
    <a href="admin.php?page=all-routes" class="page-title-action">همه شناورها</a>
    <br /><br />
    <form method="post">
        <table class="form-table">
            <tbody>
                <tr>
                    <th>
                        <lable>اسم شناور</lable>
                    </th>
                    <td>
						<input type="text" name="type" class="regular-text" />
                        
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>دسته شناور</lable>
                    </th>
                    <td>
                        <select name="cat">
                            
                            <option value="مسافربری">مسافربری</option>
                            <option value="کشتی تفریحی">کشتی تفریحی</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>ظرفیت شناور</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="capacity" type="text"/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>وضعیت</lable>
                    </th>
                    <td>
                        <select name="status">
                            <option value="1">فعال</option>
                            <option value="0">غیرفعال</option>
                        </select>
                    </td>
                </tr>
                
            </tbody>
            
        </table>
        <br>
        <input type="submit" value="افزودن شناور" name="addtrip" class="button-primary" />
    
    </form> 
</div>