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
<h1><?php _e( 'AdBack Message', 'ad-back' ); ?></h1>

<div id="ab-go-settings">
    <div class="ab-login-box ab-discover">
        <h2><?php esc_html_e('Activate and customize your message!', 'ad-back'); ?></h2>
        <a href="https://www.adback.co/en/monitoring/custom" target="_blank"><img style="max-width: 710px;width: 100%;" src="<?php echo plugin_dir_url( __FILE__ ); ?>images/head.png"/></a>
        <p>
            <?php _e('Customize message description', 'ad-back'); ?>
        </p>
        <a href="https://www.adback.co" target="_blank" class="button button-ab"><?php _e('Customize my message on AdBack.co', 'ad-back'); ?></a>
    </div>
</div>
