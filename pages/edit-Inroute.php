<?php
/* edit Inroute page 
** show detail's Inroute in page and we can edit & save it
*/

defined("ABSPATH") || exit;

global $wpdb;
$id = sanitize_text_field( $_GET['id'] );
$route_id = sanitize_text_field($_GET['route_id']);
$table = $wpdb->prefix .'Inroutes';

//redirect when url is wrong!
if( !isset($_GET['action']) || !isset($_GET['id']) || !current_user_can('administrator')){
    wp_redirect( admin_url() . 'admin.php?page=all-Inroutes' );
}

if( isset($_POST['editInroute']) ){
    
    $begining = isset($_POST['TT_begining']) ? sanitize_text_field($_POST['TT_begining']) : '' ;
    $destination = isset($_POST['TT_destination']) ? sanitize_text_field($_POST['TT_destination']) : '' ;
    $type = isset($_POST['TT_type']) ? sanitize_text_field($_POST['TT_type']) : '' ;
    
    $day = isset($_POST['TT_day']) ? sanitize_text_field($_POST['TT_day']) : '' ;
    $month = isset($_POST['TT_month']) ? sanitize_text_field($_POST['TT_month']) : '' ;
    $year = isset($_POST['TT_year']) ? sanitize_text_field($_POST['TT_year']) : '' ;
    
    $date = $year.$month.$day;
    
    $time = isset($_POST['TT_time']) ? sanitize_text_field($_POST['TT_time']) : '' ;
    $price = isset($_POST['TT_price']) ? sanitize_text_field($_POST['TT_price']) : '' ;
    $status = isset($_POST['TT_status']) ? sanitize_text_field($_POST['TT_status']) : '' ;
    
    
    $edit_Inroute = $wpdb->update($table , array(
        'route_id'    => $route_id,
        'begining'    => $begining,
        'destination' => $destination,
        'type'        => $type,
        'time'        => $time,
        'price'       => $price,
        'status'      => $status,
        ),array(
            'id' => $id
            ));
    
    wp_redirect(admin_url() . 'admin.php?page=all-Inroutes&route_id='.$route_id );
    
}




$get_Inroute = $wpdb->get_results( $wpdb->prepare("select * from {$table} where id=%d" , $id) );
?>

<div class="wrap">
    <h1 class="wp-heading-inline">ویرایش زیرمسیر</h1>
    <a href="admin.php?page=all-Inroutes&route_id=<?php echo $route_id; ?>" class="page-title-action">همه زیرمسیرها</a>
    <br /><br />
    <form method="post">
        <table class="form-table">
            <tbody>
                <?php
                if( $wpdb->num_rows > 0 ):
                    foreach( $get_Inroute as $Inroute ):
                ?>

				<tr>
                    <th>
                        <lable>نوع کشتی</lable>
                    </th>
                    <td>
                        <select name="TT_type" required style="height:33px;">
                            <option value="" hidden>نوع کشتی</option>
                        <?php
                        
                        $table = $wpdb->prefix . 'trip_type';
                        $get_trip = $wpdb->get_results("select * from {$table} where cat='مسافربری'") ;
                        
                        foreach( $get_trip as $trip ){
                            
                            if( $Inroute->type == $trip->id ){
                                $selected = 'selected="selected"';
                            }else{
                                $selected= null;
                            }
                            
                            echo '<option value="'.$trip->id.'" '.$selected.'>'.$trip->cat.' '.$trip->type.' '. $trip->capacity.' نفره</option>';
                        }
                        
                        ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>
                        <lable>مبدا</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="TT_begining" type="text" value="<?php echo $Inroute->begining; ?>"/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>مقصد</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="TT_destination" type="text"  value="<?php echo $Inroute->destination; ?>"/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>زمان</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="TT_time" type="text"  value="<?php echo $Inroute->time; ?>"/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>هزینه</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="TT_price" type="text"  value="<?php echo $Inroute->price; ?>"/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>وضعیت</lable>
                    </th>
                    <td>
                        <select name="TT_status" style="height:33px;">
                            <option value="1" <?php if( $Inroute->status == 1 ){ echo 'selected="selected"'; } ?> >فعال</option>
                            <option value="0" <?php if( $Inroute->status == 0 ){ echo 'selected="selected"'; } ?> >غیرفعال</option>
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
        <input type="submit" value="ویرایش زیرمسیر" name="editInroute" class="button-primary" />
    
    </form> 
</div>