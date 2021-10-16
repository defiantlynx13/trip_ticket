<?php
/* add Inroute page 
** Add a new Inroute for parent route
*/

defined("ABSPATH") || exit;

global $wpdb;
$table = $wpdb->prefix .'Inroutes';


//redirect when url is wrong!
if( !current_user_can('administrator')){
    wp_redirect( admin_url() . 'admin.php?page=all-fall-inroutes' );
	exit;
}

if( isset($_POST['addInroute']) ){
    
    $begining = '-' ;
    $destination = '-' ;
    $type = isset($_POST['TT_type']) ? sanitize_text_field($_POST['TT_type']) : '' ;
    
    $day = isset($_POST['TT_day']) ? sanitize_text_field($_POST['TT_day']) : '' ;
    $month = isset($_POST['TT_month']) ? sanitize_text_field($_POST['TT_month']) : '' ;
    $year = isset($_POST['TT_year']) ? sanitize_text_field($_POST['TT_year']) : '' ;
    
    $date = $year.$month.$day;
    
    $time = isset($_POST['TT_time']) ? sanitize_text_field($_POST['TT_time']) : '' ;
    $price = isset($_POST['TT_price']) ? sanitize_text_field($_POST['TT_price']) : '' ;
    $status = isset($_POST['TT_status']) ? sanitize_text_field($_POST['TT_status']) : '' ;
    
    $add_Inroute = $wpdb->insert($table , array(
        'route_id'    => 0,
        'begining'    => $begining,
        'destination' => $destination,
        'type'        => $type,
        'time'        => $time,
        'price'       => $price,
        'status'      => $status,
		'fall'		  => 1
        ));
    
    if( $add_Inroute ){
        wp_redirect(admin_url() . 'admin.php?page=all-fall-inroutes' );
		exit;
    }
}

?>

<div class="wrap">
    <h1 class="wp-heading-inline">افزودن سفر تفریحی</h1>
    <a href="admin.php?page=all-fall-inroutes" class="page-title-action">همه سفرهای تفریحی</a>
    <br /><br />
    <form method="post">
        <table class="form-table">
            <tbody>


				<tr>
                    <th>
                        <lable>نوع کشتی</lable>
                    </th>
                    <td>
                        
                        <select name="TT_type" required style="height:33px !important">
                            <option value="" hidden>نوع کشتی</option>
                        <?php
                        
                        $table = $wpdb->prefix . 'trip_type';
                        $get_trip = $wpdb->get_results("select * from {$table} where cat='کشتی تفریحی'") ;
                        
                        foreach( $get_trip as $trip ){
                            echo '<option value="'.$trip->id.'">'.$trip->cat.' '.$trip->type.' '. $trip->capacity.' نفره</option>';
                        }
                        
                        ?>
                            
                        </select>
						<p id="ress"></p>
                    </td>
                </tr>         
                
                <tr>
                    <th>
                        <lable>زمان</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="TT_time" type="text" required/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>قیمت</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="TT_price" type="text" required/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>وضعیت</lable>
                    </th>
                    <td>
                        <select name="TT_status" required>
                            <option value="1" >فعال</option>
                            <option value="0" >غیرفعال</option>
                        </select>
                    </td>
                </tr>
                
            </tbody>
            
        </table>
        <br>
        <input type="submit" value="افزودن زیرمسیر" name="addInroute" class="button-primary" />
    
    </form> 
</div>