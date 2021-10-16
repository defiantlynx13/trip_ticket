<?php

defined("ABSPATH") || exit;

add_shortcode('TT_basket' , 'TT_basket_function');

function TT_basket_function(){ 




if( $_SESSION['beforeBasket']['route_id'] == 0 ){
    unset($_SESSION['expire']);
}

if( isset( $_SESSION['expire'] ) && time() > $_SESSION['expire'] ){
	echo 'Hello';
    unset($_SESSION['basket']);
    $_SESSION['basket']=array();

}

if ( isset($_GET['index']) && wp_verify_nonce($_GET['nonce'], 'index') ){
    $index = sanitize_text_field($_GET['index']);
    unset ( $_SESSION['basket'][ $index ] );
    wp_redirect(home_url(). '/tt_basket');
    exit;
}


global $wpdb;
$user = wp_get_current_user();

require_once( plugin_dir_path(__FILE__) . 'sidebar.php' ); ?>
    
    <div style="width:75%;float:right">
        
        <?php
        if( isset($_POST['add_to_cart_log']) ){
			
			$name = sanitize_text_field( $_POST['tt_name'] );
			$family = sanitize_text_field( $_POST['tt_family'] );
			$melli = sanitize_text_field( $_POST['tt_melli'] );
			$email = sanitize_text_field( $_POST['tt_email'] );
			$mobile = sanitize_text_field( $_POST['tt_mobile'] );

			$day = sanitize_text_field( $_POST['tt_day'] );
			$month = sanitize_text_field( $_POST['tt_month'] );
			$year = sanitize_text_field( $_POST['tt_year'] );

			$birthday = $year.$month.$day;

			if( $_SESSION['beforeBasket']['route_id'] !== 0 ){
				$begining = sanitize_text_field( $_POST['tt_begining'] );
				$destination = sanitize_text_field( $_POST['tt_destination'] );
				$in_begining = sanitize_text_field( $_POST['tt_in_begining'] );
				$in_destination = sanitize_text_field( $_POST['tt_in_destination'] );
			}else{
				$begining = 0;
				$destination = 0;
				$in_begining = 0;
				$in_destination = 0;
			}

			$capacity = sanitize_text_field( $_POST['tt_capacity'] );
			$price = sanitize_text_field( $_POST['tt_price'] );
			$pass_id = 0;
			$route_id = sanitize_text_field( $_POST['tt_route_id'] );
			$inroute_id = sanitize_text_field( $_POST['tt_in_route_id'] );

			$type = sanitize_text_field( $_POST['tt_type'] );
			$type_id = sanitize_text_field( $_POST['tt_type_id'] );
			$cat = sanitize_text_field( $_POST['tt_cat'] );
			$date = sanitize_text_field( $_POST['tt_date'] );
			$time = sanitize_text_field( $_POST['tt_time'] );
			$number = sanitize_text_field( $_POST['tt_number'] );

			if( !isset($_SESSION['basket']) ){
                $_SESSION['basket'] = array();
            }

			$_SESSION['basket'][] = array(
				$name,
				$family,
				$melli,
				$begining,
				$destination,
				$in_begining,
				$in_destination,
				$capacity,
				$price,
				$pass_id,
				$route_id,
				$inroute_id,
				$type,
				$date,
				$time,
				$number,
				$email,
				$mobile,
				$birthday,
				$cat,
				$type_id
				);

				
		}
        else if( isset($_POST['add_to_cart']) ){
            
            $melli = sanitize_text_field( $_POST['tt_melli'] );
            $name = sanitize_text_field( $_POST['tt_name'] );
            $family = sanitize_text_field( $_POST['tt_family'] );
            $price = sanitize_text_field( $_POST['tt_price'] );
            $pass_id = sanitize_text_field( $_POST['pass_id'] );
            $number = sanitize_text_field( $_POST['tt_number'] );
        
                    
                    $route_id = $_SESSION['beforeBasket']['route_id'];
                    
                    $inroute_id = $_SESSION['beforeBasket']['inroute_id'];
                    
                    $date = $_SESSION['beforeBasket']['date'];
                    $time = $_SESSION['beforeBasket']['time'];
					$type = $_SESSION['beforeBasket']['type'];
					$capacity = $_SESSION['beforeBasket']['number'];
                    

                    $Troute = $wpdb->prefix . 'routes';
					if( $route_id !== 0 ){
						$get_route = $wpdb->get_results( $wpdb->prepare("select * from {$Troute} where id=%d" , $route_id) );
						foreach( $get_route as $route ){
							$begining = $route->begining;
							$destination = $route->destination;
						}
					}else{
						$begining = 0;
						$destination = 0;
					}
                    
                    
                    $Tinroute = $wpdb->prefix . 'Inroutes';
                    $get_inroute = $wpdb->get_results( $wpdb->prepare("select * from {$Tinroute} where id=%d" , $inroute_id) );
                    foreach( $get_inroute as $inroute ){
                        $in_begining = $inroute->begining;
                        $in_destination = $inroute->destination;
                        // $type = $inroute->type;
                    }
                    
                    $Ttype = $wpdb->prefix . 'trip_type';
                    $get_type = $wpdb->get_results( $wpdb->prepare("select * from {$Ttype} where id=%d" , $type) );
                    foreach( $get_type as $type ){
                        $capacity = $type->capacity;
                    }
            
            if( !isset($_SESSION['basket']) ){
                $_SESSION['basket'] = array();
            }
            
            foreach( $_SESSION['basket'] as $key=>$value ){
                if( $number == $value[15] ){
                    $dup = 1;
                }
                else if( $melli == $value[2] ){
                    $dup1 = 1;
                }
            }
            if( isset($dup) ){
                echo '<p style="background:#fafafa;height:40px;line-height:40px;border-right:2px solid rgba(255,23,68 ,1);padding-right:10px;">شماره صندلی تکراری می باشد <a style="margin-right:5px;color:#33b5e5;font-size:13px;" href="'.home_url().'/tt_buy">بازگشت</a></p>';
            }
            else if( isset($dup1) ){
                echo '<p style="background:#fafafa;height:40px;line-height:40px;border-right:2px solid rgba(255,23,68 ,1);padding-right:10px;">شماره ملی تکراری می باشد <a style="margin-right:5px;color:#33b5e5;font-size:13px;" href="'.home_url().'/tt_buy">بازگشت</a></p>';
            }
            else{
                $_SESSION['basket'][] = array(
					$name,
					$family,
					$melli,
					$begining,
					$destination,
					$in_begining,
					$in_destination,
					$capacity,
					$price,
					$pass_id,
					$route_id,
					$inroute_id,
					$type,
					$date,
					$time,
					$number
				);
            }
            
            
            
            // print_r($_SESSION['basket']);
            
            //set expire for session (24 hour)
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + 86400;
            
            
            
            ?>
               <?php
        }
        
        ?>
        <?php
        // echo $_SESSION['basket'][0][12]->id;
        // print_r($_SESSION['basket']);
        ?>
            
            <table class="list_table">
                
                <thead>
                    <tr>
                        <th>نام</th>
                        <th>شماره ملی</th>
                        <th>تاریخ</th>
                        <th>زمان</th>
    					<?php if( $_SESSION['beforeBasket']['route_id'] !== 0 ){
                            echo '<th>مسیر</th>';
                        }
                        ?>

                        <th>اسم شناور</th>
                        <th>قیمت</th>
                        <th>شماره صندلی</th>
                        <th></th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php
                    
                    // unset($_SESSION['basket']);
                    if( !empty($_SESSION['basket']) ){
                        foreach( $_SESSION['basket'] as $key=>$value ){ ?>
                        <tr>
                            <td><?php echo $value[0].' '.$value[1]; ?></td>
                            <td><?php echo $value[2]?></td>
                            <td><?php echo substr($value[13],0,4).'/'.substr($value[13],4,2).'/'.substr($value[13],6,2); ?></td>
                            <td><?php echo $value[14]?></td>
							<?php
							if( $_SESSION['beforeBasket']['route_id'] !== 0 ){
								echo '<td>'.$value[3].'/'.$value[5].' به '.$value[4]. '/' .$value[6].'</td>';
							}
							?>
							<?php
							if( is_user_logged_in() ){ ?>
								<td><?php echo $value[12]->cat. ' ' .$value[12]->type; ?></td>
							<?php
							}else{ ?>
								<td><?php echo $value[12]; ?>  <?php echo ' '.$value[19]; ?></td>
							<?php }

							
							?>
                            
                            <td><?php echo $value[8]?> تومان</td>
                            <td><?php echo $value[15]?></td>
                            <td><a class="delete_basket" href="<?php echo the_permalink().'?index='.$key.'&nonce='.wp_create_nonce('index'); ?>">حذف</a></td>
                        </tr>
                        <?php }  
                        } ?>
                    
                </tbody>
                
            </table>
            
            <a style="padding-right:5px;color:#4086AA;font-size: 14px;" href="<?php echo home_url(); ?>/tt_buy">+ افزودن بلیط جدید</a><br><br>
            
            <?php if( !empty($_SESSION['basket']) ){ echo '<a class="checkout_link" href="'.home_url().'/tt_checkout">تصفیه حساب </a>'; } ?>
                
        
    </div>
    
<?php
}
?>