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
 * @param string Preamble
 * @return html Filtered Preamble
 */

function tootpress_preamble_filter_apply($preamble) {
	$preamble=apply_filters( 'tootpress_preamble_filter', $preamble );
	$preamble=wp_kses_post($preamble);
	return $preamble;
}

/**
 * Closing Filter
 * 
 * This filter outputs content after the last toot loop. 
 * 
 * @since 0.5
 * 
 * @param string Closing
 * @return html Filtered Closing
 */

function tootpress_closing_filter_apply($content) {
	$content=apply_filters( 'tootpress_closing_filter', $content );
	$content=wp_kses_post($content);
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
	$label=esc_html($label);
	return $label;
}

/**
 * Move Backward Filter
 * 
 * This filter overwrites the backward label in the menu
 * 
 * @since 0.5
 * 
 * @param string Original Label
 * @return string New Label
 */

function tootpress_menu_backward_filter_apply($label) {
	$label=apply_filters( 'tootpress_menu_backward_label', $label );
	$label=esc_html($label);
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
 * @param string Content
 * @param int TootPress Current Page Number
 * @return html Content
 */

function tootpress_beforeloop_filter_apply($content, $current_page_number) {

	$last_page_number=tootpress_amount_of_pages();

	$content=apply_filters( 'tootpress_beforeloop_filter', $content, $current_page_number, $last_page_number );

	$content=wp_kses_post($content);

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
 * @param string Content
 * @param int TootPress Current Page Number
 * @return html Content
 */

function tootpress_afterloop_filter_apply($content, $current_page_number) {

	$last_page_number=tootpress_amount_of_pages();

	$content=apply_filters( 'tootpress_afterloop_filter', $content, $current_page_number, $last_page_number );

	$content=wp_kses_post($content);

	return $content;
}

/**
 * Mastodon Logo Filter
 * 
 * This filter overwrites the Mastodon Logo with Custom Logo
 * 
 * @since 0.5
 * 
 * @param html Mastodon Logo
 * @return html Custom Logo
 */

function tootpress_mastodon_logo_filter_apply($img) {
	$img=apply_filters( 'tootpress_mastodon_logo_filter', $img );
	$img=wp_kses_post($img);
	return $img;
}

/**
 * Between Filter
 * 
 * This filter adds custom HTML between the toots
 * 
 * @since 0.5
 * 
 * @param string Content
 * @return html Between Content
 */

function tootpress_between_filter_apply($content) {
	$content=apply_filters( 'tootpress_between_filter', $content );	
	$content=wp_kses_post($content);
	return $content;
}

/**
 * Toot Content Filter
 * 
 * This filter can be used to manipulate the toot content
 * 
 * @since 0.5
 * 
 * @param html Content
 * @return html Filtered Content
 */

function tootpress_toot_content_filter_apply($content) {
	$content=apply_filters( 'tootpress_toot_content_filter', $content );
	$content=wp_kses_post($content);	
	return $content;
}

/**
 * Date Filter
 * 
 * This filter overwrites the date output with custom format
 * 
 * @since 0.5
 * 
 * @param string Date
 * @return string Custom Format
 */

function tootpress_date_filter_apply($date) {

	// 2023-05-30 22:40:28

	$year=substr($date,0,4);
	$month=substr($date,5,2);
	$day=substr($date,8,2);
	$hour=substr($date,11,2);
	$minute=substr($date,14,2);
	$second=substr($date,17,2);

	$date=apply_filters( 'tootpress_date_filter', $date, $year, $month, $day, $hour, $minute, $second );

	$date=esc_html($date);

	return $date;
}

/**
 * Image Filter
 * 
 * This filter can be used to manipulate image tags
 * 
 * @since 0.5
 * 
 * @param html Image Tag
 * @param string Image File Name
 * @param string Image Description
 * @param int Image Width
 * @param int Image Height
 * @param url TootPress Image Directory
 * @param int Amount of Images
 * @param int Image Number
 * @return html Filtered Image Tag
 */

function tootpress_image_filter_apply($img_tag,$filename,$description,$width,$height,$image_directory_path,$amount_of_images,$image_number) {

	$img_tag=apply_filters( 'tootpress_image_filter',$img_tag,$filename,$description,$width,$height,$image_directory_path,$amount_of_images,$image_number);

	$img_tag=wp_kses_post($img_tag);	

	return $img_tag;
}

?>