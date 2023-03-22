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
 * Fires hook when new toots are loaded
 * 
 * This hook can be used by other plugins.
 * For example: Refresh Cache
 * 
 * @since 0.1
 */

 function tootpress_fire_toots_update() {
	do_action( 'tootpress_toots_update' );
}

?>