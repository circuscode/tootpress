<?php

/**
 * Healthy
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Executes Plugin Healthy Check
 * 
 * @since 0.1
 * 
 * @return html Result
 */

 function tootpress_healthy_check() {

	$output='';

	/* 
	Required Settings
	*/

	$output.='<p><strong>Settings</strong></p>';
	$output.='<p>';

	// Setting: Mastodon Instance
	if (tootpress_get_mastodon_instance()) {
		$output.='Mastodon Instance is set.';
	} else {
		$output.='<span class="tootpress-healtycheck-error">&nbsp;Error:&nbsp;</span> Mastodon Instance is missing.';
	}
	$output.='<br/>';

	// Setting: OAUTH API Token
	if (tootpress_get_mastodon_auth_token()) {
		$output.='OAUTH Access Token is set.';
	} else {
		$output.='<span class="tootpress-healtycheck-error">&nbsp;Error:&nbsp;</span> OAUTH Access Token is missing.';
	}
	$output.='<br/>';

	// Setting: Account ID
	if (tootpress_get_mastodon_account_id()) {
		$output.='Account ID is set.';
	} else {
		$output.='<span class="tootpress-healtycheck-error">&nbsp;Error:&nbsp;</span> Account ID is missing.';
	}
	$output.='<br/>';

	// Setting: Page ID
	if (tootpress_get_toot_page()) {
		$output.='Page ID is set.';
	} else {
		$output.='<span class="tootpress-healtycheck-warning">&nbsp;Warning:&nbsp;</span> Page ID is missing.';
	}
	$output.='</p>';

	/* 
	Checks
	*/

	$output.='<p><strong>Checks</strong></p>';
	$output.='<p>';

	// Check: Is Mastodon Instance running and healthy?
	$mastodon_instance=tootpress_get_mastodon_instance();
	$status_code=tootpress_mastodon_apirequest_instance_verify ($mastodon_instance);

	if(!$mastodon_instance) {
		$output.='<span class="tootpress-healtycheck-warning">&nbsp;Warning:&nbsp;</span> Mastodon Instance could not be verified.';
	} elseif ($status_code==200) {
		$output.='Mastodon Instance is up and running.';
	} else {
		$output.='<span class="tootpress-healtycheck-error">&nbsp;Error:&nbsp;</span>  Mastodon Instance is offline or in bad healthy.';
	}
	$output.='<br/>';

	// Check: Are Requests with Authentification possible?
	$oauth_token=tootpress_get_mastodon_auth_token();
	$status_code=tootpress_mastodon_apirequest_authcode_verify ($oauth_token);

	if(!$oauth_token) {
		$output.='<span class="tootpress-healtycheck-warning">&nbsp;Warning:&nbsp;</span> API request with authentification could not be made.';
	} elseif ($status_code==200) {
		$output.='API request with authentication could be executed successfully.';
	} else {
		$output.='<span class="tootpress-healtycheck-error">&nbsp;Error:&nbsp;</span>   API Request with Authentification has failed.';
	}
	$output.='<br/>';

	// Check: Are TootPress Folders in WordPress Uploads existing and writable?
	if ( ! file_exists( tootpress_get_apidata_directory() ) ) {
		$output.='<span class="tootpress-healtycheck-error">&nbsp;Error:&nbsp;</span> Directory /wp-content/uploads/tootpress-mastodonapidata not found.';
	} elseif (is_writable(tootpress_get_apidata_directory())) {
		$output.='Directory /wp-content/uploads/tootpress-mastodonapidata exists and is writable.';
  	} else {
		$output.='<span class="tootpress-healtycheck-error">&nbsp;Error:&nbsp;</span> Directory /wp-content/uploads/tootpress-mastodonapidata is not writable.';
  	}
	$output.='<br/>';
	if ( ! file_exists( tootpress_get_path_image_directory() ) ) {
		$output.='<span class="tootpress-healtycheck-error">&nbsp;Error:&nbsp;</span> Directory /wp-content/uploads/tootpress-images not found.';
	} elseif (is_writable(tootpress_get_path_image_directory())) {
		$output.='Directory /wp-content/uploads/ tootpress-images exists and is writable.';
  	} else {
		$output.='<span class="tootpress-healtycheck-error">&nbsp;Error:&nbsp;</span> Directory /wp-content/uploads/tootpress-images is not writable.';
  	}
	$output.='<br/>';

	// Check: Status allow_url_open
	// Required to copy images from Mastodon to WordPress Uploads Folder
	if (ini_get('allow_url_fopen'))  {
		$output.='PHP option allow_url_fopen is set to TRUE.';
  	} else {
		$output.='<span class="mathilda-healtycheck-error">&nbsp;Error:&nbsp;</span> PHP option allow_url_fopen is set to FALSE (0) on the webhosting environment. Please change to TRUE (1).';
  	}
	$output.='</p>';

	/* 
	Status
	*/

	$output.='<p><strong>Status</strong></p>';
	$output.='<p>';

	// Status: Steady Fetch
	$status_cron_newtoots=get_option('tootpress_cron_newtoots_status');
	if ($status_cron_newtoots) {
		$output.='Steady Fetch: Active';
	} else {
		$output.='Steady Fetch: Inactive';
	}
	$output.='<br/>';

	// Status: Complete Timeline
	$status_timeline_complete=get_option('tootpress_timeline_complete');
	$status_cron_alltoots=get_option('tootpress_cron_alltoots_status');
	if ($status_timeline_complete) {
		$output.='Complete Timeline: Loaded';
	} else {
		if($status_cron_alltoots) {
			$output.='Complete Timeline: in progress';
		} else {
			$output.='Complete Timeline: Not loaded';
		}
	}
	$output.='</p>';

	/* 
	Information
	*/

	$output.='<p><strong>Information</strong></p>';
	$output.='<p>';

	// Amount of previous API Requests
	$amount_of_api_requests=tootpress_get_amount_of_api_requests();
	$output.='Amount of Requests to Mastodon API: '.$amount_of_api_requests;
	$output.='<br/>';

	// Amount of Toots in Database
	$amount_of_toots=tootpress_get_amount_of_toots();
	$output.='Amount of Toots in Database: '.$amount_of_toots;
	$output.='<br/>';

	// Amount of Media in Database
	$amount_of_media=tootpress_get_amount_of_media();
	$output.='Amount of Media in Database: '.$amount_of_media;
	$output.='<br/>';

	// Latest Toot
	$latest_toot=tootpress_get_latest_toot();
	if($latest_toot){$output.='Latest Toot: '.$latest_toot.'<br/>';}

	// Oldest Toot
	$oldest_toot=tootpress_get_oldest_toot();
	if($oldest_toot){$output.='Oldest Toot: '.$oldest_toot.'<br/>';};

	// Last Insert
	$last_insert=get_option('tootpress_last_insert');
	if($last_insert){$output.='Last Insert: '.$last_insert.'<br/>';}

	// PHP Max Execution Time
	$this_environment_php_execution_time=ini_get('max_execution_time');
	if($this_environment_php_execution_time==0) {
		$output.='Max PHP script execution time: not limited';
	} else {
		$output.='Max PHP script execution time: '.$this_environment_php_execution_time.' Seconds';
	}

	$output.='</p>';

    return $output;
}

?>