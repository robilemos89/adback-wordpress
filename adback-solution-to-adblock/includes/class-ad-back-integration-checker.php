<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.adback.co
 * @since      1.0.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/includes
 */
class Integration_Checker
{
    /**
     * Check integration & return true if full
     *
     * @since    3.0.0
     */
    public static function isFullIntegration()
    {
        return get_option('adback_integration') === '1';
    }

    /**
     * Check integration & return true if Lite
     *
     * @since    3.0.0
     */
    public static function isLiteIntegration()
    {
        return get_option('adback_integration') === '0';
    }

    /**
     * Set lite integration
     *
     * @since    3.0.0
     */
    public static function liteIntegration()
    {
        update_option('adback_integration', '0');
        self::notifyLiteInstallation(Ad_Back_Generic::getToken()->access_token);
    }

    /**
     * Set full integration
     *
     * @since    3.0.0
     */
    public static function fullIntegration()
    {
        update_option('adback_integration', '1');
        self::notifyFullInstallation(Ad_Back_Generic::getToken()->access_token);
    }

    /**
     * notify .co full integration
     *
     * @since    3.0.0
     * @param    $accessToken
     */
    private static function notifyFullInstallation($accessToken)
    {
        $notifyUrl = 'https://www.adback.co/api/plugin-activate/wordpress?access_token=' . $accessToken;
        Ad_Back_Get::execute($notifyUrl);
    }

    /**
     * notify .co full integration
     *
     * @since    3.0.0
     * @param    $accessToken
     */
    private static function notifyLiteInstallation($accessToken)
    {
        $notifyUrl = 'https://www.adback.co/api/plugin-activate/wordpressLite?access_token=' . $accessToken;
        Ad_Back_Get::execute($notifyUrl);
    }
}
