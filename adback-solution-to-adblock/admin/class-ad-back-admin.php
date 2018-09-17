<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.adback.co
 * @since      1.0.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/admin
 * @author     AdBack <contact@adback.co>
 */

include_once(plugin_dir_path(__FILE__) . '../class-ad-back.php');
include_once(plugin_dir_path(__FILE__) . '../includes/class-ad-back-integration-checker.php');

class Ad_Back_Admin extends Ad_Back_Generic
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueueStyles()
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

        if (!$this->shouldPageHaveLib()) {
            return;
        }

        wp_enqueue_style('vex-css', plugin_dir_url(__FILE__) . 'css/vex.css', array(), $this->version, 'all');
        wp_enqueue_style('vex-theme-css', plugin_dir_url(__FILE__) . 'css/vex-theme-default.css', array(), $this->version, 'all');
        wp_enqueue_style('sweetalert2-css', plugin_dir_url(__FILE__) . 'css/sweetalert2.min.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/ab-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
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

        if (!$this->shouldPageHaveLib()) {
            return;
        }

        $translation_array = array(
            'bounce' => __('Bounce rate of adblocker users', 'ad-back'),
            'ad_blocker' => __('Adblocker activation / deactivation', 'adback-solution-to-adblock'),
            'ad_blocker_percent' => __('Ad blocker percent', 'adback-solution-to-adblock'),
            'blocked_page_view' => __('Blocked page views', 'adback-solution-to-adblock'),
            'browser' => __('Browser', 'adback-solution-to-adblock'),
            'os' => __('OS', 'adback-solution-to-adblock'),
            'percent_adblock_users' => __('Percent adblock users', 'adback-solution-to-adblock'),
            'percent_bounce_adblock_users' => __('Percent bounce adblock users', 'adback-solution-to-adblock'),
            'percent_bounce_all_users' => __('Percent bounce all users', 'adback-solution-to-adblock'),
            'oops' => __('Oops...', 'adback-solution-to-adblock'),
            'invalid_email_or_password' => __('Invalid email or password', 'adback-solution-to-adblock'),
            'the_key_email_and_domain_fields_should_be_fill' => __('The key, email and domain fields should be filled', 'adback-solution-to-adblock'),
            'the_email_and_password_fields_should_be_fill' => __('The email and password fields should be filled', 'adback-solution-to-adblock'),
            'there_is_an_error_in_the_registration' => __('There is an error in the registration: {0}', 'adback-solution-to-adblock'),
            'users_having_ad_blocker' => __('Users having ad blocker', 'adback-solution-to-adblock'),
            'users_who_have_disabled_an_ad_blocker' => __('Users who have disabled an ad blocker', 'adback-solution-to-adblock'),
            'percent_page_view_with_ad_block' => __('Percent page view with AdBlock', 'adback-solution-to-adblock'),
            'percent_page_view' => __('Percent page view', 'adback-solution-to-adblock'),
            'days' => __('days', 'adback-solution-to-adblock'),
            'loading' => __('Loading ...', 'adback-solution-to-adblock'),
            'no_data' => __('No Data', 'adback-solution-to-adblock'),
            'error' => __('Something went wrong', 'adback-solution-to-adblock'),
        );

        if ($this->isConnected()) {
            if ($this->getDomain() == '') {
                $this->askDomain();
            }
            // Loading AdBack library
            wp_enqueue_script('adback', 'https://' . $this->getDomain() . '/lib/ab.min.js', array(), $this->version, true);
        }

        wp_enqueue_script('vex-js', plugin_dir_url(__FILE__) . 'js/vex.combined.min.js', array(), $this->version, true);
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/ab-admin.js', array('jquery'), $this->version, true);
        wp_enqueue_script('html2canvas-js', plugin_dir_url(__FILE__) . 'js/html2canvas.min.js', array(), $this->version, true);
        wp_enqueue_script('canvas2image-js', plugin_dir_url(__FILE__) . 'js/canvas2image.js', array(), $this->version, true);
        wp_enqueue_script('sweetalert2-js', plugin_dir_url(__FILE__) . 'js/sweetalert2.min.js', array(), $this->version, true);
        wp_localize_script($this->plugin_name, 'trans_arr', $translation_array);
    }

    /**
     * Return if the current page is plugin page
     *
     * @return bool
     */
    public function shouldPageHaveLib()
    {
        if (is_admin()) {
            $screen = get_current_screen();
            if ($screen->id == "dashboard") {
                return true;
            }

            if (isset($_GET['page']) && ($_GET['page'] == 'ab' || $_GET['page'] == 'ab-settings' ||
                    $_GET['page'] == 'ab-message' || $_GET['page'] == 'ab-diagnostic') || $_GET['page'] == 'ab-placements') {
                return true;
            }

        }


        return false;
    }

    public function dashboardWidget()
    {
        wp_add_dashboard_widget(
            'adback',
            'Adback',
            array($this, 'dashboardWidgetContent')
        );
    }

    public function dashboardWidgetContent()
    {
        if ($this->isConnected() && $this->hasChooseIntegration()) {
            if ($this->getDomain() == '') {
                $this->askDomain();
            }
            include_once('partials/ad-back-admin-widget.php');
        } else {
            printf(__('You must be log in to see stats. Go to <a href="%s">Log in page</a>', 'ad-back'), get_admin_url(get_current_blog_id(), 'admin.php?page=ab'));
        }
    }

    /**
     * Check if isConnected / hasChooseIntegration and render page
     *
     * @since   1.0.0
     * @param   string $page
     */
    private function preDisplay($page)
    {
        global $wpdb;
        if (isset($_GET['access_token'])) {
            self::saveToken(array(
                'access_token' => $_GET['access_token'],
                'refresh_token' => '',
            ));
            include_once('partials/ad-back-admin-redirect.php');
        } elseif (!$this->isConnected()) {
            include_once('partials/ad-back-admin-login-display.php');
        } elseif ($this->hasntChooseIntegration()) {
            include_once('partials/ad-back-admin-choice.php');
        } else {
            if ($this->getDomain() === '') {
                $this->askDomain();
            }
            if ($page === 'partials/ad-back-admin-diagnostic.php') {

                $adback = new Ad_Back_Public($this->plugin_name, $this->version);
                $adback->enqueueScripts();
                $token = self::getToken();
                $script = $this->askScripts();
                $table_name_end_point = $wpdb->prefix . 'adback_end_point';
                $endPoints = $wpdb->get_row('SELECT * FROM ' . $table_name_end_point . ' WHERE id = ' . get_current_blog_id());
                $rules = get_option('rewrite_rules', array());
            }
            $adback_account = $wpdb->prefix . 'adback_account';
            $email = $wpdb->get_row('SELECT username FROM ' . $adback_account . ' where id = ' . get_current_blog_id());
            $email = $email->username;

            include_once $page;
        }
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function displayPluginStatsPage()
    {
        $this->preDisplay('partials/ad-back-admin-display.php');
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function displayPluginStatsLitePage()
    {
        $this->preDisplay('partials/ad-back-admin-lite-display.php');
    }

    /**
     * Render the choice page for this plugin.
     *
     * @since    1.0.0
     */
    public function displayPluginIntegrationChoicePage()
    {
        $this->preDisplay('partials/ad-back-admin-choice.php');
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function displayPluginSettingsPage()
    {
        $this->preDisplay('partials/ad-back-admin-settings-display.php');
    }

    /**
     * Render the message page for this plugin.
     *
     * @since    1.0.0
     */
    public function displayPluginMessagePage()
    {
        $this->preDisplay('partials/ad-back-admin-message-display.php');
    }

    /**
     * Render the placements page for this plugin.
     *
     * @since    1.0.0
     */
    public function displayPluginPlacementsPage()
    {
        $this->preDisplay('partials/ad-back-admin-placements-display.php');
    }

    /**
     * Render the message page for this plugin.
     *
     * @since    1.0.0
     */
    public function displayPluginDiagnosticPage()
    {
        $this->preDisplay('partials/ad-back-admin-diagnostic.php');
    }

    /**
     * Render the refresh domain page for this plugin.
     *
     * @since    1.0.0
     */
    public function displayPluginRefreshDomainPage()
    {
        global $wpdb;
        $wpdb->query('delete from ' . $wpdb->prefix . 'adback_full_tag');

        $this->preDisplay('partials/ad-back-admin-refresh-domain.php');
    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */
    public function addPluginAdminMenu()
    {
        global $_wp_last_object_menu;

        $_wp_last_object_menu++;

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */

        add_menu_page('AdBack', 'AdBack', 'manage_options', 'ab', '', plugin_dir_url(__FILE__) . '/partials/images/_dback_blanc_logo.png', $_wp_last_object_menu);

        if (Integration_Checker::isFullIntegration()) {
            add_submenu_page('ab', 'AdBack Statistiques', __('Statistics', 'adback-solution-to-adblock'), 'manage_options', 'ab', array($this, 'displayPluginStatsPage'));
            add_submenu_page('ab', 'AdBack Message', __('Message', 'adback-solution-to-adblock'), 'manage_options', 'ab-message', array($this, 'displayPluginMessagePage'));
            add_submenu_page('ab', 'AdBack Placements', __('Placements', 'adback-solution-to-adblock'), 'manage_options', 'ab-placements', array($this, 'displayPluginPlacementsPage'));
        } else {
            add_submenu_page('ab', 'AdBack Statistiques', __('Statistics', 'adback-solution-to-adblock'), 'manage_options', 'ab', array($this, 'displayPluginStatsLitePage'));
        }
        add_submenu_page('ab', 'AdBack Settings', __('Settings', 'adback-solution-to-adblock'), 'manage_options', 'ab-settings', array($this, 'displayPluginSettingsPage'));
        add_submenu_page('ab', 'AdBack Diagnostic', __('Diagnostic', 'adback-solution-to-adblock'), 'manage_options', 'ab-diagnostic', array($this, 'displayPluginDiagnosticPage'));

        add_plugins_page('ab', '', 'manage_options', 'ab-refresh-domain', array($this, 'displayPluginRefreshDomainPage'));
    }

    public function saveMessageCallback()
    {
        update_option('adback_admin_hide_message', $_POST['hide-admin'] == 'true' ? '1' : '0');

        $this->saveMessage($_POST['display']);

        echo "{\"done\":true}";
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public function saveGoMessageCallback()
    {
        $this->saveMessage($_POST['display']);

        echo "{\"done\":true}";
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public function liteIntegration()
    {
        Integration_Checker::liteIntegration();
        Ad_Back_Updator::update();

        echo "{\"done\":true}";
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public function fullIntegration()
    {
        Integration_Checker::fullIntegration();
        Ad_Back_Updator::update();

        echo "{\"done\":true}";
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public function logoutCallback()
    {
        global $wpdb; // this is how you get access to the database

        $table_name = $wpdb->prefix . 'adback_account';
        $wpdb->update(
            $table_name,
            array(
                "id" => get_current_blog_id(),
                "username" => "",
                "key" => "",
                "secret" => ""
            ),
            array("id" => get_current_blog_id())
        );

        //create token table
        $table_name = $wpdb->prefix . 'adback_token';
        $wpdb->update(
            $table_name,
            array(
                "id" => get_current_blog_id(),
                "access_token" => "",
                "refresh_token" => ""
            ),
            array("id" => get_current_blog_id())
        );

        //create myinfo table
        $table_name = $wpdb->prefix . 'adback_myinfo';
        $wpdb->update(
            $table_name,
            array(
                "id" => get_current_blog_id(),
                "myinfo" => "",
                "domain" => "",
                "update_time" => current_time('mysql', 1)
            ),
            array("id" => get_current_blog_id())
        );

        echo "{\"done\":true}";
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public function registerCallback()
    {
        global $wpdb; // this is how you get access to the database


        $blogId = get_current_blog_id();
        $table_name_token = $wpdb->prefix . 'adback_token';
        $savedToken = $wpdb->get_row("SELECT * FROM " . $table_name_token . " WHERE id = " . $blogId);
        $accessToken = '';

        if (null === $savedToken || '' === $savedToken->access_token) {
            $fields = array(
                'email' => $_POST['email'],
                'website' => $_POST['site-url'] ?: get_site_url($blogId),
            );

            $locale = explode("_", get_locale());
            if (isset($locale[0]) && in_array($locale[0], array('en', 'fr'))) {
                $locale = $locale[0];
            } else {
                $locale = 'en';
            }

            $response = Ad_Back_Post::execute('https://www.adback.co/tokenoauth/register/' . $locale, $fields);
            $data = json_decode($response, true);
            $accessToken = '';
            if (array_key_exists('access_token', $data)) {
                $accessToken = $data['access_token'];
            }
            $refreshToken = '';
            if (array_key_exists('refresh_token', $data)) {
                $refreshToken = $data['refresh_token'];
            }

            $sql = <<<SQL
INSERT INTO $table_name_token
  (id,access_token,refresh_token) values (%d,%s,%s)
  ON DUPLICATE KEY UPDATE access_token = %s, refresh_token = %s;
SQL;
            $sql = $wpdb->prepare(
                $sql,
                $blogId,
                $accessToken,
                $refreshToken,
                $accessToken,
                $refreshToken
            );
            $wpdb->query($sql);

            $savedToken = $wpdb->get_row("SELECT * FROM " . $table_name_token . " WHERE id = " . $blogId);
        }
        if ('' === $accessToken && '' === $savedToken->access_token) {
            $notices = get_option('adback_deferred_admin_notices', array());
            $notices[] = sprintf(__('Registration error', 'adback-solution-to-adblock'), get_admin_url($blogId, 'admin.php?page=ab-settings'));
            update_option('adback_deferred_admin_notices', $notices);

            $errorMsg = isset($data['error']['message']) ? $data['error']['message'] : 'error';
            update_option('adback_registration_error', $errorMsg);
        } else {
            delete_option('adback_registration_error');
            $adback_account = $wpdb->prefix . 'adback_account';
            $wpdb->update(
                $adback_account,
                array(
                    'id' => get_current_blog_id(),
                    'username' => $_POST['email'],
                ),
                array('id' => get_current_blog_id())
            );
        }

        echo "{\"done\":true}";
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public function addConfigNotice()
    {
        if (current_user_can('manage_options')) {

            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/ab-admin.css', array(), $this->version, 'all');

            if (!$this->isConnected() && !in_array($_REQUEST['page'], array('ab', 'ab-placements', 'ab-message', 'ab-settings', 'ab-diagnostic'))) {
                echo '<div class="updated" style="padding: 0; margin: 0; border: none; background: none;">
		                <div class="adback-incentive">
		                <form name="adback-incentive" action="' . esc_url(get_admin_url(get_current_blog_id(), 'admin.php?page=ab-settings')) . '" method="POST">
                        <div class="adback-incentive-button-container">
                            <div class="adback-incentive-button-border">
                                <input type="submit" class="adback-incentive-button" value="' . __("Activate my AdBack plugin", 'adback-solution-to-adblock') . '">
                            </div>
                        </div>
                        <div class="adback-incentive-description">
                            ' . __("It's time to analyze your adblock users, set up your AdBack account!", 'adback-solution-to-adblock') . '
                        </div>
                    </div>
                    </form>
                </div>';
            }
            require_once plugin_dir_path(__FILE__) . '../includes/class-ad-back-external-checker.php';
            Ad_Back_External_Checker::check();
        }
    }
}
