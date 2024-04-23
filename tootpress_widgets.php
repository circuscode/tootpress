<?php

/**
 * Widgets
 * 
 * @package TootPress
 * @since 0.3
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Add TootPress to Widget "At a Glance"
 * 
 * @since 0.3
 */
 
function tootpress_glance_counter() {
	
	$toots_count=tootpress_get_amount_of_toots();
    
    $text='<li class="post-count">';
    $text.='<a class="toot-count" href="">';
    $text.=esc_html($toots_count);;
    $text.=' Toots';
    $text.='</a></li>';

	echo $text;

}
add_filter( 'dashboard_glance_items', 'tootpress_glance_counter');

?>