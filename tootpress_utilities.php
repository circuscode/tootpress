<?php

/**
 * Utilities
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Do we toot here? ;-)
 * 
 * @since 0.1
 * 
 * @return bool Yes or No
 */

function tootpress_toot_here() {

    $toot_page=tootpress_get_toot_page();
    $current_page=get_the_ID();

    if($toot_page==$current_page) {
        return true;
    } else {
        return false;
    }

}

/**
 * Are Toots in the Database?
 * 
 * @since 0.1
 * 
 * @return bool
 */

function tootpress_are_toots_in_the_database() {
	$amount=tootpress_get_amount_of_toots();
	if($amount>0) {
		return true;
	} else {
		return false;
	}
}

/**
 * Convert the MySQL Date to German Format
 * 
 * @since 0.1
 * 
 * @return string German Date
 */

function tootpress_convert_mysqldate_to_german_format($mysql_date) {
	$date_stamp = strtotime($mysql_date);
	$german_date = date_i18n( 'j. F Y H:i', $date_stamp ); 
	return $german_date;
}

/**
 * Convert the MySQL Date to International English Format
 * 
 * @since 0.1
 * 
 * @return string International Date
 */

 function tootpress_convert_mysqldate_to_international_format($mysql_date) {
	$date_stamp = strtotime($mysql_date);
	$international_date = date_i18n( 'Y/m/d H:i', $date_stamp ); 
	return $international_date;
}

/**
 * Removes target=_blank from String
 * 
 * @since 0.1
 */

 function tootpress_remove_target_blank($toot_content) {

	$output=str_replace('target="_blank" ','',$toot_content); 
	return $output;
}

/**
 * Checks if WordPress runs with german language
 * 
 * @since 0.1
 * 
 * @return bool
 */

function tootpress_is_language_german() {

	$this_wp_language=get_locale();

	if($this_wp_language=='de_DE') {
		return true;
	} else {
		return false;
	}

}

/**
 * Checks if Pretty Permalink is enabled
 * 
 * @since 0.1
 * 
 * @return bool
 */

function tootpress_is_pretty_permalink_enabled() {
	if (get_option('permalink_structure')) { 
		return true; 
	} 
	else { 
		return false; 
	}
}

?>