<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.adback.co
 * @since      1.0.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ad_Back
 * @subpackage Ad_Back/includes
 * @author     Antoine Ferrier <contact@adback.co>
 */
class Ad_Back_Activator
{
    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        global $wpdb;

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        $charset_collate = $wpdb->get_charset_collate();

        //create account table
        $table_name = $wpdb->prefix . 'adback_account';

        $sql = "CREATE TABLE ".$table_name." (
            `id` mediumint(9) NOT NULL,
            `username` varchar(100) DEFAULT '' NOT NULL,
            `key` varchar(100) DEFAULT '' NOT NULL,
            `secret` varchar(100) DEFAULT '' NOT NULL,
            UNIQUE KEY id (id)
        ) ".$charset_collate.";";

        dbDelta( $sql );

        $wpdb->insert(
            $table_name,
            array(
                "id" => "1",
                "username" => "",
                "key" => "",
                "secret" => ""
            )
        );

        //create token table
        $table_name = $wpdb->prefix . 'adback_token';

        $sql = "CREATE TABLE ".$table_name." (
            `id` mediumint(9) NOT NULL,
            `access_token` varchar(64) DEFAULT '' NOT NULL,
            `refresh_token` varchar(64) DEFAULT '' NOT NULL,
            UNIQUE KEY id (id)
        ) ".$charset_collate.";";

        dbDelta( $sql );

        $wpdb->insert(
            $table_name,
            array(
                "id" => "1",
                "access_token" => "",
                "refresh_token" => ""
            )
        );

        //create myinfo table
        $table_name = $wpdb->prefix . 'adback_myinfo';

        $sql = "CREATE TABLE ".$table_name." (
            `id` mediumint(9) NOT NULL,
            `myinfo` text DEFAULT '' NOT NULL,
            `domain` text DEFAULT '' NOT NULL,
            `update_time` DATETIME NULL,
            UNIQUE KEY id (id)
        ) ".$charset_collate.";";

        dbDelta( $sql );

        $wpdb->insert(
            $table_name,
            array(
                "id" => "1",
                "myinfo" => "",
                "domain" => "",
                "update_time" => ""
            )
        );

        //create message table
        $table_name = $wpdb->prefix . 'adback_message';

        $sql = "CREATE TABLE ".$table_name." (
            `id` mediumint(9) NOT NULL,
            `link` varchar(1024) DEFAULT '' NOT NULL,
            `header_text` varchar(1024) DEFAULT '' NOT NULL,
            `message` text DEFAULT '' NOT NULL,
            `close_text` varchar(1024) DEFAULT '' NOT NULL,
            `display` BIT NOT NULL,
            `update_time` DATETIME NULL,
            UNIQUE KEY id (id)
        ) ".$charset_collate.";";

        dbDelta( $sql );

        $wpdb->insert(
            $table_name,
            array(
                "id" => "1",
                "link" => "",
                "header_text" => "",
                "message" => "",
                "close_text" => "",
                "display" => 0,
                "update_time" => ""
            )
        );
    }
}
