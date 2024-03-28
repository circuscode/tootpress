<?php

/**
 * Get Functions
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Get Auth Token
 * 
 * @since 0.1
 * 
 * @return string Auth Token
 */

 function tootpress_get_mastodon_auth_token() {
    $mastodon_auth_token=get_option('tootpress_mastodon_oauth_access_token');
    return $mastodon_auth_token;
}

/**
 * Get Mastodon Instance
 * 
 * @since 0.1
 * 
 * @return string Mastodon Instance
 */

 function tootpress_get_mastodon_instance() {
    $mastodon_instance=get_option('tootpress_mastodon_instance');
    return $mastodon_instance;
}

/**
 * Get Mastodon Account ID
 * 
 * @since 0.1
 * 
 * @return string Mastodon Account ID
 */

 function tootpress_get_mastodon_account_id() {
    $mastodon_account_id=get_option('tootpress_mastodon_account_id');
    return $mastodon_account_id;
}

/**
 * Get latest Toot
 * 
 * @since 0.1
 * 
 * @return string Latest Toot from Options
 * @return boolean If Option is not set
 */

 function tootpress_get_latest_toot() {

    $latest_toot=get_option('tootpress_latest_toot');

    if($latest_toot) {
        return $latest_toot;
    } else {
        return false;
    }

}

/**
 * Get oldest Toot
 * 
 * @since 0.1
 * 
 * @return string Oldest Toot from Options
 * @return boolean If Option is not set
 */

 function tootpress_get_oldest_toot() {

    $oldest_toot=get_option('tootpress_oldest_toot');

    if($oldest_toot) {
        return $oldest_toot;
    } else {
        return false;
    }

}

/**
 * Get Custom Cron Period in Minutes
 * 
 * @since 0.1
 * 
 * @return int Custom Cron Period (in Minutes)
 */

 function tootpress_get_custom_cron_period_in_minutes() {

	$period=get_option('tootpress_cron_period');
	// Convert from Seconds to Minutes for User Interface
	$period=$period/60;
	return $period;

}

/**
 * Get Toot Page
 * 
 * @since 0.1
 * 
 * @return int Page ID
 */

 function tootpress_get_toot_page() {

	$pageid=get_option('tootpress_page_id');
	return $pageid;

}

/**
 * Get CSS Option
 * 
 * @since 0.1
 * 
 * @return int CSS Option
 */

 function tootpress_get_css_option() {

	$css=get_option('tootpress_css');

    if($css==0){
        $css=1;
    }else{
        $css=0;
    }

	return $css;

}

/**
 * Get Backlink Option
 * 
 * @since 0.3
 * 
 * @return int Backlink Option
 */

 function tootpress_get_backlink_option() {

	$backlink=get_option('tootpress_backlink');

	return $backlink;

}

/**
 * Get Page Slug of TootPress Page
 * 
 * @since 0.1
 * 
 * @return string 
 */

 function tootpress_get_slug() {

	$pageid=tootpress_get_toot_page();
	$slug = get_post_field( 'post_name', $pageid );
	return $slug;

}

?>