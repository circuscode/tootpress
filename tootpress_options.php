<?php

/**
 * Options
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Adds Page to Options Menu.
 * 
 * @since 0.1
 */

function tootpress_options_menu() {
    add_options_page('TootPress', 'TootPress', 'manage_options', 'tootpress-options', "tootpress_options_content");
}

add_action( 'admin_menu', 'tootpress_options_menu');

/**
 * Defines the TootPress Options Page
 * 
 * @since 0.1
 */

function tootpress_options_content() {

    // Header
	echo '
	<div class="wrap">
	<h1>Options › TootPress</h1>
	<p class="tootpress_settings">All Settings<br/>&nbsp;</p>
	
	<form method="post" action="options.php">';
	
    // Options
	do_settings_sections( 'tootpress-options' );
	settings_fields( 'tootpress_options' );
	submit_button();

	echo '</form></div><div class="clear"></div>';
}

/**
 * Displays the Input Fields.
 * 
 * @since 0.1
 */

 function tootpress_options_display_mastodon_instance()
 {
	 echo '<input class="regular-text" type="text" name="tootpress_mastodon_instance" id="tootpress_mastodon_instance" value="'. esc_attr(get_option('tootpress_mastodon_instance')) .'"/>';
 }
 
function tootpress_options_display_mastodon_oauth_access_token()
{
	echo '<input class="regular-text" type="text" name="tootpress_mastodon_oauth_access_token" id="tootpress_mastodon_oauth_access_token" value="'. esc_attr(get_option('tootpress_mastodon_oauth_access_token')) .'"/>';
}

function tootpress_options_display_mastodon_account_id()
{
	echo '<input type="text" name="tootpress_mastodon_account_id" id="tootpress_mastodon_account_id" value="'. esc_attr(get_option('tootpress_mastodon_account_id')) .'"/>';
}

function tootpress_options_display_page_id()
{
	echo '<input type="text" name="tootpress_page_id" id="tootpress_page_id" value="'. esc_attr(get_option('tootpress_page_id')) .'"/>';
}

function tootpress_options_display_amount_toots_page()
{
	echo '<input type="text" name="tootpress_amount_toots_page" id="tootpress_amount_toots_page" value="'. esc_attr(get_option('tootpress_amount_toots_page')) .'"/>';
}

function tootpress_options_display_cron_period()
{
	echo '<input type="text" name="tootpress_cron_period" id="tootpress_cron_period" value="'. esc_attr(tootpress_get_custom_cron_period_in_minutes()) .'"/>';
}

function tootpress_options_display_navigation()
{
	echo '<input type="radio" id="tootpress_navigation_standard" name="tootpress_navigation" value="standard" ' .  checked('standard', esc_attr(get_option('tootpress_navigation')), false) . '/>'; 
	echo '<label for="tootpress_navigation_standard">Standard</label>';
	echo '<br/>&nbsp;<br/>';
	echo '<input type="radio" id="tootpress_navigation_numbers" name="tootpress_navigation" value="numbers" ' .  checked('numbers', esc_attr(get_option('tootpress_navigation')), false) . '/>'; 
	echo '<label for="tootpress_navigation_numbers">Numbers</label>';
}	

function tootpress_options_display_css()
{
	echo '<input type="checkbox" name="tootpress_css" value="1" ' .  checked(1, esc_attr(tootpress_get_css_option()), false) . '/>'; 
}	

/**
 * Displays the Chapter Descriptions.
 * 
 * @since 0.1
 */

function tootpress_options_display_mastodonapi_description()
{ echo '<p>Following data is required to authenticate with the Mastodon API</p>'; }

function tootpress_options_display_plugin_description()
{ echo '<p>Basic Settings</p>'; }

function tootpress_options_display_userinterface_description()
{ echo '<p>Expert Settings</p>'; }

function tootpress_options_display_expert_description()
{ echo '<p>Process Settings</p>'; }

/**
 * Defines the Option Chapters including input fields
 * 
 * @since 0.1
 */

// Mastodon API Settings

function tootpress_options_mastodonapi_display()
{
	
	add_settings_section("mastodonapi_settings_section", "Mastodon API", "tootpress_options_display_mastodonapi_description", "tootpress-options");
	
	add_settings_field("tootpress_mastodon_instance", "Instance", "tootpress_options_display_mastodon_instance", "tootpress-options", "mastodonapi_settings_section");
	add_settings_field("tootpress_mastodon_oauth_access_token", "OAUTH Access Token", "tootpress_options_display_mastodon_oauth_access_token", "tootpress-options", "mastodonapi_settings_section");
	
	register_setting("tootpress_options", "tootpress_mastodon_instance","tootpress_validate_mastodon_instance");
	register_setting("tootpress_options", "tootpress_mastodon_oauth_access_token","tootpress_validate_mastodon_oauth_access_token");

}

// Plugin Basic Settings 

function tootpress_options_plugin_display()
{
	
	add_settings_section("plugin_settings_section", "Plugin", "tootpress_options_display_plugin_description", "tootpress-options");
	
	add_settings_field("tootpress_mastodon_account_id", "Account ID", "tootpress_options_display_mastodon_account_id", "tootpress-options", "plugin_settings_section");
	add_settings_field("tootpress_page_id", "Page ID", "tootpress_options_display_page_id", "tootpress-options", "plugin_settings_section");
	
	register_setting("tootpress_options", "tootpress_mastodon_account_id", "tootpress_validate_mastodon_account_id");
	register_setting("tootpress_options", "tootpress_page_id", "tootpress_validate_page_id");

}

// User Interface Settings 

function tootpress_options_userinterface_display()
{
	
	add_settings_section("userinterface_settings_section", "User Interface", "tootpress_options_display_userinterface_description", "tootpress-options");
	
	add_settings_field("tootpress_amount_toots_page", "Amount Toots Page", "tootpress_options_display_amount_toots_page", "tootpress-options", "userinterface_settings_section");
	add_settings_field("tootpress_navigation", "Navigation", "tootpress_options_display_navigation", "tootpress-options", "userinterface_settings_section");
	
	register_setting("tootpress_options", "tootpress_amount_toots_page", "tootpress_validate_amount_toots_page");
	register_setting("tootpress_options", "tootpress_navigation", "tootpress_validate_navigation");

}

// Expert Settings 

function tootpress_options_expert_display()
{
	
	add_settings_section("expert_settings_section", "Expert", "tootpress_options_display_expert_description", "tootpress-options");
	
	add_settings_field("tootpress_css", "Deactivate CSS", "tootpress_options_display_css", "tootpress-options", "expert_settings_section");;
	add_settings_field("tootpress_cron_period", "Period", "tootpress_options_display_cron_period", "tootpress-options", "expert_settings_section");
	
	register_setting("tootpress_options", "tootpress_css", "tootpress_validate_css");
	register_setting("tootpress_options", "tootpress_cron_period", "tootpress_validate_cron_period");

}

// Actions
add_action("admin_init", "tootpress_options_mastodonapi_display");
add_action("admin_init", "tootpress_options_plugin_display");
add_action("admin_init", "tootpress_options_userinterface_display");
add_action("admin_init", "tootpress_options_expert_display");

?>