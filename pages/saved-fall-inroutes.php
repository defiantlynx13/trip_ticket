<?php
/* all-routes page 
** show all route in page and we can edit or delete routes
*/

defined("ABSPATH") || exit;

global $wpdb;
$inroute_id = $_GET['id'];

if( isset( $_GET['action'] ) && $_GET['action'] == 'delete' && current_user_can('administrator') ){
    if( wp_verify_nonce( $_GET['nonce'] , 'delete') ){
        $table = $wpdb->prefix . 'Inroutes';
        $del_route = $wpdb->delete($table , array(
            'id' => sanitize_text_field($_GET['id'])
            ));
        if( $del_route ){
            wp_redirect(admin_url(). 'admin.php?page=all-fall-inroutes');
        }
    }
}


?>

<div class="wrap">

    <h1 class="wp-heading-inline">بلیط های ثبت شده</h1>
	<br><br>
		 <?php
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $num = range(0, 9);
        $year = str_replace($persian, $num, jdate("Y") );
        $month = str_replace($persian, $num, jdate("m") );
        $day = str_replace($persian, $num, jdate("j") );
        
        ?>
        
        
        <!--Date-->
        <label for="date"></label>
        <select id="day" name="TT_day" style="border: 1px solid #aaa;border-radius: 3px;height: 35px;width: 70px;font-family:IRANSansWeb">
            <option value="" hidden>روز</option>
			<option value="01">1</option>
            <option value="02">2</option>
            <option value="03">3</option>
            <option value="04">4</option>
            <option value="05">5</option>
            <option value="06">6</option>
            <option value="07">7</option>
            <option value="08">8</option>
            <option value="09">9</option>
            <?php
            for($i=10; $i<32; $i++){
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
        </select>
        
        &nbsp;
        <select id="month" required name="TT_month" style="border: 1px solid #aaa;border-radius: 3px;height: 35px;width: 70px;font-family:IRANSansWeb">
            <option value="" hidden>ماه</option>
			<option value="01">فروردین</option>
            <option value="02">اردیبهشت</option>
            <option value="03">خرداد</option>
            <option value="04">تیر</option>
            <option value="05">مرداد</option>
            <option value="06">شهریور</option>
            <option value="07">مهر</option>
            <option value="08">آبان</option>
            <option value="09">آذر</option>
            <option value="10">دی</option>
            <option value="11">بهمن</option>
            <option value="12">اسفند</option>
        </select>

        
        &nbsp;
        <select id="year" required name="TT_year" style="border: 1px solid #aaa;border-radius: 3px;height: 35px;width: 70px;font-family:IRANSansWeb">
            <option value="" hidden>سال</option>
			<?php
                
                echo '<option value="'.$year.'">'.$year.'</option>';
                echo '<option value="'.($year+1).'">'.($year+1).'</option>';
                echo '<option value="'.($year+2).'">'.($year+2).'</option>';

            ?>
        </select>

	<a id="out_ex" href="&inroute=<?php echo $inroute_id; ?>" target="_blank"  class="page-title-action">خروجی اکسل</a>
    <br/><br/>
    <table class="wp-list-table widefat fixed striped">
        
        <thead>
            <tr>
                <th class="column-primary">نام و نام خانوادگی</th>
                <th>شماره ملی</th>
                <th>تلفن همراه</th>
                <th>تاریخ</th>
                <th>زمان</th>
                <th>شماره بلیط</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            //show all routes ------------------------
            $table = $wpdb->prefix . 'tickets';
            $get_tickets = $wpdb->get_results( $wpdb->prepare( "select * from {$table} where inroute_id=%d order by id desc limit 30" , $_GET['id']) );
            
            if( $wpdb->num_rows > 0 ){
                foreach( $get_tickets as $tickets ):
                    $date = substr($tickets->date,0,4).'/'.substr($tickets->date,4,2).'/'.substr($tickets->date,6,2);

                    echo '<tr class="is-expanded">';
                    
                        //ticket name and family
                        echo '<td>'.$tickets->pass_name .'&nbsp;'. $tickets->pass_family;
                        echo '</td>';
                        
                        //ticket melli
                        echo '<td data-colname="Ship Type">'.$tickets->pass_melli.'</td>';
                        
                        //ticket phone
                        echo '<td data-colname="Ship Type">'.$tickets->pass_phone.'</td>';
                        
                        //ticket date
                        echo '<td data-colname="Price">'.$date.'</td>';
                        
                        //ticket time
                        echo '<td data-colname="Capacity">'.$tickets->time.'</td>';
                        
                        //ticket pass
                        
                        echo '<td data-colname="Status">'.$tickets->private_pass.'</td>';
                        

                    echo '</tr>';
            endforeach;
            
            }
            else{ 
               echo '<tr>';
               echo '<td style="color:red">هیچ نتیجه ای وجود ندارد.</td>';
               echo '<td></td>';
               echo '<td></td>';
               echo '<td></td>';
               echo '<td></td>';
			   echo '<td></td>';
               echo '</tr>';
            }
            ?>
            
            
        </tbody>
        
        <tfoot>
            <tr>
                <th class="column-primary">نام و نام خانوادگی</th>
                <th>شماره ملی</th>
                <th>تلفن همراه</th>
                <th>تاریخ</th>
                <th>زمان</th>
                <th>شماره بلیط</th>
            </tr>
        </tfoot>
        
    </table>

</div>