<?php

/**
 * Set Functions
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Set latest Toot
 * 
 * @since 0.1
 * 
 */

 function tootpress_set_latest_toot() {

	global $wpdb;
	$table_name=$wpdb->prefix . 'tootpress_toots';
	$latest_toot=$wpdb->get_var( "SELECT MAX(toot_mastodon_id) FROM $table_name" );
	update_option('tootpress_latest_toot',$latest_toot);

}

/**
 * Set oldest Toot
 * 
 * @since 0.1
 * 
 */

 function tootpress_set_oldest_toot() {

	global $wpdb;
	$table_name=$wpdb->prefix . 'tootpress_toots';
	$oldest_toot=$wpdb->get_var( "SELECT MIN(toot_mastodon_id) FROM $table_name" );
	update_option('tootpress_oldest_toot',$oldest_toot);

}

/**
 * Set Last Run
 * 
 * @since 0.1
 * 
 */

 function tootpress_set_last_insert() {

	$now=date_i18n( 'Y-m-d H:i:s' );
	update_option('tootpress_last_insert',$now);

}

?>