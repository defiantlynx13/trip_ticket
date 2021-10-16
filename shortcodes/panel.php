<?php

defined("ABSPATH") || exit;

add_shortcode('TT_panel' , 'TT_panel_function');

function TT_panel_function(){

    global $wpdb;
    $table = $wpdb->prefix . 'routes';
    $table2 = $wpdb->prefix . 'Inroutes';
    $table3 = $wpdb->prefix . 'trip_type';
    
    $get_type = $wpdb->get_results("select * from {$table3}");
    
    $get_typee = $wpdb->get_results("select distinct * from {$table3}");
    
    $get_route = $wpdb->get_results("select * from {$table}");
    
    // echo do_shortcode('[auto_qrcode qrcode="Hello Mohammad" size=6 ,margin=4]');
    require_once( plugin_dir_path(__FILE__) . 'sidebar.php' ); ?>
    
    <div style="width:75%;float:left">
        
    <!--<form action="<?php //echo home_url(). '/tt_list' ;?>" method="post">-->
        
        
        <!--trip cat-->
    <!--    <label for="type">دسته شناور:</label>-->
    <!--    <select id="type" required name="TT_cat" style="border: 1px solid #aaa;border-radius: 5px;height: 35px;width: 130px;">-->
    <!--        <option value="مسافربری">مسافربری</option>-->
    <!--        <option value="کشتی تفریحی">کشتی تفریحی</option>-->
    <!--    </select>-->
        
    <!--    &nbsp;&nbsp;-->
        
        <!--trip type-->
    <!--    <label for="type">نوع شناور:</label>-->
    <!--    <select id="type" required name="TT_type" style="border: 1px solid #aaa;border-radius: 5px;height: 35px;width: 130px;">-->
    <!--        <option value="تندرو">تندرو</option>-->
    <!--        <option value="کندرو">کندرو</option>-->
    <!--    </select>-->
        
    <!--    &nbsp;&nbsp;-->
        
        <!--trip number-->
    <!--    <label for="type">تعداد بلیط:</label>-->
    <!--    <select id="type" required name="TT_cap" style="border: 1px solid #aaa;border-radius: 5px;height: 35px;width: 130px;">-->
    <!--        <?php
            
          // foreach( $get_typee as $type ){
          //      echo '<option value="'.$type->capacity.'">'.$type->capacity.'</option>';-->
          //  }-->
            
        //    ?>
            
    <!--    </select>-->
        
    <!--    &nbsp;&nbsp;-->
    <!--    <br><br>-->
        <!--begining-->
    <!--    <label for="begining">مبدا:</label>-->
    <!--    <select id="begining" required name="TT_begining" style="border: 1px solid #aaa;border-radius: 5px;height: 35px;width: 130px;">-->
            <?php
            // foreach( $get_route as $route ){
            //     echo '<option value="'.$route->begining.'">'.$route->begining.'</option>';
            // }
            ?>
    <!--    </select>-->
        
    <!--    &nbsp;&nbsp;-->
        
        <!--destination-->
    <!--    <label for="destination">مقصد:</label>-->
    <!--    <select id="destination" required name="TT_destination" style="border: 1px solid #aaa;border-radius: 5px;height: 35px;width: 130px;">-->
    <!--        <?php
            // foreach( $get_route as $route ){
            //     echo '<option value="'.$route->destination.'">'.$route->destination.'</option>';
                
            // }
            ?>
    <!--    </select>-->
        <?php
      //  $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');-->
     //   $num = range(0, 9);-->
     //   $year = str_replace($persian, $num, jdate("Y") );
     //   $month = str_replace($persian, $num, jdate("m") );
     //   $day = str_replace($persian, $num, jdate("j") );
        
        ?>
    <!--    &nbsp;&nbsp;-->
    <!--    <br><br>-->
        <!--Date-->
    <!--    <label for="date">تاریخ:</label>-->
    <!--    <select id="date" required name="TT_day" style="border: 1px solid #aaa;border-radius: 5px;height: 35px;width: 130px;">-->
    <!--        <option value="01" <?php if( $day == '01' ){ echo 'selected="selected"'; } ?>>1</option>-->
    <!--        <option value="02" <?php if( $day == '02' ){ echo 'selected="selected"'; } ?>>2</option>-->
    <!--        <option value="03" <?php if( $day == '03' ){ echo 'selected="selected"'; } ?>>3</option>-->
    <!--        <option value="04" <?php if( $day == '04' ){ echo 'selected="selected"'; } ?>>4</option>-->
    <!--        <option value="05" <?php if( $day == '05' ){ echo 'selected="selected"'; } ?>>5</option>-->
    <!--        <option value="06" <?php if( $day == '06' ){ echo 'selected="selected"'; } ?>>6</option>-->
    <!--        <option value="07" <?php if( $day == '07' ){ echo 'selected="selected"'; } ?>>7</option>-->
    <!--        <option value="08" <?php if( $day == '08' ){ echo 'selected="selected"'; } ?>>8</option>-->
    <!--        <option value="09" <?php if( $day == '09' ){ echo 'selected="selected"'; } ?>>9</option>-->
    <!--        <?php
        //   for($i=10; $i<32; $i++){-->
           //     echo '<option value="'.$i.'">'.$i.'</option>';-->
        //   }-->
            ?>-->
    <!--    </select>-->
        
    <!--    &nbsp;&nbsp;-->
    <!--    <select id="date" required name="TT_month" style="border: 1px solid #aaa;border-radius: 5px;height: 35px;width: 130px;">-->
    <!--        <option value="01" <?php if( $month == '01' ){ echo 'selected="selected"'; } ?>>فروردین</option>-->
    <!--        <option value="02" <?php if( $month == '02' ){ echo 'selected="selected"'; } ?>>اردیبهشت</option>-->
    <!--        <option value="03" <?php if( $month == '03' ){ echo 'selected="selected"'; } ?>>خرداد</option>-->
    <!--        <option value="04" <?php if( $month == '04' ){ echo 'selected="selected"'; } ?>>تیر</option>-->
    <!--        <option value="05" <?php if( $month == '05' ){ echo 'selected="selected"'; } ?>>مرداد</option>-->
    <!--        <option value="06" <?php if( $month == '06' ){ echo 'selected="selected"'; } ?>>شهریور</option>-->
    <!--        <option value="07" <?php if( $month == '07' ){ echo 'selected="selected"'; } ?>>مهر</option>-->
    <!--        <option value="08" <?php if( $month == '08' ){ echo 'selected="selected"'; } ?>>آبان</option>-->
    <!--        <option value="09" <?php if( $month == '09' ){ echo 'selected="selected"'; } ?>>آذر</option>-->
    <!--        <option value="10" <?php if( $month == '10' ){ echo 'selected="selected"'; } ?>>دی</option>-->
    <!--        <option value="11" <?php if( $month == '11' ){ echo 'selected="selected"'; } ?>>بهمن</option>-->
    <!--        <option value="12" <?php if( $month == '12' ){ echo 'selected="selected"'; } ?>>اسفند</option>-->
    <!--    </select>-->

        
    <!--    &nbsp;&nbsp;-->
    <!--    <select id="date" required name="TT_year" style="border: 1px solid #aaa;border-radius: 5px;height: 35px;width: 130px;">-->
    <!--        <?php
                
       //         echo '<option value="'.$year.'">'.$year.'</option>';-->
        //        echo '<option value="'.($year+1).'">'.($year+1).'</option>';-->
        //        echo '<option value="'.($year+2).'">'.($year+2).'</option>';-->

            ?>-->
    <!--    </select>-->
        
    <!--    &nbsp;&nbsp;-->
    <!--    <input type="submit" value="فیلتر کردن" name="TT_filter" />-->
        
    <!--</form>-->
    
    
    <p class="search_ticket"><a style="background:#87907D;box-shadow:0 0 10px #ddd;" href="<?php echo home_url(). '/tt_list';?>">جستجوی بلیط </a></p>
    
    <div style="" class="panel_desc">
        <h6>مسافر گرامی</h6>
        <p style="color:<?php echo get_option('tt_panel_color1'); ?>"><?php echo get_option('tt_panel_desc1'); ?></p>
        <p style="color:<?php echo get_option('tt_panel_color2'); ?>"><?php echo get_option('tt_panel_desc2'); ?></p>
        <p style="color:<?php echo get_option('tt_panel_color3'); ?>"><?php echo get_option('tt_panel_desc3'); ?></p>
        <p style="color:<?php echo get_option('tt_panel_color4'); ?>"><?php echo get_option('tt_panel_desc4'); ?></p>
        <p style="color:<?php echo get_option('tt_panel_color5'); ?>"><?php echo get_option('tt_panel_desc5'); ?></p>
        <p style="color:<?php echo get_option('tt_panel_color6'); ?>"><?php echo get_option('tt_panel_desc6'); ?></p>
    </div>
    
    </div>

<?php    
}
?>