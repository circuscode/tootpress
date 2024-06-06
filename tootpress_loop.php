<?php

/**
 * Loop
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Starts TootPres in the Blog
 * 
 * @since 0.1
 * 
 * @param html Content WordPress
 * @return html Content TootPress or WordPress
 */

function tootpress_content($content) {

    // Should we toot here?
    // Are any Toots in the Database?
    // Is this the FrontEnd?
    if (tootpress_toot_here() & tootpress_are_toots_in_the_database() & !is_admin()) {

        // TootPress Paging
        $tootpress_current_page=tootpress_get_query_var();

        // TootPress Content
        $tootpress_content='<div id="tootpress-area">';

        // TootPress Preamble
        $tootpress_content.=tootpress_paint_preamble();

        // TootPress Loop
        $tootpress_content.=tootpress_loop($tootpress_current_page);

        // TootPress Bottom Navigation
        $tootpress_content.=tootpress_create_menu($tootpress_current_page);

        // TootPress End
        $tootpress_content.='</div>';

        return $tootpress_content;

    } else {
        return $content;
    }
    
}
add_filter ('the_content', 'tootpress_content');

/**
 * TootPress Loop
 * 
 * @since 0.1
 * 
 * @param int TootPress Page Numnber
 * @return html Toots
 */

 function tootpress_loop($range) {

    $tootloop='';
    $amount_toots_page=get_option('tootpress_amount_toots_page');

    // Read Toots
    $toot_cache=array();
    $toot_cache=tootpress_get_toots_from_database($amount_toots_page, $range);
    $amount_toots_cache=count($toot_cache);

    // Get Configuration
    $mastodon_instance=tootpress_get_mastodon_instance();
    $mastodon_account=tootpress_get_mastodon_account_name();
    $tootpress_backlink=tootpress_get_backlink_option();

    // Loop
    if($amount_toots_cache>0) {

        foreach($toot_cache as $toot) {

            // Paint
            $tootloop.=tootpress_paint_toot( $toot['toot_mastodon_id'], $toot['toot_date'], $toot['toot_content'], $toot['toot_media'], $mastodon_instance, $mastodon_account, $tootpress_backlink);
    
        }

    }

    return $tootloop;

}

?>