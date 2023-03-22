<?php

/**
 * Cron
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Creates the intervall for requesting new toots
 * 
 * @since 0.1
 * 
 * @param array Schedules
 * @return array Schedules
 */

function tootpress_cron_schedule_newtoots ( $schedules ) {

	$period=get_option('tootpress_cron_period');

    $schedules['tootpress_schedule_newtoots'] = array(
        'interval' => $period,
        'display'  => esc_html__( 'TootPress Custom Window' ),
    );

    return $schedules;
}
add_filter( 'cron_schedules', 'tootpress_cron_schedule_newtoots' );

/**
 * Creates the intervall for requesting all toots
 * 
 * @since 0.1
 * 
 * @param array Schedules
 * @return array Schedules
 */

 function tootpress_cron_schedule_alltoots ( $schedules ) {

    $schedules['tootpress_schedule_alltoots'] = array(
        'interval' => 300,
        'display'  => esc_html__( 'TootPress Every5Minutes' ),
    );

    return $schedules;
}
add_filter( 'cron_schedules', 'tootpress_cron_schedule_alltoots' );

/**
 * Defines the cron for requesting new toots
 * 
 * @since 0.1
 * 
 * @return bool
 */

function tootpress_cron_process_newtoots() {

	// Is Steady Load active?
	$cron_status=get_option('tootpress_cron_newtoots_status');

	if($cron_status) {

		if(tootpress_ready_to_retrieve_toots_from_mastodon_api()){
			// Request API
			tootpress_copy_toots_from_mastodon("forwards");
			return true;
		} else {
			return false;
		}

	}

}
add_action( 'tootpress_cron_hook_newtoots', 'tootpress_cron_process_newtoots' );

/**
 * Defines the cron for requesting all toots
 * 
 * @since 0.1
 * 
 * @return bool
 */

function tootpress_cron_process_alltoots() {

	// Is Complete History Load active?
	$cron_status=get_option('tootpress_cron_alltoots_status');

	if($cron_status) {

		if(tootpress_ready_to_retrieve_toots_from_mastodon_api()){
			// Request API
			tootpress_copy_toots_from_mastodon("backwards");
			return true;
		} else {
			return false;
		}

	}

}
add_action( 'tootpress_cron_hook_alltoots', 'tootpress_cron_process_alltoots' );

/**
 * Schedules the crons
 * 
 * @since 0.1
 * 
 */

if( !wp_next_scheduled( 'tootpress_cron_hook_newtoots' ) ) {
	wp_schedule_event( time(), 'tootpress_schedule_newtoots', 'tootpress_cron_hook_newtoots' );
}
if( !wp_next_scheduled( 'tootpress_cron_hook_alltoots' ) ) {
		wp_schedule_event( time(), 'tootpress_schedule_alltoots', 'tootpress_cron_hook_alltoots' );
}

?>