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
 * @author     AdBack <contact@adback.co>
 */
class Ad_Back_Activator
{
    const DB_VERSION = 1;

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate($networkwide)
    {
        global $wpdb;

        add_option( 'adback_solution_to_adblock_db_version', self::DB_VERSION);

        if (is_multisite() && $networkwide) {
            $sites = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

            foreach ($sites as $blogId) {
                switch_to_blog($blogId);
                self::initializeBlog();
                restore_current_blog();
            }
        } else {
            self::initializeBlog();
        }
    }

    public static function initializeBlog()
    {
        // Nothing here, anymore.
    }
}
