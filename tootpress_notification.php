<?php

/**
 * Notifications
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Create Error Message: Required API Options not maintained
 * 
 * @since 0.1
 * 
 * @return string Error Message
 */

function tootpress_error_message_required_api_options_missing() {
	$message='<p>';
	$message.='Information required to request Mastodon API are not available.';
	$message.='<br/>';
	$message.='Mastodon Instance, OAUTH Access Token, Account ID have to be added in Plugin Options.';
	$message.='</p>';
	return $message;
}

/**
* Create Error Message: Mastodon Instance and/or OAUTH Access Token not maintained
* 
* @since 0.1
* 
* @return string Error Message
*/

function tootpress_error_message_instance_andor_token_missing() {
   $message='<p>';
   $message.='Information required to retrieve Mastodon Account ID is not available.';
   $message.='<br/>';
   $message.='Mastodon Instance and/or OAUTH Access Token are missing in Plugin Options.';
   $message.='</p>';
   return $message;
}

?>