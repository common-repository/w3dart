<?php
/**
 * Plugin Name:       W3Dart
 * Plugin URI:        https://w3dart.com/
 * Description:       Visual Feddback tool for Wordpress Websits to collect bugs 
 * Version:           1.0.0
 * Requires at least: 3.5.0
 * Author:            W3Dart
 */

define('W3DART_VERSION', '1.0');
$plugin_dir = str_replace('/w3dart.php', '', plugin_basename( __FILE__ ));
define('W3DART_PLUGIN_URL', $plugin_dir);
define('ADMIN_DIR_W3DART',   'admin');

if(!function_exists('w3dart_add_menu')){
	function w3dart_add_menu() {
		add_menu_page('W3Dart', 'W3Dart', 'manage_options', 'W3Dart', 'w3dart_print_overview', plugins_url(W3DART_PLUGIN_URL . '/assets/icon.png'));
	}
	add_action('admin_menu','w3dart_add_menu');
}

if(!function_exists('w3dart_print_overview')){
	function w3dart_print_overview() {
		if (!current_user_can('administrator'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		$options = get_option('w3dart_options');
		?>
		<div class="wrap">
			<div class="w3dart_title">
				<h2 class="us-headline"><?php _e("W3Dart Settings","w3dart");?></h2>
			</div>
		
			<?php
			require_once(ADMIN_DIR_W3DART . '/settings.php');
			?>
		</div>
		<?php
	}
}

if(!function_exists('w3dart_register_settings')){
	function w3dart_register_settings() {
		register_setting( 'w3dart_options', 'w3dart_options');
	}
	add_action( 'admin_init', 'w3dart_register_settings' );
}


// include JS / CSS files
if(!function_exists('w3dart_include_admin_script')){
	function w3dart_include_admin_script($hook) {
		wp_enqueue_script('w3dart-admin-js',  plugins_url(W3DART_PLUGIN_URL . '/js/admin.js'));
		wp_enqueue_style('w3dart-admin-css',  plugins_url(W3DART_PLUGIN_URL . '/css/admin.css'));
	}
	add_action('admin_enqueue_scripts', 'w3dart_include_admin_script');
}

if(!function_exists('w3dart_add_code_in_footer')){
	function w3dart_add_code_in_footer() {
		$w3dart_options = get_option('w3dart_options');
		
		$w3dart_code_display = false;
		if (isset($w3dart_options['w3dart_script_code'])) {
			$w3dart_script_code = $w3dart_options['w3dart_script_code'];
			if (isset($w3dart_options['visible-for'])) 
			{
				$VisibleFor = $w3dart_options['visible-for'];
				if($VisibleFor == 'all')
				{
					$w3dart_code_display = true;
				}
				else if($VisibleFor == 'users')
				{
					if(is_user_logged_in())
					{
						$w3dart_code_display = true;
					}
				}
				else if($VisibleFor == 'roles')
				{
					if(is_user_logged_in())
					{
						$w3user = new WP_User(get_current_user_id());
						if (!empty($w3user->roles) && is_array($w3user->roles)) {
							foreach($w3user->roles as $role ) {
								if ($w3dart_code_display) {
									break;
								}
								foreach($w3dart_options['visible-for-roles'] as $chrole) {
									if ($chrole == $role) {
										$w3dart_code_display = true;
									}
								}
							}
						}
					}
				}
			}
			if($w3dart_code_display)
			{
				$allowed_html = array(
					'script'      => array(
						'src'  => array(),
						'defer' => array(),
						
					),
					'async' => array(),
				);
				echo wp_kses($w3dart_script_code,$allowed_html);
			}
		}
	}
	add_action( 'wp_footer', 'w3dart_add_code_in_footer',99 );
}

if(!function_exists('w3dart_admin_footer_code')){
	function w3dart_admin_footer_code()
	{
		$w3dart_options = get_option('w3dart_options');	
		if (isset($w3dart_options['w3dart_script_code'])) {
			if (isset($w3dart_options['visible-for-backend']))
			{
				$w3dart_script_code = $w3dart_options['w3dart_script_code'];
				$allowed_html = array(
					'script'      => array(
						'src'  => array(),
						'defer' => array(),
						
					),
					'async' => array(),
				);
				echo wp_kses($w3dart_script_code,$allowed_html);
			}
		}
	}
	add_action('admin_footer', 'w3dart_admin_footer_code');
}