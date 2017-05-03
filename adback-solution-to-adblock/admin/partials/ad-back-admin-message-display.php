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

$subscription = $this->askSubscription();

$showTrial = is_array($subscription) && ($subscription['trial'] || $subscription['trial_status'] == 1 || $subscription['allowed'] > 0);

$progress = $subscription['progress'];
$allowed = $subscription['trial_status'] == 1 ? 10000 : $subscription['allowed'];

?>
<?php include "ad-back-admin-header.php" ?>
<h1><?php _e( 'AdBack Message', 'ad-back' ); ?></h1>

<div id="ab-full-app">
    <div id="ab-full-form"></div>
</div>
<div id="ab-go-settings">
    <?php if ($showTrial) { ?>
    <div class="ab-trial-box">
        <h2><?php echo $progress."/".$allowed." messages"; ?></h2>
        <div class="ab-progress">
            <div class="ab-progress-bar" role="progressbar" style="width:<?php echo $allowed > 0 ? ceil($progress / $allowed * 100) : 100 ?>%">
            </div>
        </div>
        <?php if ($subscription['trial_status'] == 1) { ?>
            <p>
                <?php _e('Free trial description', 'ad-back'); ?>
            </p>
            <a href="https://www.adback.co" target="_blank" class="button button-ab"><?php _e('Free trial start', 'ad-back'); ?></a>
        <?php } ?>
    </div>
    <?php } ?>
</div>

<script type="text/javascript">
    window.onload = function () {
        if (typeof adbackjs === 'object') {
            adbackjs.init({
                token: '<?php echo $this->getToken()->access_token; ?>',
                url: 'https://<?php echo $this->getDomain(); ?>/api/',
                language: '<?php echo str_replace('_', '-', get_locale()); ?>'
            });
        }
    }
</script>
