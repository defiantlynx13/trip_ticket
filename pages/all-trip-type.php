<?php
/* all-routes page 
** show all route in page and we can edit or delete routes
*/

defined("ABSPATH") || exit;

global $wpdb;

if( isset( $_GET['action'] ) && $_GET['action'] == 'delete' && current_user_can('administrator') ){
    if( wp_verify_nonce( $_GET['nonce'] , 'delete') ){
        
        $table1 = $wpdb->prefix . 'trip_type';
        //delete route
        $del_tripe_type = $wpdb->delete($table1 , array(
            'id' => sanitize_text_field($_GET['id'])
            ));
            
        
        wp_redirect(admin_url(). 'admin.php?page=all-trip-type');
        
    }
}


?>

<div class="wrap">

    <h1 class="wp-heading-inline">همه شناورها</h1>
    <a href="admin.php?page=add-trip-type" class="page-title-action">افزودن شناور</a>
    <br /><br />
    <table class="wp-list-table widefat fixed striped">
        
        <thead>
            <tr>
                <th>اسم شناور</th>
                <th>دسته شناور</th>
                <th>ظرفیت شناور</th>
                <th>وضعیت</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            //show all routes ------------------------
            $table = $wpdb->prefix . 'trip_type';
            $get_trip_type = $wpdb->get_results( "select * from {$table} order by id desc");
            
            if( $wpdb->num_rows > 0 ){
                foreach( $get_trip_type as $trip_type ):
                    
                    echo '<tr>';
                    
                        //trip type
                        echo '<td><strong>'.$trip_type->type;
                        echo '<div class="row-actions">';
                        echo '<span><a href="admin.php?page=all-trip-type&action=delete&id='.$trip_type->id.'&nonce='.wp_create_nonce('delete').'" onclick="return confirm(\'آیا مطمئن هستید این شناور حذف شود؟\')" style="color:red">حذف</a></span>';
                        echo '&nbsp;&nbsp;<span><a href="admin.php?page=edit-trip-type&action=edit&id='.$trip_type->id.'">ویرایش</a></span>';
                        echo '</div>';
                        echo '</strong></td>';
                        
                        //trip cat
                        echo '<td><strong>'.$trip_type->cat.'</strong></td>';
                        
                        //trip capacity
                        echo '<td><strong>'.$trip_type->capacity.'</strong></td>';
                        
                        //trip status
                        if( $trip_type->status == 1 ){
                            $status = '<span style="color:green">فعال</span>';
                        }else{
                            $status = '<span style="color:red">غیرفعال</span>';
                        }
                        echo '<td><strong>'.$status.'</strong></td>';

                    echo '</tr>';
            endforeach;
            
            }
            else{ 
               echo '<tr>';
               echo '<td>هیچ موردی وجود ندارد.</td>';
               echo '<td></td>';
               echo '<td></td>';
               echo '<td></td>';
               echo '</tr>';
            }
            ?>
            
            
        </tbody>
        
        <tfoot>
            <tr>
                <th>اسم شناور</th>
                <th>دسته شناور</th>
                <th>ظرفیت شناور</th>
                <th>وضعیت</th>
            </tr>
        </tfoot>
        
    </table>

</div>