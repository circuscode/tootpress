<?php

/**
 * Tools
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Adds Page to Tool Menu.
 * 
 * @since 0.1
 */

function tootpress_tools_menu() {
    	add_management_page(
            'Toots',
            'Toots',
            'manage_options',
            'tootpress-tools-menu',
            'tootpress_tools_controller'
        );
}
add_action('admin_menu', 'tootpress_tools_menu');

/**
 * Controls the tool page.
 * 
 * @since 0.1
 */

function tootpress_tools_controller() {
	
	echo '<div class="wrap">';

	// Apps
	$tootpress_copy_toots=false;
	$tootpress_cron_newtoots=false;
	$tootpress_cron_alltoots=false;
	$tootpress_retrieveid=false;
	$tootpress_healthy_check=false;
	$tootpress_factory_settings=false;

    /* 
	Which App to load?
	*/

	// Copy Toots
	if(isset($_GET['copytoots'])) {
		if($_GET['copytoots']=='true')
		{
		$tootpress_copy_toots=true;
		}	
	}
	// Switch Cron New Toots
	if(isset($_GET['cronnewtoots'])) {
		if($_GET['cronnewtoots']=='true')
		{
		$tootpress_cron_newtoots=true;
		}	
	}
	// Trigger Cron All Toots
	if(isset($_GET['cronalltoots'])) {
		if($_GET['cronalltoots']=='true')
		{
		$tootpress_cron_alltoots=true;
		}	
	}
	// Receive ID from Mastodon
	if(isset($_GET['retrieveid'])) {
		if($_GET['retrieveid']=='true')
		{
		$tootpress_retrieveid=true;
		}	
	}
	// Plugin Healthy Check
	if(isset($_GET['healthy'])) {
		if($_GET['healthy']=='true')
		{
		$tootpress_healthy_check=true;
		}	
	}
	// Factory Settings
	if(isset($_GET['factorysettings'])) {
		if($_GET['factorysettings']=='true')
		{
		$tootpress_factory_settings=true;
		}	
	}
	
	// App Loader
	if ($tootpress_copy_toots) {
		tootpress_copy_toots_load();
	} elseif ($tootpress_cron_newtoots) {
		tootpress_switch_cron_newtoots_load();
	} elseif ($tootpress_cron_alltoots) {
		tootpress_trigger_cron_alltoots_load();
	} elseif ($tootpress_retrieveid) {
		tootpress_retrieve_mastodonid();
	} elseif ($tootpress_healthy_check) {
		tootpress_healthy_check_load();
	} elseif ($tootpress_factory_settings) {
		tootpress_factory_settings_load();
	} else {
		// Display Tools, if no App selected
		tootpress_tools();
	}
	
	echo '</div>';
	
}

/**
 * Displays the tools
 * 
 * @since 0.1
 */

function tootpress_tools() {
	
	// Create Dynamic Label: Switch Cron New Toots
	if(get_option('tootpress_cron_newtoots_status')) {
		$button_newtoots_label='Deactivate';
	} else {
		$button_newtoots_label='Activate';
	}

	// Create Dynamic Label: Trigger Cron All Tools
	if(get_option('tootpress_cron_alltoots_status')) {
		$button_alltoots_label='In progress';
	} elseif (get_option('tootpress_timeline_complete')) {
		$button_alltoots_label='Loaded';
	} else {
		$button_alltoots_label='Load';
	}

	echo '
	
	<!-- headline -->
	<h1 class="tootpress_tools_headline">Toots</h1>
	<p class="tootpress_tools_description">TootPress Tools</p>

	<table class="form-table">
	
	<!-- List of Applications -->

	<!-- Copy Toots -->
	<tr valign="top">
	<th scope="row">
	<label for="copy-toots">Mastodon API Request</label>
	</th>
	<td>
	<a class="button" href="'.esc_url(admin_url()).'tools.php?page=tootpress-tools-menu&copytoots=true">Run</a>
	</td>

	<!-- Steady Fetch -->
	<tr valign="top">
	<th scope="row">
	<label for="cron-newtoots">Steady Fetch</label>
	</th>
	<td>
	<a class="button" href="'.esc_url(admin_url()).'tools.php?page=tootpress-tools-menu&cronnewtoots=true">'.esc_html($button_newtoots_label).'</a>
	</td>

	<!-- Complete Archiv -->
	<tr valign="top">
	<th scope="row">
	<label for="cron-alltoots">Complete Timeline</label>
	</th>
	<td>
	<a class="button" href="'.esc_url(admin_url()).'tools.php?page=tootpress-tools-menu&cronalltoots=true">'.esc_html($button_alltoots_label).'</a>
	</td>

	<!-- Receive ID -->
	<tr valign="top">
	<th scope="row">
	<label for="retrieve-id">Account ID</label>
	</th>
	<td>
	<a class="button" href="'.esc_url(admin_url()).'tools.php?page=tootpress-tools-menu&retrieveid=true">Retrieve</a>
	</td>

	<!-- Plugin Healthy Check -->
	<tr valign="top">
	<th scope="row">
	<label for="plugin-healthy-check">Healthy Check</label>
	</th>
	<td>
	<a class="button" href="'.esc_url(admin_url()).'tools.php?page=tootpress-tools-menu&healthy=true">Show Results</a>
	</td>

	<!-- Factory Settings -->
	<tr valign="top">
	<th scope="row">
	<label for="factory-settings">Factory Settings</label>
	</th>
	<td>
	<a class="button" href="'.esc_url(admin_url()).'tools.php?page=tootpress-tools-menu&factorysettings=true">Reset</a>
	</td>
	
	</table>';
	
}

/**
 * Outputs the bottom of the tool page
 * 
 * @since 0.1
 */

 function tootpress_tools_close() {
	
	echo '<p>&nbsp;<br/><a class="button" href="'.esc_url(admin_url()).'tools.php?page=tootpress-tools-menu">Back to TootPress Tools</a></p>';
	
}

/**
 * Request Mastodon API
 * 
 * @since 0.1
 */

 function tootpress_copy_toots_load() {
	
	echo '<h1 class="tootpress_tools_headline">Toots</h1>';
	echo '<p class="tootpress_tools_description">Mastodon API Request<br/>&nbsp;</p>';
	
	if(tootpress_ready_to_retrieve_toots_from_mastodon_api()) {

		// Run API Request
		$api_response=tootpress_copy_toots_from_mastodon("forwards");

		// Result API Request
		if($api_response) {
			echo '<p>Request done.<br/>';
			echo 'New toots have been loaded.</p>';
		} else {
			echo '<p>Request done.<br/>';
			echo 'No new toots on Mastodon.</p>';
		}

	} else {
		// TootPress is not ready to run
		echo '<p>Request not possible.</p>';
		echo wp_kses( tootpress_error_message_required_api_options_missing(), tootpress_escaping_allowed_html() );
	} 

	tootpress_tools_close();

}

/**
 * Steady Load
 * 
 * @since 0.1
 */

 function tootpress_switch_cron_newtoots_load() {
	
	echo '<h1 class="tootpress_tools_headline">Toots</h1>';
	echo '<p class="tootpress_tools_description">Steady Fetch<br/>&nbsp;</p>';

	// Current cron status
	$status_cron_newtoots=get_option('tootpress_cron_newtoots_status');

	if(!$status_cron_newtoots) {

		if(tootpress_ready_to_retrieve_toots_from_mastodon_api()) {
			// Activate Steady Load
			update_option('tootpress_cron_newtoots_status','1');
			$period=tootpress_get_custom_cron_period_in_minutes();
			echo '<p>Cron was activated.<br/>';
			echo 'Steady Fetch runs every '.esc_html($period).' Minutes.<br/>';
			echo 'New Toots will be added automatically.</p>';
		} else {
			// TootPress is not ready to run
			echo '<p>Steady Fetch could not be activated.</p>';
			echo wp_kses( tootpress_error_message_required_api_options_missing(), tootpress_escaping_allowed_html() );
		}

	} else {
		// Deactivate Steady Load
		update_option('tootpress_cron_newtoots_status','0');
		echo '<p>Cron was deactivated.<br/>';
		echo 'New toots are no longer loaded automatically.</p>';
	}

	tootpress_tools_close();

}

/**
 * Complete Timeline
 * 
 * @since 0.1
 */

 function tootpress_trigger_cron_alltoots_load() {
	
	echo '<h1 class="tootpress_tools_headline">Toots</h1>';
	echo '<p class="tootpress_tools_description">Complete Timeline<br/>&nbsp;</p>';

	// Has the timeline already loaded?
	if(get_option('tootpress_timeline_complete')) {
		echo '<p>Your Mastodon Timeline is already loaded completely.</p>';
	} else {

		// Current Cron Status
		$status_cron_alltoots=get_option('tootpress_cron_alltoots_status');

		if($status_cron_alltoots) {
			// Complete Timeline Load is already running
			echo '<p>Procedure in progress.<br/>';
			echo '480 toots are loaded per hour.<br/>';
			echo 'Until the timeline is complete.</p>';
		} else {

			if(tootpress_ready_to_retrieve_toots_from_mastodon_api()) {
				// Initiate Complete Timeline  Load
				update_option('tootpress_cron_alltoots_status','1');
				echo '<p>Procedure is initated.<br/>';
				echo 'Your Mastodon Timeline will be loaded shortly.</p>';
			} else {
				// TootPress is not ready to run
				echo '<p>Procedure could not be activated.</p>';
				echo wp_kses( tootpress_error_message_required_api_options_missing(), tootpress_escaping_allowed_html() );
			}

		}

	}

	tootpress_tools_close();

}

/**
 * Receive the Mastodon ID
 * 
 * @since 0.1
 */

 function tootpress_retrieve_mastodonid() {
	
	echo '<h1 class="tootpress_tools_headline">TootPress › Mastodon ID</h1>';
	echo '<p class="tootpress_tools_description">Retrieve<br/>&nbsp;</p>';

	if(tootpress_ready_to_authenticate_with_mastodon_api()) {

		// API Request: Verify Credentials
		$verifycrendentials=tootpress_mastodon_apirequest_account_verify_credentials();
		$mastodonid=$verifycrendentials['id'];
		
		echo '<p>Your Mastodon Account ID is the following.</p>';
		echo '<p>'.esc_html($mastodonid).'</p>';

	} else {
		echo wp_kses( tootpress_error_message_instance_andor_token_missing(), tootpress_escaping_allowed_html() );
	}

	tootpress_tools_close();

}

/**
 * Prepares the page for Healthy Check
 * 
 * @since 0.1
 */

function tootpress_healthy_check_load() {
	
	echo '<h1 class="tootpress_tools_headline">TootPress › Healthy Check</h1>';
	echo '<p class="tootpress_tools_description">Analysis<br/>&nbsp;</p>';
	$health_status=tootpress_healthy_check();
	echo wp_kses( $health_status, tootpress_escaping_allowed_html() );
	tootpress_tools_close();

}

/**
 * Factory Settings
 * 
 * @since 0.1
 */

 function tootpress_factory_settings_load() {
	
	echo '<h1 class="tootpress_tools_headline">TootPress › Factory Settings</h1>';
	echo '<p class="tootpress_tools_description">Restore<br/>&nbsp;</p>';
	
	tootpress_restore_factory_settings();

	echo '<p>';
	echo '* Toots were removed<br/>';
	echo '* Media were removed<br/>';
	echo '* Cron was deactivated<br/>';
	echo '* Settings set to default<br/>';
	echo '* Files in Uploads have to be removed manually<br/>';
	echo '</p>';
	
	tootpress_tools_close();

}

?>