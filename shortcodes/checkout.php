<?php
defined("ABSPATH") || exit;

add_shortcode('TT_checkout' , 'TT_checkout_function');

function TT_checkout_function(){ 

if( !isset( $_SESSION['beforeBasket'] ) ){
	wp_redirect( home_url() . '/tt_buy' );
	exit;
}

if( empty($_SESSION['basket']) ){
    $_SESSION['basket'] = array();
}

$_SESSION['basket'] = array_values( $_SESSION['basket'] );

if( isset( $_SESSION['expire'] ) && time() > $_SESSION['expire'] ){
    unset($_SESSION['basket']);
    $_SESSION['basket']=array();
}

global $wpdb;
$user = wp_get_current_user();

$session_array = array();
foreach( $_SESSION['basket'] as $key=>$value ){
    $session_array[] = $value[15];
}

$g_date = $_SESSION['beforeBasket']['date'];

$date = substr($g_date,0,4).'/'.substr($g_date,4,2).'/'.substr($g_date,6,2);
$time = $_SESSION['beforeBasket']['time'];
$type = $_SESSION['beforeBasket']['type'];
$data = $_SESSION['beforeBasket']['date'];

$route_id = $_SESSION['beforeBasket']['route_id'];
$inroute_id = $_SESSION['beforeBasket']['inroute_id'];

$Troute = $wpdb->prefix . 'routes';
$get_route = $wpdb->get_results( $wpdb->prepare("select * from {$Troute} where id=%d" , $route_id) );
foreach( $get_route as $route ){
	$begining = $route->begining;
	$destination = $route->destination;
}

$Tinroute = $wpdb->prefix . 'Inroutes';
$get_inroute = $wpdb->get_results( $wpdb->prepare("select * from {$Tinroute} where id=%d" , $inroute_id) );
foreach( $get_inroute as $inroute ){
	$price = $inroute->price;
	$in_begining = $inroute->begining;
	$in_destination = $inroute->destination;
	$typee = $inroute->type;
}

$Tticket = $wpdb->prefix . 'tickets';
$get_numbers = $wpdb->get_results( "select * from {$Tticket} where route_id={$route_id} and inroute_id={$inroute_id} and typer={$typee} and time='$time' and date='$data'" );

$number_array = array();
foreach( $get_numbers as $numbers ){
	$number_array[] = $numbers->number;
}
// print_r( $number_array );

if( isset($_POST['buyticket']) ){
    
$results = array_intersect ( $number_array, $session_array );
$price = sanitize_text_field( $_POST['tt_price'] );

if( !empty( $results ) ){
    
    echo '<p style="background:#fafafa;height:40px;line-height:40px;border-right:2px solid rgba(255,23,68 ,1);padding-right:10px;">متاصفانه صندلی های شماره   ';
    foreach( $results as $res ){
        echo $res .' ، ';
    }
    echo 'لحظاتی پیش رزرو شده اند. <a style="margin-right:5px;color:#33b5e5;font-size:13px;" href="'.home_url().'/tt_buy">بازگشت به صفحه خرید بلیط</a>';
    
    foreach( $results as $ress ){
        $key = array_search( $ress , $session_array);
        unset( $_SESSION['basket'][$key] );
    }
    
}else{
    
    //payment

    $MerchantID = get_option('tt_merchent'); //Required
    $Amount = $price; //Amount will be based on Toman - Required
    $Description = 'توضیحات تراکنش تستی'; // Required
    $Email = 'UserEmail@Mail.Com'; // Optional
    $Mobile = '09123456789'; // Optional
    $CallbackURL = home_url().'/tt_print_ticket'; // Required
    
    
    $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
    
    $result = $client->PaymentRequest(
    [
    'MerchantID' => $MerchantID,
    'Amount' => $Amount,
    'Description' => $Description,
    'Email' => $Email,
    'Mobile' => $Mobile,
    'CallbackURL' => $CallbackURL,
    ]
    );
    
    //Redirect to URL You can do it also by creating a form
    if ($result->Status == 100) {
        
        $rand = rand(1,1000000000000000);
        
        //change persian number to latin in now date
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $num = range(0, 9);
        
        $year = str_replace($persian, $num, jdate("Y") );
        $month = str_replace($persian, $num, jdate("m") );
        $day = str_replace($persian, $num, jdate("j") );
        
        $now = $year.$month.$day;
        
        $table = $wpdb->prefix . 'tickets';
		if( !is_user_logged_in() ){
			$user_id = 0;
		}
        foreach( $_SESSION['basket'] as $value ){
			if( !is_user_logged_in() ){
				$x = $value[20];
				$y = $value[17];
			}else{
				$x = $value[12]->id;
				if( !empty($user->phone) ){
					$y = $user->phone;
				}else{
					$y = '';
				}
				
			}
            $insert_ticket = $wpdb->insert( $table  , 
                array(
                    'user_id'  => $user->ID,
                    'pass_id'  => $value[9],
                    'route_id' => $value[10],
                    'inroute_id' => $value[11],
                    'typer' => $x,
                    'number' => $value[15],
                    'date' => $value[13],
                    'time' => $value[14],
                    'date_register' => $now,
                    'price' => $value[8],
                    'status' => 0,
                    'private_pass' => $rand,
                    'token' => $result->Authority,
					'pass_name' => $value[0],
					'pass_family' => $value[1],
					'pass_melli' => $value[2],
					'pass_phone' =>$y
                    )
            );
        }
        
        
        
    Header('Location: https://www.zarinpal.com/pg/StartPay/'.$result->Authority);
    //برای استفاده از زرین گیت باید ادرس به صورت زیر تغییر کند:
    //Header('Location: https://www.zarinpal.com/pg/StartPay/'.$result->Authority.'/ZarinGate');
    } else {
    echo'ERR: '.$result->Status;
    }
    
    
}

}
else if( isset($_POST['buytickett']) ){
	
$results = array_intersect ( $number_array, $session_array );
$price = sanitize_text_field( $_POST['tt_price'] );

if( !empty( $results ) ){
    
    echo '<p style="background:#fafafa;height:40px;line-height:40px;border-right:2px solid rgba(255,23,68 ,1);padding-right:10px;">متاصفانه صندلی های شماره   ';
    foreach( $results as $res ){
        echo $res .' ، ';
    }
    echo 'لحظاتی پیش رزرو شده اند. <a style="margin-right:5px;color:#33b5e5;font-size:13px;" href="'.home_url().'/tt_buy">بازگشت به صفحه خرید بلیط</a>';
    
    foreach( $results as $ress ){
        $key = array_search( $ress , $session_array);
        unset( $_SESSION['basket'][$key] );
    }
    
}else{
        
        $rand = rand(1,1000000000000000);
        
        //change persian number to latin in now date
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $num = range(0, 9);
        
        $year = str_replace($persian, $num, jdate("Y") );
        $month = str_replace($persian, $num, jdate("m") );
        $day = str_replace($persian, $num, jdate("j") );
        
        $now = $year.$month.$day;
        
        $table = $wpdb->prefix . 'tickets';
		if( !is_user_logged_in() ){
			$user_id = 0;
		}
        foreach( $_SESSION['basket'] as $value ){
			if( !is_user_logged_in() ){
				$x = $value[20];
				$y = $value[17];
			}else{
				$x = $value[12]->id;
				if( !empty($user->phone) ){
					$y = $user->phone;
				}else{
					$y = '';
				}
				
			}
            $insert_ticket = $wpdb->insert( $table  , 
                array(
                    'user_id'  => $user->ID,
                    'pass_id'  => $value[9],
                    'route_id' => $value[10],
                    'inroute_id' => $value[11],
                    'typer' => $x,
                    'number' => $value[15],
                    'date' => $value[13],
                    'time' => $value[14],
                    'date_register' => $now,
                    'price' => $value[8],
                    'status' => 1,
                    'private_pass' => $rand,
                    'token' => '',
					'pass_name' => $value[0],
					'pass_family' => $value[1],
					'pass_melli' => $value[2],
					'pass_phone' =>$y
                    )
            );
        }

		header( "location:".home_url()."/tt_print_ticket" );
		exit();

}

}

if( !empty($_SESSION['basket']) ){
    $count = count( $_SESSION['basket'] );
}else{
    $count = 0;
}

// print_r( $_SESSION['basket'] );
require_once( plugin_dir_path(__FILE__) . 'sidebar.php' );

?>
    
    <div style="width:75%;float:right">
        <table class="list_table" style="">
            <thead>
                
                
                <tr>
                    <th><strong>تاریخ :</strong> <span style="color:#4086AA"><?php echo $date;  ?></span></th>
                    <th><strong>زمان :</strong><span style="color:#4086AA"> <?php if( is_user_logged_in() ) { echo $time; }else{  echo $_SESSION['beforeBasket']['time']; } ?></span></th>
                    <?php
					if( $_SESSION['beforeBasket']['route_id'] !== 0 ){
					?>
					<th><strong>مسیر :</strong><span style="color:#4086AA"> <?php echo $begining; ?> به <?php echo $destination; ?></span></th>
					
				</tr>
                <tr>
                    <th><strong>مبدا :</strong> <span style="color:#4086AA"><?php echo $in_begining; ?></span></th>
                    <th><strong>مقصد :</strong><span style="color:#4086AA"> <?php echo $in_destination; ?></span></th>
					<?php
					}
					?>
                    <th><strong>تعداد بلیط :</strong> <span style="color:#4086AA"><?php echo $count; ?></span></th>
                </tr>
                
            </thead>
        </table> 
        
        
        
        <table class="list_table">
            <thead>
                
                <tr>
                    
                    <th><strong>نام</strong> </th>
                    <th><strong>نام خانوادگی</strong> </th>
                    <th><strong>شماره ملی</strong> </th>
                    <th><strong>قیمت</strong> </th>
                    <th><strong>شماره بلیط</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $_SESSION['basket'] as $key=>$value ){

                ?>
                
                <tr>
                    <td><?php echo $value[0]; ?></td>
                    <td><?php echo $value[1]; ?></td>
                    <td><?php echo $value[2]; ?></td>
                    <td><?php echo $value[8]; ?> تومان</td>
                    <td><?php echo $value[15]; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table> 
        <div class="online_pay">
            
        <p style="margin-bottom:10px"><span style="" href="" class="have-code">کد تخفیف دارید؟</span></p>
        
        <form class="discount-form" method="post">
            <input type="" name="tt_discount" class="input_code" />
            <input type="submit" name="set_discount" value="اعمال" class="submit_code" />
        </form>
        
        
            
        
        <form action="<?php the_permalink(); ?>" method="post" style="margin-top: 20px;">
        <?php
        
            if( isset( $_POST['set_discount'] ) ){
                
                $code = isset( $_POST['tt_discount'] ) ? sanitize_text_field( $_POST['tt_discount'] ) : '';
                
                $tablee = $wpdb->prefix. 'discount';
                $get_percent = $wpdb->get_results("select * from $tablee where code='{$code}'");
                if( $wpdb->num_rows > 0 ){
                    foreach( $get_percent as $percent ){
                        $percentt = $percent->percent;
                    }
                    echo '<span style="color:red;font-size:12px;display:block;margin-bottom:0px;">'.$percentt.' درصد تخفیف اعمال شد</span><br>';
                    echo '<p style="font-weight:bold;clear:both !important;font-size: 19px;">مبلغ قابل پرداخت : ' . ( ($count*$price) - (($count*$price)*($percentt/100)) );
                    echo '<input type="hidden" name="tt_price" value="'.( ($count*$price)-(($count*$price)*($percentt/100)) ).'" />';
                    
                }else{
                    
                    echo '<span style="color:red;font-size:12px;display:block;margin-bottom:0px;">چنین کدی وجود ندارد.</span><br>';
                    echo '<p style="font-weight:bold;clear:both !important;font-size: 19px;">مبلغ قابل پرداخت : ' . $count * $price;
                    echo '<input type="hidden" name="tt_price" value="'.$count*$price.'" />';
                }
            }else{
                echo '<input type="hidden" name="tt_price" value="'.$count*$price.'" />';
                echo '<p style="font-weight:bold;clear:both !important;font-size: 19px;">مبلغ قابل پرداخت : ' . $count * $price;
            }
            
            ?>
            
         تومان
        
        
        </p>
        
            
            <input type="hidden" name="tt_count" value="<?php echo $count; ?>" />
            
            
            <?php
			if( !isset($percentt) ){
				$percentt = 0;
			}
            foreach( $number_array as $array ){
            ?>
            <input type="hidden" name="tt_number[]" value='<?php echo $array; ?>' />
            <?php
            }
            
            if( ($count*$price) == 0 && $_SESSION['basket'] == null ){
                echo '<input type="submit" class="paymenter" name="buyticket" value="پرداخت آنلاین" disabled/>';
            }
			else if( ( ($count*$price)-(($count*$price)*($percentt/100)) ) == 0 && $_SESSION['basket'] !== null ){
				echo '<input type="submit" class="paymenter" name="buytickett" value="پرداخت آنلاین" />';
			}
			else if ( $_SESSION['basket'] !== null ){
				
                echo '<input type="submit" class="paymenter" name="buyticket" value="پرداخت آنلاین" />';
            }
            
            ?>
            
            
        </form>
        </div>
    </div>
    
<?php




}
?>