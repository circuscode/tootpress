<?php

/**
 * Developer Tools
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

function tootpress_tools_dev_menu() {
    	add_management_page(
            'Toots Developer',
            'Toots Developer',
            'manage_options',
            'tootpress-tools-dev-menu',
            'tootpress_tools_dev_controller'
        );
}

// Display developer tools only, if option is set
$tootpress_developer=get_option('tootpress_developer');
if ($tootpress_developer == 1)
{
add_action('admin_menu', 'tootpress_tools_dev_menu');
}

/**
 * Controls the output of the tool page.
 * 
 * @since 0.1
 */

function tootpress_tools_dev_controller() {
	
	echo '<div class="wrap">';

	// Apps
	$tootpress_scripting=false;
	$tootpress_clearing=false;

    /* 
	Which App to load?
	*/

	// Scripting
	if(isset($_GET['scripting'])) {
		if($_GET['scripting']=='true')
		{
		$tootpress_scripting=true;
		}	
	}
	// Clearing
	if(isset($_GET['clearing'])) {
		if($_GET['clearing']=='true')
		{
		$tootpress_clearing=true;
		}	
	}
	
	// App Loader
	if ($tootpress_scripting) {
		tootpress_script_load();
	}
	elseif ($tootpress_clearing) {
		tootpress_clearing_load();
	} else {
		// Display Apps, if no App selected
		tootpress_tools_developer();
	}
	
	echo '</div>';
	
}

/**
 * Displays the developer tools
 * 
 * @since 0.1
 */

function tootpress_tools_developer() {
	
	echo '
	
	<!-- headline -->
	<h1 class="tootpress_tools_headline">Toots Developer</h1>
	<p class="tootpress_tools_description">Helper Tools</p>

	<table class="form-table">
	
	<!-- Run the script -->
	<tr valign="top">
	<th scope="row">
	<label for="cron">Run Script</label>
	</th>
	<td>
	<a class="button" href="'.admin_url(). 'tools.php?page=tootpress-tools-dev-menu&scripting=true">Yes!</a>
	</td>
	</tr>

	<!-- Clear Data -->
	<tr valign="top">
	<th scope="row">
	<label for="cron">Start afresh</label>
	</th>
	<td>
	<a class="button" href="'.admin_url(). 'tools.php?page=tootpress-tools-dev-menu&clearing=true">Do!</a>
	</td>
	</tr>
	
	</table>';
	
}

/**
 * Executes the script tool
 * 
 * @since 0.1
 */

function tootpress_script_load() {
	
	echo '<h1 class="tootpress_tools_headline">TootPress › Scripting</h1>';
	echo '<p class="tootpress_tools_description">Output<br/>&nbsp;</p>';
	tootpress_scripting();
	tootpress_tools_dev_close();

}

/**
 * Executes the data clearing
 * 
 * @since 0.1
 */

 function tootpress_clearing_load() {

	tootpress_clear_data();
	
	echo '<h1 class="tootpress_tools_headline">TootPress › Start afresh</h1>';
	echo '<p class="tootpress_tools_description">Following data were reset.</p>';
	echo '<p>';
	echo '* Toots<br/>';
	echo '* Media<br/>';
	echo '* Option Latest Toot<br/>';
	echo '* Option Oldest Toot<br/>';
	echo '* Option Last Insert<br/>';
	echo '* Option Timeline Complete<br/>';
	echo '* Option Cron NewToots Status<br/>';
	echo '* Option Cron AllToots Status<br/>';
	echo '</p>';

	tootpress_tools_dev_close();

}

/**
 * Outputs the bottom of the tool page
 * 
 * @since 0.1
 */

function tootpress_tools_dev_close() {
	
	echo '<p>&nbsp;<br/><a class="button" href="'.esc_url(admin_url()).'tools.php?page=tootpress-tools-dev-menu">Back to TootPress Tools</a></p>';
	
}

/**
 * Adds Developer Options Page to Options Menu.
 * 
 * @since 0.1
 */

function tootpress_options_dev_menu() {
    add_options_page('TootPress Developer', 'TootPress Developer', 'manage_options', 'tootpress-options-dev', "tootpress_options_dev_content");
}

// Display developer option only, if option is set
$tootpress_developer=get_option('tootpress_developer');
if ($tootpress_developer == 1)
{
add_action( 'admin_menu', 'tootpress_options_dev_menu');
}

/**
 * Defines the TootPress Developer Options Page
 * 
 * @since 0.1
 */

function tootpress_options_dev_content() {

    // Header
	echo '
	<div class="wrap">
	<h1>Options › TootPress Developer</h1>
	<p class="tootpress_settings_dev">Internal Process Options<br/>&nbsp;</p>
	
	<form method="post" action="options.php">';
	
    // Options
	do_settings_sections( 'tootpress-options-dev' );
	settings_fields( 'tootpress_options_dev' );
	submit_button();

	echo '</form></div><div class="clear"></div>';
}

/**
 * Displays the Input Fields for Developers.
 * 
 * @since 0.1
 */

 function tootpress_options_dev_display_latest_toot()
 {
	 echo '<input class="regular-text" type="text" name="tootpress_latest_toot" id="tootpress_latest_toot" value="' . esc_attr(get_option('tootpress_latest_toot')) .'"/>';
 }

 function tootpress_options_dev_display_oldest_toot()
 {
	 echo '<input class="regular-text" type="text" name="tootpress_oldest_toot" id="tootpress_oldest_toot" value="'. esc_attr(get_option('tootpress_oldest_toot')) .'"/>';
 }

/**
 * Displays the Developer Chapter Description.
 * 
 * @since 0.1
 */

function tootpress_options_dev_display_description()
{ echo '<p>Database Values</p>'; }

/**
 * Defines the Developer Option Chapters including input fields
 * 
 * @since 0.1
 */

function tootpress_options_dev_display()
{
	
	add_settings_section("tootpress_settings_dev_section", "Read / Manipulate", "tootpress_options_dev_display_description", "tootpress-options-dev");
	
	add_settings_field("tootpress_latest_toot", "Latest Toot", "tootpress_options_dev_display_latest_toot", "tootpress-options-dev", "tootpress_settings_dev_section");
	add_settings_field("tootpress_oldest_toot", "Oldest Toot", "tootpress_options_dev_display_oldest_toot", "tootpress-options-dev", "tootpress_settings_dev_section");
	
	register_setting("tootpress_options_dev", "tootpress_latest_toot");
	register_setting("tootpress_options_dev", "tootpress_oldest_toot");

}

// Actions
add_action("admin_init", "tootpress_options_dev_display");

?>