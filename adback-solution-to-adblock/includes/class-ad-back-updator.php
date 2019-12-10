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
 * @since      2.4.0
 * @package    Ad_Back
 * @subpackage Ad_Back/includes
 * @author     AdBack <contact@adback.co>
 */
class Ad_Back_Updator
{
    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function update()
    {
        global $wpdb;

        $currentVersion = (int)get_option("adback_solution_to_adblock_db_version");

        if (null === $currentVersion || $currentVersion < 2) {
            $currentVersion = 3;
            if (is_multisite()) {
                $sites = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

                foreach ($sites as $blogId) {
                    switch_to_blog($blogId);
                    self::createFullTagAndEndPointDatabase();
                    restore_current_blog();
                }
            } else {
                self::createFullTagAndEndPointDatabase();
            }
            update_option("adback_solution_to_adblock_db_version", $currentVersion);
        }
    }

    /**
     * On update from version 2
     *
     * @since    1.0.0
     */
    public static function onUpdateFromOldVersion()
    {
        global $wpdb;
        $currentVersion = (int)get_option('adback_solution_to_adblock_db_version');

        if (2 === $currentVersion) {
            update_option('adback_integration', '1');
            update_option('adback_solution_to_adblock_db_version', 3);
        }
        if (3 === $currentVersion) {
            update_option('adback_solution_to_adblock_db_version', 4);
            $adback_account = $wpdb->prefix . 'adback_account';
            $wpdb->replace(
                $adback_account,
                array(
                    'id' => get_current_blog_id(),
                    'username' => get_bloginfo('admin_email'),
                )
            );
        }
        if (4 === $currentVersion) {
            Ad_Back_Transient::setAccount(array(
                'id' => get_current_blog_id(),
                'username' => get_bloginfo('admin_email')
            ));
        }
    }

    /**
     * Update full tag and endpoint database
     */
    public static function createFullTagAndEndPointDatabase()
    {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        require_once(dirname(__FILE__) . '/ad-back-rewrite-rule-validator.php');

        $blogId = get_current_blog_id();

        $savedToken = Ad_Back_Transient::getToken($blogId);

        if (null !== $savedToken && '' !== $savedToken->access_token) {
            if (self::isRewriteRouteEnabled()) {
                // loop while endpoints (next) conflict with rewrite rules, if not, insert all endpoint data
                for ($i = 0; $i < 5; $i++) {
                    $url = $i === 0 ? "https://www.adback.co/api/end-point/me?access_token=" : "https://www.adback.co/api/end-point/refresh?access_token=";
                    $endPointData = Ad_Back_Get::execute($url . $savedToken->access_token);
                    $endPoints = json_decode($endPointData, true);

                    if (
                        is_array($endPoints)
                        && array_key_exists('old_end_point', $endPoints)
                        && array_key_exists('end_point', $endPoints)
                        && array_key_exists('next_end_point', $endPoints)
                        && !Ad_Back_Rewrite_Rule_Validator::validate($endPoints['next_end_point'])
                    ) {
                        $data = (object) array(
                            'old_end_point' => $endPoints['old_end_point'],
                            'end_point' => $endPoints['end_point'],
                            'next_end_point' => $endPoints['next_end_point'],
                        );

                        Ad_Back_Transient::setEndpoint($data, $blogId);
                        break;
                    }
                }
            }

            $fullScriptData = Ad_Back_Get::execute("https://www.adback.co/api/script/me/full?access_token=" . $savedToken->access_token);
            $fullScripts = json_decode($fullScriptData, true);

            $genericScriptData = Ad_Back_Get::execute("https://www.adback.co/api/script/me/generic?access_token=" . $savedToken->access_token);
            $genericScript = json_decode($genericScriptData, true);

            $fullScripts['script_codes']['generic'] = $genericScript;
            $types = self::getTypes();

            if (is_array($fullScripts) && !empty($fullScripts) && array_key_exists('script_codes', $fullScripts)) {
                $scriptData = array();

                foreach ($types as $key => $type) {
                    if (
                        array_key_exists($type, $fullScripts['script_codes'])
                        && '' !== $fullScripts['script_codes'][$type]['code']
                    ) {
                        $scriptData[$type] = $fullScripts['script_codes'][$type]['code'];
                    }
                }

                Ad_Back_Transient::setFullTag($scriptData, $blogId);
            }
        }
    }

    public static function isRewriteRouteEnabled()
    {
        return (bool)get_option('permalink_structure');
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        $types = array();
        if (Integration_Checker::isFullIntegration()) {
            $types = array(
                'analytics',
                'message',
                'product',
                'banner',
                'catcher',
                'iab_banner',
            );
        }

        if (Integration_Checker::isLiteIntegration()) {
            $types = array(
                'analytics',
                'iab_banner',
                'generic',
            );
        }

        return $types;
    }
}
