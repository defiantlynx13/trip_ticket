<?php

defined("ABSPATH") || exit;

add_shortcode('TT_Buy' , 'TT_Buy_function');

function TT_Buy_function(){ 

global $wpdb;
$user = wp_get_current_user();
  
if( isset( $_POST['addpass'] ) ){
    
    $melli = sanitize_text_field( $_POST['tt_melli'] );
    $phone = sanitize_text_field( $_POST['tt_phone'] );
    $name = sanitize_text_field( $_POST['tt_name'] );
    $family = sanitize_text_field( $_POST['tt_family'] );
    $birthday = sanitize_text_field( $_POST['tt_year'] ).sanitize_text_field( $_POST['tt_month'] ).sanitize_text_field( $_POST['tt_day'] );
    $sex = sanitize_text_field( $_POST['tt_sex'] );
    
    $insert_pass = $wpdb->insert($wpdb->prefix. 'passenger' , array(
        'melli'    => $melli,
        'phone'    => $phone,
        'name'     => $name,
        'family'   => $family,
        'birthday' => $birthday,
        'sex'      => $sex,
        'user_id'  => $user->ID,
        'parent'   => 1,
        'status'   => 1,
        'dated'     => jdate('Y/m/j'),
        'ip'       => $_SERVER['REMOTE_ADDR']
        ));
}

require_once( plugin_dir_path(__FILE__) . 'sidebar.php' ); ?>
    
    <div style="width:75%;float:right">
        
        <?php

        
        echo '<div style="border:1px solid #ddd;padding:20px;border-radius:5px;margin-bottom:20px;overflow:hidden;background:#fff;font-size:15px">';
        
		if( isset( $_SESSION['beforeBasket'] ) ){

            // foreach( $get_before_ticket as $before_ticket ){
                    
                    // $route_id = $before_ticket->route_id;
                    
                    // $inroute_id = $before_ticket->inroute_id;
					// print_r($_SESSION['beforeBasket']);
					$inroute_id = $_SESSION['beforeBasket']['inroute_id'];
					$route_id = $_SESSION['beforeBasket']['route_id'];
					$type = $_SESSION['beforeBasket']['type'];
					$date = $_SESSION['beforeBasket']['date'];
					$time = $_SESSION['beforeBasket']['time'];
                    
                    $Troute = $wpdb->prefix . 'routes';
					if( $route_id !== 0 ){
						$get_route = $wpdb->get_results( $wpdb->prepare("select * from {$Troute} where id=%d" , $route_id) );

						foreach( $get_route as $route ){
							$begining = $route->begining;
							$destination = $route->destination;
						}
					}
                    
                    $Tinroute = $wpdb->prefix . 'Inroutes';
                    $get_inroute = $wpdb->get_results( $wpdb->prepare("select * from {$Tinroute} where id=%d" , $inroute_id) );
                    foreach( $get_inroute as $inroute ){
                        $price = $inroute->price;
                        $in_begining = $inroute->begining;
                        $in_destination = $inroute->destination;
                        $typee = $inroute->type;
                    }
                    
                    $Ttype = $wpdb->prefix . 'trip_type';
                    $get_type = $wpdb->get_results( $wpdb->prepare("select * from {$Ttype} where id=%d" , $type) );
                    foreach( $get_type as $type ){
                        $capacity = $type->capacity;
                        $typeee = $type->type;
                        $cat = $type->cat;
                    }
                    
                    $tickets_table = $wpdb->prefix . 'tickets';
                    $get_tickets_number = $wpdb->get_results("select * from {$tickets_table} where route_id={$route_id} and inroute_id={$inroute_id} and typer={$typee} and date={$date}");
                    $num = $wpdb->num_rows;
                    
                    //ticket number off
                    $get_tickets_on = $wpdb->get_results("select * from {$tickets_table} where route_id={$route_id} and inroute_id={$inroute_id} and typer={$typee} and time='$time' and date='$date'");
                    $z = $wpdb->num_rows;
                    $array_number = array();
                    foreach( $get_tickets_on as $tickets_on ){
                        $array_number[] = $tickets_on->number;
                    }
                    
					if( $route_id !== 0 ){
						echo '<p style="font-size:15px;margin-bottom:0;margin-top:5px;width:49%;float:right;border-bottom: 1px dashed #aaa;padding-bottom: 12px;">مسیر: از <span style="color:#4086AA">'.$begining.'</span> تا <span style="color:#4086AA">'.$destination.'</span></p>';
                    	echo '<p style="font-size:15px;margin-bottom:0;margin-top:5px;width:49%;float:left;border-bottom: 1px dashed #aaa;padding-bottom: 12px;">زیرمسیر: از <span style="color:#4086AA">'.$in_begining.'</span> تا <span style="color:#4086AA">'.$in_destination.'</span></p>';
					}
                    
                    echo '<p style="font-size:15px;padding-top:10px;border-bottom: 1px dashed #aaa;padding-bottom: 12px;margin-bottom:0;margin-top:5px;width:49%;float:right">تاریخ : <span style="color:#4086AA">'.substr($date,0,4). '/' . substr($date, 4,2). '/'. substr($date, 6,2).'</span> زمان : <span style="color:#4086AA">'.$time.'</span></p>';
                    echo '<p style="font-size:15px;padding-top:10px;border-bottom: 1px dashed #aaa;padding-bottom: 12px;margin-bottom:0;margin-top:5px;width:49%;float:left">اسم شناور: <span style="color:#4086AA">'.$typeee.'</span></p>';
                    echo '<p style="font-size:15px;padding-top:10px;border-bottom: 1px dashed #aaa;padding-bottom: 12px;margin-bottom:0;margin-top:5px;width:49%;float:right">دسته شناور: <span style="color:#4086AA">'.$cat.'</span></p>';
                    echo '<p style="font-size:15px;padding-top:10px;border-bottom: 1px dashed #aaa;padding-bottom: 12px;margin-bottom:0;margin-top:5px;width:49%;float:left">ظرفیت: <span style="color:#4086AA">'.($capacity-$num).'</span></p>';
                    echo '</p>';

					if( !is_user_logged_in() ):

						$main_array = range( 1, $capacity );
						$nist = array();
						foreach( $array_number as $value ){
							$pos = array_search($value , $main_array);
							// unset( $main_array[$pos] );
							$nist[] = $main_array[$pos];
						}
						// echo array_search(36, $nist);
						?>
							
							<p class="cls" style="margin-bottom:0;margin-top:5px;width:100%;float:right;padding-bottom: 12px;padding-top:10px;"> <label>شماره صندلی : <br></label>
									<br><?php
										// print_r($main_array);
										foreach( $main_array as $main ){
											if( array_search($main, $nist, true) !== false ){
												echo '<span style="background: #ccc;padding: 5px 0px;width: 70px;border-radius: 3px;margin: 8px 0px 8px 10px;display: inline-block;text-align: center;color: #fff;">'.$main.'</span>';
											}else{
												echo '<input type="radio" id="radio'.$main.'" name="tt_number" value="'.$main.'" /><label class="numberlabel" for="radio'.$main.'">'.$main.'</label>';

											}
										}
										
										?>
							</p>

						<?php

					endif;
                    
            // }
        }else{
            echo '<span style="color:red">هیچ بلیطی انتخاب نشده است. <a href="'.home_url().'/tt_list" style="color:#4086AA;font-size:13px"> جستجوی بلیط</a><span>';
        }
        
        ?>
        
        <form action="<?php echo home_url() . '/tt_basket' ?>" method="post" style="">
            
            <?php
            
             

            if( isset($_POST['select_pass']) ){
             
            $main_array = range( 1, $capacity );
            $nist = array();
            foreach( $array_number as $value ){
                $pos = array_search($value , $main_array);
                // unset( $main_array[$pos] );
				$nist[] = $main_array[$pos];
            }
            // print_r($array_number);
            
            $pass_id = sanitize_text_field($_POST['tt_pass_id']); 
            $table = $wpdb->prefix . 'passenger';
            $get_pass = $wpdb->get_results( $wpdb->prepare("select * from {$table} where user_id=%d and id=%s", $user->ID, $pass_id) );
                
            
            
            foreach( $get_pass as $pass ){
                
                ?>
            
            <input type="hidden" name="pass_id" value="<?php echo $_POST['tt_pass_id']; ?>"/>
            
            <p style="margin-bottom:0;margin-top:5px;width:49%;float:right;border-bottom: 1px dashed #aaa;padding-bottom: 12px;padding-top:10px;">
                <label for="melli">شماره ملی:</label>
                <span style="color:#4086AA"><?php echo $pass->melli; ?></span>
                <input type="hidden" id="melli" value="<?php echo $pass->melli; ?>" name="tt_melli" style="border:none;background:#fcfcfc;color:rgba(93,64,55 ,1)" />
            </p>
            
            <p style="margin-bottom:0;margin-top:5px;width:49%;float:left;border-bottom: 1px dashed #aaa;padding-bottom: 12px;padding-top:10px;color:rgba(93,64,55 ,1)">
            <label for="type">سن:</label>
            
            <?php
            $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
            $num = range(0, 9);
            $year = str_replace($persian, $num, jdate("Y") );
            
            $birthday = substr( $pass->birthday, 0,4 );
            
            $type=$year-$birthday;
            
            if( get_option('tt_nozad_age_bottom') <= $type && $type <= get_option('tt_nozad_age_top')){
                $type="خردسال";
            }else if( get_option('tt_koodak_age_bottom') <= $type && $type <= get_option('tt_koodak_age_top') ){
                $type = "کودک";
            }else if( get_option('tt_bozorg_age_bottom') <= $type && $type <= get_option('tt_bozorg_age_top') ){
                $type= "بزرگسال";
            }
            ?>
            <span style="color:#4086AA"><?php echo $type; ?></span>
            <input type="hidden" id="type" value="<?php echo $type; ?>" style="border:none;background:#fcfcfc;" /><br>
            </p>
            
            <p style="margin-bottom:0;margin-top:5px;width:49%;float:right;border-bottom: 1px dashed #aaa;padding-bottom: 12px;padding-top:10px;">
            <label for="name">نام:</label>
            <span style="color:#4086AA"><?php echo $pass->name; ?></span>
            <input type="hidden" id="name" value="<?php echo $pass->name; ?>" name="tt_name" style="border:none;background:#fcfcfc;color:rgba(93,64,55 ,1)" />
            </p>
            
            <p style="margin-bottom:5px;margin-top:5px;width:49%;float:left;border-bottom: 1px dashed #aaa;padding-bottom: 12px;padding-top:10px;">
            <label for="family">نام خانوادگی:</label>
            <span style="color:#4086AA"><?php echo $pass->family; ?></span>
            <input type="hidden" id="family" value="<?php echo $pass->family; ?>" name="tt_family" style="border:none;background:#fcfcfc;color:rgba(93,64,55 ,1)" />
            </p>
            
            <p style="margin-bottom:0;margin-top:5px;width:100%;border-bottom: 1px dashed #aaa;padding-bottom: 12px;padding-top:10px;">
            <label for="price" style="margin-bottom: 0;margin-top: 14px;display: inline-block;">قیمت:</label>
            <span style="color:#4086AA"><?php echo $price; ?> تومان</span>
            <input type="hidden" id="price" value="<?php echo $price; ?>" name="tt_price" style="border:none;background:#fcfcfc;"/> 
            </p>
            
            <p class="cls" style="margin-bottom:0;margin-top:5px;width:100%;float:right;padding-bottom: 12px;padding-top:10px;"> <label>شماره صندلی : <br></label>
                    <br><?php

                    // foreach( $main_array as $main ){
                    //     echo '<input type="radio" id="radio'.$main.'" name="tt_number" value="'.$main.'" /><label class="numberlabel" for="radio'.$main.'">'.$main.'</label>';
                    // }

					foreach( $main_array as $main ){
						if( array_search($main, $nist, true) !== false ){
							echo '<span style="background: #ccc;padding: 5px 0px;width: 70px;border-radius: 3px;margin: 8px 0px 8px 10px;display: inline-block;text-align: center;color: #fff;">'.$main.'</span>';
						}else{
							echo '<input type="radio" id="radio'.$main.'" name="tt_number" value="'.$main.'" /><label class="numberlabel" for="radio'.$main.'">'.$main.'</label>';

						}
					}

                    
                    ?>
                
            </p>
            
            
            <p style="margin-bottom:5px;margin-top:32px;width:49%;float:left;padding:12px 0;">
                <input type="submit" name="add_to_cart" value="افزودن به سبد خرید" class="add_to_cartta" style=""/>
            </p><br>
                
                 
            <?php
                
            }
            
                    
            }
            
            ?>
            
        </form>
        
        <?php
        echo '</div>';
        // echo '<br><a href="'.home_url().'/tt_list">جستجوی بلیط</a>';
        ?>
		<?php if( is_user_logged_in() ){ ?>
        <div style="border:1px solid #ddd;border-radius:5px;padding:20px;margin:15px 0;">
			
			
			<form action="" method="post">  
				<select name="tt_pass_id" required style="font-family:IRANSansWeb;margin-bottom:15px;border: 1px solid #aaa;border-radius: 3px;height: 40px;width: 150px;margin-left:5px;" >
					<option value="" hidden>انتخاب مسافر</option>
					<?php
					$table = $wpdb->prefix . 'passenger';
					$get_pass = $wpdb->get_results( $wpdb->prepare("select * from {$table} where user_id=%d", $user->ID) );
					foreach( $get_pass as $pass ){
						echo '<option value="'.$pass->id.'">'.$pass->name.' '.$pass->family.'</option>';
					}
					
					?>
				</select>
				&nbsp;
				
				
				<input type="submit" name="select_pass" value="انتخاب" style="box-shadow:0 0 10px #ddd;height:40px;background:#87907D;font-family:IRANSansWeb;border:none;color:#fff;border-radius:3px;" /> 
				<br>
				<a href="<?php echo home_url()?>/tt_newpass" style="font-size: 13px;">+ ثبت مسافر جدید</a><br>
				
			</form> 
        </div>
        <?php }else{ ?>

			<div class="buy_log_out">

				<div class="buy_log_right">
					<div class="buy_log_right_title">خرید بلیط بدون ثبت نام</div>
					
					<div class="in_buy_log_right">
					
						<form action="<?php bloginfo('url'); ?>/tt_basket" method="post" class="newpass-sho">

            				<label for="name"><span style="color:red">*</span> نام :</label><br>
							<input type="text" name="tt_name" id="name" required placeholder="نام ..." /><br>
							
							<label for="family"><span style="color:red">*</span> نام خانوادگی :</label><br>
							<input type="text" name="tt_family" id="family" required placeholder="نام خانوادگی ..." /><br>

							<label for="melli"><span style="color:red">*</span> شماره ملی:</label><br>
							<input type="text" name="tt_melli" id="melli" required placeholder="شماره ملی ..."/><br>
							
							<label for="mobile"><span style="color:red">*</span> تلفن همراه :</label><br>
							<input type="text" name="tt_mobile" id="mobile" required placeholder="تلفن همراه ..." /><br>
							
							<label for="email"> ایمیل:</label><br>
							<input type="email" name="tt_email" id="email" placeholder="ایمیل ..."/><br>
							
							<label for="birthday"><span style="color:red">*</span> تاریخ تولد:</label><br>
							<select name="tt_day" required >
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
								
								for( $i=10 ; $i<32 ; $i++ ){
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
								
								?>
							</select>
							&nbsp;&nbsp;&nbsp;
								<select id="date" required name="tt_month" required >
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

							&nbsp;&nbsp;&nbsp;
							<select name="tt_year" required >
								<option value="" hidden>سال</option>
								<?php
								
								$persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
								$num = range(0, 9);
								$x = str_replace($persian, $num, jdate("Y") );
								
								while($x>1300){
									echo '<option value="'.$x.'">'.$x.'</option>';
									$x--;
								}
								?>
							</select>
							<br><br>
							<label for="sex"><span style="color:red">*</span> جنسیت:</label><br>
							<input type="radio" name="tt_sex" id="sex" required value="مرد"/> مرد
							&nbsp;&nbsp;&nbsp;
							<input type="radio" name="tt_sex" id="sex" value="زن"/> زن
							<br><br>
							<?php
							if( $_SESSION['beforeBasket']['route_id'] !== 0 ){ ?>
							<input type="hidden" name="tt_begining" value="<?php echo $begining; ?>" />
							<input type="hidden" name="tt_destination" value="<?php echo $destination; ?>" />
							<?php 
							}
							?>
							
							<input type="hidden" name="tt_in_begining" value="<?php echo $in_begining; ?>" />
							<input type="hidden" name="tt_in_destination" value="<?php echo $in_destination; ?>" />

							<input type="hidden" name="tt_capacity" value="<?php echo $capacity; ?>" />
							<input type="hidden" name="tt_price" value="<?php echo $price; ?>" />
							<input type="hidden" name="tt_route_id" value="<?php echo $route_id; ?>" />
							<input type="hidden" name="tt_in_route_id" value="<?php echo $inroute_id; ?>" />

							<input type="hidden" name="tt_type" value="<?php echo $typeee; ?>" />
							<input type="hidden" name="tt_cat" value="<?php echo $cat; ?>" />
							<input type="hidden" name="tt_type_id" value="<?php echo $typee; ?>" />

							<input type="hidden" name="tt_date" value="<?php echo $date; ?>" />
							<input type="hidden" name="tt_number" id ="tt_number_hidden" value="" />
							<input type="hidden" name="tt_time" value="<?php echo $time; ?>" />

							<input style="" type="submit" class="add_to_cart_log" name="add_to_cart_log" value="افزودن به سبد خرید" />
							
							
						</form>
					
					</div>
					


				</div>

				<div class="buy_log_left">
					<h6>آیا حساب کاربری دارید؟</h6>
					<p class="login_buy_log_left"><a href="<?php echo home_url() . '/tt_login'; ?>">ورود به پنل</a></p>
					<p><a href="<?php echo home_url() . '/tt_register'; ?>" style="color:#4086AA">+ ثبت نام در سایت</a></p>
				</div>

			</div>

		<?php } ?>
            
        
    
<?php
}
?>