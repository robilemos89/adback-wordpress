<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.adback.co
 * @since      1.0.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/admin/partials
 */

?>
<h1><?php _e( 'AdBack', 'ad-back' ); ?></h1>

<div id="ab-login">
    <div class="ab-col-md-12">
            <div class="ab-login-box">
                <center><a href="https://www.adback.co" target="_blank"><div class="ab-login-logo" style="background-image:url('<?php echo plugin_dir_url( __FILE__ ); ?>images/_dback.png');"></div></a></center>
                <center>

                </center>
                <center>
                    <button
                            class="ab-button ab-button-primary"
                            id="ab-register-adback"
                            style="margin-top: 30px;"
                            data-site-url="<?php echo get_site_url(get_current_blog_id()) ?>"
                            data-email="<?php echo get_bloginfo('admin_email') ?>"
                            data-local="<?php echo (get_locale() === 'fr_FR') ? 'fr':'en'; ?>"
                    >
                        <?php esc_html_e('Create my AdBack account', 'adback-solution-to-adblock'); ?>
                    </button>
                </center>
                <br/>
                <center>
                    <a href="#" id="ab-login-adback" style="width:100%;margin-top: 30px;"><?php esc_html_e('Log in', 'adback-solution-to-adblock'); ?></a>
                </center>
                <br/>
                <center>
                    <a href="/wp-admin/plugins.php" class="ab-refuse-adback"><?php esc_html_e('Refuse (you won’t be able to use AdBack solutions)', 'adback-solution-to-adblock'); ?></a>
                </center>
            </div>
    </div>
</div>
