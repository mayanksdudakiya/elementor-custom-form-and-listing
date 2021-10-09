<?php 

/*@ Enqueue styles & scripts */
if( !function_exists('scratchcode_enqueue_style_and_scripts') ):

	function scratchcode_enqueue_style_and_scripts(){

		wp_enqueue_style('general_css', 
			get_stylesheet_directory_uri() . '/assets/css/general.css', 
			array(),
			'8.0.0',
			'all' 
		);

		wp_enqueue_style('PNotifyCss', 
			get_stylesheet_directory_uri() . '/assets/lib/pnotify/PNotifyBrightTheme.css', 
			array(),
			'1.0.0',
			'all' 
		);

		wp_enqueue_style('select2Css', 
			get_stylesheet_directory_uri() . '/assets/lib/select2/select2.min.css', 
			array(),
			'1.0.0',
			'all' 
		);

		wp_enqueue_script(
			'jquery_validate',
			get_stylesheet_directory_uri() . '/assets/lib/jquery-validate/jquery.validate.min.js',
			array('jquery'),
			'1.0.0',
			true
		);

		wp_enqueue_script(
			'additional_jquery_validate',
			get_stylesheet_directory_uri() . '/assets/lib/jquery-validate/additional-methods.min.js',
			array('jquery'),
			'1.0.0',
			true
		);

		wp_enqueue_script(
			'pnotify',
			get_stylesheet_directory_uri() . '/assets/lib/pnotify/PNotify.js',
			array('jquery'),
			'1.0.0',
			true
		);

		wp_enqueue_script(
			'pnotifyButton',
			get_stylesheet_directory_uri() . '/assets/lib/pnotify/PNotifyButtons.js',
			array('jquery'),
			'1.0.0',
			true
		);

		wp_enqueue_script(
			'select2',
			get_stylesheet_directory_uri() . '/assets/lib/select2/select2.min.js',
			array('jquery'),
			'1.0.0',
			true
		);
				
		wp_enqueue_script( 
			'general_js', 
			get_stylesheet_directory_uri() . '/assets/js/general.js',
			array('jquery'),
			'1.0.0',
			true 
		);

		$frontendconfig = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'is_user_logged_in' => is_user_logged_in(),
		);
		wp_localize_script( 'general_js', 'scratchcodeFrontendConfig', $frontendconfig );
	}
	add_action('wp_enqueue_scripts', 'scratchcode_enqueue_style_and_scripts');

endif;

/*@ Add anything into footer */
add_action('wp_footer', 'scratchcode_add_content_footer'); 
function scratchcode_add_content_footer() { 
    $loader = '<div id="loading" style="display:none;"></div>';
	echo $loader;
}

/*@ Mail function */
if( !function_exists('scratchcode_mail') ):

	function scratchcode_mail($from, $to, $subject, $template){

		$headers[] = 'From: '. $from . "\r\n";
		$headers[] ='Reply-To: ' . $from . "\r\n";
		$headers[] = 'Content-Type: text/html; charset=UTF-8';

		$is_mail_sent = wp_mail($to, $subject, $template, $headers);
	}

endif;

/*@ Get post type */
function scratchcode_er_get_post_types($update_arg){

	$args = [
		'post_status' => 'publish',
		'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
	];

    $args = array_merge($args, $update_arg);

	return get_posts($args);
}

/*@ Include files */
include_once("includes/business-registration.php");
include_once("includes/business-portal.php");

/*@ Add setting page into WordPress */
add_action('acf/init', 'scratchcode_my_acf_op_init');
function scratchcode_my_acf_op_init() {

    // Check function exists.
    if( function_exists('acf_add_options_page') ) {

        // Register options page.
        acf_add_options_page(array(
			'page_title' 	=> 'Settings',
			'menu_title'	=> 'Theme Settings',
			'menu_slug' 	=> 'scratchcode-theme-general-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false
		));	
    } 
}
