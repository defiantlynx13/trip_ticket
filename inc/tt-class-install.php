<?php

//create custom template page
        
        $post_id = -1;

        // Setup custom vars
        $author_id = 1;
        $slug1 = 'tt_print_ticket';
        $title = 'چاپ بلیط';

        // Check if page exists, if not create it
        if ( null == get_page_by_title( $title )) {

            $uploader_page = array(
                    'comment_status'        => 'closed',
                    'ping_status'           => 'closed',
                    'post_author'           => $author_id,
                    'post_name'             => $slug1,
                    'post_title'            => $title,
                    'post_status'           => 'publish',
                    'post_type'             => 'page'
            );

            $post_id = wp_insert_post( $uploader_page );


            if ( !$post_id ) {

                    wp_die( 'Error creating template page' );

            } else {

                    update_post_meta( $post_id, '_wp_page_template', 'print_ticket.php' );

            }
        } // end check if
        
        
        
        //create new print ticket page
        $slug2 = 'tt_new_print_ticket';
        $title = 'چاپ بلیط شما';
        // Check if page exists, if not create it
        if ( null == get_page_by_title( $title )) {

            $uploader_page = array(
                    'comment_status'        => 'closed',
                    'ping_status'           => 'closed',
                    'post_author'           => $author_id,
                    'post_name'             => $slug2,
                    'post_title'            => $title,
                    'post_status'           => 'publish',
                    'post_type'             => 'page'
            );

            $post_id = wp_insert_post( $uploader_page );


            if ( !$post_id ) {

                    wp_die( 'Error creating template page' );

            } else {

                    update_post_meta( $post_id, '_wp_page_template', 'new_print_ticket.php' );

            }
        } // end check if
        
        //basket page
        $basket_title = wp_strip_all_tags( 'سبد خرید من' );
         $basket = array(
              'post_title'    => $basket_title,
              'post_name'     => 'tt_basket',
              'post_content'  => '[TT_basket]',
              'post_status'   => 'publish',
              'post_author'   => 1,
              'post_type'     => 'page',
            );
                
         post_exists( $basket_title ) or wp_insert_post( $basket );
        
        //reset page
        $reset_title = wp_strip_all_tags( 'فراموشی رمز عبور' );
         $reset = array(
              'post_title'    => $reset_title,
              'post_name'     => 'tt_reset',
              'post_content'  => '[TT_reset]',
              'post_status'   => 'publish',
              'post_author'   => 1,
              'post_type'     => 'page',
            );
                
         post_exists( $reset_title ) or wp_insert_post( $reset );
        
        //login page
        $login_title = wp_strip_all_tags( 'ورود به پنل' );
        $login = array(
          'post_title'    => $login_title,
          'post_name'     => 'tt_login',
          'post_content'  => '[TT_login]',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'     => 'page',
        );
        post_exists( $login_title ) or wp_insert_post( $login );
        
        //register page
        $register_title = wp_strip_all_tags( 'ثبت نام در سایت' );
        $register = array(
          'post_title'    => $register_title,
          'post_name'     => 'tt_register',
          'post_content'  => '[TT_register]',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'     => 'page',
        );
        post_exists( $register_title ) or wp_insert_post( $register );
        
        //buy page
        $buy_title = wp_strip_all_tags( 'خرید بلیط جدید' );
        $buy = array(
          'post_title'    => $buy_title,
          'post_name'     => 'tt_buy',
          'post_content'  => '[TT_Buy]',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'     => 'page',
        );
        post_exists( $buy_title ) or wp_insert_post( $buy );
        
        //changepass page
        $changepass_title = wp_strip_all_tags( 'تغییر رمز ورود' );
        $changepass = array(
          'post_title'    => $changepass_title,
          'post_name'     => 'tt_changepass',
          'post_content'  => '[TT_changepass]',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'     => 'page',
        );
        post_exists( $changepass_title ) or wp_insert_post( $changepass );
        
        //checkout page
        $checkout_title = wp_strip_all_tags( 'تصفیه حساب' );
        $checkout = array(
          'post_title'    => $checkout_title,
          'post_name'     => 'tt_checkout',
          'post_content'  => '[TT_checkout]',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'     => 'page',
        );
        post_exists( $checkout_title ) or wp_insert_post( $checkout );
        
        //list page
        $list_title = wp_strip_all_tags( 'لیست بلیط های من' );
        $list = array(
          'post_title'    => $list_title,
          'post_name'     => 'tt_list',
          'post_content'  => '[TT_list]',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'     => 'page',
        );
        post_exists( $list_title ) or wp_insert_post( $list );
        
        //myfamily page
        $myfamily_title = wp_strip_all_tags( 'مسافران ثبت شده' );
        $myfamily = array(
          'post_title'    => $myfamily_title,
          'post_name'     => 'tt_myfamily',
          'post_content'  => '[TT_myfamily]',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'     => 'page',
        );
        post_exists( $myfamily_title ) or wp_insert_post( $myfamily );
        
        //newpass page
        $newpass_title = wp_strip_all_tags( 'ثبت مسافر جدید' );
        $newpass = array(
          'post_title'    => $newpass_title,
          'post_name'     => 'tt_newpass',
          'post_content'  => '[TT_newpass]',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'     => 'page',
        );
        post_exists( $newpass_title ) or wp_insert_post( $newpass );
        
        //panel page
        $panel_title = wp_strip_all_tags( 'داشبورد' );
        $panel = array(
          'post_title'    => $panel_title,
          'post_name'     => 'tt_panel',
          'post_content'  => '[TT_panel]',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'     => 'page',
        );
        post_exists( $panel_title ) or wp_insert_post( $panel );
        
        
        //last ticket page
        $lastticket_title = wp_strip_all_tags( 'بلیط های قبلی' );
        $lastticket = array(
          'post_title'    => $lastticket_title,
          'post_name'     => 'tt_lastticket',
          'post_content'  => '[TT_lastticket]',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'     => 'page',
        );
        post_exists( $lastticket_title ) or wp_insert_post( $lastticket );




//create tables
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    global $wpdb, $charset_collate;
    
    $table1 = $wpdb->prefix . "before_basket"; 
    $query = "CREATE TABLE $table1 ( 
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `route_id` int(11) NOT NULL,
    `inroute_id` int(11) NOT NULL,
    `type` int(11) NOT NULL,
    `date` varchar(255) CHARACTER SET utf8 NOT NULL,
    `time` varchar(255) CHARACTER SET utf8 NOT NULL,
     PRIMARY KEY (`id`)
    ) $charset_collate;";
    
    $table2 = $wpdb->prefix . "discount"; 
    $query .= "CREATE TABLE $table2 ( 
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `code` varchar(255) CHARACTER SET utf8 NOT NULL,
    `percent` int(11) NOT NULL,
    PRIMARY KEY (`id`) 
    ) $charset_collate;";
    
    $table3 = $wpdb->prefix . "Inroutes"; 
    $query .= "CREATE TABLE $table3 ( 
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `route_id` int(11) NOT NULL,
    `begining` varchar(255) CHARACTER SET utf8 NOT NULL,
    `destination` varchar(255) CHARACTER SET utf8 NOT NULL,
    `type` int(11) NOT NULL,
    `time` varchar(255) CHARACTER SET utf8 NOT NULL,
    `price` int(255) NOT NULL,
    `status` int(11) NOT NULL,
	`fall` int(11) NOT NULL DEFAULT '0',
     PRIMARY KEY (`id`) 
    ) $charset_collate;";
    
    $table4 = $wpdb->prefix . "passenger";
    $query .= "CREATE TABLE $table4 ( 
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `melli` varchar(255) CHARACTER SET utf8 NOT NULL,
    `phone` varchar(255) CHARACTER SET utf8 NOT NULL,
    `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
    `family` varchar(255) CHARACTER SET utf8 NOT NULL,
    `birthday` varchar(255) CHARACTER SET utf8 NOT NULL,
    `sex` varchar(255) CHARACTER SET utf8 NOT NULL,
    `user_id` int(11) NOT NULL DEFAULT '0',
    `parent` int(11) NOT NULL DEFAULT '0',
    `status` int(11) NOT NULL,
    `dated` varchar(255) CHARACTER SET utf8 NOT NULL,
    `ip` varchar(255) CHARACTER SET utf8 NOT NULL,
    PRIMARY KEY (`id`)
    ) $charset_collate;";
    
    $table5 = $wpdb->prefix . "routes"; 
    $query .= "CREATE TABLE $table5 ( 
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `begining` varchar(255) CHARACTER SET utf8 NOT NULL,
    `destination` varchar(255) CHARACTER SET utf8 NOT NULL,
    PRIMARY KEY (`id`)
    ) $charset_collate;";
    
    $table6 = $wpdb->prefix . "tickets"; 
    $query .= "CREATE TABLE $table6 ( 
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `pass_id` int(11) NOT NULL,
    `route_id` int(11) NOT NULL,
    `inroute_id` int(11) NOT NULL,
    `typer` int(11) NOT NULL,
    `number` int(11) NOT NULL,
    `date` varchar(255) CHARACTER SET utf8 NOT NULL,
    `time` varchar(255) CHARACTER SET utf8 NOT NULL,
    `date_register` varchar(255) CHARACTER SET ucs2 NOT NULL,
    `price` int(11) NOT NULL,
    `status` int(11) NOT NULL,
    `private_pass` bigint(20) NOT NULL,
    `token` varchar(255) NOT NULL,
	`pass_name` varchar(255) CHARACTER SET utf8 NOT NULL,
 	`pass_family` varchar(255) CHARACTER SET utf8 NOT NULL,
 	`pass_melli` int(255) NOT NULL,
 	`pass_phone` varchar(255) CHARACTER SET utf8 NOT NULL,
    PRIMARY KEY (`id`)
    ) $charset_collate;";
    
    $table7 = $wpdb->prefix . "trip_type"; 
    $query .= "CREATE TABLE $table7 ( 
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `type` varchar(255) CHARACTER SET utf8 NOT NULL,
    `cat` varchar(255) CHARACTER SET utf8 NOT NULL,
    `capacity` int(11) NOT NULL,
    `status` int(11) NOT NULL,
    PRIMARY KEY (`id`)
    ) $charset_collate;";
     
    dbDelta( $query ); 

?>