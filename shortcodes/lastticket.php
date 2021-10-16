<?php

defined("ABSPATH") || exit;

add_shortcode('TT_lastticket' , 'TT_lastticket_function');

function TT_lastticket_function(){ 

global $wpdb;
$user = wp_get_current_user();

if( !is_user_logged_in() ){

	if( isset( $_POST['tt_print'] ) ){
	
		$melli = sanitize_text_field( $_POST['tt_melli'] );
		$phone = sanitize_text_field( $_POST['tt_phone'] );
		$number = sanitize_text_field( $_POST['tt_number'] );

		$get_ticket = $wpdb->get_results( $wpdb->prepare( "select * from {$wpdb->prefix}tickets where pass_melli=%d and pass_phone=%d and private_pass=%d" , $melli, $phone, $number ) );
		
		if( $wpdb->num_rows > 0 ){
			foreach( $get_ticket as $ticket ){
				$route_id = $ticket->route_id;
				$inroute_id = $ticket->inroute_id;
				$name = $ticket->pass_name . '%20' . $ticket->pass_family;
				$melli = $ticket->pass_melli;
				$time = $ticket->date . '%20ساعت%20' . $ticket->time;
				$number = $ticket->number;
				$pass = $ticket->private_pass;

				global $wpdb;
				$get_type = $wpdb->get_results( $wpdb->prepare("select * from {$wpdb->prefix}trip_type where id=%d" , $ticket->typer) );
				if( $wpdb->num_rows > 0 ){
					foreach( $get_type as $type ){
						$pass_type = $type->type;
						$pass_cat = $type->cat;
						if( $pass_cat == 'کشتی تفریحی' ){
							$pass_cat = 'کشتی %20 تفریحی';
						}
						$typer = $pass_type . '%20' . $pass_cat;
					}
				}

				if( $route_id !== '0' ){
					$get_route = $wpdb->get_results( $wpdb->prepare("select * from {$wpdb->prefix}routes where id=%d" , $route_id) );
					foreach( $get_route as $route ){
						$begining = $route->begining;
						$destination = $route->destination;
					}
					

					$Tinroute = $wpdb->prefix . 'Inroutes';
					$get_inroute = $wpdb->get_results( $wpdb->prepare("select * from {$Tinroute} where id=%d" , $inroute_id) );
					foreach( $get_inroute as $inroute ){
						$in_begining = $inroute->begining;
						$in_destination = $inroute->destination;
					}
					$route = $begining.'%20/'.$in_begining.'%20به%20'.$destination.'%20/'.$in_destination;
				}


			}
			if( $route_id == '0' ){
				wp_redirect( home_url() . '/tt_new_print_ticket?names='.$name.'&melli='.$melli.'&time='.$time.'&number='.$number.'&type='.$typer.'&pass='.$pass );
				exit;
			}else{
				wp_redirect( home_url() . '/tt_new_print_ticket?names='.$name.'&melli='.$melli.'&route='.$route.'&time='.$time.'&number='.$number.'&type='.$typer.'&pass='.$pass );
				exit;
			}
			
		}else{
			echo '<p style="background:#fafafa;padding:5px 10px;border-right:2px solid red">بلیط موردنظر یافت نشد. لطفا با پشتیبانی سایت تماس حاصل نمایید.</p>';
		}

	}

}


require_once( plugin_dir_path(__FILE__) . 'sidebar.php' ); ?>
    
    <div style="width:75%;float:right">    
        <?php
		if( !is_user_logged_in() ){ ?>
			
			<form action="" method="post" target="_blank">

			<p>
				<label for="melli"><span style="color:red">*</span> شماره ملی:</label><br>
				<input type="text" name="tt_melli" id="melli" placeholder="" required></p>
			<p>

			<p>
				<label for="phone"><span style="color:red">*</span> تلفن همراه:</label><br>
				<input type="text" name="tt_phone" id="phone" placeholder="" required></p>
			<p>

			<p>
				<label for="number"><span style="color:red">*</span> شماره بلیط:</label><br>
				<input type="text" name="tt_number" id="password" placeholder="" required></p>
			<p>

			<p>
			<input type="submit" name="tt_print" value="مشاهده بلیط" id="wp-submit"></p>
			<p>

			</form>

		<?php }else{
		?>
		


        <table class="list_table">
            <thead>
                <tr>
                    <th>نام</th>
                    <th>شماره ملی</th>
                    <th>تاریخ</th>
                    <th>زمان</th>
                    <th>قیمت</th>
                    <th>اسم شناور</th>
                    <th>مسیر</th>
                    <th>مبدا</th>
                    <th>مقصد</th>
                    <th>شماره صندلی</th>
                    <th>پرینت بلیط</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $id = $user->ID;
                $table = $wpdb->prefix . 'tickets';
                $get_ticket = $wpdb->get_results("select * from {$table} where user_id={$id} order by id desc");
                foreach( $get_ticket as $tickets ){

                        $route_id = $tickets->route_id;
						
                        $inroute_id = $tickets->inroute_id;

                        $pass_id = $tickets->pass_id;
                        $time = $tickets->time;
                        $date = $tickets->date;
                        $pp = $tickets->private_pass;
                        $number = $tickets->number;
						$price = $tickets->price;
                        
                        $type = $tickets->typer;
                        if( $route_id !== '0' ){
							$Troute = $wpdb->prefix . 'routes';
							$get_route = $wpdb->get_results( $wpdb->prepare("select * from {$Troute} where id=%d" , $route_id) );
							foreach( $get_route as $route ){
								$begining = $route->begining;
								$destination = $route->destination;
							}
						}else{
							$begining = null;
							$destination = null;
						}
                        
                        
                        $Tinroute = $wpdb->prefix . 'Inroutes';
                        $get_inroute = $wpdb->get_results( $wpdb->prepare("select * from {$Tinroute} where id=%d" , $inroute_id) );
                        foreach( $get_inroute as $inroute ){
                            $in_begining = $inroute->begining;
                            $in_destination = $inroute->destination;
                        }
                        
                        $Ttype = $wpdb->prefix . 'trip_type';
                        $get_type = $wpdb->get_results( $wpdb->prepare("select * from {$Ttype} where id=%d" , $type) );
                        foreach( $get_type as $type ){
                            $typee = $type->type;
                            $cat = $type->cat;
                        }
                        
                        $Tpass = $wpdb->prefix . 'passenger';
                        $get_pass = $wpdb->get_results( $wpdb->prepare("select * from {$Tpass} where id=%d" , $pass_id) );
                        foreach( $get_pass as $pass ){
                            $name = $pass->name;
                            $family = $pass->family;
                            $melli = $pass->melli;
                        }
						
                    $dates = substr($date,0,4).'/'.substr($date,4,2).'/'.substr($date,6,2);    
                    echo '<tr>';
                        echo '<td>'.$name.' '.$family.'</td>';
                        echo '<td>'.$melli.'</td>';
                        echo '<td>'.$dates.'</td>';
                        echo '<td>'.$time.'</td>';
                        echo '<td>'.$price.' تومان</td>';
                        echo '<td>'.$typee.' '.$cat.'</td>';

						if( $route_id !== '0' ){
							echo '<td>'.$begining.' به '.$destination.'</td>';
						}else{
							echo '<td>-</td>';
						}
						
                        echo '<td>'.$in_begining.'</td>';
                        echo '<td>'.$in_destination.'</td>';
                        echo '<td>'.$number.'</td>';
						if( $route_id !== '0' ){
                        	echo '<td><a style="color:#4086AA" target="_blank" href="'.home_url().'/tt_new_print_ticket?names='.$name.' '.$family.'&melli='.$melli.'&time='.$dates.' ساعت '.$time.'&number='.$number.'&type='.$typee.' '.$cat.'&route='.$begining.'/ '.$in_begining.' &nbsp;&nbsp; به &nbsp;&nbsp;'.$destination.'/ '.$in_destination.'&pass='.$pp.'">پرینت</a></td>';
						}else{
                        	echo '<td><a style="color:#4086AA" target="_blank" href="'.home_url().'/tt_new_print_ticket?names='.$name.' '.$family.'&melli='.$melli.'&time='.$dates.' ساعت '.$time.'&number='.$number.'&type='.$typee.' '.$cat.'&pass='.$pp.'">پرینت</a></td>';
						}
					echo '</tr>';
                    }
                    
                ?>
            </tbody>
        </table>

        <?php
		}
		?>
    </div>
    
<?php
}
?>