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
<h1><?php _e( 'AdBack Settings', 'ad-back' ); ?></h1>

<div id="ab-settings">
    <fieldset>
        <legend class="screen-reader-text">
            <span><?php esc_html_e('Activate your message', 'ad-back'); ?></span>
        </legend>
        <label for="ab-settings-display">
            <input type="checkbox" id="ab-settings-display" value="1" <?php echo ($messages['display'] == '1' ? "checked='checked'" : ""); ?>> <?php esc_html_e('Activate your message', 'ad-back'); ?>
        </label>
    </fieldset>
<br/>
    <fieldset>
        <legend class="screen-reader-text">
            <span><?php esc_html_e('No message for logged in Wordpress admin', 'ad-back'); ?></span>
        </legend>
        <label for="ab-settings-hide-admin">
            <input type="checkbox" id="ab-settings-hide-admin" value="0" <?php echo (get_option('adback_admin_hide_message', '1') === '1' ? "checked='checked'" : ""); ?>> <?php esc_html_e('No message for logged in Wordpress admin', 'ad-back'); ?>
        </label>
    </fieldset>
	<p class="submit">
		<input type="submit" id="ab-settings-submit" class="button button-primary" value="<?php esc_html_e('Save', 'ad-back'); ?>">
	</p>
</div>
