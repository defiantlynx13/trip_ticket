<?php
/* edit-routes page 
** show detail's route in page and we can edit & save it
*/

defined("ABSPATH") || exit;

global $wpdb;
$id = sanitize_text_field( $_GET['id'] );
$table = $wpdb->prefix .'trip_type';

//redirect when url is wrong!
if( !isset($_GET['action']) || !isset($_GET['id']) || !current_user_can('administrator')){
    wp_redirect( admin_url() . 'admin.php?page=all-trip-type' );
}

if( isset($_POST['edittrip']) ){
    
    $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '' ;
    $cat = isset($_POST['cat']) ? sanitize_text_field($_POST['cat']) : '' ;
    $capacity = isset($_POST['capacity']) ? sanitize_text_field($_POST['capacity']) : '' ;
    $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '' ;
    
    $edit_route = $wpdb->update($table, array(
        
        'type' => $type,
        'cat' => $cat,
        'capacity' => $capacity,
        'status' => $status
        
        ),array(
            'id' => $id
            ));
    
    
    wp_redirect(admin_url() . 'admin.php?page=all-trip-type' );
    
}

$get_trip_type = $wpdb->get_results( $wpdb->prepare("select * from {$table} where id=%d" , $id) );
?>

<div class="wrap">
    <h1 class="wp-heading-inline">ویرایش مسیر</h1>
    <a href="admin.php?page=all-routes" class="page-title-action">همه مسیرها</a>
    <br /><br />
    <form method="post">
        <table class="form-table">
            <tbody>
                <?php
                if( $wpdb->num_rows > 0 ):
                    foreach( $get_trip_type as $trip_type ):
                ?>
                <tr>
                    <th>
                        <lable>اسم شناور</lable>
                    </th>
                    <td>
						<input type="text" class="regular-text" name="type" value="<?php echo $trip_type->type; ?>" />
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>دسته شناور</lable>
                    </th>
                    <td>
                        <select name="cat">
                            <option <?php if( $trip_type->cat == 'مسافربری' ){ echo 'selected="selected"'; } ?> value="مسافربری">مسافربری</option>
                            <option <?php if( $trip_type->cat == 'کشتی تفریحی' ){ echo 'selected="selected"'; } ?> value="کشتی تفریحی">کشتی تفریحی</option>
                            
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>ظرفیت شناور</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="capacity" type="text" value="<?php echo $trip_type->capacity; ?>"/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>وضعیت</lable>
                    </th>
                    <td>
                        <select name="status">
                            <option <?php if( $trip_type->status == 1 ){ echo 'selected="selected"'; } ?> value="1">فعال</option>
                            <option <?php if( $trip_type->status == 0 ){ echo 'selected="selected"'; } ?> value="0">غیرفعال</option>
                        </select>
                    </td>
                </tr>
                
                <?php
                    endforeach;
                endif;
                ?>
                
            </tbody>
            
        </table>
        <br>
        <input type="submit" value="ویرایش شناور" name="edittrip" class="button-primary" />
    
    </form> 
</div>