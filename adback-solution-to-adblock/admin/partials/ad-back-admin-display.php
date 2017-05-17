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
    <div id="adb-stats">
        <grid>
            <div col="5/6">
                <!--<tabs>
                    <tab header="<?php /*_e('Global Statistics', 'ad-back'); */?>">-->
                        <section class="help-center">
                            <span>
                                <a href="javascript:history.back()" id="ab-form-start"><span class="dashicons-before dashicons-arrow-left-alt2"><?php _e('Back', 'ad-back'); ?></span></a>
                            </span>
                            <div style="float: right;">
                                <a href="http://docs.adback.co/en/latest/faq/adback.html" >
                                    <span class="dashicons-before dashicons-editor-help"><?php _e('Help center', 'ad-back');?></span>
                                </a>
                            </div>
                        </section>
                        <page>
                            <h3><?php _e('Today', 'ad-back'); ?></h3>
                            <today-widget></today-widget>

                            <h3><?php _e('Period: Last 7 days', 'ad-back'); ?></h3>
                            <div style="margin-bottom: 10px">
<!--                                <browser-type style="display:inline-block"></browser-type>-->
                                <datepicker style="float:right"></datepicker>
                                <div style="float:none;clear:both;"></div>
                            </div>
                            <section>
                                <h4 class="header-section"><?php _e('Blocked page view and percent', 'ad-back'); ?></h4>
                                <h7><?php _e('Blocked page view and percent - Sub', 'ad-back'); ?></h7>
                                <div class="section-content">
                                    <graph type="page-view-adblocker-percent"
                                           style="width: 95%; height: 400px; margin-bottom: 50px; position:relative;">
                                    </graph>
                                </div>
                            </section>

                            <section>
                                <h4 class="header-section"><?php _e('New - former adblock users', 'ad-back'); ?></h4>
                                <h7><?php _e('New - former adblock users - Sub', 'ad-back'); ?></h7>
                                <div class="section-content">
                                    <graph type="adblocker-new-old"
                                           style="width: 95%; height: 400px; margin-bottom: 50px; position:relative;">
                                    </graph>
                                </div>
                            </section>

                            <section>
                                <h4 class="header-section"><?php _e('Bounce rate of adblocker users', 'ad-back'); ?></h4>
                                <div class="section-content">
                                    <graph type="bounce"
                                           style="width: 95%; height: 400px; margin-bottom: 50px; position:relative;">
                                    </graph>
                                </div>
                            </section>

                            <section>
                                <h4 class="header-section"><?php _e('Browser', 'ad-back'); ?></h4>
                                <div class="section-content">
                                    <graph type="browser"
                                           style="width: 95%; height: 400px; margin-bottom: 50px; position:relative;">
                                    </graph>
                                </div>
                            </section>

                            <section>
                                <hr/>
                                <div class="section-content" style="padding-bottom:20px;">
                                    <p>
                                        <?php _e("When connecting to your AdBack dashboard, you'll discover the share of your adblocker visitors using a whitelist, the type of adblocker they use, the share of your analytics tools that are blocked (Google Analytics and Xiti), the geolocation of your adblocker users, their connection type, their operating system, the browser they use, on which device they are ; as well as data about their behavior on your site: the referral traffic, a list of your blocked pages, the bounce rate, the visit duration and the recurrence...", 'ad-back'); ?>
                                    </p>
                                    <center>
                                        <a href="<?php _e('https://www.adback.co/en/sites/dashboard', 'ad-back'); ?>"
                                           target="_blank"
                                           class="button-ab"><?php esc_html_e('Discover the top 10 of the blocked pages on your site and many other statistics!', 'ad-back'); ?></a>
                                    </center>
                                </div>
                            </section>
                        </page>
                    <!--</tab>-->
                    <!--<tab header="<?php /*_e('Monetisation Statistics', 'ad-back'); */ ?>">
                        <page>
                        <datepicker></datepicker>
                        <graph type="bounce"
                               style="width: 95%; height: 400px; margin-bottom: 50px; position:relative;">
                        </graph>
                        </page>
                    </tab>-->
                <!--</tabs>-->
            </div>

            <div col="1/6">
                <div>
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
