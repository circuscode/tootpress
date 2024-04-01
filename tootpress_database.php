<?php

/**
 * Database
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Creates the Database Tables
 * 
 * @since 0.1
 * 
 */

function tootpress_create_database_tables() {

    global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();

	/*  Toot Table */

	$table_name = $wpdb->prefix . "tootpress_toots";

	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
	toot_id bigint UNSIGNED NOT NULL AUTO_INCREMENT,
	toot_mastodon_id varchar(32) NOT NULL,
	toot_date datetime NOT NULL,
	toot_content text NOT NULL,
	toot_media boolean NOT NULL,
	PRIMARY KEY (toot_id),
 	UNIQUE KEY mastodon_id (toot_mastodon_id)
	) $charset_collate;";
	dbDelta( $sql );

	/* Media Table */

    $table_name = $wpdb->prefix . "tootpress_media";
	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
    attachment_id bigint UNSIGNED NOT NULL AUTO_INCREMENT,
	attachment_mastodon_id varchar(32) NOT NULL,
	attachment_reference_toot varchar(32) NOT NULL,
    attachment_file varchar(256) NOT NULL,
	attachment_description varchar(350),
	attachment_width smallint UNSIGNED NOT NULL,
	attachment_height smallint UNSIGNED NOT NULL,
	PRIMARY KEY (attachment_id),
 	UNIQUE KEY mastodon_id (attachment_mastodon_id)
	) $charset_collate;";
	dbDelta( $sql );

	$database_version=1;
	update_option('mathilda_database_version', $database_version);

}

/**
 * Deletes the Database Tables
 * 
 * @since 0.1
 * 
 */

function tootpress_delete_database_tables() {

	global $wpdb;
	$wpdb->query( "DROP TABLE {$wpdb->prefix}tootpress_toots" );
	$wpdb->query( "DROP TABLE {$wpdb->prefix}tootpress_media" );

}

/**
 * Clears the TootPress Data
 * 
 * Function removes all data from Mastodon and some specified options
 * 
 * @since 0.1
 * 
 */

 function tootpress_clear_data() {

	update_option('tootpress_latest_toot','');
	update_option('tootpress_oldest_toot','');
	update_option('tootpress_last_insert','');
	update_option('tootpress_timeline_complete','');
	update_option('tootpress_cron_newtoots_status','0');
	update_option('tootpress_cron_alltoots_status','0');
	
	global $wpdb;
	$table_name=$wpdb->prefix . 'tootpress_toots';
	$wpdb->get_var( "DELETE FROM $table_name" );
	$table_name=$wpdb->prefix . 'tootpress_media';
	$wpdb->get_var( "DELETE FROM $table_name" );

}

/**
 * Restores to Factory Settings
 * 
 * Notice: JSON and image files will not be removed
 * 
 * @since 0.1
 * 
 */

function tootpress_restore_factory_settings() {

    update_option('tootpress_plugin_version', "1");
    update_option('tootpress_database_version', "1");
	update_option('tootpress_active', "1");
    update_option('tootpress_mastodon_instance',"");
    update_option('tootpress_mastodon_oauth_access_token',"");
    update_option('tootpress_mastodon_account_id',"");
	update_option('tootpress_mastodon_account_name',"");
    update_option('tootpress_mastodon_amount_of_requests',"0");
    update_option('tootpress_latest_toot',"");
    update_option('tootpress_oldest_toot',"");
    update_option('tootpress_cron_newtoots_status',"0");
    update_option('tootpress_cron_alltoots_status',"0");
    update_option('tootpress_cron_period', "15");
    update_option('tootpress_last_insert', "");
    update_option('tootpress_timeline_complete', "");
    update_option('tootpress_page_id', "");
    update_option('tootpress_amount_toots_page',"50");
	update_option('tootpress_navigation',"standard");
	update_option('tootpress_css',"1");
	update_option('tootpress_backlink','0');
    update_option('tootpress_developer',"0");
	
	global $wpdb;
	$table_name=$wpdb->prefix . 'tootpress_toots';
	$wpdb->get_var( "DELETE FROM $table_name" );
	$table_name=$wpdb->prefix . 'tootpress_media';
	$wpdb->get_var( "DELETE FROM $table_name" );

	tootpress_deactivate ();

}

/**
 * Saves a toot into the database
 * 
 * @since 0.1
 * 
 * @param int Toot ID
 * @param date Toot Date
 * @param string Toot Content
 * @param bool Media Flag
 */

function tootpress_add_toot($mastodon_id,$date,$content,$media) {

	global $wpdb;
	$table_name = $wpdb->prefix . 'tootpress_toots';

	$wpdb->insert(
		$table_name,
		array(
			'toot_mastodon_id' => $mastodon_id,
			'toot_date' => $date,
			'toot_content' => $content,
			'toot_media' => $media
			)
		);
}

/**
 * Saves a media attachment into the database
 * 
 * @since 0.1
 * 
 * @param int Media ID
 * @param int Toot Reference
 * @param string Media URL
 * @param string Media Description
 * @param int Media Width
 * @param int Media Height 
 */

 function tootpress_add_media_attachment($mastodon_id,$reference_toot,$file,$description,$width,$height) {

	global $wpdb;
	$table_name = $wpdb->prefix . 'tootpress_media';

	$wpdb->insert(
		$table_name,
		array(
			'attachment_mastodon_id' => $mastodon_id,
			'attachment_reference_toot' => $reference_toot,
			'attachment_file' => $file,
			'attachment_description' => $description,
			'attachment_width' => $width,
			'attachment_height' => $height
			)
		);
}

/**
 * Get Toots from Database
 * 
 * @since 0.1
 * 
 * @param int Amount Toots
 * @param int Range Timeline
 * @return array Toots
 */

function tootpress_get_toots_from_database($amount, $range) {

	global $wpdb;
	$table_name=$wpdb->prefix . 'tootpress_toots';
	$offset=$amount*($range-1);
	
	return $wpdb->get_results( "SELECT 
		toot_mastodon_id, 
		toot_date, 
		toot_content, 
		toot_media
	FROM $table_name 
	ORDER BY toot_date 
	DESC LIMIT $offset, $amount", 
	ARRAY_A);

}

/**
 * Get Media from Database
 * 
 * @since 0.1
 * 
 * @param int Toot ID
 * @return array Media
 */

 function tootpress_get_media_from_database($tootid) {

	global $wpdb;
	$table_name=$wpdb->prefix . 'tootpress_media';
	
	return $wpdb->get_results( "SELECT 
		attachment_file, 
		attachment_description, 
		attachment_width, 
		attachment_height
	FROM $table_name 
	WHERE attachment_reference_toot=$tootid", 
	ARRAY_A);

}

?>