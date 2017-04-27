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
<h1><?php _e( 'AdBack : The stats of your AdBlock audience', 'ad-back' ); ?></h1>

<p>
    <?php _e('Statistics description', 'ad-back'); ?>
</p>
<hr class="clear">

<div class="col-9">
    <div data-ab-datepicker data-ab-type="classic" data-ab-id="global-datepicker"></div>

    <div class="block-graph">
        <h2><?php _e('Blocked page view and percent', 'ad-back'); ?></h2>
        <h4><?php _e('Blocked page view and percent - Sub', 'ad-back'); ?></h4>
        <div data-ab-graph data-ab-type="page-view-adblocker-percent" data-ab-date="global-datepicker"
             style="width: 95%; height: 400px; margin-bottom: 50px; position:relative;">
        </div>
    </div>

    <div class="block-graph">
        <h2><?php _e('New - former adblock users', 'ad-back'); ?></h2>
        <h4><?php _e('New - former adblock users - Sub', 'ad-back'); ?></h4>
        <div data-ab-graph data-ab-type="adblocker-new-old" data-ab-date="global-datepicker"
             style="width: 95%; height: 400px; margin-bottom: 50px; position:relative;">
        </div>
    </div>

    <div class="block-graph">
        <h2><?php _e('Bounce rate of adblocker users', 'ad-back'); ?></h2>
        <div data-ab-graph data-ab-type="bounce" data-ab-date="global-datepicker"
             style="width: 95%; height: 400px; margin-bottom: 50px; position:relative;">
        </div>
    </div>

    <div class="block-graph">
        <h2><?php _e('Browser', 'ad-back'); ?></h2>
        <div data-ab-graph data-ab-type="browser" data-ab-date="global-datepicker"
             style="width: 95%; height: 400px; margin-bottom: 50px; position:relative;">
        </div>
    </div>

    <div class="loader hide"
         style="position:absolute;width: 100%; height:100%; background-color: #FFFFFF; opacity: 0.8; text-align: center">
        <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             x="0px" y="0px"
             width="40px" height="40px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;"
             xml:space="preserve">
  <path fill="#000"
        d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z">
      <animateTransform attributeType="xml"
                        attributeName="transform"
                        type="rotate"
                        from="0 25 25"
                        to="360 25 25"
                        dur="0.6s"
                        repeatCount="indefinite"/>
  </path>
  </svg>
    </div>
</div>
<div class="col-3">
<!--ICI le block pour le status de la periode d'essai-->
</div>
<center>
    <a href="<?php _e('https://www.adback.co/en/sites/dashboard', 'ad-back'); ?>" target="_blank"
       class="button button-primary button-ab"><?php esc_html_e('Discover', 'ad-back'); ?></a>
</center>

<script type="text/javascript">
    window.onload = function () {
        if (typeof adbackjs === 'object') {
            adbackjs.init({
                token: '<?php echo $this->getToken()->access_token; ?>',
                url: 'https://<?php echo $this->getDomain(); ?>/api/',
                language: '<?php echo str_replace('_', '-', get_locale()); ?>'
            });
        } else {
            (function ($) {
                $("div[data-ab-graph]").each(function () {
                    $(this).append('<?php esc_js(printf(__('No data available, please <a href="%s">refresh domain</a>', 'ad-back'),
                        esc_url(home_url('/wp-admin/admin.php?page=ab-refresh-domain')))); ?>');
                });
            })(jQuery);
        }
    }
</script>
