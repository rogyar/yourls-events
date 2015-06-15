<?php
/*
Plugin Name: API Get Url Events
Plugin URI: http://www.atwix.com/
Description: Returns logged visits for requested URL
Version: 1.0
Author: Rogyar
Author URI: http://github.com/rogyar/
*/

// No direct calls
if( !defined( 'YOURLS_ABSPATH' ) ) die();

yourls_add_filter( 'api_action_events', 'get_url_events' );

function get_url_events()
{
    if( !isset( $_REQUEST['shorturl'] ) ) {
        return array(
            'statusCode' => 400,
            'simple'     => "Need a 'shorturl' parameter",
            'message'    => 'error: missing param',
        );
    }

    if( !isset( $_REQUEST['timestamp'] ) ) {
        return array(
            'statusCode' => 400,
            'simple'     => "Need a 'timestamp' parameter",
            'message'    => 'error: missing param',
        );
    }

    $shorturl = $_REQUEST['shorturl'];

    /* Check if valid shorturl */
    if(false == yourls_is_shorturl($shorturl)) {
        return array(
            'statusCode' => 404,
            'simple '    => 'Error: short URL not found',
            'message'    => 'error: not found',
        );
    }

    /* Check if the requested date is valid */
    if (false == strtotime($_REQUEST['timestamp'])) {
        return array(
            'statusCode' => 400,
            'simple'     => "Timestamp is not correct",
            'message'    => 'error: wrong timestamp',
        );
    }

    global $ydb;

    $table_log = YOURLS_DB_TABLE_LOG;

    $keyword = yourls_sanitize_string($shorturl);
    $lastCheck = yourls_sanitize_string($_REQUEST['timestamp']);
    $keywordRange = sprintf( "= '%s'", yourls_escape($keyword));
    $query = "SELECT * FROM `$table_log` WHERE `shorturl` $keywordRange AND `click_time` > $lastCheck;";

    return array('request' => $query, 'data' => $ydb->get_results($query, ARRAY_A));
}

