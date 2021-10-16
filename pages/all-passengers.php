<?php
/* all-routes page 
** show all route in page and we can edit or delete routes
*/

defined("ABSPATH") || exit;

global $wpdb;

if( isset( $_GET['action'] ) && $_GET['action'] == 'delete' && current_user_can('administrator') ){
    if( wp_verify_nonce( $_GET['nonce'] , 'delete') ){
        
        $table1 = $wpdb->prefix . 'passenger';
        //delete route
        $del_route = $wpdb->delete($table1 , array(
            'user_id' => sanitize_text_field($_GET['id'])
            ));
            
        //delete inroute
        $table2 = $wpdb->prefix . 'users';
        $del_inroute = $wpdb->delete($table2 , array(
            'id' => sanitize_text_field($_GET['id'])
            ));
            
        if( $del_route ){
            wp_redirect(admin_url(). 'admin.php?page=all-passengers');
        }
    }
}


?>

<div class="wrap">

    <h1 class="wp-heading-inline">همه مسافران</h1>
    <br /><br />
    <table class="wp-list-table widefat fixed striped">
        
        <thead>
            <tr>
                <th>نام</th>
                <th>نام خانوادگی</th>
                <th>شماره ملی</th>
                <th>شماره تماس</th>
                <th>تاریخ تولد</th>
                <th>جنسیت</th>
                <th>تاریخ عضویت</th>
                <th>وضعیت</th>
                <th>ip ثبت کننده</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            //show all routes ------------------------
            $table = $wpdb->prefix . 'passenger';
            $get_passengers = $wpdb->get_results( $wpdb->prepare("select * from {$table} where parent=%d", 0) );
            
            if( $wpdb->num_rows > 0 ){
                foreach( $get_passengers as $passengers ):
                    
                    echo '<tr>';
                    
                        //pass name
                        echo '<td><strong>'.$passengers->name;
                        echo '<div class="row-actions">';
                        echo '<span><a style="color:green" href="admin.php?page=all-in-passengers&user_id='.$passengers->user_id.'">زیرمسافران</a></span>&nbsp;&nbsp;';
                        echo '<span><a href="admin.php?page=all-passengers&action=delete&id='.$passengers->user_id.'&nonce='.wp_create_nonce('delete').'" onclick="return confirm(\'با حذف مسافر، تمامی زیرمسافران آن نیز حذف می شود. آیا مطمئن هستید؟\')" style="color:red">حذف</a></span>';
                        echo '&nbsp;&nbsp;<span><a href="admin.php?page=edit-passenger&action=edit&id='.$passengers->id.'">ویرایش</a></span>';
                        echo '</div>';
                        echo '</strong></td>';
                        
                        //pass family
                        echo '<td><strong>'.$passengers->family.'</strong></td>';

                        //pass melli
                        echo '<td><strong>'.$passengers->melli.'</strong></td>';
                        
                        //pass phone
                        echo '<td><strong>'.$passengers->phone.'</strong></td>';
                        
                        //change persian number to latin
                        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
                        $num = range(0, 9);
                        $year = str_replace($num, $persian, substr($passengers->birthday,0,4) );
                        $month = str_replace($num, $persian, substr($passengers->birthday,4,2) );
                        $day = str_replace($num, $persian, substr($passengers->birthday,6,2) );
                        
                        $birthday = $year.'/'.$month.'/'.$day;
                        
                        //pass birthday
                        echo '<td><strong>'.$birthday.'</strong></td>';
                        
                        //pass sex
                        echo '<td><strong>'.$passengers->sex.'</strong></td>';
                        
                        //pass date
                        echo '<td><strong>'.$passengers->dated.'</strong></td>';
                        
                        if( $passengers->status == 1 ){
                            $status = '<span style="color:green">فعال</span>';
                        }else{
                            $status = '<span style="color:red">غیرفعال</span>';
                        }
                        //pass status
                        echo '<td><strong>'.$status.'</strong></td>';
                        
                        //pass ip
                        echo '<td><strong>'.$passengers->ip.'</strong></td>';
                        

                    echo '</tr>';
            endforeach;
            
            }
            else{ 
               echo '<tr>';
               echo '<td>هیچ موردی وجود ندارد.</td>';
               echo '<td></td>';
               echo '<td></td>';
               echo '<td></td>';
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
                <th>نام</th>
                <th>نام خانوادگی</th>
                <th>شماره ملی</th>
                <th>شماره تماس</th>
                <th>تاریخ تولد</th>
                <th>جنسیت</th>
                <th>تاریخ عضویت</th>
                <th>وضعیت</th>
                <th>ip ثبت کننده</th>
            </tr>
        </tfoot>
        
    </table>

</div>