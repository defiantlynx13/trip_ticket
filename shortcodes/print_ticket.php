<!doctype html>
<html>
    
    <head>
        <title>چاپ بلیط</title>
        <style>
            .print_table{
                border:1px solid #ddd;
                padding:20px;
                width:95%;
                margin:0 auto;
            }
            .print_table table{
                width:100%;
            }
            .print_table th{
                text-align:right;
                padding:10px;
            }
            .qrcode img{
                display:block;
                margin:0 auto;
            }
        </style>
    </head>

<body style="direction:rtl;text-align:right;font-family:IRANSansWeb;font-size:15px;box-sizing:border-box;">
<?php

defined("ABSPATH") || exit;

if( isset( $_SESSION['expire'] ) && time() > $_SESSION['expire'] ){
    unset($_SESSION['basket']);
    $_SESSION['basket']=array();
}

if( empty($_SESSION['basket']) ){
    $_SESSION['basket'] = array();
}

if( !empty($_SESSION['basket']) ){
    $count = count( $_SESSION['basket'] );
}else{
    $count = 0;
}

$user = wp_get_current_user();
global $wpdb;
$table = $wpdb->prefix . 'tickets';

if( is_user_logged_in() ){
	$id = $user->ID;
}else{
	$id = 0;
}

$get_ticket = $wpdb->get_results("select * from {$table} where user_id={$id} order by id desc limit 1");
foreach( $get_ticket as $ticket ){
    $pp = $ticket->private_pass;
	$phone = $ticket->pass_phone;
}

                
 // require_once( plugin_dir_path(__FILE__) . 'sidebar.php' ); 
 
 ?>
                <br>
            <button id="this" onclick="getElementById('this').style.display = 'none';window.print();return false;" style="margin: 0 auto;display: inherit;background: #87907D;border: 0;padding:10px 20px;color:#fff;border-radius:3px;box-shadow:0 0 10px #eee;cursor:pointer;font-size:.9em;font-family:IRANSansWeb">پرینت بلیط</button>
            
    
        
        <?php

		if( isset($_GET['Authority']) ){

			$token = sanitize_text_field($_GET['Authority']);
        
			$pricea = $wpdb->get_results( "select sum(price) as sum from {$table} where token='$token'" );
			foreach( $pricea as $pricee ){
				$priceee = $pricee->sum;
			}
			
			$MerchantID = get_option('tt_merchent');
			
			$Amount = $priceee; //Amount will be based on Toman
			$Authority = $_GET['Authority'];
			
			if ($_GET['Status'] == 'OK') {
			
			$client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
			
			$result = $client->PaymentVerification(
			[
			'MerchantID' => $MerchantID,
			'Authority' => $Authority,
			'Amount' => $Amount,
			]
			);
			
			
			if ( $_GET['Status'] == 'OK' || $result->Status == 100 ) {
				
				$wpdb->update(
					$table,
					array(
						'status' => 1
						),
					array(
						'token' => sanitize_text_field($_GET['Authority'])
						)
					);
					
					$to = $user->user_email;
					$subject = 'خرید آنلاین بلیط';
					$body = 'salam';
					
					wp_mail( $to, $subject, $body );
					
					require_once( ROOT . '/shortcodes/sms-class.php' );
					
					try {
						
						date_default_timezone_set("Asia/Tehran");
					
						
						// your sms.ir panel configuration
						$APIKey = "e7faa04884fa68114a048";
						$SecretKey = "gfgd2g5dg1f5g2w5rrw2er6we2re";
					
						
						// message data
						$data = array(
							"ParameterArray" => array(
								array(
					
									"Parameter" => "private_pass",
									"ParameterValue" => $pp
								)
							),
							"Mobile" => $phone,
							"TemplateId" => "5178"
						);
					
						$SmsIR_UltraFastSend = new SmsIR_UltraFastSend($APIKey,$SecretKey);
						$UltraFastSend = $SmsIR_UltraFastSend->UltraFastSend($data);
					// 	var_dump($UltraFastSend);
						
					} catch (Exeption $e) {
						echo 'Error UltraFastSend : '.$e->getMessage();
					}
					
					
					
					
					
					
			// echo 'Transaction success. RefID:'.$result->RefID;
			} else {
				
				$wpdb->delete(
					$table,
					array(
						'token' => sanitize_text_field($_GET['Authority'])
						)
					);
				
				// echo 'Transaction failed. Status:'.$result->Status;
				// echo '<br>';
				// echo $result->RefID;
			}
			} 
			else {
					$wpdb->delete(
					$table,
					array(
						'token' => sanitize_text_field($_GET['Authority'])
						)
					);
					wp_redirect(home_url() . '/tt_checkout');
			}

		}


		if( isset($pp) ){
			$get_tickets = $wpdb->get_results("select * from {$table} where user_id={$id} and private_pass={$pp}");
			
			foreach( $get_tickets as $tickets ){
				
				
				$route_id = $tickets->route_id;
				$inroute_id = $tickets->inroute_id;
				
				$pass_id = $tickets->pass_id;
				$time = $tickets->time;
				$date = $tickets->date;
				
				$number = $tickets->number;
				
				$type = $tickets->typer;
				
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

				if( !is_user_logged_in() ){
					$name = $tickets->pass_name;
					$family = $tickets->pass_family;
					$melli = $tickets->pass_melli;
					$phone = $tickets->pass_phone;
				}
				
				
				
				?>
                        
                        
                        <div style="width:95%;margin:20px auto;border:4px solid #eee;padding:15px 10px;overflow:hidden;border-radius:3px;">
                
                <div style="width:60%;float:right;margin-bottom:15px;">
                    
                    
                    <div style="overflow:hidden">
                        <div style="border:2px solid #eee;border-radius:5px;width:49.5%;float:right;box-sizing:border-box;padding:15px;"><strong>نام مسافر: </strong>&nbsp;<?php echo $name . ' ' . $family; ?></div>
                        <div style="border:2px solid #eee;border-radius:5px;width:49.5%;float:left;box-sizing:border-box;padding:15px;"><strong>شماره ملی: </strong>&nbsp;<?php echo $melli; ?></div>
                    </div>
                    
                    <div style="overflow:hidden">
                        <div style="border:2px solid #eee;border-radius:5px;width:49.5%;margin-top:10px;float:right;box-sizing:border-box;padding:15px;"><strong>زمان: </strong>&nbsp;<?php echo substr($date, 0, 4) .'/'.substr($date, 4, 2) .'/'.substr($date, 6, 2); ?>&nbsp; ساعت &nbsp;<?php echo $time; ?></div>
                        <div style="border:2px solid #eee;border-radius:5px;width:49.5%;margin-top:10px;float:left;box-sizing:border-box;padding:15px;"><strong>شماره صندلی: </strong>&nbsp;<?php echo $number; ?></div>
                    </div>
                    
                    <div style="overflow:hidden">
                        
                        <div style="border:2px solid #eee;border-radius:5px;width:100%;margin-top:10px;float:left;box-sizing:border-box;padding:15px;"><strong>اسم شناور: </strong>&nbsp;<?php echo $typee. ' ' . $cat; ?></div>
                    </div>
                    <?php
					if( $_SESSION['beforeBasket']['route_id'] !== 0 ){
					?>
                    <div style="border:2px solid #eee;padding:15px;border-radius:5px;margin-top:10px;"><strong>مسیر: </strong>&nbsp;<?php echo $begining . '/ ' . $in_begining . '&nbsp;&nbsp; به &nbsp;&nbsp;' . $destination . '/ ' . $in_destination; ?></div>
                    <?php
					}
					?>
                </div>
                
                <div style="width:39%;float:left;margin-bottom:30px">
                    
                    
                    
                    <div style="border:2px solid #eee;padding:15px;border-radius:5px;overflow:hidden">
                        
                        <div style="width:100%;float:left;box-sizing:border-box;" class="qrcode">
                            <?php echo do_shortcode('[auto_qrcode qrcode='.$pp.' size=6 ,margin=4]'); ?>
                        </div>
                    </div>
                    
                </div>
                
                <div style="border:2px solid #eee;padding:15px;border-radius:5px;margin-top:10px;clear:both"><strong>توضیحات: </strong>&nbsp;
                        <p style="font-size:15px;text-align:justify">* <?php echo get_option('tt_print_page_desc1'); ?> </p>
                        <p style="font-size:15px;text-align:justify;margin-bottom:0">* <?php echo get_option('tt_print_page_desc2'); ?></p>
                        <p style="font-size:15px;text-align:justify;margin-bottom:0">* <?php echo get_option('tt_print_page_desc3'); ?></p>
                </div>
                
            </div>
            
            
            
            <br><br>
            <div style="border-bottom:1px dashed #777"></div>
            <br><br>
                        
                        
<?php

if ( isset( $_GET['Status'] ) ){
	if ( $_GET['Status'] == 'OK' || $result->Status == 100 ) {

		unset($_SESSION['basket']);

	}
}



            
            }
                    
}
?>

    </body>
</html>