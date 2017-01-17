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
<h1><?php _e( 'AdBack', 'wp_admin_style' ); ?></h1>

<div id="ab-select-slug">

	<span><?php esc_html_e('Select the slug for your website :', 'ad-back'); ?></span><br>
	<select id="ab-select-slug-field" tabindex='-1'>
		<?php
			foreach($myinfo['sites'] as $site) {
				echo "<option value='".$site['slug']."'>".$site['slug']."</option>";
			}
		?>
	</select><br>
	<button class="button button-primary" id="ab-select-slug-save"><?php esc_html_e('Save', 'ad-back'); ?></button>
	
</div>