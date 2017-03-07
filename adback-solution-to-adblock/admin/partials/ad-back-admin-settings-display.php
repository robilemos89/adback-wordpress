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
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><?php esc_html_e('Show warning message for user with ad blocker', 'ad-back'); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text">
							<span><?php esc_html_e('Show warning message for user with ad blocker', 'ad-back'); ?></span>
						</legend>
						<label for="ab-settings-display">
							<input type="checkbox" id="ab-settings-display" value="1" <?php echo ($messages['display'] ? "checked='checked'" : ""); ?>>
						</label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e('Header text', 'ad-back'); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text">
							<span><?php esc_html_e('Header text', 'ad-back'); ?></span>
						</legend>
						<p>
							<input type="text" id="ab-settings-header-text" class="regular-text" value="<?php echo $messages['custom_messages'][0]['header_text']; ?>">
						</p>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e('Text message', 'ad-back'); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text">
							<span><?php esc_html_e('Text message', 'ad-back'); ?></span>
						</legend>
						<p>
							<textarea rows="10" cols="50" id="ab-settings-message" class="large-text code"><?php echo $messages['custom_messages'][0]['message']; ?></textarea>
						</p>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e('Text close button', 'ad-back'); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text">
							<span><?php esc_html_e('Text close button', 'ad-back'); ?></span>
						</legend>
						<p>
							<input type="text" id="ab-settings-close-text" class="regular-text" value="<?php echo $messages['custom_messages'][0]['close_text']; ?>">
						</p>
					</fieldset>
				</td>
			</tr>
		</tbody>
	</table>
	<p class="submit">
		<input type="submit" id="ab-settings-submit" class="button button-primary" value="<?php esc_html_e('Save', 'ad-back'); ?>">
	</p>
</div>
