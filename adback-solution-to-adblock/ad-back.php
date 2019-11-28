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
 * Version:           3.9.0
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
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-ad-back-updator.php';
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-ad-back-get.php';
    Ad_Back_Activator::activate($networkwide);
    Ad_Back_Updator::update();

    adback_plugin_rules();
    flush_rewrite_rules();
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

function adback_plugins_loaded() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-ad-back-updator.php';
    Ad_Back_Updator::onUpdateFromOldVersion();
    Ad_Back_Updator::update();
}

function adback_plugin_rules() {
    $endPoints = Ad_Back_Transient::getEndpoint(get_current_blog_id());

    if (null !== $endPoints && false !== $endPoints) {
        if ('' != $endPoints->old_end_point) {
            add_rewrite_rule($endPoints->old_end_point . '/?(.*)', 'index.php?pagename=adback_proxy&adback_request=$matches[1]', 'top');
        }
        if ('' != $endPoints->end_point) {
            add_rewrite_rule($endPoints->end_point . '/?(.*)', 'index.php?pagename=adback_proxy&adback_request=$matches[1]', 'top');
        }
        if ('' != $endPoints->next_end_point) {
            add_rewrite_rule($endPoints->next_end_point . '/?(.*)', 'index.php?pagename=adback_proxy&adback_request=$matches[1]', 'top');
        }
    }

    $token = Ad_Back_Transient::getToken(get_current_blog_id());

    if (is_array($token)) {
        $token = (object)$token;
    }

    add_rewrite_rule($token->access_token.'/update', 'index.php?pagename=adback_update', 'top');
}

function adback_plugin_query_vars($vars) {
    $vars[] = 'adback_request';

    return $vars;
}

function adback_plugin_display() {
    $adback_page_name = get_query_var('pagename');
    if ('adback_proxy' == $adback_page_name):
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-ad-back-proxy.php';
        $adback_request = get_query_var('adback_request');
        Ad_Back_Proxy::execute($adback_request);
        exit;
    endif;

    if ('adback_update' == $adback_page_name):
        Ap_Back_Transient::deleteFullTag(get_current_blog_id());

        echo "Refreshed";
        exit;
    endif;
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

function addToRobotsTxt($robotsTxt) {
    $additions = '
# Added by AdBack plugin

Disallow: /components/
Disallow: /modules/
';
    $rows = Ad_Back_Transient::getEndpoint();

    foreach ($rows as $row) {
        $row->old_end_point and $additions .= 'Disallow: /' . $row->old_end_point . '/' . "\n";
        $row->end_point and $additions .= 'Disallow: /' . $row->end_point . '/' . "\n";
        $row->next_end_point and $additions .= 'Disallow: /' . $row->next_end_point . '/' . "\n";
    }

    return $robotsTxt . $additions;
}

add_action('admin_notices', 'adback_admin_notices');
add_action('wpmu_new_blog', 'adback_new_blog');
add_action('plugins_loaded', 'adback_plugins_loaded');
add_filter('wpmu_drop_tables', 'adback_delete_blog' );
register_activation_hook( __FILE__, 'activate_ad_back' );
register_deactivation_hook( __FILE__, 'deactivate_ad_back' );
//add rewrite rules in case another plugin flushes rules
add_action('init', 'adback_plugin_rules');
//add plugin query vars (product_id) to wordpress
add_filter('query_vars', 'adback_plugin_query_vars');
//register plugin custom pages display
add_filter('template_redirect', 'adback_plugin_display');
//refresh robot.txt
add_filter('robots_txt', 'addToRobotsTxt');

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
