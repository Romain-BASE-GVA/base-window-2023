<?php
// // Définition du textdomain
load_theme_textdomain( 'base_window_' );

// Gestion du <title> par WP
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );

// Autoriser les fichiers SVG
function wpc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'wpc_mime_types');

// ACF - Activation des Options Page
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Theme options',
		'menu_title'	=> 'Theme options',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

function prefix_reset_metabox_positions(){
	delete_user_meta( wp_get_current_user()->ID, 'meta-box-order_post' );
	delete_user_meta( wp_get_current_user()->ID, 'meta-box-order_page' );
	delete_user_meta( wp_get_current_user()->ID, 'meta-box-order_custom_post_type' );
}
add_action( 'admin_init', 'prefix_reset_metabox_positions' );

function base_window_font_correct_filetypes( $data, $file, $filename, $mimes, $real_mime ) {

	if ( ! empty( $data['ext'] ) && ! empty( $data['type'] ) ) {
	return $data;
	}
	
	$wp_file_type = wp_check_filetype( $filename, $mimes );
	
	// Check for the file type you want to enable, e.g. 'svg'.
	if ( 'ttf' === $wp_file_type['ext'] ) {
	$data['ext'] = 'ttf';
	$data['type'] = 'font/ttf';
	}
	
	if ( 'otf' === $wp_file_type['ext'] ) {
	$data['ext'] = 'otf';
	$data['type'] = 'font/otf';
	}
	
	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'base_window_font_correct_filetypes', 10, 5 );

function base_window_add_custom_upload_mimes( $mime_types ) {

	$mime_types['otf']   = 'application/x-font-otf';
	$mime_types['woff']  = 'application/x-font-woff';
	$mime_types['woff2'] = 'application/x-font-woff2';
	$mime_types['ttf']   = 'application/x-font-ttf';
	$mime_types['svg']   = 'image/svg+xml';
	$mime_types['eot']   = 'application/vnd.ms-fontobject';

	return $mime_types;

}
add_filter( 'upload_mimes', 'base_window_add_custom_upload_mimes', 0 );
