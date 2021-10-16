<?php
/* all-routes page 
** show all route in page and we can edit or delete routes
*/

defined("ABSPATH") || exit;

global $wpdb;

if( isset( $_GET['action'] ) && $_GET['action'] == 'delete' && current_user_can('administrator') ){
    if( wp_verify_nonce( $_GET['nonce'] , 'delete') ){
        
        $table = $wpdb->prefix . 'discount';
        //delete route
        $del_discount = $wpdb->delete($table , array(
            'id' => sanitize_text_field($_GET['id'])
            ));
            
        if( $del_discount ){
            wp_redirect(admin_url(). 'admin.php?page=all-discount');
        }
    }
}


?>

<div class="wrap">

    <h1 class="wp-heading-inline">همه تخفیف ها</h1>
    <a href="admin.php?page=add-discount" class="page-title-action">افزودن تخفیف</a>
    <br /><br />
    <table class="wp-list-table widefat fixed striped">
        
        <thead>
            <tr>
                <th>کد تخفیف</th>
                <th>درصد</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            //show all routes ------------------------
            $table = $wpdb->prefix . 'discount';
            $get_discount = $wpdb->get_results( "select * from {$table}");
            
            if( $wpdb->num_rows > 0 ){
                foreach( $get_discount as $discount ):
                    
                    echo '<tr>';
                    
                        //route first
                        echo '<td><strong>'.$discount->code;
                        echo '<div class="row-actions">';
                        echo '<span><a href="admin.php?page=all-discount&action=delete&id='.$discount->id.'&nonce='.wp_create_nonce('delete').'" onclick="return confirm(\'آیا مطمئن هستید؟\')" style="color:red">حذف</a></span>';
                        echo '</div>';
                        echo '</strong></td>';
                        
                        //route end
                        echo '<td><strong>'.$discount->percent.'</strong></td>';

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
                <th>کد تخفیف</th>
                <th>درصد</th>
            </tr>
        </tfoot>
        
    </table>

</div>