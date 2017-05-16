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
<?php include "ad-back-admin-header.php" ?>
<div id="ab-settings">
    <div id="ab-full-app">
        <grid>
            <div col="5/6">
                <div id="ab-configuration-form"></div>
                <div class="ab-primary-setting">
                    <h4><?php esc_html_e('Adback Account', 'ad-back'); ?></h4>
                    <button id="ab-logout" primary m-full><?php esc_html_e('Log out', 'ad-back'); ?></button>
                </div>
            </div>
            <div col="1/6">
                <div id="adb-stats">
                    <progress-bar type="subscription"
                                  dashboardlink="<?php _e('https://www.adback.co/en/sites/dashboard', 'ad-back'); ?>"
                                  pricelink="<?php _e('https://www.adback.co/en/#prix', 'ad-back'); ?>"
                                  reviewlink="<?php _e('https://wordpress.org/support/plugin/adback-solution-to-adblock/reviews/', 'ad-back') ?>"
                    >

                    </progress-bar>
                </div>
            </div>
        </grid>
    </div>
</div>

<script type="text/javascript">
    window.onload = function () {
        if (typeof adbackjs === 'object') {
            adbackjs.init({
                token: '<?php echo $this->getToken()->access_token; ?>',
                url: 'https://<?php echo $this->getDomain(); ?>/api/',
                language: '<?php echo str_replace('_', '-', get_locale()); ?>',
                version: 1
            });
        }
    }
</script>
