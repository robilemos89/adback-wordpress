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

                <?php if (Integration_Checker::isFullIntegration()) { ?>
                <div id="ab-configuration-form"></div>
                <?php } ?>
                <section style="background-color:transparent;">
                    <h4 class="header-section"><?php esc_html_e('Get more statistics', 'adback-solution-to-adblock'); ?></h4>
                    <hr/>
                    <div class="section-content">
                        <button id="ab-website" class="btn-generic-save" primary
                                m-full><?php esc_html_e('Redirect me to my AdBack dashboard', 'adback-solution-to-adblock'); ?></button>
                    </div>
                </section>
                <section style="background-color:transparent;">
                    <h4 class="header-section"><?php esc_html_e('Adback Account', 'adback-solution-to-adblock'); ?></h4>
                    <hr/>
                    <div class="section-content">
                        <button id="ab-logout" class="btn-generic-save" primary m-full>
                            <?php esc_html_e('Log out', 'adback-solution-to-adblock'); ?>
                        </button>
                    </div>
                </section>
                </br>
                <section style="background-color: transparent;">
                    <h4 class="header-section"><?php esc_html_e('Change of solution', 'adback-solution-to-adblock'); ?></h4>
                    <hr/>
                    <div class="section-content">
                        <?php esc_html_e('Your needs are growing or you want to change your solution:', 'adback-solution-to-adblock'); ?>
                    </div>
                    <?php if (Integration_Checker::isFullIntegration()) { ?>
                    <div class="section-content">
                        <button class="ab-button ab-button-primary" style="padding: 10px" id="switch-integration-lite">
                            <?php esc_html_e('Switch to Quick monetization solution', 'adback-solution-to-adblock'); ?>
                        </button>
                    </div>
                    <?php } else { ?>
                    <div class="section-content">
                        <button class="ab-button ab-button-primary" style="padding: 10px" id="switch-integration-full">
                            <?php esc_html_e('Switch to Advanced solution', 'adback-solution-to-adblock'); ?>
                        </button>
                    </div>
                    <?php } ?>
                </section>
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
                version: 2
            });
        }
    };

    (function ($) {
        $(document).ready(function () {
            $("#ab-website").on('click', function () {
                var locale = "<?php $locales = explode('_', get_locale());echo $locales[0]; ?>";
                var email = "<?php echo get_bloginfo('admin_email') ?>";
                window.location.href = 'https://www.adback.co/' + locale + '/login?_login_email=' + email;
            });
        });

        $("#switch-integration-lite").on('click', function () {
            swal({
                title: '<?php esc_html_e('Caution!', 'adback-solution-to-adblock') ?>',
                text: '<?php _e('If you change the option, all the solutions currently running on your site will be stopped (message, banners, ads…).    You will have access to you statistics only in the AdBack back office.\n', 'adback-solution-to-adblock') ?>',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#949494',
                cancelButtonColor: '#54AFF6',
                confirmButtonText: '<?php esc_html_e('Continue', 'adback-solution-to-adblock') ?>',
                cancelButtonText: '<?php esc_html_e('Cancel', 'adback-solution-to-adblock') ?>'
            }).then(function (result) {
                if (result.value) {
                    var data = {'action': 'lite_integration'};
                    $.post(ajaxurl, data, function (response) {
                        var obj = JSON.parse(response);
                        if (obj.done === true) {
                            window.location.href = location.protocol + '//' + location.host + location.pathname + '?page=ab';
                        } else {
                            vex.dialog.alert(trans_arr.oops + ' ' + trans_arr.error);
                        }
                    });
                }
            })
        });

        $("#switch-integration-full").on('click', function () {
            swal({
                title: '<?php esc_html_e('Caution!', 'adback-solution-to-adblock') ?>',
                text: '<?php _e('If you change the option, all the solutions currently running on your site will be stopped (message, banners, ads…).   You will have access to you statistics only in the AdBack back office.\n', 'adback-solution-to-adblock') ?>',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#949494',
                cancelButtonColor: '#54AFF6',
                confirmButtonText: '<?php esc_html_e('Continue', 'adback-solution-to-adblock') ?>',
                cancelButtonText: '<?php esc_html_e('Cancel', 'adback-solution-to-adblock') ?>'
            }).then(function (result) {
                if (result.value) {
                    var data = {'action': 'full_integration'};
                    $.post(ajaxurl, data, function (response) {
                        var obj = JSON.parse(response);
                        if (obj.done === true) {
                            window.location.href = location.protocol + '//' + location.host + location.pathname + '?page=ab';
                        } else {
                            vex.dialog.alert(trans_arr.oops + ' ' + trans_arr.error);
                        }
                    });
                }
            })
        });
    })(jQuery);
</script>
