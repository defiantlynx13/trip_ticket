<?php
/* edit-routes page 
** show detail's route in page and we can edit & save it
*/

defined("ABSPATH") || exit;

global $wpdb;
$id = sanitize_text_field( $_GET['id'] );
$table = $wpdb->prefix .'tickets';

//redirect when url is wrong!
if( !isset($_GET['action']) || !isset($_GET['id']) || !current_user_can('administrator')){
    wp_redirect( admin_url() . 'admin.php?page=all-tickets' );
}

if( isset($_POST['editTicket']) ){
    
    $day = isset($_POST['pass_day']) ? sanitize_text_field($_POST['pass_day']) : '' ;
    $month = isset($_POST['pass_month']) ? sanitize_text_field($_POST['pass_month']) : '' ;
    $year = isset($_POST['pass_year']) ? sanitize_text_field($_POST['pass_year']) : '' ;
    $date = $year.$month.$day;
    
    $time = isset($_POST['pass_time']) ? sanitize_text_field($_POST['pass_time']) : '' ;
    $inroute = isset($_POST['pass_inroute']) ? sanitize_text_field($_POST['pass_inroute']) : '' ;
    
    $type = isset($_POST['ticket_type']) ? sanitize_text_field($_POST['ticket_type']) : '' ;
    
    $status = isset($_POST['ticket_status']) ? sanitize_text_field($_POST['ticket_status']) : '' ;
    
    $edit_ticket = $wpdb->update($table, array(
        'date' => $date,
        'time' => $time,
        'inroute_id' => $inroute,
        'type' => $type,
        'status' => $status
        ),array(
            'id' => $id
            ));
    
    
    wp_redirect(admin_url() . 'admin.php?page=all-tickets' );
    
}

$get_tickets = $wpdb->get_results( $wpdb->prepare("select * from {$table} where id=%d" , $id) );
?>

<div class="wrap">
    <h1 class="wp-heading-inline">ویرایش بلیط</h1>
    <a href="admin.php?page=all-tickets" class="page-title-action">همه بلیط ها</a>
    <br /><br />
    <form method="post">
        <table class="form-table">
            <tbody>
                <?php
                if( $wpdb->num_rows > 0 ):
                    foreach( $get_tickets as $tickets ):
                        
                        $route_id = $tickets->route_id;
                        $inroute_id = $tickets->inroute_id;
                        
                        $pass_id = $tickets->pass_id;
                        $time = $tickets->time;
                        $date = $tickets->date;
                        $private_pass = $tickets->private_pass;
                        $type = $tickets->typer;
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
                        $get_type = $wpdb->get_results( $wpdb->prepare("select * from {$Ttype} where id=%d" , $type) );
                        foreach( $get_type as $type ){
                            $typee = $type->type;
                            $cat = $type->cat;
                        }
                        
                        $Tpass = $wpdb->prefix . 'passenger';
                        $get_pass = $wpdb->get_results( $wpdb->prepare("select * from {$Tpass} where id=%d" , $pass_id) );
                        foreach( $get_pass as $pass ){
                            $name = $pass->name;
                            $family = $pass->family;
                            $melli = $pass->melli;
                        }
                ?>
                <tr>
                    <th>
                        <lable>نام</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="begining" type="text" value="<?php echo $name; ?>" disabled/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>نام خانوادگی</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="destination" type="text"  value="<?php echo $family; ?>" disabled/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>شماره ملی</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="begining" type="text" value="<?php echo $melli; ?>" disabled/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>تاریخ</lable>
                    </th>
                    <td>
                        <select name="pass_day">
                            <?php
                            $pass_date= substr( $date, 6, 2 );
                            ?>
                            <option value="" hidden>روز</option>
                            <option value="01" <?php if( $pass_date == '01' ){ echo 'selected="selected"'; } ?>>1</option>
                            <option value="02" <?php if( $pass_date == '02' ){ echo 'selected="selected"'; } ?>>2</option>
                            <option value="03" <?php if( $pass_date == '03' ){ echo 'selected="selected"'; } ?>>3</option>
                            <option value="04" <?php if( $pass_date == '04' ){ echo 'selected="selected"'; } ?>>4</option>
                            <option value="05" <?php if( $pass_date == '05' ){ echo 'selected="selected"'; } ?>>5</option>
                            <option value="06" <?php if( $pass_date == '06' ){ echo 'selected="selected"'; } ?>>6</option>
                            <option value="07" <?php if( $pass_date == '07' ){ echo 'selected="selected"'; } ?>>7</option>
                            <option value="08" <?php if( $pass_date == '08' ){ echo 'selected="selected"'; } ?>>8</option>
                            <option value="09" <?php if( $pass_date == '09' ){ echo 'selected="selected"'; } ?>>9</option>
                            
                            <?php
                            for( $i=10 ; $i<32 ; $i++ ){
                                if( $i ==  $pass_date){
                                    $selected = 'selected="selected"';
                                }else{
                                    $selected= null;
                                }
                                echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                            }
                            
                            $pass_month= substr( $date, 4, 2 );
                            ?>
                        </select>
                        &nbsp;&nbsp;
                            <select id="date" required name="pass_month" >
                                <option value="" hidden>ماه</option>
                                <option value="01" <?php if( $pass_month == '01' ){ echo 'selected="selected"'; } ?>>فروردین</option>
                                <option value="02" <?php if( $pass_month == '02' ){ echo 'selected="selected"'; } ?>>اردیبهشت</option>
                                <option value="03" <?php if( $pass_month == '03' ){ echo 'selected="selected"'; } ?>>خرداد</option>
                                <option value="04" <?php if( $pass_month == '04' ){ echo 'selected="selected"'; } ?>>تیر</option>
                                <option value="05" <?php if( $pass_month == '05' ){ echo 'selected="selected"'; } ?>>مرداد</option>
                                <option value="06" <?php if( $pass_month == '06' ){ echo 'selected="selected"'; } ?>>شهریور</option>
                                <option value="07" <?php if( $pass_month == '07' ){ echo 'selected="selected"'; } ?>>مهر</option>
                                <option value="08" <?php if( $pass_month == '08' ){ echo 'selected="selected"'; } ?>>آبان</option>
                                <option value="09" <?php if( $pass_month == '09' ){ echo 'selected="selected"'; } ?>>آذر</option>
                                <option value="10" <?php if( $pass_month == '10' ){ echo 'selected="selected"'; } ?>>دی</option>
                                <option value="11" <?php if( $pass_month == '11' ){ echo 'selected="selected"'; } ?>>بهمن</option>
                                <option value="12" <?php if( $pass_month == '12' ){ echo 'selected="selected"'; } ?>>اسفند</option>
                            </select>
            
                        &nbsp;&nbsp;
                        <select name="pass_year" >
                            <option value="" hidden>سال</option>
                            <?php

                            $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
                            $num = range(0, 9);
                            $x = str_replace($persian, $num, jdate("Y") );
                            $pass_year= substr( $date, 0, 4 );
                            
                            if( $x ==  $pass_year){
                                $selected = 'selected="selected"';
                            }
                            else if( ($x+1) == $pass_year ){
                                $selectedd = 'selected="selected"';
                            }
                            else if( ($x+2) == $pass_year ){
                                $selecteddd = 'selected="selected"';
                            }
                            else{
                                $selected= null;
                            }
                            
                            echo '<option value="'.$x.'" '.$selected.'>'.$x.'</option>';
                            echo '<option value="'.($x+1).'" '.$selectedd.'>'.($x+1).'</option>';
                            echo '<option value="'.($x+2).'" '.$selecteddd.'>'.($x+2).'</option>';
                            ?>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>زمان</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="pass_time" type="text" value="<?php echo $time; ?>"/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>قیمت</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="" type="text" value="<?php echo $price; ?>" disabled/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>مسیر</lable>
                    </th>
                    <td>
						<?php
						if( isset($begining) and isset($destination)){ ?>
							<input class="regular-text" name="" type="text" value="<?php echo $begining . ' به ' . $destination; ?>" disabled/>
						<?php
						}else{
							echo '<input class="regular-text" name="" type="text" value="-" disabled/>';
						}
						?>
                        
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>زیرمسیر</lable>
                    </th>
                    <td>
                        <select name="pass_inroute" style="width:150px">
                                <?php
                                $get_inroute = $wpdb->get_results( $wpdb->prepare("select * from {$Tinroute} where route_id=%d" , $route_id) );
                                foreach( $get_inroute as $inroute ){
                                    echo '<option value="'.$inroute->id.'">'.$inroute->begining. ' به ' .$inroute->destination.'</option>';
                                }
                                ?>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>نوع کشتی</lable>
                    </th>
                    <td>
                        <select name="ticket_type" style="width:250px">
                                <?php
                                
                                $get_typee = $wpdb->get_results( "select * from {$Ttype} " );
                                foreach( $get_typee as $type ){
                                    
                                    if( $tickets->type == $type->id ){
                                        $selected = 'selected="selected"';
                                    }else{
                                        $selected = null;
                                    }
                                    
                                    echo '<option value="'.$type->id.'" '.$selected.'>'.$type->type. ' ' . $type->cat . ' ' .$type->capacity.' نفره</option>';
                                }
                                
                                ?>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>شماره بلیط</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="begining" type="text" value="<?php echo $private_pass; ?>" disabled/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>وضعیت</lable>
                    </th>
                    <td>
                        
                        <select name="ticket_status" style="width:75px">
                                <option value="1" <?php if( $tickets->status == 1 ){ echo 'selected="selected"'; } ?>>فعال</option>
                                <option value="0" <?php if( $tickets->status == 0 ){ echo 'selected="selected"'; } ?>>غیرفعال</option>
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
        <input type="submit" value="ویرایش بلیط" name="editTicket" class="button-primary" />
    
    </form> 
</div>