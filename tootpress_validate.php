<?php

/**
 * Validate Funtions
 * 
 * @package TootPress
 * @since 0.1
 */

// Security: Stops code execution if WordPress is not loaded
if (!defined('ABSPATH')) { exit; }

/**
 * Validates the Mastodon Instance
 * 
 * @since 0.1
 * 
 * @param string Input Field Mastodon Instance
 * @return string Verified Mastodon Instance (true) or null (false)
 */

 function tootpress_validate_mastodon_instance ($instance) {
    
    if($instance<>''){

        // Remove http/https & last Slash from input
        $instance=str_replace(array('http://','https://'), '', $instance);
        $instance=rtrim($instance,'/');

        // Request given instance
        $status_code=tootpress_mastodon_apirequest_instance_verify ($instance);
    
        // If Request failed
        if($status_code<>200) {
            add_settings_error( 'tootpress-options', 'invalid-instance', 'Instance: No Mastodon Instance under the given name' );
            $instance='';
        }
    }

    return $instance;
}

/**
 * Validates the OAUTH Access Token
 * 
 * @since 0.1
 * 
 * @param string Input Field OAUTH Access Token
 * @return string Verified Access Token (true) or null (false)
 */

function tootpress_validate_mastodon_oauth_access_token ($accesstoken) {
    
    if($accesstoken<>'') {

        // Is Mastodon Instance maintained?
        if(get_option('tootpress_mastodon_instance')) {

            // Request API & Verify Access Token
            $status_code=tootpress_mastodon_apirequest_authcode_verify ($accesstoken);

            // If Request has failed
            if($status_code<>200) {
                add_settings_error( 'tootpress-options', 'invalid-accesstoken', 'OAUTH Access Token: Token is not valid' );
                $accesstoken='';
            }
        } else {
            // If no Mastodon Instance is maintained,
            // Auth Code will be removed to prevent inconsistant values in TootPress
            add_settings_error( 'tootpress-options', 'invalid-accesstoken', 'OAUTH Access Token: Token is linked to Mastodon Instance. Value removed.' );
            $accesstoken='';
        }
    }

    return $accesstoken;
}

/**
 * Validates the Mastodon Account ID
 * 
 * @since 0.1
 * 
 * @param int Input Field Mastodon Account ID
 * @return int Verified Mastodon Account ID (true) or null (false)
 */

 function tootpress_validate_mastodon_account_id ($accountid) {
    
    if($accountid<>'') {

        if(tootpress_ready_to_authenticate_with_mastodon_api()) {

            // Get Account ID from Mastodon API with Verify Credentials
            $response=tootpress_mastodon_apirequest_account_verify_credentials();
            $response_accountid=$response['id'];

            // Validate Account ID
            if(!($accountid==$response_accountid)) {
                add_settings_error( 'tootpress-options', 'invalid-accountid', 'Account ID: Account ID is not in scope of the OAUTH Access Token' );
                $accountid='';
            } else {
                // Retrieve Account Name
                tootpress_retrieve_mastodon_account();
            }

        } else {

            // If no AuthCode is maintained,
            // UserID will be removed to prevent inconsistant values
            add_settings_error( 'tootpress-options', 'invalid-accountid', 'Account ID: Account ID is linked to OAUTH Access Token. Value removed.' );
            $accountid='';

        }

    }

    // Remove Account Name (if verified Account ID is missing)
    if($accountid=='') { 
        update_option('tootpress_mastodon_account_name',"");
    }

    return $accountid;
}

/**
 * Validates the Page ID
 * 
 * @since 0.1
 * 
 * @param int Input Field Page ID
 * @return int Verified Page ID
 */

 function tootpress_validate_page_id ($pageid) {
    
    if($pageid<>'') {

        // Does ID exists?
        if ( FALSE === get_post_type( $pageid ) ) {	
            add_settings_error( 'tootpress-options', 'invalid-pageid', 'Page ID: ID does not exists' );
            $pageid='';
        } 
        // Is ID a Page?
        elseif (!('page' == get_post_type($pageid))) {
            add_settings_error( 'tootpress-options', 'invalid-pageid', 'Page ID: ID is not a page' );
            $pageid='';
        }
        // If new ID is given
        elseif ($pageid<>get_option( 'tootpress_page_id')) {
            update_option('tootpress_rewrite_update','1');
        }
    }

    return $pageid;
}

/**
 * Validates the Amount of Toos on Page
 * 
 * @since 0.1
 * 
 * @param int Input Field Amount of Toots on Page
 * @return int Acceptable Amount
 */

 function tootpress_validate_amount_toots_page ($amount) {
    
    // Input required
    if ($amount == '') {
        add_settings_error( 'tootpress-options', 'invalid-amount', 'Amount Toots Page: Input is required' );
        $amount=get_option( 'tootpress_amount_toots_page' );
    }
    // Invalid Input
    elseif (!is_numeric($amount) OR $amount < 0 OR $amount==0 OR is_float($amount)) {
        add_settings_error( 'tootpress-options', 'invalid-amount', 'Amount Toots Page: Invalid input' );
        $amount=get_option( 'tootpress_amount_toots_page' );
    }
    // Allowed Range
    elseif ($amount < 10 OR $amount > 500) {
        add_settings_error( 'tootpress-options', 'invalid-amount', 'Amount Toots Page: 
        Allowed range is between 10 and 500' );
        $amount=get_option( 'tootpress_amount_toots_page' );
    } 
    else {
        // Make Inputs like "15.0" to "15"
        $amount=intval($amount);
    }

    return $amount;
}

/**
 * Validates the Cron Period
 * 
 * @since 0.1
 * 
 * @param string Input Field Cron Period
 * @return int Reliable Period
 */

 function tootpress_validate_cron_period ($period) {
    
    // Input required
    if ($period == '') {
        add_settings_error( 'tootpress-options', 'invalid-period', 'Period: Input is required' );
        $period=get_option( 'tootpress_cron_period' );
    }
    // Invalid Input
    elseif (!is_numeric($period) OR $period < 0 OR $period == 0 OR is_float($period)) {
        add_settings_error( 'tootpress-options', 'invalid-period', 'Period: Invalid input' );
        $period=get_option( 'tootpress_cron_period' );
    }
    // Allowed Range
    elseif ($period < 5) {
        add_settings_error( 'tootpress-options', 'invalid-period', 'Period: 
        Smallest permitted value is 5' );
        $period=get_option( 'tootpress_cron_period' );
    }
    else {
        // Convert to seconds
        $period=$period*60;
    }

    return $period;
}

/**
 * Validates the navigation
 * 
 * @since 0.1
 * 
 * @param string Input Field Navigation
 * @return int Reliable Navigation
 */

 function tootpress_validate_navigation ($nav) {

    return $nav;
}

/**
 * Validates the CSS Option
 * 
 * Checkbox Label: Deactivate CSS
 * What is the meaning of the values?
 * 1 = No (Plugin CSS is used)
 * 0 = Yes (Plugin CSS is not used)
 * 
 * @since 0.1
 * 
 * @param string Input Field CSS Option
 * @return int Reliable CSS Option
 */

 function tootpress_validate_css($input) {

    if ($input==0) {
        $output=1;
    } else {
        $output=0;
    }
  
    return $output;
}

/**
 * Validates the Backlink Option
 * 
 * Checkbox Label: Activate Backlink
 * What is the meaning of the values?
 * 1 = Yes
 * 0 = No
 * 
 * @since 0.3
 * 
 * @param string Input Field Backlink Option
 * @return int Reliable Backlink Option
 */

 function tootpress_validate_backlink($input) {

    if ($input==0) {
        $output=0;
    } else {
        $output=1;
    }

    return $output;
}

?>