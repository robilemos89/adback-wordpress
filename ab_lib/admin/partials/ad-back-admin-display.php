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

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h1 class="ab-lefty"><?php _e( 'AdBack : The stats of your AdBlock audience', 'ad-back' ); ?></h1>
<button id="ab-logout" class="button button-primary"><?php esc_html_e('Log out', 'ad-back'); ?></button>
<hr class="clear">

<h2><?php _e( 'Blocked page view and percent', 'ad-back' ); ?></h2>
<h4><?php _e( 'Blocked page view and percent - Sub', 'ad-back' ); ?></h4>
<div data-ab-graph data-ab-type="page-view-adblocker-percent" style="width: 95%; height: 400px; margin-bottom: 50px;">
</div>
<hr>


<h2><?php _e( 'New - former adblock users', 'ad-back' ); ?></h2>
<h4><?php _e( 'New - former adblock users - Sub', 'ad-back' ); ?></h4>
<div data-ab-graph data-ab-type="adblocker-new-old" style="width: 95%; height: 400px; margin-bottom: 50px;">
</div>
<hr>

<h2><?php _e( 'Bounce', 'ad-back' ); ?></h2>
<div data-ab-graph data-ab-type="bounce" style="width: 95%; height: 400px; margin-bottom: 50px;">
</div>
<hr>

<h2><?php _e( 'Browser', 'ad-back' ); ?></h2>
<div data-ab-graph data-ab-type="browser" style="width: 95%; height: 400px; margin-bottom: 50px;">
</div>
<hr>

<div class="ab-discover">
	<a href="https://www.adback.co" target="_blank" class="button button-primary button-ab"><?php esc_html_e('Discover', 'ad-back'); ?></a>
</div>

<script type="text/javascript">
	window.onload = function() {
            adbackjs.init({
                token: '<?php echo $this->getToken()->access_token; ?>',
                slug: '<?php echo $this->getMyInfo()["slug"]; ?>',
                url: 'https://<?php echo $this->getDomain(); ?>/api/',
                language: '<?php echo str_replace('_', '-', get_locale()); ?>'
            });
        }
</script>
