<?php

if( !defined ( 'WP_UNINSTALL_PLUGIN' ) ){
    exit();
}

global $wpdb;

$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}before_basket" );

$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}discount" );

$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}Inroutes" );

$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}passenger" );

$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}routes" );

$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}tickets" );

$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}trip_type" );


?>