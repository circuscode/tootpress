<?php

/**
 * Update
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Executes the TootPress Update Routines
 * 
 * @since 0.1
 * 
 * @return html Result
 */

 function tootpress_update() {

	$tootpress_previous_version = get_option('tootpress_plugin_version');

	/* Update Process Version 0.2 */

	/*

	if($tootpress_previous_version==1) {
		
		// Code Here

		update_option('tootpress_plugin_version', "2");
		}

	*/

}
// add_action( 'plugins_loaded', 'tootpress_update' );

?>