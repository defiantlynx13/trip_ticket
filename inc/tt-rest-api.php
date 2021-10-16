<?php

//add_action
add_action( 'rest_api_init', 'wpc_register_wp_api_endpoints' );
function wpc_register_wp_api_endpoints() {
    
	register_rest_route( 'api', '/output/', array(
        'methods' => 'GET',
        'callback' => 'wpc_somename_search_callback',
        'args' => array(
                'date' => array(
                        'required' => true,
                    ),
				'inroute' => array(
                        'required' => true,
                    ),
            )
    ));   
}

function wpc_somename_search_callback( $request ) {

	global $wpdb;
	$date = $request['date'];
	$inroute = $request['inroute'];
    $list = $wpdb->get_results( $wpdb->prepare( "select * from {$wpdb->prefix}tickets where inroute_id=%d and date=%s", $inroute , $date ) );


	
    // $jsonDecoded = json_decode( json_encode($list), true);

    $fileName = 'example.csv';

    $fp = fopen($fileName, 'w');

	fputcsv($fp, array(
			'نام مسافر',
			'شماره ملی',
			'تلفن همراه',
			'تاریخ سفر',
			'زمان',
			'شماره صندلی',
			'شماره بلیط'
			)
		);

    foreach($list as $row){
		$value = array(
			$row->pass_name.' '.$row->pass_family,
			$row->pass_melli,
			$row->pass_phone,
			$row->date,
			$row->time,
			$row->number,
			$row->private_pass
			);
        fputcsv($fp, $value);
    }

    fclose($fp);

	header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    echo "\xEF\xBB\xBF"; // UTF-8 BOM
    header('Content-Encoding: UTF-8');
    header("Content-type: application/vnd.ms-excel;charset=UTF-8");
    header("Content-disposition: csv" . date("Y-m-d") . ".csv" );

    header('Content-Disposition: attachment; filename="'. $fileName .'"');

    readfile($fileName);
    // print $fp;
	
    exit;

}
?>