<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.adback.co
 * @since             1.0.0
 * @package           Ad_Back
 *
 * @wordpress-plugin
 * Plugin Name:       AdBack solution to adblock
 * Plugin URI:        adback.co
 * Description:       With AdBack, access analytics about adblocker users, address them personalized messages, propose alternative solutions to advertising (video, survey).
 * Version:           2.2.0
 * Author:            AdBack
 * Author URI:        https://www.adback.co
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       adback-solution-to-adblock
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'ad_back_action_links' );

function ad_back_action_links( $links ) {
    $links[] = '<a href="'. esc_url( get_admin_url(get_current_blog_id(), 'admin.php?page=ab-settings') ) .'">'.__('Settings').'</a>';
    return $links;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ad-back-activator.php
 */
function activate_ad_back($networkwide) {
    if (!current_user_can( 'activate_plugins' ) )
        return;

    require_once plugin_dir_path( __FILE__ ) . 'includes/class-ad-back-activator.php';
    Ad_Back_Activator::activate($networkwide);
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ad-back-deactivator.php
 */
function deactivate_ad_back() {
    if (!current_user_can( 'activate_plugins' ) )
        return;

    require_once plugin_dir_path( __FILE__ ) . 'includes/class-ad-back-deactivator.php';
    Ad_Back_Deactivator::deactivate();
}

function adback_admin_notices() {
    if ($notices= get_option('adback_deferred_admin_notices')) {
        foreach ($notices as $notice) {
            echo "<div class='error notice is-dismissible'><p>" . $notice . "</p></div>";
        }
        delete_option('adback_deferred_admin_notices');
    }
}

function adback_new_blog($blogId) {
    if (is_plugin_active_for_network( 'adback-solution-to-adblock/ad-back.php') ) {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-ad-back-activator.php';

        switch_to_blog($blogId);
        Ad_Back_Activator::initializeBlog();
        restore_current_blog();
    }
}

function adback_delete_blog($tables) {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-ad-back-deactivator.php';
    Ad_Back_Deactivator::deleteBlog($tables);
}

add_action('admin_notices', 'adback_admin_notices');
add_action('wpmu_new_blog', 'adback_new_blog');
add_filter('wpmu_drop_tables', 'adback_delete_blog' );
register_activation_hook( __FILE__, 'activate_ad_back' );
register_deactivation_hook( __FILE__, 'deactivate_ad_back' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ad-back.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-ad-back-get.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-ad-back-post.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ad_back() {

    $plugin = new Ad_Back();
    $plugin->run();

}
run_ad_back();
