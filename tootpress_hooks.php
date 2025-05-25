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
 * Actions
 */

/**
 * Fires when new toots are loaded
 * 
 * This hook can be used by other plugins to process after load functions.
 * For example: Cache Refresh
 * 
 * @since 0.1
 */

function tootpress_fire_toots_update() {
	do_action( 'tootpress_toots_update' );
}

/**
 * Action Example: tootpress_toots_update
 * 
 * @since 0.4
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
 * Filter
 */

/**
 * Preample
 * 
 * This filter outputs html content before the toot loop. 
 * 
 * @since 0.4
 * 
 * @param string Unfiltered Preample
 * @return html Filtered Preample
 */

function tootpress_preamble_filter_apply($preamble) {
	$preamble.=apply_filters( 'tootpress_preamble_filter', $preamble );
	return $preamble;
}

/**
 * Filter Example: tootpress_preamble_filter
 * 
 * @since 0.4
 * 
 * @param string Unfiltered Preample
 * @return html Filtered Preample
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

/**
 * Afterloop Filter
 * 
 * This filter outputs html content after the toot loop. 
 * 
 * @since 0.5
 * 
 * @param string Unfiltered Content
 * @return html Filtered Content
 */

function tootpress_afterloop_filter_apply($content) {
	$content.=apply_filters( 'tootpress_afterloop_filter', $content );
	return $content;
}

/**
 * Filter Example: tootpress_afterloop_filter
 * 
 * @since 0.5
 * 
 * @param string Unfiltered Content
 * @return html Filtered Content
 *
 * function tootpress_afterloop_add( $content ) {
 * 
 * 		// Add your filter code here
 * 		// Example: $content='<p>Hello World.</p>';
 * 
 * 		return $content;
 *
 * }
 * add_filter( 'tootpress_afterloop_filter', 'tootpress_afterloop_add', 10, 1 );
 * 
 */

?>