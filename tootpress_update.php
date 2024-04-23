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
	if($tootpress_previous_version==1) {
		update_option('tootpress_plugin_version', "2");
	}

	/* Update Process Version 0.2.1 */
	if($tootpress_previous_version==2) {
		update_option('tootpress_plugin_version', "3");
	}

	/* Update Process Version 0.3 */
	if($tootpress_previous_version==3) {
		update_option('tootpress_plugin_version', "4");
		add_option('tootpress_backlink','0');
		add_option('tootpress_mastodon_account_name',"");
		if(tootpress_ready_to_retrieve_toots_from_mastodon_api()) {
			tootpress_retrieve_mastodon_account();
		}
		add_option('tootpress_rewrite_update','0');
	}
	
}
add_action( 'plugins_loaded', 'tootpress_update' );

?>