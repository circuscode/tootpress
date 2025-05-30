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
 * This filter outputs html content before the initial toot loop. 
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
 * Closing Filter
 * 
 * This filter outputs content after the last toot loop. 
 * 
 * @since 0.5
 * 
 * @param string Content
 * @return string Filtered Content
 */

function tootpress_closing_filter_apply($content) {
	$content.=apply_filters( 'tootpress_closing_filter', $content );
	return $content;
}

/**
 * Filter Example: tootpress_closing_filter
 * 
 * @since 0.5
 * 
 * @param string Content
 * @return string Filtered Content
 *
 * function tootpress_closing_add( $content ) {
 * 
 * 		// Add your filter code here
 * 		// Example: $content='<p>Hello World.</p>';
 * 
 * 		return $content;
 *
 * }
 * add_filter( 'tootpress_closing_filter', 'tootpress_closing_add', 10, 1 );
 * 
 */

/**
 * Move Forward Filter
 * 
 * This filter overwrites the forward label in the menu
 * 
 * @since 0.5
 * 
 * @param string Label Forward
 * @return string New Label
 */

function tootpress_menu_forward_filter_apply($label) {
	$label=apply_filters( 'tootpress_menu_forward_label', $label );
	return $label;
}

/**
 * Usage Example: tootpress_menu_forward_label
 * 
 * @param string Label Forward
 * @return string New Label
 *
 * function tootpress_menu_forward_label_change( $label ) {
 * 
 * 		// Add your filter code here
 * 		// Example: $label='Newer Posts';
 * 
 * 		return $label;
 *
 * }
 * add_filter( 'tootpress_menu_forward_label', 'tootpress_menu_forward_label_change', 10, 1 );
 * 
 */
 
?>