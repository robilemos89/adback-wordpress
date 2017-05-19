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
<!--                <div class="ab-primary-setting">-->
                    <section style="background-color:transparent;">
                        <h4 class="header-section"><?php esc_html_e('Adback Account', 'ad-back'); ?></h4>
                        <hr/>
                        <div class="section-content">
                            <button id="ab-logout" primary m-full><?php esc_html_e('Log out', 'ad-back'); ?></button>
                        </div>
                    </section>
<!--                </div>-->
            </div>
            <div col="1/6">
                <div id="adb-sidebar-standalone"
                     data-reviewlink="https://wordpress.org/support/plugin/adback-solution-to-adblock/reviews/"
                     data-supportlink="https://wordpress.org/support/plugin/adback-solution-to-adblock">
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
