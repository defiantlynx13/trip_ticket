<?php

defined("ABSPATH") || exit;

add_shortcode('TT_newpass' , 'TT_newpass_function');

function TT_newpass_function(){ 

if( !is_user_logged_in() ){
    wp_redirect( home_url() .'/tt_login' );
}

global $wpdb;
$user = wp_get_current_user();

require_once( plugin_dir_path(__FILE__) . 'sidebar.php' ); ?>
    
    <div style="width:75%;float:right">
        
        <form action="<?php bloginfo('url'); ?>/tt_buy" method="post" class="newpass-sho">
            
            <label for="melli">شماره ملی:</label><br>
            <input type="text" name="tt_melli" id="melli" required /><br>
            
            <label for="mobile">تلفن همراه:</label><br>
            <input type="text" name="tt_phone" id="mobile" required /><br>
            
            <label for="name">نام:</label><br>
            <input type="text" name="tt_name" id="name" required /><br>
            
            <label for="family">نام خانوادگی:</label><br>
            <input type="text" name="tt_family" id="family" required /><br>
            
            <label for="birthday">تاریخ تولد:</label><br>
            <select name="tt_day" required >
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
                
                for( $i=10 ; $i<32 ; $i++ ){
                    echo '<option value="'.$i.'">'.$i.'</option>';
                }
                
                ?>
            </select>
            &nbsp;&nbsp;&nbsp;
                <select id="date" required name="tt_month" required >
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

            &nbsp;&nbsp;&nbsp;
            <select name="tt_year" required >
                <option value="" hidden>سال</option>
                <?php
                
                $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
                $num = range(0, 9);
                $x = str_replace($persian, $num, jdate("Y") );
                
                while($x>1300){
                    echo '<option value="'.$x.'">'.$x.'</option>';
                    $x--;
                }
                ?>
            </select>
            <br><br>
            <label for="sex">جنسیت:</label><br>
            <input type="radio" name="tt_sex" id="sex" required value="مرد"/> مرد
            &nbsp;&nbsp;&nbsp;
            <input type="radio" name="tt_sex" id="sex" value="زن"/> زن
            <br><br>
            
            <input style="" type="submit" name="addpass" value="ثبت مسافر" />
            
            
        </form>
        
        
    </div>
    
<?php
}
?>