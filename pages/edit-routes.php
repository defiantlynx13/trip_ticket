<?php
/* edit-routes page 
** show detail's route in page and we can edit & save it
*/

defined("ABSPATH") || exit;

global $wpdb;
$id = sanitize_text_field( $_GET['id'] );
$table = $wpdb->prefix .'routes';

//redirect when url is wrong!
if( !isset($_GET['action']) || !isset($_GET['id']) || !current_user_can('administrator')){
    wp_redirect( admin_url() . 'admin.php?page=all-routes' );
}

if( isset($_POST['editRoute']) ){
    $begining = isset($_POST['begining']) ? sanitize_text_field($_POST['begining']) : '' ;
    $destination = isset($_POST['destination']) ? sanitize_text_field($_POST['destination']) : '' ;
    
    $edit_route = $wpdb->update($table, array(
        'begining' => $begining,
        'destination' => $destination
        ),array(
            'id' => $id
            ));
    
    
    wp_redirect(admin_url() . 'admin.php?page=all-routes' );
    
}

$get_route = $wpdb->get_results( $wpdb->prepare("select * from {$table} where id=%d" , $id) );
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
                    foreach( $get_route as $route ):
                ?>
                <tr>
                    <th>
                        <lable>مبدا</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="begining" type="text" value="<?php echo $route->begining; ?>"/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>مقصد</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="destination" type="text"  value="<?php echo $route->destination; ?>"/>
                    </td>
                </tr>
                
                <?php
                    endforeach;
                endif;
                ?>
                
            </tbody>
            
        </table>
        <br>
        <input type="submit" value="ویرایش مسیر" name="editRoute" class="button-primary" />
    
    </form> 
</div>