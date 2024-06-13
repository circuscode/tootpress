<?php

/**
 * Hooks
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Fires hook when new toots are loaded
 * 
 * This hook can be used by other plugins to process after load functions.
 * For example: Refresh Cache
 * 
 * @since 0.1
 */

function tootpress_fire_toots_update() {
	do_action( 'tootpress_toots_update' );
}

/**
 * Example: tootpress_toots_update
 * 
 * @since 0.3.1
 * 
 * function tootpress_toots_update_postprocessing() {
 *
 * 		// Add your code to be executed here
 *
 * }
 * add_action('tootpress_toots_update', 'tootpress_toots_update_postprocessing');
 * 
 */

/**
 * Example: tootpress_preamble_filter
 * 
 * @since 0.3.1
 * 
 * @param string Preamble Contentless 
 * @return html Preamble Content
 *
 * function tootpress_preamble_add( $preamble ) {
 * 
 * 		// Add your filter code here
 * 		// Example: $preamble='<p>Hello World.</p>';
 * 
 * 		return $preamble;
 *
 * }
 * add_filter( 'tootpress_preamble_filter', 'tootpress_preamble_add', 10, 1 );
 * 
 */

?>