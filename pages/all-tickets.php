<?php
/* all-routes page 
** show all route in page and we can edit or delete routes
*/

defined("ABSPATH") || exit;

global $wpdb;
$table = $wpdb->prefix . 'tickets';
$get_tickets = $wpdb->get_results( "select * from {$table} order by id desc limit 20");

//change persian number to latin in now date
$persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
$num = range(0, 9);

$year = str_replace($persian, $num, jdate("Y") );
$month = str_replace($persian, $num, jdate("m") );
$day = str_replace($persian, $num, jdate("j") );

$now = $year.$month.$day;

if( isset( $_GET['date'] ) && $_GET['date'] == 'today' ){
    $get_tickets = $wpdb->get_results( "select * from {$table} where date_register='$now' order by id desc");
}
$passtable = $wpdb->prefix . 'passenger';
$typeticket = $wpdb->prefix . 'trip_type';

if( isset( $_GET['action'] ) && $_GET['action'] == 'delete' && current_user_can('administrator') ){
    if( wp_verify_nonce( $_GET['nonce'] , 'delete') ){
        $del_ticket = $wpdb->delete($table , array(
            'id' => sanitize_text_field($_GET['id'])
            ));
        wp_redirect(admin_url(). 'admin.php?page=all-tickets');
    }
}
    
if( isset( $_POST['tt_filter'] ) ){
    
    //name input section
    $name = sanitize_text_field( $_POST['tt_name'] );
    $types = sanitize_text_field( $_POST['tt_type'] ); 
    $ex_name = explode( " " , $name );
    
    if( count($ex_name) == 1 && $types == 2 ){
            
            $get_tickets = $wpdb->get_results( "select * from {$table} where pass_melli='$name'" );
        
    }
    else if( count($ex_name) == 1 && $types == 4 ){
            
            $get_tickets = $wpdb->get_results( "select * from {$table} where time='$name' order by id desc" );
        
    }

    else if( count($ex_name) == 1 && $types == 11 ){
            
            $get_tickets = $wpdb->get_results( "select * from {$table} where private_pass='$name'" );
        
    }

  
}

?>

<div class="wrap">

    <h1 class="wp-heading-inline">بلیط های فروخته شده </h1>
    <a href="<?php echo admin_url() . 'admin.php?page=all-tickets&date=today'?>" class="page-title-action">بلیط های امروز</a>
    <a href="<?php echo admin_url(); ?>admin-ajax.php?action=csv_pull" class="page-title-action">خروجی اکسل کامل</a>
    <br><br>
    
    <form action="" method="post">
        
        <input type="text" name="tt_name" value="" style="height:30px;margin:0;" required/><select style="margin:0;height:30px;vertical-align:top;padding:0 10px;" required name="tt_type">
            
            <option value="2">شماره ملی</option>
            <option value="11">شماره بلیط</option>
            
        </select>
        
        &nbsp;
        <input type="submit" name="tt_filter" value="فیلتر کن" class="button button-secondary" style="box-shadow:none;" />
    </form>
    
    <br>
    <table class="wp-list-table widefat fixed striped">
        
        <thead>
            <tr>
                <th>نام</th>
                <th>شماره ملی</th>
                <th>تاریخ</th>
                <th>زمان</th>
                <th>قیمت</th>
                <th>مسیر</th>
                <th>مبدا</th>
                <th>مقصد</th>
                <th>اسم شناور</th>
                <th>دسته شناور</th>
                <th>شماره بلیط</th>
                <th>زمان ثبت</th>
                <th>وضعیت</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            //show all routes ------------------------
            
            
            if( $wpdb->num_rows > 0 ){
                foreach( $get_tickets as $tickets ):
                    
                    
                        $route_id = $tickets->route_id;
                        $inroute_id = $tickets->inroute_id;
                        
                        $pass_id = $tickets->pass_id;
                        $time = $tickets->time;
                        $date = $tickets->date;
                        $private_pass = $tickets->private_pass;
                        $typerr = $tickets->typer;
                        // echo $typerr;
                        $status = $tickets->status;
                        
                        $Troute = $wpdb->prefix . 'routes';
                        $get_route = $wpdb->get_results( $wpdb->prepare("select * from {$Troute} where id=%d" , $route_id) );
                        foreach( $get_route as $route ){
                            $begining = $route->begining;
                            $destination = $route->destination;
                        }
                        
                        $Tinroute = $wpdb->prefix . 'Inroutes';
                        $get_inroute = $wpdb->get_results( $wpdb->prepare("select * from {$Tinroute} where id=%d" , $inroute_id) );
                        foreach( $get_inroute as $inroute ){
                            $price = $inroute->price;
                            $in_begining = $inroute->begining;
                            $in_destination = $inroute->destination;
                        }
                        
                        $Ttype = $wpdb->prefix . 'trip_type';
                        $get_type = $wpdb->get_results( "select * from {$Ttype} where id={$typerr}" );
                        
                        if( $wpdb->num_rows > 0 ){
                            
                            foreach( $get_type as $typer ){
                                $typee = $typer->type;
                                $cat = $typer->cat;
                            }
                        }
                    
                    
                    echo '<tr>';
                    
                        //ticket name
                        echo '<td>'.$tickets->pass_name . ' ' . $tickets->pass_family;
                        echo '<div class="row-actions">';
                        echo '<span><a href="admin.php?page=edit-ticket&action=edit&id='.$tickets->id.'">ویرایش</a></span>&nbsp;&nbsp;';
                        echo '<span><a href="admin.php?page=all-tickets&action=delete&id='.$tickets->id.'&nonce='.wp_create_nonce('delete').'" onclick="return confirm(\'آیا مطمئن هستید این بلیط حذف شود؟\')" style="color:red">حذف</a></span>';
                        echo '</div>';
                        echo '</td>';
                        
                        //ticket melli
                        echo '<td>'.$tickets->pass_melli.'</td>';
                        
                        //ticket date
                        echo '<td>'.substr($date,0,4).'/'.substr($date,4,2).'/'.substr($date,6,2).'</td>';
                        
                        //ticket time
                        echo '<td>'.$time.'</td>';
                        
                        //ticket price
                        echo '<td>'.$price.'</td>';
                        
                        //ticket route
						if( isset($begining) && isset($destination) ){
							echo '<td>'.$begining.' تا '.$destination.'</td>';
						}else{
							echo '<td>-</td>';
						}
                        
                        
                        //ticket in_begining
                        echo '<td>'.$in_begining.'</td>';
                        
                        //ticket in_destination
                        echo '<td>'.$in_destination.'</td>';
                        
                        //ticket typee
                        echo '<td>'.$typee.'</td>';
                        
                        //ticket cat
                        echo '<td>'.$cat.'</td>';
                        
                        //ticket private_pass
                        echo '<td>'.$private_pass.'</td>';
                        
                        //ticket time register
                        echo '<td>'.substr($tickets->date_register,0,4) . '/' .substr($tickets->date_register,4,2) . '/' .substr($tickets->date_register,6,2) .'</td>';
                        
                        //ticket status
                        echo '<td>';
                        if( $status == 1 ){
                            echo '<span style="color:green">فعال</span>';
                        }else{
                            echo '<span style="color:red">کنسل</span>';
                        }
                        echo '</td>';

                    echo '</tr>';
            endforeach;
            
            }
            else{ 
               echo '<tr>';
               echo '<td>هیچ موردی وجود ندارد.</td>';
               echo '<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>';
               echo '</tr>';
            }
            ?>
            
            
        </tbody>
        
        <tfoot>
            <tr>
                <th>نام</th>
                <th>شماره ملی</th>
                <th>تاریخ</th>
                <th>زمان</th>
                <th>قیمت</th>
                <th>مسیر</th>
                <th>مبدا</th>
                <th>مقصد</th>
                <th>اسم شناور</th>
                <th>دسته شناور</th>
                <th>شماره بلیط</th>
                <th>زمان ثبت</th>
                <th>وضعیت</th>
            </tr>
        </tfoot>
        
    </table>

</div>