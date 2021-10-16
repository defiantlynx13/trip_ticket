<?php
/* all-routes page 
** show all route in page and we can edit or delete routes
*/

defined("ABSPATH") || exit;

global $wpdb;

if( isset( $_GET['action'] ) && $_GET['action'] == 'delete' && current_user_can('administrator') ){
    if( wp_verify_nonce( $_GET['nonce'] , 'delete') ){
        
        $table1 = $wpdb->prefix . 'routes';
        //delete route
        $del_route = $wpdb->delete($table1 , array(
            'id' => sanitize_text_field($_GET['id'])
            ));
            
        //delete inroute
        $table2 = $wpdb->prefix . 'Inroutes';
        $del_inroute = $wpdb->delete($table2 , array(
            'route_id' => sanitize_text_field($_GET['id'])
            ));
            
        //delete passengers
        // $table3 = $wpdb->prefix . 'passenger';
        // $del_inroute = $wpdb->delete($table3 , array(
        //     'route_id' => sanitize_text_field($_GET['id'])
        //     ));
            
        if( $del_route ){
            wp_redirect(admin_url(). 'admin.php?page=all-routes');
        }
    }
}


?>

<div class="wrap">

    <h1 class="wp-heading-inline">همه سفرهای مسافربری</h1>
    <a href="admin.php?page=add-route" class="page-title-action">افزودن مسیر</a>
    <br /><br />
    <table class="wp-list-table widefat fixed striped">
        
        <thead>
            <tr>
                <th>مبدا</th>
                <th>مقصد</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            //show all routes ------------------------
            $table = $wpdb->prefix . 'routes';
            $get_routes = $wpdb->get_results( "select * from {$table}");
            
            if( $wpdb->num_rows > 0 ){
                foreach( $get_routes as $routes ):
                    
                    echo '<tr>';
                    
                        //route first
                        echo '<td><strong>'.$routes->begining;
                        echo '<div class="row-actions">';
                        echo '<span><a style="color:green" href="admin.php?page=all-Inroutes&route_id='.$routes->id.'">زیرمسیرها</a></span>&nbsp;&nbsp;';
                        echo '<span><a href="admin.php?page=all-routes&action=delete&id='.$routes->id.'&nonce='.wp_create_nonce('delete').'" onclick="return confirm(\'با حذف مسیر، همه زیرمسیرها و بلیط ها حذف می شوند. آیا مطمئن هستید؟\')" style="color:red">حذف</a></span>';
                        echo '&nbsp;&nbsp;<span><a href="admin.php?page=edit-routes&action=edit&id='.$routes->id.'">ویرایش</a></span>';
                        echo '</div>';
                        echo '</strong></td>';
                        
                        //route end
                        echo '<td><strong>'.$routes->destination.'</strong></td>';

                    echo '</tr>';
            endforeach;
            
            }
            else{ 
               echo '<tr>';
               echo '<td>هیچ موردی وجود ندارد.</td>';
               echo '<td></td>';
               echo '</tr>';
            }
            ?>
            
            
        </tbody>
        
        <tfoot>
            <tr>
                <th>مبدا</th>
                <th>مقصد</th>
            </tr>
        </tfoot>
        
    </table>

</div>