<?php

/**
 * URL
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Add TootPress to WordPress Query Vars
 * 
 * Query Variable "tootpress" is used for Paging
 * 
 * @since 0.1
 */

function tootpress_urlvars( $qvars )
{
$qvars[] = 'tootpress';
return $qvars;
}

add_filter('query_vars', 'tootpress_urlvars' );

/**
 * Reads the Query Var from URL
 * 
 * Used for Paging
 * 
 * @since 0.1
 * 
 * @return bool Yes or No
 */

function tootpress_get_query_var() {

	// Get Query from URL
    $qvar=get_query_var( 'tootpress');

	// If Query Var is not set
	if ($qvar=="") {$qvar="1";}

	return $qvar;
  
}

/**
 * Adds Rewrite Rule to Wordpress
 * 
 * For Query Variable "tootpress"
 * 
 * Example:
 * https://domain/slug/3 > https://domain/index.php?pagename=slug&tootpress=3
 * 
 * @since 0.1
 * 
 * @return array Rewrite Rules
 */

function tootpress_insert_rewrite( $rules ) {

	// Get the Page for Toots
	$pageid=get_option('tootpress_page_id');
	// Get the Slug for the toot page
    $slug = get_post_field( 'post_name', $pageid );

	// Create Rewrite Rules
	// () > Terms
	// \d+ > Integer
	// / > Seperator
	// $ > Both terms must exist
    $newrules = array();
    $newrules['('.$slug.')/(\d+)$'] = 'index.php?pagename=$matches[1]&tootpress=$matches[2]';
    return $newrules + $rules;
    
}
add_filter( 'rewrite_rules_array','tootpress_insert_rewrite' );

/**
 * Get TootPress Blog URL
 * 
 * @since 0.1
 * 
 * @return string URL
 */

function tootpress_blog_url() {

	return get_page_link();
	
}

?>