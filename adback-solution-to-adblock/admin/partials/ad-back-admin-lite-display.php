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
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="ab-full-app">
    <div id="adb-stats-lite"
         data-reviewlink="https://wordpress.org/support/plugin/one-click-adblock-monetisation/reviews/"
         data-supportlink="https://wordpress.org/support/plugin/one-click-adblock-monetisation">
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
        } else {
            (function ($) {
                $("div[data-ocam-graph]").each(function () {
                    $(this).append('<?php esc_js(printf(__('No data available, please <a href="%s">refresh domain</a>', 'adback-solution-to-adblock'),
                        esc_url(home_url('/wp-admin/admin.php?page=ocam-lite-refresh-domain')))); ?>');
                });
            })(jQuery);
        }

    }
</script>
