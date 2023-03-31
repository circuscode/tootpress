<?php

/**
 * Files
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Creates the file directories
 * 
 * @since 0.1
 */

function tootpress_create_directories() {

	$mastodon_apidata_dirpath=tootpress_get_apidata_directory();
	if ( ! file_exists( $mastodon_apidata_dirpath ) ) {
		wp_mkdir_p( $mastodon_apidata_dirpath );
		}

	$mastodon_images_dirpath = tootpress_get_path_image_directory();
	if ( ! file_exists( $mastodon_images_dirpath ) ) {
		wp_mkdir_p( $mastodon_images_dirpath );
		}

}

/**
 * Create Mastodon API Response File
 * 
 * @since 0.1
 * 
 * @param array Mastodon API Response Array
 */

function tootpress_create_mastodon_apiresponse_file($toot_array) {

    $mastodon_apidata_dirpath = tootpress_get_apidata_directory();
    $time_now=date("YmdHis");

    $json=json_encode($toot_array);

	if ( file_exists( $mastodon_apidata_dirpath ) ) {
        $fp = fopen($mastodon_apidata_dirpath . "/mastodon_api_response_" . $time_now . '.json', "w");
        fwrite($fp, $json);
        fclose($fp);
	} else {
        return false;
    }

}

/**
 * Retrieve Image from Mastodon
 * 
 * @since 0.1
 * 
 * @param string Mastodon Image URL
 */

 function tootpress_retrieve_image_from_mastodon($image_url) {

    // If download function is not available, include it
    if ( ! function_exists( 'download_url' ) ) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
    }

    // Retrive Image from Mastodon
    $tmp_image_file = download_url( $image_url );

    // Create Storage Location URL
    $image_file_name = tootpress_get_image_name($image_url);
    $image_dir_path = tootpress_get_path_image_directory();
    $tootpress_image_wordpress_url = $image_dir_path . $image_file_name;

    if ( file_exists( $image_dir_path ) ) {
        // Save File to TootPress Image Directory
        if (!file_exists($tootpress_image_wordpress_url))
            {
                copy( $tmp_image_file, $tootpress_image_wordpress_url );
                @unlink( $tmp_image_file );
            }
    } else {
        return false;
    }

}

/**
 * Get API Data Directory Path
 * 
 * @since 0.1
 * 
 * @return string Mastodon API Data Directory Path
 */

function tootpress_get_apidata_directory() {

    $upload_dir = wp_upload_dir();
    $mastodon_apidata_dirname="tootpress-mastodonapidata";
    $mastodon_apidata_dirpath = $upload_dir['basedir'].'/'.$mastodon_apidata_dirname .'/';
    return $mastodon_apidata_dirpath;

}

/**
 * Get Image Directory Path
 * 
 * @since 0.1
 * 
 * @return string TootPress Images Directory Path
 */

function tootpress_get_path_image_directory() {

    $upload_dir = wp_upload_dir();
    $mastodon_image_dirname="tootpress-images";
    $mastodon_image_dirpath = $upload_dir['basedir'].'/'.$mastodon_image_dirname .'/';
    return $mastodon_image_dirpath;

}

/**
 * Get Image Directory URL
 * 
 * @since 0.1
 * 
 * @return string TootPress Images Directory URL
 */

 function tootpress_get_url_image_directory() {

    $upload_dir = wp_upload_dir();
    $mastodon_image_dirname="tootpress-images";
    $mastodon_image_dirpath = $upload_dir['baseurl'].'/'.$mastodon_image_dirname .'/';
    return $mastodon_image_dirpath;

}

/**
 * Get Image File Name
 * 
 * @since 0.1
 * 
 * @param string Image URL
 * @return string File Name
 */

function tootpress_get_image_name($image_url) {

    $image_file_name=substr(strrchr($image_url, "/"), 1);
    return $image_file_name;

}

?>