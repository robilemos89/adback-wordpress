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
<h2><?php _e('Last 7 days', 'ad-back'); ?></h2>
<br/>
<h3><?php _e( 'Blocked page view and percent', 'ad-back' ); ?></h3>
<div data-ab-graph data-ab-type="yesterday-page-view-adblocker-percent" data-ab-no-period="1" style="width: 95%; height: 400px; margin-bottom: 50px;">
</div>

<script type="text/javascript">
	window.onload = function() {
		if(typeof adbackjs === 'object') {
            adbackjs.init({
                token: '<?php echo $this->getToken()->access_token; ?>',
                url: 'https://<?php echo $this->getDomain(); ?>/api/',
                language: '<?php echo str_replace('_', '-', get_locale()); ?>'
            });
        }
    }
</script>
