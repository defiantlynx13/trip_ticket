<?php


//add base menu plugin ----------------------
        add_menu_page( 
            'همه مسیرها', 
            'خرید آنلاین بلیط', 
            'administrator', 
            'all-routes', 
            'all_routes_function', 
            'dashicons-location-alt', 
            4 
            );
            

        //add all-route menu ------------------------
        add_submenu_page( 
            'all-routes', 
            'همه سفرهای مسافربری', 
            'همه سفرهای مسافربری', 
            'administrator', 
            'all-routes', 
            'all_routes_function' 
            );
        function all_routes_function(){
            require_once( ROOT . '/pages/all-routes.php' );
        }

		//add all-fall-inroute page ------------------------
        add_submenu_page( 
            'all-routes', 
            'همه سفرهای تفریحی', 
            'همه سفرهای تفریحی', 
            'administrator', 
            'all-fall-inroutes', 
            'all_fall_inroutes_function' 
            );
        function all_fall_inroutes_function(){
            require_once( ROOT . '/pages/all-fall-inroutes.php' );
        }

		//add all-tickets menu ------------------------
        add_submenu_page( 
            'all-routes', 
            'بلیط های فروخته شده', 
            'بلیط های فروخته شده', 
            'administrator', 
            'all-tickets', 
            'all_tickets_function' 
            );
        function all_tickets_function(){
            require_once( ROOT . '/pages/all-tickets.php' );
        }

		//add add-fall-inroute page ------------------------
        add_submenu_page( 
            '', 
            'افزودن سفر تفریحی', 
            'افزودن سفر تفریحی', 
            'administrator', 
            'add-fall-inroute', 
            'add_fall_inroutes_function' 
            );
        function add_fall_inroutes_function(){
            require_once( ROOT . '/pages/add-fall-inroutes.php' );
        }

		//add edit-fall-inroute page ------------------------
        add_submenu_page( 
            '', 
            'ویرایش سفر تفریحی', 
            'ویرایش سفر تفریحی', 
            'administrator', 
            'edit-fall-inroute', 
            'edit_fall_inroutes_function' 
            );
        function edit_fall_inroutes_function(){
            require_once( ROOT . '/pages/edit-fall-inroutes.php' );
        }

		//add saved fall inroute page ------------------------
        $hook0 = add_submenu_page( 
            '', 
            'بلیط های ثبت شده', 
            '', 
            'administrator', 
            'saved-fall-inroutes', 
            'saved_fall_inroutes_function' 
            );
        function saved_fall_inroutes_function(){
            require_once( ROOT . '/pages/saved-fall-inroutes.php' );
        }
		add_action("load-".$hook0, "saved_fall_inroutes_include_function");
		function saved_fall_inroutes_include_function(){
			add_action( "admin_enqueue_scripts" , function(){
				wp_enqueue_script( 'admin-js' , content_url('plugins/TripTicket/assets/js/admin.js' , __FILE__) , null, null , true );
			} );
		}
        
        //add all-passengers menu ------------------------
        add_submenu_page( 
            'all-routes', 
            'همه مسافران', 
            'همه مسافران', 
            'administrator', 
            'all-passengers', 
            'all_passengers_function' 
            );
        function all_passengers_function(){
            require_once( ROOT . '/pages/all-passengers.php' );
        }
        
        //add all-in-passengers menu ------------------------
        add_submenu_page( 
            '', 
            'همه زیرمسافران', 
            'همه زیرمسافران', 
            'administrator', 
            'all-in-passengers', 
            'all_in_passengers_function' 
            );
        function all_in_passengers_function(){
            require_once( ROOT . '/pages/all-in-passengers.php' );
        }
        
        //add edit-in-passengers menu ------------------------
        add_submenu_page( 
            '', 
            'ویرایش زیرمسافر', 
            'ویرایش زیرمسافر', 
            'administrator', 
            'edit-in-passenger', 
            'edit_in_passenger_function' 
            );
        function edit_in_passenger_function(){
            require_once( ROOT . '/pages/edit-in-passenger.php' );
        }
        
        //add edit-passenger menu ------------------------
        add_submenu_page( 
            '', 
            'ویرایش مسافر', 
            'ویرایش مسافر',
            'administrator', 
            'edit-passenger', 
            'edit_passenger_function' 
            );
        function edit_passenger_function(){
            require_once( ROOT . '/pages/edit-passenger.php' );
        }
        
        //add all-trip-type menu ------------------------
        add_submenu_page( 
            'all-routes', 
            'همه شناورها', 
            'همه شناورها', 
            'administrator', 
            'all-trip-type', 
            'all_trip_type_function' 
            );
        function all_trip_type_function(){
            require_once( ROOT . '/pages/all-trip-type.php' );
        }
        
        //add add-trip-type page ------------------------
        add_submenu_page( 
            '', 
            'همه شناورها', 
            '', 
            'administrator', 
            'add-trip-type', 
            'add_trip_type_function' 
            );
        function add_trip_type_function(){
            require_once( ROOT . '/pages/add-trip-type.php' );
        }
        
        //add edittrip-type page ------------------------
        add_submenu_page( 
            '', 
            'ویرایش شناور', 
            '', 
            'administrator', 
            'edit-trip-type', 
            'edit_trip_type_function' 
            );
        function edit_trip_type_function(){
            require_once( ROOT . '/pages/edit-trip-type.php' );
        }
        
        //add edit-route page ------------------------
        add_submenu_page( 
            '', 
            'ویرایش مسیر', 
            '', 
            'administrator', 
            'edit-routes', 
            'edit_routes_function' 
            );
        function edit_routes_function(){
            require_once( ROOT . '/pages/edit-routes.php' );
        }
        
        //add route page ------------------------
        add_submenu_page( 
            '', 
            'افزودن مسیر جدید', 
            '', 
            'administrator', 
            'add-route', 
            'add_route_function' 
            );
        function add_route_function(){
            require_once( ROOT . '/pages/add-route.php' );
        }
        
        //add all-Inroute page ------------------------
        add_submenu_page( 
            '', 
            'همه زیرمسیرها', 
            'همه زیرمسیرها', 
            'administrator', 
            'all-Inroutes', 
            'all_Inroutes_function' 
            );
        function all_Inroutes_function(){
            require_once( ROOT . '/pages/all-Inroutes.php' );
        }

		//add all-Inroute page ------------------------
        $hook15 = add_submenu_page( 
            '', 
            'بلیط های ثبت شده', 
            'بلیط های ثبت شده', 
            'administrator', 
            'saved-inroutes', 
            'saved_inroutes_function' 
            );
        function saved_inroutes_function(){
            require_once( ROOT . '/pages/saved-inroutes.php' );
        }
		add_action("load-".$hook15, "saved_inroutes_include_function");
		function saved_inroutes_include_function(){
			add_action( "admin_enqueue_scripts" , function(){
				wp_enqueue_script( 'admin-js' , content_url('plugins/TripTicket/assets/js/admin.js' , __FILE__) , null, null , true );
			} );
		}
        
        //add edit-Inroute page ------------------------
        add_submenu_page( 
            '', 
            'ویرایش زیرمسیر', 
            '', 
            'administrator', 
            'edit-Inroute', 
            'edit_Inroute_function' 
            );
        function edit_Inroute_function(){
            require_once( ROOT . '/pages/edit-Inroute.php' );
        }
        
        //add all-tickets page ------------------------
        add_submenu_page( 
            '', 
            'ویرایش بلیط', 
            'ویرایش بلیط', 
            'administrator', 
            'edit-ticket', 
            'edit_ticket_function' 
            );
        function edit_ticket_function(){
            require_once( ROOT . '/pages/edit-ticket.php' );
        }
        
        
        //add add-Inroute page ------------------------
        $hook1 = add_submenu_page( 
            '', 
            'افزودن زیرمسیر جدید', 
            '', 
            'administrator', 
            'add-Inroute', 
            'add_Inroute_function' 
            );
        function add_Inroute_function(){
            require_once( ROOT . '/pages/add-inroute.php' );
        }
		add_action("load-".$hook1, "add_inroute_include_function");
		function add_inroute_include_function(){
			add_action( "admin_enqueue_scripts" , function(){
				wp_enqueue_script( 'admin-js' , content_url('plugins/TripTicket/assets/js/admin.js' , __FILE__) , null, null , true );
			} );
		}
        
        //add passengers page ------------------------
        add_submenu_page( 
            '', 
            'بلیط های ثبت شده', 
            '', 
            'administrator', 
            'saved-tickets', 
            'saved_tickets_function' 
            );
        function saved_tickets_function(){
            require_once( ROOT . '/pages/saved-tickets.php' );
        }
        
         //add all-off menu ------------------------
        add_submenu_page( 
            'all-routes', 
            'تخفیف ها', 
            'تخفیف ها', 
            'administrator', 
            'all-discount', 
            'all_discount_function' 
            );
        function all_discount_function(){
            require_once( ROOT . '/pages/all-discount.php' );
        }
        
        //add passengers page ------------------------
        add_submenu_page( 
            '', 
            'افزودن تخفیف', 
            '', 
            'administrator', 
            'add-discount', 
            'add_discount_function' 
            );
        function add_discount_function(){
            require_once( ROOT . '/pages/add-discount.php' );
        }
        
         //add all-off menu ------------------------
        add_submenu_page( 
            'all-routes', 
            'تنظیمات افزونه', 
            'تنظیمات افزونه', 
            'administrator', 
            'plugin-settings', 
            'plugin_settings_function' 
            );
        function plugin_settings_function(){
            require_once( ROOT . '/pages/plugin_settings.php' );
        }
        
        
?>