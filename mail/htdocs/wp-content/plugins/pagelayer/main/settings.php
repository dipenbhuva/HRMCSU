<?php

//////////////////////////////////////////////////////////////
//===========================================================
// settings.php
//===========================================================
// PAGELAYER
// Inspired by the DESIRE to be the BEST OF ALL
// ----------------------------------------------------------
// Started by: Pulkit Gupta
// Date:	   23rd Jan 2017
// Time:	   23:00 hrs
// Site:	   http://pagelayer.com/wordpress (PAGELAYER)
// ----------------------------------------------------------
// Please Read the Terms of use at http://pagelayer.com/tos
// ----------------------------------------------------------
//===========================================================
// (c)Pagelayer Team
//===========================================================
//////////////////////////////////////////////////////////////

// Are we being accessed directly ?
if(!defined('PAGELAYER_VERSION')) {
	exit('Hacking Attempt !');
}

// The Pagelayer Settings Header
function pagelayer_page_header($title = 'Pagelayer Editor'){
	
	wp_enqueue_script( 'pagelayer-admin', PAGELAYER_JS.'/pagelayer-admin.js', array('jquery'), PAGELAYER_VERSION);
	wp_enqueue_style( 'pagelayer-admin', PAGELAYER_CSS.'/pagelayer-admin.css', array(), PAGELAYER_VERSION);
		
	$promos = apply_filters('pagelayer_review_link', true);
		
	echo '<div style="margin: 0px;">	
<div class="metabox-holder">
<div class="postbox-container">	
<div class="wrap" style="margin-top:0px;">
	<h1 style="padding:0px"><!--This is to fix promo--></h1>
	<table cellpadding="2" cellspacing="1" width="100%" class="fixed" border="0">
		<tr>
			<td valign="top"><h1>'.$title.'</h1></td>
			'.($promos ? '<td align="right"><a target="_blank" class="button button-primary" href="https://wordpress.org/support/view/plugin-reviews/pagelayer">Review Pagelayer</a></td>' : '').'
			<td align="right" width="40"><a target="_blank" href="https://twitter.com/pagelayer"><img src="'.PAGELAYER_URL.'/images/twitter.png" /></a></td>
			<td align="right" width="40"><a target="_blank" href="https://www.facebook.com/pagelayer/"><img src="'.PAGELAYER_URL.'/images/facebook.png" /></a></td>
		</tr>
	</table>
	<hr />
	
	<!--Main Table-->
	<table cellpadding="8" cellspacing="1" width="100%" class="fixed">
	<tr>
		<td valign="top">';

}

// The Pagelayer Settings footer
function pagelayer_page_footer(){
	
	echo '
		</td>';
		
	$promos = apply_filters('pagelayer_right_bar_promos', true);
	
	if($promos){
	
		echo '
		<td width="200" valign="top" id="pagelayer-right-bar">';
		
		if(!defined('PAGELAYER_PREMIUM')){
			
			echo '
			<div class="postbox" style="min-width:0px !important;">
				<h2 class="hndle ui-sortable-handle">
					<span><a target="_blank" href="'.PAGELAYER_PRO_URL.'"><img src="'.PAGELAYER_URL.'/images/pagelayer_product.png" width="100%" /></a></span>
				</h2>
				<div class="inside">
					<i>Upgrade to the premium version and get the following features </i>:<br>
					<ul class="pagelayer-right-ul">
						<li>60+ Premium Widgets</li>
						<li>400+ Premium Sections</li>
						<li>Theme Builder</li>
						<li>WooCommerce Builder</li>
						<li>Theme Creator and Exporter</li>
						<li>Form Builder</li>
						<li>Popup Builder</li>
						<li>And many more ...</li>
					</ul>
					<center><a class="button button-primary" target="_blank" href="'.PAGELAYER_PRO_URL.'">Upgrade</a></center>
				</div>
			</div>';
			
		}
		
		echo '
			<div class="postbox" style="min-width:0px !important;">
				<h2 class="hndle ui-sortable-handle">
					<span><a target="_blank" href="https://wpcentral.co/?from=pagelayer-plugin"><img src="'.PAGELAYER_URL.'/images/wpcentral_product.png" width="100%" /></a></span>
				</h2>
				<div class="inside">
					<i>Manage all your WordPress sites from <b>1 dashboard</b> </i>:<br>
					<ul class="pagelayer-right-ul">
						<li>1-click Admin Access</li>
						<li>Update WordPress</li>
						<li>Update Themes</li>
						<li>Update Plugins</li>
						<li>Backup your WordPress Site</li>
						<li>Plugins & Theme Management</li>
						<li>Post Management</li>
						<li>And many more ...</li>
					</ul>
					<center><a class="button button-primary" target="_blank" href="https://wpcentral.co/?from=pagelayer-plugin">Visit wpCentral</a></center>
				</div>
			</div>
		
		</td>';
	}
	
	echo '
	</tr>
	</table>
	<br />';
	
	if(empty($GLOBALS['sitepad'])){
	
		echo '<div style="width:45%;background:#FFF;padding:15px; margin:auto">
		<b>Let your followers know that you use Pagelayer to build your website :</b>
		<form method="get" action="https://twitter.com/intent/tweet" id="tweet" onsubmit="return dotweet(this);">
			<textarea name="text" cols="45" row="3" style="resize:none;">I easily built my #WordPress #site using @pagelayer</textarea>
			&nbsp; &nbsp; <input type="submit" value="Tweet!" class="button button-primary" onsubmit="return false;" id="twitter-btn" style="margin-top:20px;"/>
		</form>
		
	</div>
	<br />
	
	<script>
	function dotweet(ele){
		window.open(jQuery("#"+ele.id).attr("action")+"?"+jQuery("#"+ele.id).serialize(), "_blank", "scrollbars=no, menubar=no, height=400, width=500, resizable=yes, toolbar=no, status=no");
		return false;
	}
	</script>
	
	<hr />
	<a href="'.PAGELAYER_WWW_URL.'" target="_blank">Pagelayer</a> v'.PAGELAYER_VERSION.' You can report any bugs <a href="http://wordpress.org/support/plugin/pagelayer" target="_blank">here</a>.';
	
	}

echo '
</div>	
</div>
</div>
</div>';

}

function pagelayer_settings_page(){

	$option_name = 'pl_gen_setting' ;
	$new_value = '';
	
	if(isset($_REQUEST['submit'])){
		check_admin_referer('pagelayer-options');
	}

	if(isset($_REQUEST['pl_gen_setting'])){
		$new_value = $_REQUEST['pl_gen_setting'];
		
		if ( get_option( $option_name ) !== false ) {
	
			// The option already exists, so we just update it.
			update_option( $option_name, $new_value );

		} else {

			// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
			$deprecated = null;
			$autoload = 'no';
			add_option( $option_name, $new_value, $deprecated, $autoload );
		}

	}
	
	if(isset($_REQUEST['pl_support_ept'])){

		$pl_support_ept = $_REQUEST['pl_support_ept'];
		
		if ( get_option( 'pl_support_ept' ) !== false ) {
	
			// The option already exists, so we just update it.
			update_option( 'pl_support_ept', $pl_support_ept );

		} else {

			// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
			$deprecated = null;
			$autoload = 'no';
			$pl_support_ept = ['post', 'page'];
			add_option( 'pl_support_ept', $pl_support_ept, $deprecated, $autoload );
		}
	}
	
	
	
	if(isset($_REQUEST['pagelayer_icons_set'])){
		$pagelayer_icons_set = $_REQUEST['pagelayer_icons_set'];
		
		if ( get_option( 'pagelayer_icons_set' ) !== false ) {
	
			// The option already exists, so we just update it.
			update_option( 'pagelayer_icons_set', $pagelayer_icons_set);

		} else {
			// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
			$deprecated = null;
			$autoload = 'no';
			//$pagelayer_icons_set = [];
			add_option( 'pagelayer_icons_set', $pagelayer_icons_set, $deprecated, $autoload );
		}
	}
	
	if(isset($_REQUEST['pagelayer_content_width'])){

		$content_width = $_REQUEST['pagelayer_content_width'];
		
		if ( get_option( 'pagelayer_content_width' ) !== false ) {
	
			// The option already exists, so we just update it.
			update_option( 'pagelayer_content_width', $content_width );

		} else {

			// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
			$deprecated = null;
			$autoload = 'no';
			add_option( 'pagelayer_content_width', $content_width, $deprecated, $autoload );
		}
	}
	
	// Tablet breakpoint 
	if(isset($_REQUEST['pagelayer_tablet_breakpoint'])){

		$tablet_breakpoint = $_REQUEST['pagelayer_tablet_breakpoint'];
		
		if ( get_option( 'pagelayer_tablet_breakpoint' ) !== false ) {
	
			// The option already exists, so we just update it.
			update_option( 'pagelayer_tablet_breakpoint', $tablet_breakpoint );

		} else {

			// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
			$deprecated = null;
			$autoload = 'no';
			add_option( 'pagelayer_tablet_breakpoint', $tablet_breakpoint, $deprecated, $autoload );
		}
	}
	
	
	// Mobile breakpoint 
	if(isset($_REQUEST['pagelayer_mobile_breakpoint'])){

		$tablet_breakpoint = $_REQUEST['pagelayer_mobile_breakpoint'];
		
		if ( get_option( 'pagelayer_mobile_breakpoint' ) !== false ) {
	
			// The option already exists, so we just update it.
			update_option( 'pagelayer_mobile_breakpoint', $tablet_breakpoint );

		} else {

			// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
			$deprecated = null;
			$autoload = 'no';
			add_option( 'pagelayer_mobile_breakpoint', $tablet_breakpoint, $deprecated, $autoload );
		}
	}
	
	if(isset($_REQUEST['pagelayer_between_widgets'])){

		$space_widgets = $_REQUEST['pagelayer_between_widgets'];
		
		if ( get_option( 'pagelayer_between_widgets' ) !== false ) {
	
			// The option already exists, so we just update it.
			update_option( 'pagelayer_between_widgets', $space_widgets );

		} else {

			// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
			$deprecated = null;
			$autoload = 'no';
			add_option( 'pagelayer_between_widgets', $space_widgets, $deprecated, $autoload );
		}
	}
	
	if(isset($_REQUEST['pagelayer_body_font'])){

		$body_font = $_REQUEST['pagelayer_body_font'];
		
		if ( get_option( 'pagelayer_body_font' ) !== false ) {
	
			// The option already exists, so we just update it.
			update_option( 'pagelayer_body_font', $body_font );

		} else {

			// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
			$deprecated = null;
			$autoload = 'no';
			add_option( 'pagelayer_body_font', $body_font, $deprecated, $autoload );
		}
	}
	
	$socials = ['pagelayer-facebook-url','pagelayer-twitter-url','pagelayer-instagram-url','pagelayer-linkedin-url','pagelayer-youtube-url','pagelayer-gplus-url','pagelayer-copyright','pagelayer-phone','pagelayer-address'];
	
	foreach( $socials as $social ){
		if(isset($_REQUEST[$social])){
			$url = $_REQUEST[$social];
			update_option($social, $url);
		}
	}
	
	if(isset($_REQUEST['pagelayer_cf_to_email'])){

		$to_email = $_REQUEST['pagelayer_cf_to_email'];
		
		if ( get_option( 'pagelayer_cf_to_email' ) !== false ) {
	
			// The option already exists, so we just update it.
			update_option( 'pagelayer_cf_to_email', $to_email );

		} else {

			// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
			$deprecated = null;
			$autoload = 'no';
			add_option( 'pagelayer_cf_to_email', $to_email, $deprecated, $autoload );
		}
	}
		
	if(defined('PAGELAYER_PREMIUM')){
	
		if(isset($_REQUEST['pagelayer_cf_subject'])){

			$subject = $_REQUEST['pagelayer_cf_subject'];
			
			if ( get_option( 'pagelayer_cf_subject' ) !== false ) {
		
				// The option already exists, so we just update it.
				update_option( 'pagelayer_cf_subject', $subject );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$deprecated = null;
				$autoload = 'no';
				add_option( 'pagelayer_cf_subject', $subject, $deprecated, $autoload );
			}
		}
		
		if(isset($_REQUEST['pagelayer_cf_headers'])){

			$subject = $_REQUEST['pagelayer_cf_headers'];
			
			if ( get_option( 'pagelayer_cf_headers' ) !== false ) {
		
				// The option already exists, so we just update it.
				update_option( 'pagelayer_cf_headers', $subject );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$deprecated = null;
				$autoload = 'no';
				add_option( 'pagelayer_cf_headers', $subject, $deprecated, $autoload );
			}
		}
		
		if(isset($_REQUEST['pagelayer_cf_from_email'])){

			$subject = $_REQUEST['pagelayer_cf_from_email'];
			
			if ( get_option( 'pagelayer_cf_from_email' ) !== false ) {
		
				// The option already exists, so we just update it.
				update_option( 'pagelayer_cf_from_email', $subject );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$deprecated = null;
				$autoload = 'no';
				add_option( 'pagelayer_cf_from_email', $subject, $deprecated, $autoload );
			}
		}
		
		if(isset($_REQUEST['pagelayer_cf_success'])){

			$success = $_REQUEST['pagelayer_cf_success'];
			
			if ( get_option( 'pagelayer_cf_success' ) !== false ) {
		
				// The option already exists, so we just update it.
				update_option( 'pagelayer_cf_success', $success );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$deprecated = null;
				$autoload = 'no';
				add_option( 'pagelayer_cf_success', $success, $deprecated, $autoload );
			}
		}
		
		if(isset($_REQUEST['pagelayer_cf_failed'])){

			$failed = $_REQUEST['pagelayer_cf_failed'];
			
			if ( get_option( 'pagelayer_cf_failed' ) !== false ) {
		
				// The option already exists, so we just update it.
				update_option( 'pagelayer_cf_failed', $failed );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$deprecated = null;
				$autoload = 'no';
				add_option( 'pagelayer_cf_failed', $failed, $deprecated, $autoload );
			}
		}
		
		if(isset($_REQUEST['pagelayer_google_captcha'])){

			$captcha = $_REQUEST['pagelayer_google_captcha'];
			
			if ( get_option( 'pagelayer_google_captcha' ) !== false ) {
		
				// The option already exists, so we just update it.
				update_option( 'pagelayer_google_captcha', $captcha );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$deprecated = null;
				$autoload = 'no';
				add_option( 'pagelayer_google_captcha', $captcha, $deprecated, $autoload );
			}
		}
		
		// Facebook APP ID
		if(isset($_REQUEST['pagelayer-fbapp-id'])){
			$fb_app_id = $_REQUEST['pagelayer-fbapp-id'];
			
			// Save it
			update_option( 'pagelayer-fbapp-id', $fb_app_id );
		}
		
		// Save Header code
		if(isset($_REQUEST['pagelayer_header_code'])){	
			update_option( 'pagelayer_header_code', wp_unslash($_REQUEST['pagelayer_header_code'] ));
		}
		
		// Save Footyer code
		if(isset($_REQUEST['pagelayer_footer_code'])){
			update_option( 'pagelayer_footer_code', wp_unslash($_REQUEST['pagelayer_footer_code'] ));
		}
	}

	$post_type = array('post', 'page', 'product');
	
	$support_ept = get_option( 'pl_support_ept', ['post', 'page']);
	foreach ( $support_ept as $support_pl ) {
		add_post_type_support( $support_pl, 'pagelayer' );
	}

	pagelayer_page_header('Pagelayer Settings');
	
?>
	<form class="pagelayer-setting-form" method="post" action="">
		<?php wp_nonce_field('pagelayer-options'); ?>
		<div class="tabs-wrapper">
			<h2 class="nav-tab-wrapper pagelayer-wrapper">
				<a href="#general" class="nav-tab">General</a>
				<a href="#settings" class="nav-tab ">Settings</a>
				<a href="#icons" class="nav-tab ">Enable Icons</a>
				<a href="#social" class="nav-tab">Information</a>
				<?php if(defined('PAGELAYER_PREMIUM')){ ?>
				<a href="#integration" class="nav-tab">Integrations</a>
				<a href="#contactform" class="nav-tab ">Contact Form</a>
				<a href="#captcha" class="nav-tab ">Google Captcha</a>
				<?php } ?>
				<a href="#support" class="nav-tab ">Support</a>
				<a href="#faq" class="nav-tab ">FAQ</a>
			</h2>
		
			<div class="pagelayer-tab-panel" id="general">
				 <table>
					<tr>
						<th scope="row">Editor Enables On </th>
						<td>
						<label>
					<?php
						foreach($post_type as $type){
							
							echo '<input type="checkbox" name="pl_support_ept[]" value="'.$type.'" '. (in_array($type, $support_ept) ? "checked" : "") .'/>'.$type.'</br>';
						}
					?>
						</label>
						</td>
					</tr>
				 </table>
			</div>
			<div class="pagelayer-tab-panel" id="settings">
				<table>
					<tr>
						<th><?php echo __('Content Width') ?></th>
						<td>
							<input name="pagelayer_content_width" type="number" step="1" min="320" max="5000" placeholder="1170" <?php if(get_option('pagelayer_content_width')){
								echo 'value="'.get_option('pagelayer_content_width').'"';
							}?>>
							<p><?php echo __('Set the custom width of the content area. The default width set is 1170px.') ?></p>
						</td>
					<tr>
					<tr>
						<th><?php echo __('Space Between Widgets') ?></th>
						<td>
							<input name="pagelayer_between_widgets" type="number" step="1" min="0" max="500" placeholder="15" <?php if(get_option('pagelayer_between_widgets')){
								echo 'value="'.get_option('pagelayer_between_widgets').'"';
							}?>>
							<p><?php echo __('Set the Space Between Widgets. The default Space set is 15px.') ?></p>
						</td>
					<tr>
					<tr>
						<th><?php echo __('Body Font') ?></th>
						<td>
							<input name="pagelayer_body_font" type="text" placeholder="Open Sans" <?php if(get_option('pagelayer_body_font')){
								echo 'value="'.get_option('pagelayer_body_font').'"';
							}?>>
							<p><?php echo __('Please give font name as it appears on Google fonts site. You can check all google fonts here: <a href="https://fonts.google.com" target="_blank">https://fonts.google.com</a>.') ?></p>
						</td>
					<tr>
					<tr>
						<th><?php echo __('Tablet Breakpoint') ?></th>
						<td>
							<input name="pagelayer_tablet_breakpoint" type="number" step="1" min="320" max="5000" placeholder="768" <?php if(get_option('pagelayer_tablet_breakpoint')){
								echo 'value="'.get_option('pagelayer_tablet_breakpoint').'"';
							}?>>
							<p><?php echo __('Set the breakpoint for tablet devices. The default breakpoint for tablet layout is 768px.') ?></p>
						</td>
					</tr>
					<tr>
						<th><?php echo __('Mobile Breakpoint') ?></th>
						<td>
							<input name="pagelayer_mobile_breakpoint" type="number" step="1" min="320" max="5000" placeholder="360" <?php if(get_option('pagelayer_mobile_breakpoint')){
								echo 'value="'.get_option('pagelayer_mobile_breakpoint').'"';
							}?>>
							<p><?php echo __('Set the breakpoint for mobile devices. The default breakpoint for mobile layout is 360px.') ?></p>
						</td>
					</tr>
					<?php if(defined('PAGELAYER_PREMIUM')){ ?>
					<tr>
						<td colspan="2">
							<b><?php echo __('Header and Footer code :');?></b>
							<p><?php echo __('You can add custom code like HTML, JavaScript, CSS etc. which will be inserted throughout your site.');?></p>
						</td>
					</tr>
					<tr>
						<th><?php echo __('Header Code : ');?></th>
						<td>
							<textarea name="pagelayer_header_code" style="width:80%;" rows="6"><?php echo get_option( 'pagelayer_header_code' ); ?></textarea>
							<p> <?php echo __('These Code will be printed in <code>&lt;head&gt;</code> Section.') ?> </p>
						</td>
					</tr>
					<tr>
						<th><?php echo __('Footer Code: ');?></th>
						<td>
							<textarea name="pagelayer_footer_code" style="width:80%;" rows="6"><?php echo  get_option( 'pagelayer_footer_code' ); ?></textarea>
							<p> <?php echo __('These Code will be printed before closing the <code>&lt;/body&gt;</code> Section.') ?> </p>
						</td>
					</tr>
					<?php } ?>
				</table>
			</div>
			<div class="pagelayer-tab-panel" id="icons">
				<table>
					<tr>
						<th scope="row">Enable Icons</th>
						<td>
						<label>
							<input type="checkbox" name="pagelayer_icons_set[]" value="font-awesome5" <?php if(in_array('font-awesome5',get_option( 'pagelayer_icons_set')) || !get_option( 'pagelayer_icons_set')){echo ' checked';}?> />font-awesome5</br>
						</label>
						</td>
					</tr>
				 </table>
			</div>
			<div class="pagelayer-tab-panel" id="social">
				<div class="pagelayer-settings-info" style="display:flex;">
					<div style="flex:1">
						<div class="pagelayer-title">
							<h2>Address and Phone Number</h2>
						</div>
						<table>
							<tr>
								<th>Address</th>
								<td><textarea name="pagelayer-address"><?php echo pagelayer_get_option('pagelayer-address');?></textarea></td>
							</tr>
							<tr>
								<th>Phone Number</th>
								<td><input type="tel" name="pagelayer-phone" <?php echo 'value="'.pagelayer_get_option('pagelayer-phone').'"';?> /></td>
							</tr>
							
							<tr>
								<th scope="row">Contact Email:</th>
								<td>
									<?php if(defined('PAGELAYER_PREMIUM')){																			
										echo '<p>You can change your contact email<br> from the Contact Form Settings.</p>';									
									}else{
									?>
									<label>
										<input name="pagelayer_cf_to_email" type="email" placeholder="email@domain.com" <?php if(get_option('pagelayer_cf_to_email')){
										echo 'value="'.get_option('pagelayer_cf_to_email').'"';
									}?>/>
									</label>
									<?php } ?>
								</td>
							</tr>
							
						</table>
						<?php if(defined('PAGELAYER_PREMIUM')){ ?>
						<div class="pagelayer-title">
							<h2>Copyright</h2>
						</div>
						<table>
							<tr>
								<th>Copyright Text</th>
								<td><textarea name="pagelayer-copyright"><?php echo pagelayer_get_option('pagelayer-copyright'); ?></textarea></td>
							</tr>
						</table>
						<?php } ?>
					</div>
					<?php if(defined('PAGELAYER_PREMIUM')){ ?>
					<div style="flex:1">
						<div class="pagelayer-title">
							<h2>Social Profile URLs</h2>
						</div>
						<table>
							<tr>
								<th>Facebook</th>
								<td><input type="text" name="pagelayer-facebook-url" <?php echo 'value="'.get_option('pagelayer-facebook-url').'"';?>/></td>
							</tr>
							<tr>
								<th>Twitter</th>
								<td><input type="text" name="pagelayer-twitter-url" <?php echo 'value="'.get_option('pagelayer-twitter-url').'"';?>/></td>
							</tr>
							<tr>
								<th>Instagram</th>
								<td><input type="text" name="pagelayer-instagram-url" <?php  echo 'value="'.get_option('pagelayer-instagram-url').'"'; ?>/></td>
							</tr>
							<tr>
								<th>LinkedIn</th>
								<td><input type="text" name="pagelayer-linkedin-url" <?php echo 'value="'.get_option('pagelayer-linkedin-url').'"'; ?>/></td>
							</tr>
							<tr>
								<th>YouTube</th>
								<td><input type="text" name="pagelayer-youtube-url" <?php echo 'value="'.get_option('pagelayer-youtube-url').'"'; ?>/></td>
							</tr>
							<tr>
								<th>Google+</th>
								<td><input type="text" name="pagelayer-gplus-url" <?php echo 'value="'.get_option('pagelayer-gplus-url').'"'; ?>/></td>
							</tr>
						</table>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php if(defined('PAGELAYER_PREMIUM')){ ?>
			<div class="pagelayer-tab-panel" id="integration">
				<div class="pagelayer-title">
					<h2>Facebook SDK Details</h2>
				</div>
				<table>
					<tr>
						<th>App ID</th>
						<td><input type="text" name="pagelayer-fbapp-id" class="pagelayer-app-id" <?php if(get_option('pagelayer-fbapp-id')){
								echo 'value="'.get_option('pagelayer-fbapp-id').'"';
							}?>/></td>
					</tr>					
				</table>
			</div>
			<div class="pagelayer-tab-panel pagelayer-cf" id="contactform">
				 <table>
					<tr>
						<th scope="row">To Email:</th>
						<td>
							<label>
								<input name="pagelayer_cf_to_email" type="email" placeholder="email@domain.com" <?php if(get_option('pagelayer_cf_to_email')){
								echo 'value="'.get_option('pagelayer_cf_to_email').'"';
							}?>/>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row">From Email:</th>
						<td>
							<label>
								<input name="pagelayer_cf_from_email" type="text" placeholder="My Site <email@domain.com>" <?php 
								if(get_option('pagelayer_cf_from_email')){
								echo 'value="'.get_option('pagelayer_cf_from_email').'"';
							}?>/>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row">Subject:</th>
						<td>
							<label>
								<input name="pagelayer_cf_subject" type="text" placeholder="Subject" <?php if(get_option('pagelayer_cf_subject')){
								echo 'value="'.get_option('pagelayer_cf_subject').'"';
							}?> />
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row">Additional Headers: </th>
						<td>
							<label>
								<textarea rows="3" name="pagelayer_cf_headers"><?php 
								if(get_option('pagelayer_cf_headers')){
									echo get_option('pagelayer_cf_headers');
								} ?></textarea>
							</label>
						</td>
					</tr>
					<tr>
						<td colspan="2"><b>Messages : </b><p>You can edit messages used for information of your form here.</p></td>
					</tr>
					<tr>
						<th scope="row">Success Message :</th>
						<td>
							<label>
								<input name="pagelayer_cf_success" type="text" placeholder="Success" <?php if(get_option('pagelayer_cf_success')){
								echo 'value="'.get_option('pagelayer_cf_success').'"';
							}?> />
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row">Failed Message :	</th>
						<td>
							<label>
								<input name="pagelayer_cf_failed" type="text" placeholder="Failed" <?php if(get_option('pagelayer_cf_failed')){
								echo 'value="'.get_option('pagelayer_cf_failed').'"';
							}?> />
							</label>
						</td>
					</tr>
				 </table>
			</div>
			<div class="pagelayer-tab-panel" id="captcha">
				 <table>
					<tr>
						<th scope="row">Google ReCaptcha </th>
						<td>
							<label>
								<input name="pagelayer_google_captcha" type="text" placeholder="captcha" <?php if(get_option('pagelayer_google_captcha')){
								echo 'value="'.get_option('pagelayer_google_captcha').'"';
							}?> />
							</label>
						</td>
					</tr>
				 </table>
			</div>
			<?php } ?>
			<div class="pagelayer-tab-panel" id="support">
				<h2>Support</h2>
				<h3>You can contact the Pagelayer Team via email. Our email address is <a href="mailto:support@pagelayer.com">support@pagelayer.com</a>. We will get back to you as soon as possible!</h3>
			</div>
			<div class="pagelayer-tab-panel" id="faq">
				<h2>FAQ</h2>
				<div class="pagelayer-acc-wrapper">
					<span class="nav-tab pagelayer-acc-tab">1: Why choose us</span>
					<div class="pagelayer-acc-panel">
						<p>Pagelayer is best live editor and easy to use and we will keep improving it !</P>
					</div>
					
					<span class="nav-tab pagelayer-acc-tab">2: Support</span>
					<div class="pagelayer-acc-panel">
						<p>You can contact the PageLayer Group via email. Our email address is <a href="mailto:support@pagelayer.com">support@pagelayer.com</a>. We will get back to you as soon as possible!</p>
					</div>
				</div>
			</div>
		</div>
		<p>
			<input type="submit" name="submit" class="button button-primary" value="Save Changes">
		</p>
	</form>
	
<?php
	
	pagelayer_page_footer();

}