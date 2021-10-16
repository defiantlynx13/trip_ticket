<?php
/*
Plugin Name:  Buy Online Tickets Plugin
Plugin URI:   https://wp-helper.ir
Description:  This Is A Private Plugin :: Please Dont Share It!
Version:      1.0
Author:       wp-helper
Author URI:   https://wp-helper.ir
License:      private
*/

if( ! defined("ABSPATH") ) exit;

session_start();

if( ! defined( "ROOT" ) ){
    define("ROOT", dirname(__FILE__) );
}


function app_output_buffer() {
	ob_start();
} // soi_output_buffer
add_action('init', 'app_output_buffer');

//export
function csv_pull_output() {
  global $wpdb;
  $file = 'email_csv';
  $table = $wpdb->prefix . 'tickets';
  $results = $wpdb->get_results("SELECT * FROM {$table}");
  
  $title = array( 'نام' , 'تاریخ' , 'زمان' , 'قیمت' , 'مسیر' , 'مبدا' , 'مقصد' , 'نوع کشتی' , 'شماره صندلی' , 'تاریخ ثبت');
  $csv_output = implode("," , $title) . "\n";
  
  foreach ($results as $tickets) {
      
    $route_id = $tickets->route_id;
    $inroute_id = $tickets->inroute_id;
    $pass_id = $tickets->pass_id;
    $time = $tickets->time;
    $date = $tickets->date;
    $private_pass = $tickets->private_pass;
    $typerr = $tickets->typer;
    $number = $tickets->number;
    $date_register = $tickets->date_register;
    
    $Tpass = $wpdb->prefix . 'passenger';
    $get_pass = $wpdb->get_results( $wpdb->prepare("select * from {$Tpass} where id=%d" , $pass_id) );
    foreach( $get_pass as $pass ){
        $name = $pass->name;
        $family = $pass->family;
        $melli = $pass->melli;
    }
    
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
    $get_type = $wpdb->get_results( "select * from {$Ttype} where id={$typerr}" );
    
    if( $wpdb->num_rows > 0 ){
        
        foreach( $get_type as $typer ){
            $typee = $typer->type;
            $cat = $typer->cat;
        }
    }
    
    $ticket = array( $name.' '.$family , substr($date,0,4).'/'.substr($date,4,2).'/'.substr($date,6,2) , $time, $price,  $begining.' به '.$destination , $in_begining, $in_destination, $typee.' '. $cat, $number, substr($date_register,0,4).'/'.substr($date_register,4,2).'/'.substr($date_register,6,2) );
    $csv_output .= implode("," , $ticket) . "\n";
    
  }
  $csv_output .= "\n";

  
  $filename = $file."_".date("Y-m-d_H-i",time());
  
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=file.csv');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    echo "\xEF\xBB\xBF"; // UTF-8 BOM
    header('Content-Encoding: UTF-8');
    header("Content-type: application/vnd.ms-excel;charset=UTF-8");
    header("Content-disposition: csv" . date("Y-m-d") . ".csv" );
    header( "Content-disposition: filename=".$filename.".csv" );
    print $csv_output;
    exit;
    
}
add_action('wp_ajax_csv_pull','csv_pull_output');

//classes require
require_once( ROOT . '/inc/main-class.php' );

require_once( ROOT . '/inc/tt-rest-api.php' );

//events on activate plugin
$tt_main = new TripTicket();

add_action( 'template_include', 'uploadr_redirect' );
function uploadr_redirect( $template ) {

    $plugindir = dirname( __FILE__ );

    if ( is_page_template( 'print_ticket.php' )) {

        $template = $plugindir . '/shortcodes/print_ticket.php';
    }
    
    if ( is_page_template( 'new_print_ticket.php' )) {

        $template = $plugindir . '/shortcodes/new_print_ticket.php';
    }

    return $template;

}

//event on uninstall plugin
register_deactivation_hook( __FILE__ , 'TT_deactivate_plugin' );

function TT_deactivate_plugin(){
    wp_delete_post( get_page_by_path( 'tt_basket', $output = OBJECT, $post_type = 'page' )->ID , true );
    wp_delete_post( get_page_by_path( 'tt_login', $output = OBJECT, $post_type = 'page' )->ID , true );
    wp_delete_post( get_page_by_path( 'tt_register', $output = OBJECT, $post_type = 'page' )->ID , true );
    wp_delete_post( get_page_by_path( 'tt_Buy', $output = OBJECT, $post_type = 'page' )->ID , true );
    wp_delete_post( get_page_by_path( 'tt_changepass', $output = OBJECT, $post_type = 'page' )->ID , true );
    wp_delete_post( get_page_by_path( 'tt_checkout', $output = OBJECT, $post_type = 'page' )->ID , true );
    wp_delete_post( get_page_by_path( 'tt_list', $output = OBJECT, $post_type = 'page' )->ID , true );
    wp_delete_post( get_page_by_path( 'tt_myfamily', $output = OBJECT, $post_type = 'page' )->ID , true );
    wp_delete_post( get_page_by_path( 'tt_newpass', $output = OBJECT, $post_type = 'page' )->ID , true );
    wp_delete_post( get_page_by_path( 'tt_panel', $output = OBJECT, $post_type = 'page' )->ID , true );
    wp_delete_post( get_page_by_path( 'tt_print_ticket', $output = OBJECT, $post_type = 'page' )->ID , true );
    wp_delete_post( get_page_by_path( 'tt_new_print_ticket', $output = OBJECT, $post_type = 'page' )->ID , true );
    wp_delete_post( get_page_by_path( 'tt_lastticket', $output = OBJECT, $post_type = 'page' )->ID , true );
    wp_delete_post( get_page_by_path( 'tt_reset', $output = OBJECT, $post_type = 'page' )->ID , true );
    
}



if( is_admin() ){
    
    //add plugin menus and pages -----------------------------------------------
    add_action('admin_menu' , 'TT_add_menu_function');
    
    function TT_add_menu_function(){
        
        require_once( ROOT . '/inc/tt-menu-pages.php' );
        
    }
}

require_once ROOT.'/shortcodes/list.php';
require_once(ROOT . '/shortcodes/login.php');
require_once(ROOT . '/shortcodes/panel.php');
require_once(ROOT . '/shortcodes/Buy.php');
require_once(ROOT . '/shortcodes/newpass.php');
require_once(ROOT . '/shortcodes/myfamily.php');
require_once(ROOT . '/shortcodes/register.php');
require_once(ROOT . '/shortcodes/basket.php');
require_once(ROOT . '/shortcodes/checkout.php');
require_once(ROOT . '/shortcodes/changepass.php');
// require_once(ROOT . '/shortcodes/ticket.php');
require_once(ROOT . '/shortcodes/number.php');
require_once(ROOT . '/shortcodes/lastticket.php');
require_once(ROOT . '/shortcodes/reset.php');

//style
add_action('wp_enqueue_scripts', function(){
    wp_enqueue_style('style-plugin' , plugins_url('assets/css/style.css' , __FILE__) , null, null);
    wp_enqueue_script('custom' , plugins_url('assets/js/custom.js' , __FILE__) , null, null, true);
});

//hide admin bar from users
add_action('after_setup_theme', 'remove_admin_bar');
 function remove_admin_bar() {
     if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
     }
}

//prevent users from wp-admin
add_action( 'init', 'blockusers_init' );
 
function blockusers_init() {
    if ( is_admin() && ! current_user_can( 'administrator' ) && 
       ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        wp_redirect( home_url().'/tt_login' );
        exit;
    }
}


//redirect when wrong pass
add_action( 'wp_login_failed', 'my_front_end_login_fail' );  // hook failed login

function my_front_end_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
   // if there's a valid referrer, and it's not the default log-in screen
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
      wp_redirect( home_url(). '/tt_login/?wrong=true' );  // let's append some information (login=failed) to the URL for the theme to use
      exit;
   }
}

?>