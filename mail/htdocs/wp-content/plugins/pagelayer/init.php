<?php

// We need the ABSPATH
if (!defined('ABSPATH')) exit;

define('PAGELAYER_BASE', plugin_basename(PAGELAYER_FILE));
define('PAGELAYER_PRO_BASE', 'pagelayer-pro/pagelayer-pro.php');
define('PAGELAYER_VERSION', '1.1.2');
define('PAGELAYER_DIR', dirname(PAGELAYER_FILE));
define('PAGELAYER_SLUG', 'pagelayer');
define('PAGELAYER_URL', plugins_url('', PAGELAYER_FILE));
define('PAGELAYER_CSS', PAGELAYER_URL.'/css');
define('PAGELAYER_JS', PAGELAYER_URL.'/js');
define('PAGELAYER_PRO_URL', 'https://pagelayer.com/pricing?from=plugin');
define('PAGELAYER_WWW_URL', 'https://pagelayer.com/');
define('PAGELAYER_DOCS', 'https://pagelayer.com/docs/');
define('PAGELAYER_API', 'https://api.pagelayer.com/');
define('PAGELAYER_SC_PREFIX', 'pl');
define('PAGELAYER_YOUTUBE_BG', 'https://www.youtube.com/watch?v=Csa6rvCWmLU');
@define('PAGELAYER_BRAND_TEXT', 'Pagelayer');
@define('PAGELAYER_LOGO', PAGELAYER_URL.'/images/pagelayer-logo-40.png');

include_once(PAGELAYER_DIR.'/main/functions.php');
include_once(PAGELAYER_DIR.'/main/class.php');

// Ok so we are now ready to go
register_activation_hook(PAGELAYER_FILE, 'pagelayer_activation');

// Is called when the ADMIN enables the plugin
function pagelayer_activation(){

	global $wpdb;

	$sql = array();

	/*$sql[] = "DROP TABLE IF EXISTS `".$wpdb->prefix."pagelayer_logs`";

	foreach($sql as $sk => $sv){
		$wpdb->query($sv);
	}*/

	add_option('pagelayer_version', PAGELAYER_VERSION);
	add_option('pagelayer_options', array());

}

// Checks if we are to update ?
function pagelayer_update_check(){

global $wpdb;

	$sql = array();
	$current_version = get_option('pagelayer_version');
	$version = (int) str_replace('.', '', $current_version);

	// No update required
	if($current_version == PAGELAYER_VERSION){
		return true;
	}

	// Is it first run ?
	if(empty($current_version)){

		// Reinstall
		pagelayer_activation();

		// Trick the following if conditions to not run
		$version = (int) str_replace('.', '', PAGELAYER_VERSION);

	}

	// Save the new Version
	update_option('pagelayer_version', PAGELAYER_VERSION);

}

// Add the action to load the plugin 
add_action('plugins_loaded', 'pagelayer_load_plugin');

// The function that will be called when the plugin is loaded
function pagelayer_load_plugin(){

	global $pagelayer;

	// Check if the installed version is outdated
	pagelayer_update_check();

	// Set the array
	$pagelayer = new PageLayer();
	
	// Load license
	pagelayer_load_license();

	// Is there any ACTION set ?
	$pagelayer->action = pagelayer_optreq('pagelayer-action');

	// Load settings 
	$options = get_option('pagelayer_options');
	$pagelayer->settings['post_types'] = empty(get_option('pl_support_ept')) ? ['post', 'page'] : get_option('pl_support_ept');
	$pagelayer->settings['max_width'] = (int) (empty(get_option('pagelayer_content_width')) ? 1170 : get_option('pagelayer_content_width'));
	$pagelayer->settings['tablet_breakpoint'] = (int) (empty(get_option('pagelayer_tablet_breakpoint')) ? 768 : get_option('pagelayer_tablet_breakpoint'));
	$pagelayer->settings['mobile_breakpoint'] = (int) (empty(get_option('pagelayer_mobile_breakpoint')) ? 360 : get_option('pagelayer_mobile_breakpoint'));
	
	// Load the language
	load_plugin_textdomain('pagelayer', false, PAGELAYER_SLUG.'/languages/');

	// Its premium
	if(defined('PAGELAYER_PREMIUM')){
	
		// Check for updates
		include_once(PAGELAYER_DIR.'/main/plugin-update-checker.php');
		$pagelayer_updater = Pagelayer_PucFactory::buildUpdateChecker(PAGELAYER_API.'updates.php?version='.PAGELAYER_VERSION, PAGELAYER_FILE);
		
		// Add the license key to query arguments
		$pagelayer_updater->addQueryArgFilter('pagelayer_updater_filter_args');
		
		// Show the text to install the license key
		add_filter('puc_manual_final_check_link-pagelayer-pro', 'pagelayer_updater_check_link', 10, 1);
		
		// Load the template builder
		include_once(PAGELAYER_DIR.'/main/template-builder.php');
		
	}else{
	
		// Show the promo
		pagelayer_maybe_promo([
			'after' => 1,// In days
			'interval' => 30,// In days
			'pro_url' => PAGELAYER_PRO_URL,
			'rating' => 'https://wordpress.org/plugins/pagelayer/#reviews',
			'twitter' => 'https://twitter.com/pagelayer?status='.rawurlencode('I love #Pagelayer Site Builder by @pagelayer team for my #WordPress site - '.home_url()),
			'facebook' => 'https://www.facebook.com/pagelayer',
			'website' => PAGELAYER_WWW_URL,
			'image' => PAGELAYER_URL.'/images/pagelayer-logo-256.png'
		]);
	
	}

}

// Add our license key if ANY
function pagelayer_updater_filter_args($queryArgs) {
	
	global $pagelayer;
	
	if ( !empty($pagelayer->license['license']) ) {
		$queryArgs['license'] = $pagelayer->license['license'];
	}
	
	return $queryArgs;
}

// Handle the Check for update link and ask to install license key
function pagelayer_updater_check_link($final_link){
	
	global $pagelayer;
	
	if(empty($pagelayer->license['license'])){
		return '<a href="'.admin_url('admin.php?page=pagelayer_license').'">Install Pagelayer Pro License Key</a>';
	}
	
	return $final_link;
}

// This adds the left menu in WordPress Admin page
add_action('admin_menu', 'pagelayer_admin_menu', 5);

// Shows the admin menu of Pagelayer
function pagelayer_admin_menu() {

	global $wp_version, $pagelayer;

	$capability = 'activate_plugins';// TODO : Capability for accessing this page

	// Add the menu page
	add_menu_page(__('Pagelayer Editor'), __('Pagelayer'), $capability, 'pagelayer', 'pagelayer_page_handler', PAGELAYER_URL.'/images/pagelayer-logo-19.png');

	// Settings Page
	add_submenu_page('pagelayer', __('Pagelayer Editor'), __('Settings'), $capability, 'pagelayer', 'pagelayer_page_handler');

	// Its premium
	if(defined('PAGELAYER_PREMIUM')){

		// Fonts link
		add_submenu_page('pagelayer', __('Font Settings'), __('Font Settings'), $capability, 'admin.php?page=pagelayer#settings');

		// Add new template
		add_submenu_page('pagelayer', __('Theme Templates'), __('Theme Templates'), $capability, 'edit.php?post_type=pagelayer-template');

		// Add new template Link
		//add_submenu_page('pagelayer', __('Add New Template'), __('Add New Template'), $capability, 'edit.php?post_type=pagelayer-template#new');

		// Add new template
		add_submenu_page('pagelayer', __('Add New Template'), __('Add New Template'), $capability, 'pagelayer_template_wizard', 'pagelayer_builder_template_wizard');

		// Export Template Wizard
		add_submenu_page('pagelayer', __('Export Templates into a Theme'), __('Export Templates'), $capability, 'pagelayer_template_export', 'pagelayer_builder_export');

	// Its free
	}else{

		// Go Pro link
		add_submenu_page('pagelayer', __('Pagelayer Go Pro'), __('Go Pro'), $capability, PAGELAYER_PRO_URL);

	}

	// Import Page
	add_submenu_page('pagelayer', __('Import a Theme and its Templates'), __('Import Theme'), $capability, 'pagelayer_import', 'pagelayer_import_page');

	// License Page
	add_submenu_page('pagelayer', __('Pagelayer Editor'), __('License'), $capability, 'pagelayer_license', 'pagelayer_license_page');

}

// This function will handle the Settings Pages in PageLayer
function pagelayer_page_handler(){

	global $wp_version, $pagelayer;
	
	wp_enqueue_script( 'pagelayer-admin', PAGELAYER_JS.'/pagelayer-admin.js', array('jquery'), PAGELAYER_VERSION);
	wp_enqueue_style( 'pagelayer-admin', PAGELAYER_CSS.'/pagelayer-admin.css', array(), PAGELAYER_VERSION);

	include_once(PAGELAYER_DIR.'/main/settings.php');
	
	pagelayer_settings_page();

}

// This function will handle the Settings Pages in PageLayer
function pagelayer_license_page(){

	global $wp_version, $pagelayer;

	include_once(PAGELAYER_DIR.'/main/license.php');
	
	pagelayer_license();

}

// Import Pagelayer Templates
function pagelayer_import_page(){

	global $wp_version, $pagelayer;

	include_once(PAGELAYER_DIR.'/main/import.php');
	
	pagelayer_import();

}

// Load the Live Body
add_action('template_redirect', 'pagelayer_load_live_body', 4);

function pagelayer_load_live_body(){

	global $post;

	// If its not live editing then stop
	if(!pagelayer_is_live()){
		return;
	}

	// If its the iFRAME then return
	if(pagelayer_is_live_iframe()){
		return;
	}

	// Are you allowed to edit ?
	if(!pagelayer_user_can_edit($post->ID)){
		return;
	}

	// Load the editor live body
	include_once(PAGELAYER_DIR.'/main/live-body.php');

	pagelayer_live_body();

}

// Add the JS and CSS for Posts and Pages when being viewed ONLY if there is our content called
add_action('template_redirect', 'pagelayer_enqueue_frontend', 5);

function pagelayer_enqueue_frontend($force = false){

	global $post, $pagelayer;

	if(!empty($pagelayer->cache['enqueue_frontend'])){
		return;
	}

	if(empty($post->ID) && empty($force)){
		return;
	}
	
	$is_pagelayer = false;
	$is_audio = false;
	
	// This IF is for Archives mainly as $post->ID is only the first post in the archive 
	// and we need to make sure that other posts are pagelayer or not
	if(!empty($GLOBALS['wp_query']->posts) && is_array($GLOBALS['wp_query']->posts)){
		foreach($GLOBALS['wp_query']->posts as $v){
			if(get_post_meta($v->ID , 'pagelayer-data')){
				$is_pagelayer = true;
			}
			
			if(preg_match('/\[pl_audio/is', $v->post_content)){
				$is_audio = true;
			}
		}
	}

	// Enqueue the FRONTEND CSS
	if(get_post_meta($post->ID , 'pagelayer-data') || $is_pagelayer || $force){

		// We dont need the auto <p> and <br> as they interfere with us
		remove_filter('the_content', 'wpautop');
		
		// No need to add curly codes to the content
		remove_filter('the_content', 'wptexturize');

		pagelayer_load_shortcodes();
		$pagelayer->cache['enqueue_frontend'] = true;
		
		// Load the global styles
		add_action('wp_head', 'pagelayer_global_js', 2);
		
		$premium_js = '';
		$premium_css = '';
		if(defined('PAGELAYER_PREMIUM')){
			$premium_js = ',chart.min.js,slick.min.js,premium-frontend.js,shuffle.min.js';
			$premium_css = ',slick.css,slick-theme.css,premium-frontend.css';
			
			// Load this For audio widget
			if($is_audio || pagelayer_is_live_iframe()){
				wp_enqueue_script('wp-mediaelement');
				wp_enqueue_style( 'wp-mediaelement' );
			}
		}
				
		// Enqueue our Editor's Frontend JS
		wp_register_script('pagelayer-frontend', PAGELAYER_JS.'/givejs.php?give=pagelayer-frontend.js,nivo-lightbox.min.js,wow.min.js,jquery-numerator.js,simpleParallax.min.js,owl.carousel.min.js'.$premium_js, array('jquery'), PAGELAYER_VERSION);
		wp_enqueue_script('pagelayer-frontend');

		wp_register_style('pagelayer-frontend', PAGELAYER_CSS.'/givecss.php?give=pagelayer-frontend.css,nivo-lightbox.css,animate.min.css,owl.carousel.min.css,owl.theme.default.min.css'.$premium_css, array(), PAGELAYER_VERSION);
		wp_enqueue_style('pagelayer-frontend');
		
		// Get list of enabled icons
		$icons = pagelayer_enabled_icons();
		foreach($icons as $icon){
			wp_register_style($icon, PAGELAYER_CSS.'/givecss.php?give='.$icon.'.min.css', array(), PAGELAYER_VERSION);
			wp_enqueue_style($icon);
		}
		
		// Load the global styles
		add_action('wp_head', 'pagelayer_global_styles', 5);
		
		// Load custom widgets
		do_action('pagelayer_custom_frontend_enqueue');

	}

}

// Load the google fonts
add_action('wp_footer', 'pagelayer_enqueue_fonts', 5);

function pagelayer_enqueue_fonts(){
	global $pagelayer;

	if(empty($pagelayer->cache['enqueue_frontend'])){
		return;
	}
	
	$url = 'Open Sans:300italic,400italic,600italic,300,400,600&subset=latin,latin-ext';
	//pagelayer_print($pagelayer->runtime_fonts);die('alpesh');
		
	foreach($pagelayer->runtime_fonts as $font){
		$url .= '|'.$font.':100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';
	}
	
	// Fetch body font if given
	if(get_option('pagelayer_body_font')){
		$url .= '|'.get_option('pagelayer_body_font').':100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';
	}
	
	//echo '<link href="https://fonts.googleapis.com/css?family='.$url.'" rel="stylesheet">';
	
	wp_register_style('pagelayer-google-font', 'https://fonts.googleapis.com/css?family='.rawurlencode($url), array(), PAGELAYER_VERSION);
	wp_enqueue_style('pagelayer-google-font');
	
}

// Load any header we have
function pagelayer_global_js(){
	global $pagelayer;

	echo '<script>
var pagelayer_ajaxurl = "'.admin_url( 'admin-ajax.php' ).'?";
var pagelayer_global_nonce = "'.wp_create_nonce('pagelayer_global').'";
var pagelayer_server_time = '.time().';
var pagelayer_facebook_id = "'.get_option('pagelayer-fbapp-id').'";
var pagelayer_settings = '.json_encode($pagelayer->settings).';
</script>';

}

// We need to handle global styles
function pagelayer_global_styles(){
	
	global $pagelayer;
	
	$styles = '<style id="pagelayer-global-styles" type="text/css">';
	
	// Style for only child row holder
	$styles .= '.pagelayer-row-stretch-auto > .pagelayer-row-holder, .pagelayer-row-stretch-full > .pagelayer-row-holder.pagelayer-width-auto{ max-width: '.$pagelayer->settings['max_width'].'px; margin-left: auto; margin-right: auto;}';
	
	if(get_option('pagelayer_body_font')){
		$styles .= 'body *{font-family:'.get_option("pagelayer_body_font").';}';
	}
	
	$styles .= '</style>';
	
	echo $styles;
}

// Load the live editor if needed
add_action('wp_enqueue_scripts', 'pagelayer_load_live', 9999);

function pagelayer_load_live(){

	global $post;

	// If its not live editing then stop
	if(!pagelayer_is_live_iframe()){
		return;
	}

	// Are you allowed to edit ?
	if(!pagelayer_user_can_edit($post->ID)){
		return;
	}

	// Load the editor class
	include_once(PAGELAYER_DIR.'/main/live.php');

	// Call the constructor
	$pl_editor = new PageLayer_LiveEditor();

}

// If we are doing ajax and its a pagelayer ajax
if(wp_doing_ajax()){	
	include_once(PAGELAYER_DIR.'/main/ajax.php');
}

// Show the backend editor options
add_action('edit_form_after_title', 'pagelayer_after_title', 10);
function pagelayer_after_title(){

	global $post;
	
	// Get the current screen
	$current_screen = get_current_screen();
	
	// For gutenberg
	if(method_exists($current_screen, 'is_block_editor') && $current_screen->is_block_editor()){

		// Add the code in the footer
		add_action('admin_footer', 'pagelayer_gutenberg_after_title');
		
		return;
	}
	
	$link = pagelayer_shortlink($post->ID).'&pagelayer-live=1';

	echo '
<div id="pagelayer-editor-button-row" style="margin-top:15px; display:inline-block;">
	<a id="pagelayer-editor-button" href="'.$link.'" class="button button-primary button-large" style="height:auto; padding:6px; font-size:18px;">
		<img src="'.PAGELAYER_URL.'/images/pagelayer-logo-40.png" align="top" width="24" /> <span>'.__('Edit with Pagelayer').'</span>
	</a>
</div>';

}

function pagelayer_gutenberg_after_title(){

	global $post;
	
	$link = pagelayer_shortlink($post->ID).'&pagelayer-live=1';

	echo '
<div id="pagelayer-editor-button-row" style="margin-left:15px; display:none">
	<a id="pagelayer-editor-button" href="'.$link.'" class="button button-primary button-large" style="height:auto; padding:6px; font-size:18px;">
		<img src="'.PAGELAYER_URL.'/images/pagelayer-logo-40.png" align="top" width="24" /> <span>'.__('Edit with Pagelayer').'</span>
	</a>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	
	var pagelayer_timer;
	var pagelayer_button = function(){
		var button = jQuery("#pagelayer-editor-button-row");
		var g = jQuery(".edit-post-header-toolbar");
		if(g.length < 1){
			return;
		}
		button.detach();
		//console.log(button);
		g.append(button);
		button.show();
		clearInterval(pagelayer_timer);
	}
	pagelayer_timer = setInterval(pagelayer_button, 100);
});
</script>';
	
}

// Handle Old Slug URL redirect for live link
add_filter( 'old_slug_redirect_url', 'pagelayer_old_slug_redirect', 10, 1);
function pagelayer_old_slug_redirect($link){
	
	if(pagelayer_optreq('pagelayer-live')){
		$link = add_query_arg('pagelayer-live', '1', $link);
	}
	
	return $link;
}

add_filter( 'post_row_actions', 'pagelayer_quick_link', 10, 2 );
add_filter( 'page_row_actions', 'pagelayer_quick_link', 10, 2 );
function pagelayer_quick_link($actions, $post){
	$link = pagelayer_shortlink($post->ID).'&pagelayer-live=1';

	$actions['pagelayer'] = '<a href="'.esc_url( $link ).'">'.__( 'Edit using Pagelayer', 'pagelayer') .'</a>';

	return $actions;
}

// Add settings link on plugin page
add_filter('plugin_action_links_pagelayer/pagelayer.php', 'pagelayer_plugin_action_links');
function pagelayer_plugin_action_links($links){
	
	if(!defined('PAGELAYER_PREMIUM')){
		 $links[] = '<a href="'.PAGELAYER_PRO_URL.'" style="color:#3db634;" target="_blank">'._x('Go Pro', 'Upgrade to Pagelayer Pro for many more features', 'pagelayer').'</a>';
	}

	$settings_link = '<a href="admin.php?page=pagelayer">Settings</a>';	
	array_unshift($links, $settings_link); 
	
	return $links;
}

// Add custom header
add_action('wp_head', 'pagelayer_add_custom_head');
function pagelayer_add_custom_head(){
	global $post;
	
	$global_code = wp_unslash( get_option('pagelayer_header_code') );

	if(!empty($post)){
		$header_code = get_post_meta($post->ID , 'pagelayer_header_code', true);
	}
	
	if(!empty($global_code)){
		echo $global_code."\n";
	}
	
	if(!empty($header_code)){
		echo $header_code."\n";
	}
		
}

// Add custom footer
add_action('wp_footer', 'pagelayer_add_custom_footer');
function pagelayer_add_custom_footer(){
	global $post;
		
	$global_code = wp_unslash( get_option('pagelayer_footer_code') );
	
	if(!empty($post)){
		$footer_code = get_post_meta($post->ID , 'pagelayer_footer_code', true);
	}
	
	if(!empty($global_code)){
		echo $global_code."\n";
	}
	
	if(!empty($footer_code)){
		echo $footer_code."\n";
	}
	
}

// Pagelayer Template Loading Mechanism
include_once(PAGELAYER_DIR.'/main/template.php');