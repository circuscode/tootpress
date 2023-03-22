<?php

/**
 * Mastodon API Requests
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Create HTTP Authorization Header
 * 
 * @since 0.1
 * 
 * @return array Authorization Header with Auth Tokken
 */

function tootpress_create_authorization_header() {

    $mastodon_auth_token=tootpress_get_mastodon_auth_token();
    $authorization_header=array(
        'Authorization' => 'Bearer ' . $mastodon_auth_token
    );
    return $authorization_header;

};

/**
 * Create API Request Query Parameter
 * 
 * API Method: Get User Statuses (Account)
 * 
 * @since 0.1
 * 
 * @param string Timeline Direction (forwards/backwords)
 * @return array Query Parameter
 */

 function tootpress_create_query_param_get_account_statuses($direction) {

    // 1st Mastodon API Request
    if(!tootpress_get_latest_toot() OR !tootpress_get_oldest_toot()) {

        // Get 40 Toots without Boosts and Replys
        $query_param=array(
            'limit' => 40,
            'exclude_replies' => true,
            'exclude_reblogs' => true,
        );

    // Request Mastodon API forwards
    } elseif($direction=='forwards') {
   
   
        $since_id=tootpress_get_latest_toot();

        if($since_id) {
            // Get 40 Toots since the last Toot without Boosts and Replys
            $query_param=array(
                'limit' => 40,
                'since_id' => $since_id,
                'exclude_replies' => true,
                'exclude_reblogs' => true,
            );
        } 

    // Reqest the Mastodon API backwards
    } elseif($direction=='backwards') {

        $max_id=tootpress_get_oldest_toot();

        if($max_id) { 

            // Get 40 Toots before $max_id without Boosts and Replys
            $query_param=array(
                'limit' => 40,
                'max_id' => $max_id,
                'exclude_replies' => true,
                'exclude_reblogs' => true,
            );
        } 

    }

    return $query_param;

};

/**
 * Get Statuses
 * 
 * API Method: Get Statuses (Account)
 * 
 * @since 0.1
 * 
 * @param string Timeline Reading Direction (forwards/backwords)
 * @return array API Response JSON
 */

 function tootpress_mastodon_apirequest_account_get_statuses($direction) {

    $mastodon_instance=tootpress_get_mastodon_instance();
    $mastodon_account_id=tootpress_get_mastodon_account_id();

    $endpoint='https://'.$mastodon_instance.'/api/v1/accounts/'.$mastodon_account_id."/statuses";

    $args = array(
        'body' => tootpress_create_query_param_get_account_statuses($direction),
        'headers' => tootpress_create_authorization_header()
    );

    $response = wp_remote_get( $endpoint, $args );
    $body=wp_remote_retrieve_body($response);

    $json=json_decode($body, true);

    tootpress_mastodon_api_inkrement_amount_of_requests();

    return $json;

}

/**
 * Verify Credentials
 * 
 * API Method: Verify Credentials (Account)
 * 
 * @since 0.1
 * 
 * @return array API Response JSON
 */

function tootpress_mastodon_apirequest_account_verify_credentials () {

    $mastodon_instance=tootpress_get_mastodon_instance();

    $endpoint='https://'.$mastodon_instance.'/api/v1/accounts/verify_credentials';

    $args = array(
        'headers' => tootpress_create_authorization_header()
    );

    $response = wp_remote_get( $endpoint, $args );
    $body=wp_remote_retrieve_body($response);

    $json=json_decode($body, true);

    tootpress_mastodon_api_inkrement_amount_of_requests();

    return $json;

}

/**
 * Verifies instance
 * 
 * API Method: View Server Information (Instance)
 * 
 * @since 0.1
 * 
 * @param string Mastodon Instance
 * @return string Status Code
 */

function tootpress_mastodon_apirequest_instance_verify ($instance) {

    $endpoint='https://'.$instance.'/api/v2/instance';

    $response = wp_remote_get( $endpoint );
    $status_code=wp_remote_retrieve_response_code ($response);

    tootpress_mastodon_api_inkrement_amount_of_requests();

    return $status_code;

}

/**
 * Verifies the authcode
 * 
 * API Method: Verify Credentials (Account)
 * 
 * @since 0.1
 * 
 * @param string Auth Code
 * @return string Status Code
 */

 function tootpress_mastodon_apirequest_authcode_verify ($authcode) {

    $mastodon_instance=tootpress_get_mastodon_instance();

    $endpoint='https://'.$mastodon_instance.'/api/v1/accounts/verify_credentials';

    $args = array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $authcode
        )
    );

    $response = wp_remote_get( $endpoint, $args );
    $status_code=wp_remote_retrieve_response_code ($response);

    tootpress_mastodon_api_inkrement_amount_of_requests();

    return $status_code;

}

/**
 *  Verifies Readyness for API Requests with Authentication
 * 
 * @since 0.1
 * 
 * @return bool
 */

 function tootpress_ready_to_authenticate_with_mastodon_api() {

    $instance=tootpress_get_mastodon_instance();
    $accesstoken=tootpress_get_mastodon_auth_token();

    if($instance=='' OR $accesstoken == '') {
            return false;
        } else {
            return true;
        }

}

/**
 * Verifies Readyness for API Requests to retrieve Toots
 * 
 * @since 0.1
 * 
 * @return bool
 */

 function tootpress_ready_to_retrieve_toots_from_mastodon_api() {

    $instance=tootpress_get_mastodon_instance();
    $accesstoken=tootpress_get_mastodon_auth_token();
    $accountid=tootpress_get_mastodon_account_id();

    if($instance=='' OR $accesstoken=='' OR $accountid=='') {
            return false;
        } else {
            return true;
        }

}

/**
 * Inkrements the Number of previous API Requests
 * 
 * @since 0.1
 * 
 */

 function tootpress_mastodon_api_inkrement_amount_of_requests() {

    $amount_of_requests=get_option('tootpress_mastodon_amount_of_requests');
    ++$amount_of_requests;
    update_option('tootpress_mastodon_amount_of_requests',$amount_of_requests);

};

?>