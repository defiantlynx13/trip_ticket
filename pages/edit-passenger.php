<?php
/* edit Inroute page 
** show detail's Inroute in page and we can edit & save it
*/

defined("ABSPATH") || exit;

global $wpdb;
$id = sanitize_text_field( $_GET['id'] );

$table = $wpdb->prefix .'passenger';

//redirect when url is wrong!
if( !isset($_GET['action']) || !isset($_GET['id']) || !current_user_can('administrator')){
    wp_redirect( admin_url() . 'admin.php?page=all-passengers' );
}

if( isset($_POST['editInroute']) ){
    
    $name = isset($_POST['pass_name']) ? sanitize_text_field($_POST['pass_name']) : '' ;
    $family = isset($_POST['pass_family']) ? sanitize_text_field($_POST['pass_family']) : '' ;
    $melli = isset($_POST['pass_melli']) ? sanitize_text_field($_POST['pass_melli']) : '' ;
    $phone = isset($_POST['pass_phone']) ? sanitize_text_field($_POST['pass_phone']) : '' ;
    $pass_year = isset($_POST['pass_year']) ? sanitize_text_field($_POST['pass_year']) : '' ;
    $pass_month = isset($_POST['pass_month']) ? sanitize_text_field($_POST['pass_month']) : '' ;
    $pass_day = isset($_POST['pass_day']) ? sanitize_text_field($_POST['pass_day']) : '' ;
    
    $birthday = $pass_year.$pass_month.$pass_day;
    $sex = isset($_POST['pass_sex']) ? sanitize_text_field($_POST['pass_sex']) : '' ;
    $status = isset($_POST['pass_status']) ? sanitize_text_field($_POST['pass_status']) : '' ;
    
    $edit_pass = $wpdb->update($table, array(
        'name' => $name,
        'family' => $family,
        'melli' => $melli,
        'phone' => $phone,
        'birthday' => $birthday,
        'sex' => $sex,
        'status' => $status,
        ),array(
            'id' => $id
            ));
    
    
    wp_redirect(admin_url() . 'admin.php?page=all-passengers' );
   
}




$get_pass = $wpdb->get_results( $wpdb->prepare("select * from {$table} where id=%d" , $id) );
?>

<div class="wrap">
    <h1 class="wp-heading-inline">ویرایش مسافر</h1>
    <a href="admin.php?page=all-passengers" class="page-title-action">همه مسافران</a>
    <br /><br />
    <form method="post">
        <table class="form-table">
            <tbody>
                <?php
                if( $wpdb->num_rows > 0 ):
                    foreach( $get_pass as $pass ):
                ?>
                <tr>
                    <th>
                        <lable>نام</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="pass_name" type="text" value="<?php echo $pass->name; ?>"/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>نام خانوادگی</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="pass_family" type="text"  value="<?php echo $pass->family; ?>"/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>شماره ملی</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="pass_melli" type="text"  value="<?php echo $pass->melli; ?>"/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>شماره تماس</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="pass_phone" type="text"  value="<?php echo $pass->phone; ?>"/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>تاریخ تولد</lable>
                    </th>
                    <td>
                         <select name="pass_day">
                            <?php
                            $pass_date= substr( $pass->birthday, 6, 2 );
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
                            
                            $pass_month= substr( $pass->birthday, 4, 2 );
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
                            $pass_year= substr( $pass->birthday, 0, 4 );
                            
                            
                            
                            while($x>1300){
                                if( $pass_year == $x ){
                                    $selected = 'selected="selected"';
                                }else{
                                    $selected = null;
                                }
                                echo '<option value="'.$x.'" '.$selected.'>'.$x.'</option>';
                                $x--;
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>جنسیت</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="pass_sex" type="text"  value="<?php echo $pass->sex; ?>"/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>تاریخ عضویت</lable>
                    </th>
                    <td>
                        <input class="regular-text" name="" type="text"  value="<?php echo $pass->dated; ?>" disabled/>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        <lable>وضعیت</lable>
                    </th>
                    <td>
                        <select name="pass_status">
                            <option value="1" <?php if( $pass->status == 1 ){ echo 'selected="selected"'; } ?> >فعال</option>
                            <option value="0" <?php if( $pass->status == 0 ){ echo 'selected="selected"'; } ?> >غیرفعال</option>
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
        <input type="submit" value="ویرایش مسافر" name="editInroute" class="button-primary" />
    
    </form> 
</div>