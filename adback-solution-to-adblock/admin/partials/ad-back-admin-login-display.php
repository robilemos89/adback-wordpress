<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link	   https://www.adback.co
 * @since	  1.0.0
 *
 * @package	Ad_Back
 * @subpackage Ad_Back/admin/partials
 */

?>
<h1><?php _e( 'AdBack', 'ad-back' ); ?></h1>

<div id="ab-login">
	<div class="ab-col-md-6">
			<div class="ab-login-box">
				<h2><?php esc_html_e('Register with AdBack Account', 'ad-back'); ?></h2>
				<center><a href="https://www.adback.co" target="_blank"><div class="ab-login-logo" style="background-image:url('<?php echo plugin_dir_url( __FILE__ ); ?>images/_dback.png');"></div></a></center>
				<span class="ab-login-envato-desc"><?php esc_html_e('If you are a subscriber of AdBack.co, The usage of the plugins is free, click below to identify yourself:', 'ad-back'); ?></span>
				<center>
					<button class="button button-primary" id="ab-login-adback" style="width:100%;margin-top: 30px;"><?php esc_html_e('Activate my AdBack account', 'ad-back'); ?></button>
				</center>
				<center>
					<button
							class="button button-primary"
							id="ab-register-adback"
							style="width:100%;margin-top: 30px;"
							data-site-url="<?php echo get_site_url() ?>"
							data-email="<?php echo get_bloginfo('admin_email') ?>"
					>
						<?php esc_html_e('Create my AdBack account', 'ad-back'); ?>
					</button>
				</center>
			</div>
	</div>
</div>