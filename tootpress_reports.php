<?php

/**
 * Reports
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * 
 * Get Amount of Mastodon API Requests
 * 
 * @since 0.1
 * 
 * @return int Amount of API Requests
 */

function tootpress_get_amount_of_api_requests(){
    $amount_of_mastodon_api_requests=get_option('tootpress_mastodon_amount_of_requests');
    return $amount_of_mastodon_api_requests;
}

/**
 * 
 * Get Amount of Toots
 * 
 * @since 0.1
 * 
 * @return int Amount of Toots
 */

function tootpress_get_amount_of_toots() {
	global $wpdb;
	$table_name=$wpdb->prefix . 'tootpress_toots';
	return $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
}

/**
 * 
 * Get Amount of Media
 * 
 * @since 0.1
 * 
 * @return int Amount of Media
 */

 function tootpress_get_amount_of_media() {
	global $wpdb;
	$table_name=$wpdb->prefix . 'tootpress_media';
	return $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
}

?>