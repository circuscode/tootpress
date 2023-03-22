<?php

/**
 * Process
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Core Process
 * 
 * @since 0.1
 * 
 * @param string API Reading Direction ('forwards'/'backwords')
 * @return bool Have new toots been loaded?
 */

 function tootpress_copy_toots_from_mastodon($direction) {

    // Make Mastodon API Call and retrieve data
    $array_toots=tootpress_mastodon_apirequest_account_get_statuses($direction);

    // Stop process, if no new toots are existing
    if(!array_key_exists('0', $array_toots)) {
 
        // Shutdown AllToots Cron, if last toot is loaded
        if($direction=='backwards') {
            update_option('tootpress_cron_alltoots_status','0');
            update_option('tootpress_timeline_complete', "1");
        }
        
        return false;
    } 

    // Save API Response as File
    tootpress_create_mastodon_apiresponse_file($array_toots);

    // Create filtered Toot and Media Caches
    $toot_cache=tootpress_create_toot_cache($array_toots);
    $media_cache=tootpress_create_media_cache($array_toots);

    // Retrieve Images
    $media_cache=tootpress_copy_images_from_mastodon($media_cache);

    // Save Caches to Database
    tootpress_save_tootcache_into_database($toot_cache);
    tootpress_save_media_into_database($media_cache);

    // Update Parameter
    tootpress_set_latest_toot();
    tootpress_set_oldest_toot();
    tootpress_set_last_insert();

    // Fire WordPress Hook
    tootpress_fire_toots_update();

    return true;
}

/**
 * Creates the toot cache
 * 
 * @since 0.1
 * 
 * @param array JSON Response from Mastodon API
 * @return array Array with Toots and attributes in scope
 */

 function tootpress_create_toot_cache($json_toots) {

    $toot_cache=array();

    foreach($json_toots as $attribute) {

        // Should this toot be processed?
        if(tootpress_is_toot_public($attribute['visibility'])) {

            $toot_media=0;

            // Does the toot contain attachments?
            if(array_key_exists('0', $attribute['media_attachments'])) {
                $toot_media=1;
            } 

            // Convert the ISO 8601 to MySQL Datetime Format
            $toot_date=iso8601_to_datetime($attribute['created_at']);

            // Fill array
            $toot_cache[]=array(
                'mastodon_id' => $attribute['id'],
                'date' => $toot_date,
                'content' => $attribute['content'],
                'media' => $toot_media
            );
        }

    }

    // Ensure a chrononical order in database storage
    sort($toot_cache);

    return $toot_cache;
}

/**
 * Creates the media cache
 * 
 * @since 0.1
 * 
 * @param array JSON Response from Mastodon API
 * @return array Array with media and attributes in scope
 */

 function tootpress_create_media_cache($json_toots) {

    $media_cache=array();

    foreach($json_toots as $attribute) {

        // Should this toot be processed?
        if(tootpress_is_toot_public($attribute['visibility'])) {

            // Does the toot contain attachments?
            if(array_key_exists('0', $attribute['media_attachments'])) {
            
                // Keep Reference Toot
                $toot_id=$attribute['id'];

                foreach($attribute['media_attachments'] as $media_attribute) {

                    // Should this attachment be processed?
                    if(tootpress_is_attachment_image($media_attribute['type'])) {

                        // Fill array
                        $media_cache[]=array(
                            'mastodon_id' => $media_attribute['id'],
                            'reference_toot' => $toot_id,
                            'file' => $media_attribute['url'],
                            'description' => $media_attribute['description'],
                            'width' => $media_attribute['meta']['original']['width'],
                            'height' => $media_attribute['meta']['original']['height']
                        );

                    }

                }

            } 

        }

    }

    // Ensure a chrononical order in the database
    sort($media_cache);

    return $media_cache;
}

/**
 * Saves the toot cache into database
 * 
 * @since 0.1
 * 
 * @param array Toot Cache
 */

function tootpress_save_tootcache_into_database($toot_cache) {
    
    foreach($toot_cache as $toot) {

        tootpress_add_toot(
            $toot['mastodon_id'],
            $toot['date'],
            $toot['content'],
            $toot['media']
        );

    }
}

/**
 * Saves the media cache into database
 * 
 * @since 0.1
 * 
 * @param array Toot Cache
 */

 function tootpress_save_media_into_database($media_cache) {
    
    // Does exist an entry in Media Cache?
    if(array_key_exists('0', $media_cache)) {

        foreach($media_cache as $attachment) {

            tootpress_add_media_attachment(
                $attachment['mastodon_id'],
                $attachment['reference_toot'],
                $attachment['file'],
                $attachment['description'],
                $attachment['width'],
                $attachment['height']
            );

        }
    }
}

/**
 * Copy Images from Mastodon
 * 
 * @since 0.1
 * 
 * @param array Media Cache
 */

function tootpress_copy_images_from_mastodon($media_cache) {

    // Does exist an entry in Media Cache?
    if(array_key_exists('0', $media_cache)) {

        foreach($media_cache as &$attribute) {
           
            // Retrieve image file
            tootpress_retrieve_image_from_mastodon($attribute['file']);
            // Transfrom image url to file name
            $attribute['file']=tootpress_get_image_name($attribute['file']);

        } 

    }

    return $media_cache;

}

/**
 * Verifies if Toot is public
 * 
 * @since 0.1
 * 
 * @param string Visibility Attribute
 * @return bool
 */

function tootpress_is_toot_public($visibility) {

    if ($visibility=='public') {
        return true;
    } else {
        return false;
    }

}

/**
 * Verifies if attachment is an image
 * 
 * @since 0.1
 * 
 * @param string Type Attribute
 * @return bool
 */

 function tootpress_is_attachment_image($type) {

    if ($type=='image') {
        return true;
    } else {
        return false;
    }

}

?>