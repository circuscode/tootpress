<?php

/*
Plugin Name:  TootPress
Description:  TootPress copies your Toots from Mastodon to WordPress.
Version:	  0.3.1
Author:       Marco Hitschler
Author URI:   https://www.unmus.de/
License:      GPL3
License URI:  https://www.gnu.org/licenses/gpl-3.0.html
Domain Path:  /languages
Text Domain:  tootpress
*/

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

// Basic Setup: Include program files
require_once('tootpress_install.php');
require_once('tootpress_update.php');
require_once('tootpress_plugin.php');
require_once('tootpress_options.php');
require_once('tootpress_validate.php');
require_once('tootpress_api.php');
require_once('tootpress_files.php');
require_once('tootpress_database.php');
require_once('tootpress_process.php');
require_once('tootpress_cron.php');
require_once('tootpress_hooks.php');
require_once('tootpress_tools.php');
require_once('tootpress_healthy.php');
require_once('tootpress_utilities.php');
require_once('tootpress_reports.php');
require_once('tootpress_url.php');
require_once('tootpress_loop.php');
require_once('tootpress_blog.php');
require_once('tootpress_menu.php');
require_once('tootpress_widgets.php');
require_once('tootpress_notification.php');
require_once('tootpress_get.php');
require_once('tootpress_set.php');
require_once('tootpress_developer.php');
require_once('tootpress_script.php');

// Ensure that all required functions are available during setup
require_once( ABSPATH . 'wp-admin/includes/upgrade.php');

// Hooks
register_activation_hook( __FILE__ , 'tootpress_activate' );
register_uninstall_hook( __FILE__ , 'tootpress_delete' );
register_deactivation_hook( __FILE__ , 'tootpress_deactivate' );

?>
