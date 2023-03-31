<?php

/**
 * Plugin
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Adds Blog CSS
 * 
 * @since 0.1
 */

function tootpress_blogs_css() {
	// Load CSS only on Toots Page
	if ( tootpress_toot_here() ){
		// Load CSS only if Option is set
		if(get_option('tootpress_css')) {
			wp_register_style( 'tootpress', plugins_url( 'tootpress_toots.css' ) );
			wp_enqueue_style( 'tootpress' );
		}
	}
}
add_action('wp_enqueue_scripts','tootpress_blogs_css');

/**
 * Adds Admin CSS
 * 
 * @since 0.1
 */

 function tootpress_admin_css($hook) {
	// Load CSS only on Toots Tools Page
	if ( 'tools_page_tootpress-tools-menu' != $hook ) {
        return;
    }
	wp_register_style( 'tootpress', plugins_url( 'tootpress_tools.css' ) );
	wp_enqueue_style( 'tootpress' );
}
add_action( 'admin_enqueue_scripts', 'tootpress_admin_css' );

/**
 * Adds Mathilda Flag
 * 
 * @since 0.1
 * 
 * @param string CSS Body Class
 * @return string CSS Body Class
 */

function tootpress_flag( $classes ) {

	if ( tootpress_toot_here() ) {
        $classes[] = 'tootpress-is-here';
        return $classes;
    }
	else {
		$classes[] = 'tootpress-is-not-here';
        return $classes;
	}
}
add_filter( 'body_class', 'tootpress_flag' );

/**
 * Returns allowed HTML tags
 * 
 * Used for escaping echos
 * 
 * @since 0.2
 * 
 * @return array Allowed HTML Tags
 */

function tootpress_escaping_allowed_html() {
	return array(
		'p' => array(),
		'div' => array(
			'class' => array(),
		),
		'img' => array(
			'src' => array(),
			'alt' => array(),
		),
        'br' => array(),
		'strong' => array(),
		'span' => array(
			'class' => array(),
		),
		'a' => array(
			'class' => array(),
			'href' => array(),
			'rel' => array(),
		),
	);
}

?>