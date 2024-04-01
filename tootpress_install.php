<?php

/**
 * Installation, Deinstallation, Deactivation
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Installs the plugin
 * 
 * Function will triggered with plugin activation
 * 
 * @since 0.1
 */

 function tootpress_activate () {

	if (!get_option('tootpress_active')) {

	// Initialize Settings

    add_option('tootpress_plugin_version', "1");
    add_option('tootpress_database_version', "1");
	add_option('tootpress_active', "1");
    add_option('tootpress_mastodon_instance',"");
    add_option('tootpress_mastodon_oauth_access_token',"");
    add_option('tootpress_mastodon_account_id',"");
    add_option('tootpress_mastodon_account_name',"");
    add_option('tootpress_mastodon_amount_of_requests',"0");
    add_option('tootpress_latest_toot',"");
    add_option('tootpress_oldest_toot',"");
    add_option('tootpress_cron_newtoots_status',"0");
    add_option('tootpress_cron_alltoots_status',"0");
    add_option('tootpress_cron_period', "900");
    add_option('tootpress_last_insert', "");
    add_option('tootpress_timeline_complete', "");
    add_option('tootpress_page_id', "");
    add_option('tootpress_amount_toots_page',"50");
    add_option('tootpress_navigation',"standard");
    add_option('tootpress_css','1');
    add_option('tootpress_backlink','0');
    add_option('tootpress_developer',"0");
    }

    // Create Database Tables

    tootpress_create_database_tables();

    // Create Folders

    tootpress_create_directories();

}

/**
 * Deinstalls the plugin
 * 
 * Function will triggered with plugin deletion
 * 
 * @since 0.1
 */

function tootpress_delete () {

    if ( get_option('tootpress_active') ) {

    /* Delete Options */

    delete_option('tootpress_plugin_version');
    delete_option('tootpress_database_version');
    delete_option('tootpress_active');
    delete_option('tootpress_mastodon_instance');
    delete_option('tootpress_mastodon_oauth_access_token');
    delete_option('tootpress_mastodon_account_id');
    delete_option('tootpress_mastodon_account_name');
    delete_option('tootpress_mastodon_amount_of_requests');
    delete_option('tootpress_latest_toot');
    delete_option('tootpress_oldest_toot');
    delete_option('tootpress_cron_newtoots_status');
    delete_option('tootpress_cron_alltoots_status');
    delete_option('tootpress_cron_period');
    delete_option('tootpress_last_insert');
    delete_option('tootpress_timeline_complete');
    delete_option('tootpress_page_id', "");
    delete_option('tootpress_amount_toots_page');
    delete_option('tootpress_navigation');
    delete_option('tootpress_css');
    delete_option('tootpress_backlink');
    delete_option('tootpress_developer');
    }

    /* Deletes the Database Tables */

    tootpress_delete_database_tables();

}

/**
 * Deactivates the plugin
 * 
 * Function will triggered with plugin deactivation
 * 
 * @since 0.1
 */

function tootpress_deactivate () {

    // Remove Rewrite Rules
    flush_rewrite_rules();

    // Unschedule Crons
	$timestamp = wp_next_scheduled( 'tootpress_cron_hook_alltoots' );
	wp_unschedule_event($timestamp, 'tootpress_cron_hook_alltoots' );   
	$timestamp = wp_next_scheduled( 'tootpress_cron_hook_newtoots' );
   	wp_unschedule_event($timestamp, 'tootpress_cron_hook_newtoots' );

}

?>