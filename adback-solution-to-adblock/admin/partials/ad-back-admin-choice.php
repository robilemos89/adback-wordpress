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
<h1><?php _e('AdBack', 'ad-back'); ?></h1>

<div id="ab-login">
    <div class="ab-col-md-12">
        <div class="ab-step-left">
            <a style="color: #00b988;" class="padding-10"> <img src="<?php echo plugin_dir_url(__FILE__) . '/images/success.svg' ?>" class="ab-check"><?php esc_html_e('Account creation', 'adback-solution-to-adblock'); ?></a>
            <a style="color: black;" class="padding-10"><img src="<?php echo plugin_dir_url(__FILE__) . '/images/check-gray.svg' ?>" class="ab-check"><?php esc_html_e('Choice of the solution', 'adback-solution-to-adblock'); ?></a>
            <a style="color: gray" class="padding-10"><img src="<?php echo plugin_dir_url(__FILE__) . '/images/check-gray.svg' ?>" class="ab-check"><?php esc_html_e('Let\'s go!', 'adback-solution-to-adblock'); ?></a>
        </div>
        <div class="ab-choose-box">
            <div class="ab-choose-sticky multi-line"><?php _e('Highly</br>recommended', 'adback-solution-to-adblock'); ?></div>
            <h2 class="ab-choose-h"><?php esc_html_e('ONE CLICK ADBLOCK MONETIZATION', 'adback-solution-to-adblock'); ?></h2>
            <h3 class="ab-choose-h"><?php esc_html_e('Only solution for websites with less than 1.5 million monthly pageviews', 'adback-solution-to-adblock'); ?></h3>
            <p class="ab-choose-text"><?php esc_html_e('Monetize instantly your adblock audience by displaying a message offering 2 possibilities to
                        access your content: disabling the adblocker or clicking on an ad. You win in every case!'); ?></p>
            <button id="ab-choose-light"><?php esc_html_e('CONTINUE', 'adback-solution-to-adblock'); ?></button>
        </div>
        <br/>
        <div class="text-align-center">
            <a id="ab-choose-custom"><?php esc_html_e('or continue with the advanced mode', 'adback-solution-to-adblock'); ?></a>
            <p style="color: #818181d6;"><?php esc_html_e('Caution: only for premium websites and highly advanced users. Needs some technical integration.'); ?></p>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function ($) {
        $("#ab-choose-light").on('click', function () {
            var data = {
                'action': 'lite_integration'
            };
            $.post(ajaxurl, data, function (response) {
                var obj = JSON.parse(response);
                if (obj.done === true) {
                    window.location.href = location.protocol + '//' + location.host + location.pathname + '?page=ab';
                } else {
                    vex.dialog.alert(trans_arr.oops + ' ' + trans_arr.error);
                }
            });
        });
        $("#ab-choose-custom").on('click', function () {
            var data = {
                'action': 'full_integration'
            };
            $.post(ajaxurl, data, function (response) {
                var obj = JSON.parse(response);
                if (obj.done === true) {
                    window.location.href = location.protocol + '//' + location.host + location.pathname + '?page=ab';
                } else {
                    vex.dialog.alert(trans_arr.oops + ' ' + trans_arr.error);
                }
            });
        });
    })(jQuery);
</script>
