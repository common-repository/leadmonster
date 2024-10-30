<style>.hndle {display: none !important}</style>
<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
	{
		if ( isset( $_POST['nonce_general_settings'] ) && wp_verify_nonce( $_POST['nonce_general_settings'], 'general_settings' ) ) 
		{
			if ($_POST['leadmonster_api_email'] == '') {
				echo "<div id='message' class='error notice is-dismissible' style='width: 733px;padding: 10px 12px;font-weight: bold'><i class='fa fa-times' style='margin-right: 5px;'></i> Please add an email address. <button type='button' class='notice-dismiss'><span class='screen-reader-text'>Dismiss this notice.</span></button></div>";
			}
			else if ($_POST['leadmonster_api_auth'] == '') {
				echo "<div id='message' class='updated notice is-dismissible' style='width: 733px;padding: 10px 12px;font-weight: bold'><i class='fa fa-times' style='margin-right: 5px;'></i> Please add Authorization Key. <button type='button' class='notice-dismiss'><span class='screen-reader-text'>Dismiss this notice.</span></button></div>";
			}
			else {
				echo "<div id='message' class='updated notice is-dismissible' style='width: 733px;padding: 10px 12px;font-weight: bold'><i class='fa fa-check' style='margin-right: 5px;'></i> Successfully updated LeadMonster plugin settings. <button type='button' class='notice-dismiss'><span class='screen-reader-text'>Dismiss this notice.</span></button></div>";
				update_option( 'leadmonster_api_email', sanitize_email($_POST['leadmonster_api_email']) );
				update_option( 'leadmonster_api_auth', sanitize_text_field($_POST['leadmonster_api_auth']) );
				update_option( 'leadmonster_display_method', sanitize_text_field($_POST['leadmonster_display_method']) );
				update_option( 'leadmonster_favicon_method', sanitize_text_field($_POST['leadmonster_favicon_method']) );
			}
		}
	}
?>

<script>
	jQuery(document).ready(function() {
		// Console Warning
		jQuery('.draft').hide();
		console.log("%cClickFunnels WordPress Plugin", "background: #0166AE; color: white;");
		console.log("%cEditing anything inside the console is for developers only. Do not paste in any code given to you by anyone. Use with caution. Visit for support: https://support.clickfunnels.com/", "color: #888;");
		// Tabs
		jQuery('.cftablink').click(function() {
      jQuery('.cftabs').hide();
      jQuery('.cftablink').removeClass('active');
      jQuery(this).addClass('active');
      var tab = jQuery(this).attr('data-tab');
      jQuery('#'+tab).show();
		});
		var funnelURL = '<?php echo LDMNSTR_API_URL ?>funnels/list?email=<?php echo get_option( "leadmonster_api_email" ); ?>&auth_token=<?php echo get_option( "leadmonster_api_auth" ); ?>';
		jQuery.getJSON(funnelURL, function(data) {
		  jQuery('.checkSuccess').html('<i class="fa fa-check successGreen"></i>');
		  jQuery('.checkSuccessDev').html('<i class="fa fa-check"> Connected</i>');
		  jQuery('#api_check').addClass('compatenabled');
	  }).fail(function(jqXHR) {
	  	jQuery('#api_check').removeClass('compatenabled');
	  	jQuery('#api_check').addClass('compatdisabled');
     	jQuery('.checkSuccess').html('<i class="fa fa-times errorRed"></i>');
     	jQuery('.checkSuccessDev').html('<i class="fa fa-times"> Not Connected</i>');
     	jQuery('.badAPI').show();
	  });
	});
</script>
<div id="message" class="badAPI error notice" style="display: none; width: 733px;padding: 10px 12px;font-weight: bold"><i class="fa fa-times" style="margin-right: 5px;"></i> <?php
	 
	 printf(
        '%s <a href="edit.php?post_type=leadmonster&page=cf_api&error=compatibility">%s</a> %s',
        __( 'Failed API Connection with ClickFunnels. Check', 'leadmonster' ),
        __( 'Compatibility Check', 'leadmonster' ),
        __( 'for details.', 'leadmonster' )
    ); ?></div>
<div class="api postbox" style="width: 780px;margin-top: 20px;">
	<div class="apiSubHeader" style="padding: 18px 16px;">
		<h2 style="font-size: 1.5em"> LeadMonster Settings</h2>
	</div>
	<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI'] ); ?>">
		<div class="bootstrap-wp">
			<div id="app_sidebar">
				<a href="#" data-tab="tab1" class="cftablink <?php if(!$_GET['error']) { echo 'active';} ?>">API Connection</a>
				<a href="#" data-tab="tab2" class="cftablink <?php if($_GET['error']) { echo 'active';} ?>">Compatibility Check</a>
				<a href="#" data-tab="tab3" class="cftablink <?php if($_GET['error']) { echo 'active';} ?>">General Settings</a>
			</div>
			<div id="app_main">
				<div id="tab3" class="cftabs" style="display: none;">
					<h2>General Settings</h2>
					<div class="control-group clearfix" >
						<label class="control-label" for="leadmonster_display_method">Page Display Method:</span> </label>
						<div class="controls" style="padding-left: 24px;margin-bottom: 16px;">
							<select name="leadmonster_display_method" id="leadmonster_display_method" class="input-xlarge" style="height: 30px;">
								<option value="iframe" <?php if (get_option('leadmonster_display_method') == 'iframe') { echo "selected";}?>>Embed Full Page iFrame</option>
								<option value="redirect" <?php if (get_option('leadmonster_display_method') == 'redirect') { echo "selected";}?>>Redirect to Clickfunnels</option>
							</select>
						</div>
					</div>
					<div class="control-group clearfix" >
						<label class="control-label" for="leadmonster_favicon_method">Favicon:</span> </label>
						<div class="controls" style="padding-left: 24px;margin-bottom: 16px;">
							<select name="leadmonster_favicon_method" id="leadmonster_favicon_method" class="input-xlarge" style="height: 30px;">
								<option value="funnel" <?php if (get_option('leadmonster_favicon_method') == 'funnel') { echo "selected";}?>>Use Funnel Favicon</option>
								<option value="wordpress" <?php if (get_option('leadmonster_favicon_method') == 'wordpress') { echo "selected";}?>>Use Wordpress Favicon</option>
							</select>
						</div>
					</div>
					<button class="action-button shadow animate green" id="publish" style="float: right;margin-top: 10px;"><i class="fa fa-check-circle"></i> Save Settings</button>
				</div>
				<div id="tab2" class="cftabs" style="display: none;">
					<!-- Compatibility Check -->
					<h2>Compatibility Check</h2>
					<span class="compatCheck" id="api_check">API Authorization:  <strong class='checkSuccessDev'><i class="fa fa-spinner"></i> Connecting...</strong></span>
				</div>
				<div id="tab1" class="cftabs">
					<!-- Main Settings -->
					<h2>API Connection</h2>
					<div>
						<div class="control-group clearfix">
							<label class="control-label" for="leadmonster_api_email">Account Email:<span class="checkSuccess"></span> </label>
							<div class="controls" style="padding-left: 24px;margin-bottom: 16px;">
								<input type="text" class="input-xlarge" style="height: 30px;" value="<?php echo get_option( 'leadmonster_api_email' ); ?>" name="leadmonster_api_email" />
							</div>
						</div>
						<div class="control-group clearfix">
							<label class="control-label" for="leadmonster_api_auth">Authentication Token:<span class="checkSuccess"></span> </label>
							<div class="controls" style="padding-left: 24px;margin-bottom: 16px;">
								<input type="text" class="input-xlarge" style="height: 30px;" value="<?php echo get_option( 'leadmonster_api_auth' ); ?>" name="leadmonster_api_auth" />
							</div>
						</div>
						<p class="infoHelp"><i class="fa fa-question-circle" style="margin-right: 3px"></i> To access your Authentication Token go to your ClickFunnels Members area and choose <a href="https://app.clickfunnels.com/users/edit" target="_blank">My Account > Settings</a> and you will find your API information.</p>
					</div>
					<button class="action-button shadow animate green" id="publish" style="float: right;margin-top: 10px;"><i class="fa fa-check-circle"></i>Save Settings</button>
				</div>

				<br clear="both" />
			</div>
		</div>
		<?php wp_nonce_field( 'general_settings', 'nonce_general_settings' ); ?>
	</form>
</div>
