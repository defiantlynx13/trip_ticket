<?php


add_shortcode('TT_list' , 'TT_list_function');

function TT_list_function(){
    global $wpdb;
    $table = $wpdb->prefix . 'routes';
    $table2 = $wpdb->prefix . 'Inroutes';
    $table3 = $wpdb->prefix . 'trip_type';
    
    $get_route = $wpdb->get_results("select * from {$table} GROUP BY begining");

	$get_routee = $wpdb->get_results("select * from {$table} GROUP BY destination");
    
    $get_type = $wpdb->get_results("select * from {$table3}");
    
    $get_typee = $wpdb->get_results("select distinct * from {$table3} where status=1 GROUP BY capacity");

	$get_type_name = $wpdb->get_results("select distinct * from {$table3} where status=1 GROUP BY type");

	if( isset( $_POST['beforeBasket'] ) ){
		
		$inroute_id = sanitize_text_field( $_POST['inroute_id'] );
		$route_id = isset( $_POST['route_id'] ) ? sanitize_text_field( $_POST['route_id'] ) : 0 ;
		$date = sanitize_text_field( $_POST['date'] );
		$time = sanitize_text_field( $_POST['time'] );
		$type = sanitize_text_field( $_POST['type'] );
		$number = sanitize_text_field( $_POST['num'] );

		//define lastroute session

		$_SESSION['beforeBasket'] = array(
			'inroute_id' => $inroute_id,
			'route_id'   => $route_id,
			'date'       => $date,
			'time'       => $time,
			'type'       => $type,
			'number'     => $number
		);

		wp_redirect( home_url() . '/tt_buy' );
		exit;
	}
	
	

?>
    <form action="<?php the_permalink();?>" method="post" style="font-size:14px;">
        

		<!--trip type-->
        <label for="type"></label>
        <select id="type" required name="TT_type" style="border: 1px solid #aaa;border-radius: 3px;height: 40px;width: 100px;margin-left:5px;font-family:IRANSansWeb">
			<option value="" hidden>اسم شناور</option>
			<?php
            
            foreach( $get_type_name as $type ){
                echo '<option value="'.$type->type.'">'.$type->type.'</option>';
            }
            ?>
		</select>
        
        &nbsp;&nbsp;

        
        <!--trip cat-->
        <label for="type"></label>
		
        <select id="type" class="TT_cat" required name="TT_cat" style="border: 1px solid #aaa;border-radius: 3px;height: 40px;width: 120px;margin-left:5px;font-family:IRANSansWeb">
            <option value="" hidden>دسته شناور</option>
			<option value="مسافربری">مسافربری</option>
            <option value="کشتی تفریحی">کشتی تفریحی</option>
        </select>
        
        &nbsp;&nbsp;
        
        
        <!--trip number-->
        <label for="type"></label>
        <select id="type" required name="TT_cap" style="border: 1px solid #aaa;border-radius: 3px;height: 40px;width: 100px;margin-left:5px;font-family:IRANSansWeb">
            <option value="" hidden>تعداد بلیط</option>
			<?php
            
            foreach( $get_typee as $type ){
                echo '<option value="'.$type->capacity.'">'.$type->capacity.'</option>';
            }
            
            ?>
            
        </select>
        
        &nbsp;&nbsp;
        
        <!--begining-->
        <label for="begining"></label>
        <select id="begining" class="hide_beg_add_inroute" name="TT_begining" style="display:none;border: 1px solid #aaa;border-radius: 3px;height: 40px;width: 80px;margin-left:5px;font-family:IRANSansWeb">
            <option value="" hidden>مبدا</option>
			<?php
            foreach( $get_route as $route ){
                echo '<option value="'.$route->begining.'">'.$route->begining.'</option>';
            }
            ?>
        </select>
        
        &nbsp;&nbsp;
        
        <!--destination-->
        <label for="destination"></label>
        <select id="destination" class="hide_des_add_inroute" name="TT_destination" style="display:none;border: 1px solid #aaa;border-radius: 3px;height: 40px;width: 80px;margin-left:5px;font-family:IRANSansWeb">
            <option value="" hidden>مقصد</option>
			<?php
            foreach( $get_routee as $route ){
                echo '<option value="'.$route->destination.'">'.$route->destination.'</option>';
                
            }
            ?>
        </select>
        <?php

		date_default_timezone_set("Asia/Tehran");

        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $num = range(0, 9);
        $year = str_replace($persian, $num, jdate("Y") );
        $month = str_replace($persian, $num, jdate("m") );
        $day = str_replace($persian, $num, jdate("d") );
        
        ?>
        &nbsp;
        
        <!--Date-->
        <label for="date"></label>
        <select id="date" required name="TT_day" style="border: 1px solid #aaa;border-radius: 3px;height: 40px;width: 70px;font-family:IRANSansWeb">
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
            for($i=10; $i<32; $i++){
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
        </select>
        
        &nbsp;
        <select id="date" required name="TT_month" style="border: 1px solid #aaa;border-radius: 3px;height: 40px;width: 70px;font-family:IRANSansWeb">
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

        
        &nbsp;
        <select id="date" required name="TT_year" style="border: 1px solid #aaa;border-radius: 3px;height: 40px;width: 70px;font-family:IRANSansWeb">
            <option value="" hidden>سال</option>
			<?php
                
                echo '<option value="'.$year.'">'.$year.'</option>';
                echo '<option value="'.($year+1).'">'.($year+1).'</option>';
                echo '<option value="'.($year+2).'">'.($year+2).'</option>';

            ?>
        </select>
        
        &nbsp;&nbsp;
        <input type="submit" value="فیلتر کردن" name="TT_filter" class="TT_filter" style="" />
        
    </form>
    <br>
     <table style="" class="list_table">
        <thead>
            <tr>
                 <th>زمان</th>
                 <th>تاریخ</th>
                 <th>مبدا</th>
                 <th>مقصد</th>
                 <th>اسم شناور</th>
                 <th>دسته شناور</th>
                 <th>قیمت</th>
                 <th>ظرفیت</th>
                 <th>ظرفیت باقی مانده</th>
                 <th></th>
            </tr>
             
         </thead>
        
         <tbody>
             <?php
                if( isset($_POST['TT_filter']) ){
                    
                    $cat = sanitize_text_field( $_POST['TT_cat'] );
                    $type = sanitize_text_field( $_POST['TT_type'] );
                    $cap = sanitize_text_field( $_POST['TT_cap'] );
                    
					if( $cat == 'مسافربری' ){
						$begining = sanitize_text_field( $_POST['TT_begining'] );
						$destination = sanitize_text_field( $_POST['TT_destination'] );
					}

                    $tableid = $wpdb->prefix . 'trip_type';
                    $get_id = $wpdb->get_results("select * from {$tableid} where type='$type' and cat='$cat' and capacity='$cap' and status=1");
                    
                    if( $wpdb->num_rows > 0 ){
                        
                        foreach( $get_id as $idd ){
                            $trip_id = $idd->id;
                        }

						if( $cat == 'مسافربری' ){
							$get_id = $wpdb->get_results("select * from {$table} where begining='$begining' and destination='$destination'");
						}
                        
                        
                        foreach( $get_id as $id ){
                            if( isset($trip_id) ){
								if( $cat == 'مسافربری' ){
									$get_inroute = $wpdb->get_results("select * from {$table2} where route_id={$id->id} and type={$trip_id} and status=1 order by time ASC");
								}else{
									$get_inroute = $wpdb->get_results("select * from {$table2} where route_id=0 and type={$trip_id} and status=1 order by time ASC");
								}
                                
                            }   
                        }

                    }
                    
                    

                }else{
                    $get_inroute = $wpdb->get_results("select * from {$table2} where status=1 order by time limit 30");
                }
                
                if( $wpdb->num_rows > 0 ){
                    foreach( $get_inroute as $inroute ){
                        echo '<tr>';
                        	date_default_timezone_set('Asia/Tehran');

                            $date_now = $year.$month.$day;
                            
                            $time_now = date("H:i");
                        
                            echo '<td>'.$inroute->time.'</td>';
							
							if( isset($_POST['TT_filter']) ){
								$day = sanitize_text_field( $_POST['TT_day'] );
							$month = sanitize_text_field( $_POST['TT_month'] );
							$year = sanitize_text_field( $_POST['TT_year'] );
							$date = $year.$month.$day;
								echo '<td>'.substr($date,0,4).'/'.substr($date,4,2).'/'.substr($date,6,2).'</td>';
							}else{
								echo '<td>'.substr($date_now,0,4).'/'.substr($date_now,4,2).'/'.substr($date_now,6,2).'</td>';
							}

                            

                            $table_type = $wpdb->prefix . 'trip_type';
                            $get_type = $wpdb->get_results( $wpdb->prepare("select * from {$table_type} where id=%d", $inroute->type ) );
                            
                            echo '<td>';
							$get_route = $wpdb->get_results( $wpdb->prepare("select * from {$table} where id=%d", $inroute->route_id) );
							if( $wpdb->num_rows > 0 ){
								foreach( $get_route as $route ){
									$send_beg = $route->begining;
									echo $send_beg;
								}
								echo '/';
							}
 
                            echo $inroute->begining;
                            echo '</td>';
                            
                            echo '<td>';
							if( $wpdb->num_rows > 0 ){
								foreach( $get_route as $route ){
									$send_des = $route->destination;
									echo $send_des;
									$route_id = $route->id;
								}
								echo '/';
							}

                            echo $inroute->destination;
                            echo '</td>';
                            
                            foreach( $get_type as $type ){
                                $typee= $type->type;
                                $cat = $type->cat;
                                $cap = $type->capacity;
                            }
                            
                            $tickets_table = $wpdb->prefix . 'tickets';
							if( isset($_POST['TT_filter']) ){
								$get_tickets_number = $wpdb->get_results("select * from {$tickets_table} where route_id={$inroute->route_id} and inroute_id={$inroute->id} and typer={$inroute->type} and date={$date}");
								$num = $wpdb->num_rows;
							}else{
								$get_tickets_number = $wpdb->get_results("select * from {$tickets_table} where route_id={$inroute->route_id} and inroute_id={$inroute->id} and typer={$inroute->type} and date={$date_now}");
								$num = $wpdb->num_rows;
							}
                            
                            
                            echo '<td>'.$typee.'</td>';
                            echo '<td>'.$cat.'</td>';
                            echo '<td>'.$inroute->price.' تومان</td>';
                            echo '<td>'.$cap.'</td>';
                            echo '<td>'.($cap-$num).'</td>';
                            echo '<td>';
                            
                            
                            if( isset($_POST['TT_filter']) ){
								$day = sanitize_text_field( $_POST['TT_day'] );
								$month = sanitize_text_field( $_POST['TT_month'] );
								$year = sanitize_text_field( $_POST['TT_year'] );
								$date = $year.$month.$day;

								if( $date_now > $date || ( $date_now == $date && $time_now > $inroute->time ) ){
									echo '<a style="font-size:12px;background:#E91E63;padding:3px 10px;border-radius:3px;text-decoration:none;color:#fff" href="#!">غیرقابل خرید</a>';
								}else{
									?>
									<form action="" method="post">
										<input type="hidden" value="<?php echo $inroute->id; ?>" name="inroute_id" />
										<?php
										if( $cat == 'مسافربری' ){
											echo '<input type="hidden" value="'.$route_id.'" name="route_id" />';
										}
										?>
										
										<input type="hidden" value="<?php echo $date; ?>" name="date" />
										<input type="hidden" value="<?php echo $inroute->time; ?>" name="time" />
										<input type="hidden" value="<?php echo $inroute->type; ?>" name="type" />
										<input type="hidden" value="<?php echo $cap-$num; ?>" name="num" />
										<input type="submit" value="خرید بلیط" name="beforeBasket" style="" class="ticket_by_list" />
									</form>
									<?php
								}


							}else{
								if( $time_now > $inroute->time ){
									echo '<a style="font-size:12px;background:#E91E63;padding:3px 10px;border-radius:3px;text-decoration:none;color:#fff" href="#!">غیرقابل خرید</a>';
								}else{
									?>
									<form action="" method="post">
										<input type="hidden" value="<?php echo $inroute->id; ?>" name="inroute_id" />
										<?php
										if( $cat == 'مسافربری' ){
											echo '<input type="hidden" value="'.$route_id.'" name="route_id" />';
										}
										?>
										<input type="hidden" value="<?php echo $date_now; ?>" name="date" />
										<input type="hidden" value="<?php echo $inroute->time; ?>" name="time" />
										<input type="hidden" value="<?php echo $inroute->type; ?>" name="type" />
										<input type="hidden" value="<?php echo $cap-$num; ?>" name="num" />
										<input type="submit" value="خرید بلیط" name="beforeBasket" style="" class="ticket_by_list" />
									</form>
									<?php
								}
							}
                            
                            if( isset($low) && $low == 1 ){
                                
                            }
							?>
								

								
                                <?php

                            echo '</td>';
                         
                        echo '</tr>';
                    
                    }
                }else{
					echo '<tr>';
					echo '<td>موردی یافت نشد ...</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>';
					echo '</tr>';
				}
                
             ?>
             
         </tbody>
        
     </table>

<?php
    }
?>