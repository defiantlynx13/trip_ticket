<?php
/* all-routes page 
** show all route in page and we can edit or delete routes
*/

defined("ABSPATH") || exit;

global $wpdb;

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

    <h1 class="wp-heading-inline">همه سفرهای تفریحی</h1>
    <a href="admin.php?page=add-fall-inroute" class="page-title-action">افزودن سفر تفریحی </a>
    <br /><br />
    <table class="wp-list-table widefat fixed striped">
        
        <thead>
            <tr>
                <th class="column-primary">زمان</th>
                <th>اسم شناور</th>
                <th>دسته شناور</th>
                <th>قیمت</th>
                <th>ظرفیت</th>
                <th>وضعیت</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            //show all routes ------------------------
            $table = $wpdb->prefix . 'Inroutes';
            $get_routes = $wpdb->get_results( $wpdb->prepare( "select * from {$table} where fall=%d order by time" , 1) );
            
            
            
            if( $wpdb->num_rows > 0 ){
                foreach( $get_routes as $routes ):
                    
                    $table1 = $wpdb->prefix . 'trip_type';
                    $get_trip = $wpdb->get_results( $wpdb->prepare( "select * from {$table1} where id=%d" , $routes->type) );
                    foreach( $get_trip as $trip ){
                        $type = $trip->type;
                        $cat = $trip->cat;
                        $cap = $trip->capacity;
                    }
                    
                    echo '<tr class="is-expanded">';
                    
                        //inroute begining
                        echo '<td class="column-primary" data-colname="Begining">'.$routes->time;
                        echo '<div class="row-actions">';
						echo '<span><a href="admin.php?page=saved-fall-inroutes&id='.$routes->id.'" style="color:green">بلیط های ثبت شده</a></span>&nbsp;&nbsp;';
                        echo '<span><a href="admin.php?page=all-fall-inroutes&action=delete&id='.$routes->id.'&nonce='.wp_create_nonce('delete').'" onclick="return confirm(\'با حذف زیرمسیر، تمامی بلیط های آن نیز حذف خواهد شد. آیا مطمئن هستید؟\')" style="color:red">حذف</a></span>';
                        echo '&nbsp;&nbsp;<span><a href="admin.php?page=edit-fall-inroute&action=edit&id='.$routes->id.'">ویرایش</a></span>';
                        echo '</div>';
                        echo '</td>';
                        
                        //inroute type
                        echo '<td data-colname="Ship Type">'.$type.'</td>';
                        
                        //inroute cat
                        echo '<td data-colname="Ship Type">'.$cat.'</td>';
                        
                        //inroute price
                        echo '<td data-colname="Price">'.$routes->price.'</td>';
                        
                        //inroute capacity
                        echo '<td data-colname="Capacity">'.$cap.'</td>';
                        
                        //inroute capacity
                        if( $routes->status == 1 ){
                            echo '<td data-colname="Status" style="color:green">فعال</td>';
                        }else{
                            echo '<td data-colname="Status" style="color:red">غیرفعال</td>';
                        }

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
                <th class="column-primary">زمان</th>
                <th>اسم شناور</th>
                <th>دسته شناور</th>
                <th>قیمت</th>
                <th>ظرفیت</th>
                <th>وضعیت</th>
            </tr>
        </tfoot>
        
    </table>

</div>