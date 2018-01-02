<?php

/**
 * Fired during plugin activation and upgrade
 *
 * @link       https://www.adback.co
 * @since      2.4.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/includes
 */

/**
 * Fired during plugin activation and upgrade
 *
 * This class defines all code necessary to run during the plugin's upgrade
 *
 * @since      2.7.0
 * @package    Ad_Back
 * @subpackage Ad_Back/includes
 * @author     AdBack <contact@adback.co>
 */
class Ad_Back_External_Checker
{
    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    2.7.0
     */
    public static function check()
    {
        $wpRocketSettings = get_option("wp_rocket_settings");

        if (is_array($wpRocketSettings) && in_array($wpRocketSettings['lazyload_iframes'], [1, true, '1'])) {
            $notices = get_option('adback_deferred_admin_notices', array());
            $notices[] = __('There is an incompatibility with the WP Rocket plugin configuration, please deactivate the iframe compression', 'adback-solution-to-adblock');
            update_option('adback_deferred_admin_notices', $notices);
        }

        $wpRocketLazyLoadSettings = get_option("rocket_lazyload_options");

        if (is_array($wpRocketLazyLoadSettings) && in_array($wpRocketLazyLoadSettings['iframes'], [1, true, '1'])) {
            $notices = get_option('adback_deferred_admin_notices', array());
            $notices[] = __('There is an incompatibility with the WP Lazy Load Rocket plugin configuration, please deactivate the iframe compression', 'adback-solution-to-adblock');
            update_option('adback_deferred_admin_notices', $notices);
        }
    }
}
