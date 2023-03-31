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
	if ( tootpress_toot_here() ){
		if(get_option('tootpress_css')) {
			$add_css='<link rel="stylesheet" id="mathilda-css" href="'. plugins_url() .'/tootpress/tootpress_toots.css" type="text/css" media="all">';
			echo $add_css;
		}
	}
}

add_action('wp_head','tootpress_blogs_css');

/**
 * Adds Admin CSS
 * 
 * @since 0.1
 */

 function tootpress_admin_css() {
	$add_css='<link rel="stylesheet" id="tootpress-css" href="'. plugins_url() .'/tootpress/tootpress_tools.css" type="text/css" media="all">';
	echo $add_css;
}
add_action( 'admin_head', 'tootpress_admin_css' );

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
        'br' => array(),
		'strong' => array(),
		'span' => array(
			'class' => array(),
		),
	);
}

?>