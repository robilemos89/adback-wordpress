<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.adback.co
 * @since      1.0.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/public
 * @author     AdBack
 */

include_once(plugin_dir_path( __FILE__ ) . '../class-ad-back.php');

class Ad_Back_Public extends Ad_Back_Generic
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueueScripts()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ad_Back_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ad_Back_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        $me = $this->getMyInfo();
        $mess = $this->getCacheMessages();

        if (is_array($me)) {
            var_dump($me);
            if (!empty($me['analytics_domain']) && !empty($me['analytics_script'])) {
                echo "<script>(function (a,d){var s,t;s=d.createElement('script');s.src=a;s.async=1;t=d.getElementsByTagName('script')[0];t.parentNode.insertBefore(s,t);})('https://" . $me['analytics_domain'] . "/" . $me['analytics_script'] . ".js', document);</script>";
            }

            if (!empty($me['product_domain']) && !empty($me['product_script'])) {
                echo "<script>(function (a,d){var s,t;s=d.createElement('script');s.src=a;s.async=1;t=d.getElementsByTagName('script')[0];t.parentNode.insertBefore(s,t);})('https://" . $me['product_domain'] . "/" . $me['product_script'] . ".js', document);</script>";
            }

            if (!empty($me['message_domain']) && !empty($me['message_script'])) {
                if ($mess->display == '1' &&
                    (!current_user_can('manage_options') ||
                    (current_user_can('manage_options') && get_option('adback_admin_hide_message', '1') === '0'))
                ) {
                    echo "<script>(function (a,d){var s,t,u;s=d.createElement('script');s.src=a;s.async=1;t=d.getElementsByTagName('script')[0];t.parentNode.insertBefore(s,t);})('https://" . $me['message_domain'] . "/" . $me['message_script'] . ".js', document);</script>";
                }
            }
        }
    }
}
