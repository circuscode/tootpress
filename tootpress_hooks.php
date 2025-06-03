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
 * This action will be fired after toot update to execute custom post-processing.  
 * For example: Cache Refresh
 * 
 * @since 0.1
 */

function tootpress_fire_toots_update() {
	do_action( 'tootpress_toots_update' );
}

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
 * @param string Empty Preample
 * @return html Filtered Preample
 */

function tootpress_preamble_filter_apply($preamble) {
	$preamble=apply_filters( 'tootpress_preamble_filter', $preamble );
	return $preamble;
}

/**
 * Closing Filter
 * 
 * This filter outputs content after the last toot loop. 
 * 
 * @since 0.5
 * 
 * @param string Empty Content
 * @return string Filtered Content
 */

function tootpress_closing_filter_apply($content) {
	$content=apply_filters( 'tootpress_closing_filter', $content );
	return $content;
}

/**
 * Move Forward Filter
 * 
 * This filter overwrites the forward label in the menu
 * 
 * @since 0.5
 * 
 * @param string Original Label
 * @return string New Label
 */

function tootpress_menu_forward_filter_apply($label) {
	$label=apply_filters( 'tootpress_menu_forward_label', $label );
	return $label;
}

/**
 * Move Backward Filter
 * 
 * This filter overwrites the backward label in the menu
 * 
 * @since 0.5
 * 
 * @param string Original Backward
 * @return string New Label
 */

function tootpress_menu_backward_filter_apply($label) {
	$label=apply_filters( 'tootpress_menu_backward_label', $label );
	return $label;
}

/**
 * Before Loop Filter
 * 
 * This filter outputs content before the toot loop.
 * It will be applied on all tootpress pages.
 * 
 * @since 0.5
 * 
 * @param int TootPress Current Page Number
 * @return string Content
 */

function tootpress_beforeloop_filter_apply($current_page_number) {

	$content='';
	$last_page_number=tootpress_amount_of_pages();

	$content=apply_filters( 'tootpress_beforeloop_filter', $content, $current_page_number, $last_page_number );

	return $content;
}

/**
 * After Loop Filter
 * 
 * This filter outputs content after the toot loop.
 * It will be applied on all tootpress pages.
 * 
 * @since 0.5
 * 
 * @param int TootPress Current Page Number
 * @return string Content
 */

function tootpress_afterloop_filter_apply($current_page_number) {

	$content='';
	$last_page_number=tootpress_amount_of_pages();

	$content=apply_filters( 'tootpress_afterloop_filter', $content, $current_page_number, $last_page_number );

	return $content;
}

?>