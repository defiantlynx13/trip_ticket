<?php
/* settings page 
** show all settings for this plugin
*/

defined("ABSPATH") || exit;

global $wpdb;

$user = wp_get_current_user();

if( isset( $_POST['tt_settings_submit'] ) ){
    
    $merchent = sanitize_text_field( $_POST['tt_merchent_zarinpal'] );
    
    //age management
    $nozad_bottom = sanitize_text_field( $_POST['nozad_age_bottom'] );
    $nozad_top = sanitize_text_field( $_POST['nozad_age_top'] );
    $koodak_bottom = sanitize_text_field( $_POST['koodak_age_bottom'] );
    $koodak_top = sanitize_text_field( $_POST['koodak_age_top'] );
    $bozorg_bottom = sanitize_text_field( $_POST['bozorg_age_bottom'] );
    $bozorg_top = sanitize_text_field( $_POST['bozorg_age_top'] );
    
    //ticket page
    $print_desc1 = sanitize_text_field( $_POST['tt_print_page_desc1'] );
    $print_desc2 = sanitize_text_field( $_POST['tt_print_page_desc2'] );
    $print_desc3 = sanitize_text_field( $_POST['tt_print_page_desc3'] );
    
    //panel desc
    $panel_desc1 = sanitize_text_field( $_POST['tt_panel_desc1'] );
    $panel_desc2 = sanitize_text_field( $_POST['tt_panel_desc2'] );
    $panel_desc3 = sanitize_text_field( $_POST['tt_panel_desc3'] );
    $panel_desc4 = sanitize_text_field( $_POST['tt_panel_desc4'] );
    $panel_desc5 = sanitize_text_field( $_POST['tt_panel_desc5'] );
    $panel_desc6 = sanitize_text_field( $_POST['tt_panel_desc6'] );
    
    //panel desc color
    $panel_color1 = sanitize_text_field( $_POST['tt_panel_color1'] );
    $panel_color2 = sanitize_text_field( $_POST['tt_panel_color2'] );
    $panel_color3 = sanitize_text_field( $_POST['tt_panel_color3'] );
    $panel_color4 = sanitize_text_field( $_POST['tt_panel_color4'] );
    $panel_color5 = sanitize_text_field( $_POST['tt_panel_color5'] );
    $panel_color6 = sanitize_text_field( $_POST['tt_panel_color6'] );
    
    //panel email sms
    // $email_print = sanitize_text_field( $_POST['tt_email_text_print_ticket'] );
    $phone_sms = sanitize_text_field( $_POST['tt_phone_sms'] );
    
    update_option( 'tt_merchent' , $merchent );
    
    //add age option
    update_option( 'tt_nozad_age_bottom' , $nozad_bottom );
    update_option( 'tt_nozad_age_top' , $nozad_top );
    update_option( 'tt_koodak_age_bottom' , $koodak_bottom );
    update_option( 'tt_koodak_age_top' , $koodak_top );
    update_option( 'tt_bozorg_age_bottom' , $bozorg_bottom );
    update_option( 'tt_bozorg_age_top' , $bozorg_top );
    
    //add print page option
    update_option( 'tt_print_page_desc1' , $print_desc1 );
    update_option( 'tt_print_page_desc2' , $print_desc2 );
    update_option( 'tt_print_page_desc3' , $print_desc3 );
    
    //add panel option
    update_option( 'tt_panel_desc1' , $panel_desc1 );
    update_option( 'tt_panel_desc2' , $panel_desc2 );
    update_option( 'tt_panel_desc3' , $panel_desc3 );
    update_option( 'tt_panel_desc4' , $panel_desc4 );
    update_option( 'tt_panel_desc5' , $panel_desc5 );
    update_option( 'tt_panel_desc6' , $panel_desc6 );
    
    //add panel desc color
    update_option( 'tt_panel_color1' , $panel_color1 );
    update_option( 'tt_panel_color2' , $panel_color2 );
    update_option( 'tt_panel_color3' , $panel_color3 );
    update_option( 'tt_panel_color4' , $panel_color4 );
    update_option( 'tt_panel_color5' , $panel_color5 );
    update_option( 'tt_panel_color6' , $panel_color6 );
    
    //add email sms options
    // update_option( 'tt_email_text_print_ticket' , $email_print );
	update_user_meta( $user->ID, 'phone', $phone_sms );
    
}

?>
<div class="wrap">
    
    <h1 class="wp-heading-inline">تنظیمات افزونه</h1>
    
    
    <form action="" method="post">
        
        <table class="form-table">
            <tbody>
                
                <tr>
                    <th>
                        مرچنت کد زرین پال
                    </th>
                    <td>
                        <input type="text" class="regular-text" name="tt_merchent_zarinpal" value="<?php echo get_option('tt_merchent'); ?>" />
                        <p class="description">قطعه کد 32 رقمی که پس از ثبت سایت در زرین پال و تایید آن، به شما داده می شود. </p>
                    </td>
                </tr>

            </tbody>
        </table>
        <br>
        <hr>
        <h2 class="title"> مدیریت نوع مسافر </h2>
        
        <table class="form-table">
            <tbody>
                
                <tr>
                    <th>
                        سن نوزاد
                    </th>
                    <td style="font-size:14px !important;">از
                        <select style="width:50px;margin-left:10px;margin-right:10px;" name="nozad_age_bottom">
                            <?php
                            
                            for( $i=0; $i<10 ; $i++ ){
                                if( $i == get_option('tt_nozad_age_bottom') ){
                                    $selected = 'selected="selected"';
                                }else{
                                    $selected = null;
                                }
                                echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                            }
                            
                            ?>
                        </select>
                        
                        تا
                        
                        <select style="width:50px;margin-right:10px;" name="nozad_age_top">
                            <?php
                            
                            for( $i=0; $i<10 ; $i++ ){
                                if( $i == get_option('tt_nozad_age_top') ){
                                    $selected = 'selected="selected"';
                                }else{
                                    $selected = null;
                                }
                                echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                            }
                            
                            ?>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        سن کودک
                    </th>
                    <td style="font-size:14px !important;">از
                        <select style="width:50px;margin-left:10px;margin-right:10px;" name="koodak_age_bottom">
                            <?php
                            
                            for( $i=3; $i<15 ; $i++ ){
                                if( $i == get_option('tt_koodak_age_bottom') ){
                                    $selected = 'selected="selected"';
                                }else{
                                    $selected = null;
                                }
                                echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                            }
                            
                            ?>
                        </select>
                        
                        تا
                        
                        <select style="width:50px;margin-right:10px;" name="koodak_age_top">
                            <?php
                            
                            for( $i=3; $i<15 ; $i++ ){
                                if( $i == get_option('tt_koodak_age_top') ){
                                    $selected = 'selected="selected"';
                                }else{
                                    $selected = null;
                                }
                                echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                            }
                            
                            ?>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <th>
                        سن بزرگسال
                    </th>
                    <td style="font-size:14px !important;">از
                        <select style="width:50px;margin-left:10px;margin-right:10px;" name="bozorg_age_bottom">
                            <?php
                            
                            for( $i=7; $i<15 ; $i++ ){
                                if( $i == get_option('tt_bozorg_age_bottom') ){
                                    $selected = 'selected="selected"';
                                }else{
                                    $selected = null;
                                }
                                echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                            }
                            
                            ?>
                        </select>
                        
                        تا
                        
                        <select style="width:50px;margin-right:10px;" name="bozorg_age_top">
                            <?php
                            
                            for( $i=70; $i<120 ; $i++ ){
                                if( $i == get_option('tt_bozorg_age_top') ){
                                    $selected = 'selected="selected"';
                                }else{
                                    $selected = null;
                                }
                                echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                            }
                            
                            ?>
                        </select>
                    </td>
                </tr>

            </tbody>
        </table>
        <br>
        <hr>
        <h2 class="title"> توضیحات صفحه بلیط </h2>
        
        <table class="form-table">
            <tbody>
                
                <tr>
                    <th>
                        توضیح اول
                    </th>
                    <td>
                        <input type="text" class="regular-text" name="tt_print_page_desc1" value="<?php echo get_option('tt_print_page_desc1'); ?>" />
                        
                    </td>
                </tr>
                
                <tr>
                    <th>
                        توضیح دوم
                    </th>
                    <td>
                        <input type="text" class="regular-text" name="tt_print_page_desc2" value="<?php echo get_option('tt_print_page_desc2'); ?>" />
                        
                    </td>
                </tr>
                
                <tr>
                    <th>
                        توضیح سوم
                    </th>
                    <td>
                        <input type="text" class="regular-text" name="tt_print_page_desc3" value="<?php echo get_option('tt_print_page_desc3'); ?>" />
                        
                    </td>
                </tr>

            </tbody>
        </table>
        <br>
        <hr>
        <h2 class="title"> توضیحات ورودی پنل </h2>
        
        <table class="form-table">
            <tbody>
                
                <tr>
                    <th>
                        متن توضیح اول
                    </th>
                    <td>
                        <input type="text" class="regular-text" name="tt_panel_desc1" value="<?php echo get_option('tt_panel_desc1'); ?>" />
                        <select name="tt_panel_color1">
                            <option value="#4086AA" <?php if( get_option('tt_panel_color1') == '#4086AA' ){ echo 'selected="selected"'; } ?>>آبی پر رنگ</option>
                            <option value="#91C3DC" <?php if( get_option('tt_panel_color1') == '#91C3DC' ){ echo 'selected="selected"'; } ?>>آبی کم رنگ</option>
                            <option value="#87907D" <?php if( get_option('tt_panel_color1') == '#87907D' ){ echo 'selected="selected"'; } ?>>سبز پررنگ</option>
                            <option value="#AAB6A2" <?php if( get_option('tt_panel_color1') == '#AAB6A2' ){ echo 'selected="selected"'; } ?>>سبز کم رنگ</option>
                            <option value="#555555" <?php if( get_option('tt_panel_color1') == '#555555' ){ echo 'selected="selected"'; } ?>>سیاه پر رنگ</option>
                            <option value="#666666" <?php if( get_option('tt_panel_color1') == '#666666' ){ echo 'selected="selected"'; } ?>>سیاه کم رنگ</option>
                            <option value="#FF3333" <?php if( get_option('tt_panel_color1') == '#FF3333' ){ echo 'selected="selected"'; } ?>>قرمز</option>
                        </select>
                        
                    </td>
                </tr>
                
                <tr>
                    <th>
                        توضیح دوم
                    </th>
                    <td>
                        <input type="text" class="regular-text" name="tt_panel_desc2" value="<?php echo get_option('tt_panel_desc2'); ?>" />
                        <select name="tt_panel_color2">
                            <option value="#4086AA" <?php if( get_option('tt_panel_color2') == '#4086AA' ){ echo 'selected="selected"'; } ?>>آبی پر رنگ</option>
                            <option value="#91C3DC" <?php if( get_option('tt_panel_color2') == '#91C3DC' ){ echo 'selected="selected"'; } ?>>آبی کم رنگ</option>
                            <option value="#87907D" <?php if( get_option('tt_panel_color2') == '#87907D' ){ echo 'selected="selected"'; } ?>>سبز پررنگ</option>
                            <option value="#AAB6A2" <?php if( get_option('tt_panel_color2') == '#AAB6A2' ){ echo 'selected="selected"'; } ?>>سبز کم رنگ</option>
                            <option value="#555555" <?php if( get_option('tt_panel_color2') == '#555555' ){ echo 'selected="selected"'; } ?>>سیاه پر رنگ</option>
                            <option value="#666666" <?php if( get_option('tt_panel_color2') == '#666666' ){ echo 'selected="selected"'; } ?>>سیاه کم رنگ</option>
                            <option value="#FF3333" <?php if( get_option('tt_panel_color2') == '#FF3333' ){ echo 'selected="selected"'; } ?>>قرمز</option>
                        </select>
                        
                    </td>
                </tr>
                
                <tr>
                    <th>
                        توضیح سوم
                    </th>
                    <td>
                        <input type="text" class="regular-text" name="tt_panel_desc3" value="<?php echo get_option('tt_panel_desc3'); ?>" />
                        <select name="tt_panel_color3">
                            <option value="#4086AA" <?php if( get_option('tt_panel_color3') == '#4086AA' ){ echo 'selected="selected"'; } ?>>آبی پر رنگ</option>
                            <option value="#91C3DC" <?php if( get_option('tt_panel_color3') == '#91C3DC' ){ echo 'selected="selected"'; } ?>>آبی کم رنگ</option>
                            <option value="#87907D" <?php if( get_option('tt_panel_color3') == '#87907D' ){ echo 'selected="selected"'; } ?>>سبز پررنگ</option>
                            <option value="#AAB6A2" <?php if( get_option('tt_panel_color3') == '#AAB6A2' ){ echo 'selected="selected"'; } ?>>سبز کم رنگ</option>
                            <option value="#555555" <?php if( get_option('tt_panel_color3') == '#555555' ){ echo 'selected="selected"'; } ?>>سیاه پر رنگ</option>
                            <option value="#666666" <?php if( get_option('tt_panel_color3') == '#666666' ){ echo 'selected="selected"'; } ?>>سیاه کم رنگ</option>
                            <option value="#FF3333" <?php if( get_option('tt_panel_color3') == '#FF3333' ){ echo 'selected="selected"'; } ?>>قرمز</option>
                        </select>
                        
                    </td>
                </tr>
                
                <tr>
                    <th>
                        توضیح چهارم
                    </th>
                    <td>
                        <input type="text" class="regular-text" name="tt_panel_desc4" value="<?php echo get_option('tt_panel_desc4'); ?>" />
                        <select name="tt_panel_color4">
                            <option value="#4086AA" <?php if( get_option('tt_panel_color4') == '#4086AA' ){ echo 'selected="selected"'; } ?>>آبی پر رنگ</option>
                            <option value="#91C3DC" <?php if( get_option('tt_panel_color4') == '#91C3DC' ){ echo 'selected="selected"'; } ?>>آبی کم رنگ</option>
                            <option value="#87907D" <?php if( get_option('tt_panel_color4') == '#87907D' ){ echo 'selected="selected"'; } ?>>سبز پررنگ</option>
                            <option value="#AAB6A2" <?php if( get_option('tt_panel_color4') == '#AAB6A2' ){ echo 'selected="selected"'; } ?>>سبز کم رنگ</option>
                            <option value="#555555" <?php if( get_option('tt_panel_color4') == '#555555' ){ echo 'selected="selected"'; } ?>>سیاه پر رنگ</option>
                            <option value="#666666" <?php if( get_option('tt_panel_color4') == '#666666' ){ echo 'selected="selected"'; } ?>>سیاه کم رنگ</option>
                            <option value="#FF3333" <?php if( get_option('tt_panel_color4') == '#FF3333' ){ echo 'selected="selected"'; } ?>>قرمز</option>
                        </select>
                        
                    </td>
                </tr>
                
                <tr>
                    <th>
                        توضیح پنجم
                    </th>
                    <td>
                        <input type="text" class="regular-text" name="tt_panel_desc5" value="<?php echo get_option('tt_panel_desc5'); ?>" />
                        <select name="tt_panel_color5">
                            <option value="#4086AA" <?php if( get_option('tt_panel_color5') == '#4086AA' ){ echo 'selected="selected"'; } ?>>آبی پر رنگ</option>
                            <option value="#91C3DC" <?php if( get_option('tt_panel_color5') == '#91C3DC' ){ echo 'selected="selected"'; } ?>>آبی کم رنگ</option>
                            <option value="#87907D" <?php if( get_option('tt_panel_color5') == '#87907D' ){ echo 'selected="selected"'; } ?>>سبز پررنگ</option>
                            <option value="#AAB6A2" <?php if( get_option('tt_panel_color5') == '#AAB6A2' ){ echo 'selected="selected"'; } ?>>سبز کم رنگ</option>
                            <option value="#555555" <?php if( get_option('tt_panel_color5') == '#555555' ){ echo 'selected="selected"'; } ?>>سیاه پر رنگ</option>
                            <option value="#666666" <?php if( get_option('tt_panel_color5') == '#666666' ){ echo 'selected="selected"'; } ?>>سیاه کم رنگ</option>
                            <option value="#FF3333" <?php if( get_option('tt_panel_color5') == '#FF3333' ){ echo 'selected="selected"'; } ?>>قرمز</option>
                        </select>
                        
                    </td>
                </tr>
                
                <tr>
                    <th>
                        توضیح ششم
                    </th>
                    <td>
                        <input type="text" class="regular-text" name="tt_panel_desc6" value="<?php echo get_option('tt_panel_desc6'); ?>" />
                        <select name="tt_panel_color6">
                            <option value="#4086AA" <?php if( get_option('tt_panel_color6') == '#4086AA' ){ echo 'selected="selected"'; } ?>>آبی پر رنگ</option>
                            <option value="#91C3DC" <?php if( get_option('tt_panel_color6') == '#91C3DC' ){ echo 'selected="selected"'; } ?>>آبی کم رنگ</option>
                            <option value="#87907D" <?php if( get_option('tt_panel_color6') == '#87907D' ){ echo 'selected="selected"'; } ?>>سبز پررنگ</option>
                            <option value="#AAB6A2" <?php if( get_option('tt_panel_color6') == '#AAB6A2' ){ echo 'selected="selected"'; } ?>>سبز کم رنگ</option>
                            <option value="#555555" <?php if( get_option('tt_panel_color6') == '#555555' ){ echo 'selected="selected"'; } ?>>سیاه پر رنگ</option>
                            <option value="#666666" <?php if( get_option('tt_panel_color6') == '#666666' ){ echo 'selected="selected"'; } ?>>سیاه کم رنگ</option>
                            <option value="#FF3333" <?php if( get_option('tt_panel_color6') == '#FF3333' ){ echo 'selected="selected"'; } ?>>قرمز</option>
                        </select>
                        
                    </td>
                </tr>

            </tbody>
        </table>
        
        
        <br>
        <hr>
        <h2 class="title">تلفن مدیر جهت پیامک </h2>
        
        <table class="form-table">
            <tbody>
                
                
                
                <tr>
                    <th>
                        شماره تلفن
                    </th>
                    <td>
                        <input type="text" class="regular-text" name="tt_phone_sms" value="<?php echo get_user_meta( $user->ID, 'phone', true ); ?>" />
                        <p class="description">شماره تلفن جهت ارسال پیامک به آن</p>
                    </td>
                </tr>

            </tbody>
        </table>
        
        
        
        <p class="submit">
            <input class="button button-primary" type="submit" name="tt_settings_submit" value="ذخیره تنظیمات" />
        </p>
        
    </form>
    
</div>