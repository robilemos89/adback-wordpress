<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://www.adback.co
 * @since      1.0.0
 *
 * @package    Ad_Back
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}

global $wpdb;

$default = new \stdClass();
$default->blog_id = 1;

$sites = function_exists('get_sites') ? get_sites() : [$default];

foreach ($sites as $site) {
    $blogId = $site->blog_id;
    $prefix = $blogId == 1 ? '' : $blogId."_";

    $table_name = $wpdb->prefix . $prefix . 'adback_account';
    $sql = "DROP TABLE IF EXISTS ".$table_name;
    $wpdb->query($sql);

    $table_name = $wpdb->prefix . $prefix . 'adback_token';
    $sql = "DROP TABLE IF EXISTS ".$table_name;
    $wpdb->query($sql);

    $table_name = $wpdb->prefix . $prefix . 'adback_myinfo';
    $sql = "DROP TABLE IF EXISTS ".$table_name;
    $wpdb->query($sql);

    $table_name = $wpdb->prefix . $prefix . 'adback_message';
    $sql = "DROP TABLE IF EXISTS ".$table_name;
    $wpdb->query($sql);
}
