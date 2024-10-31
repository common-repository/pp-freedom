<?php defined( 'ABSPATH' ) || exit;
function ppfrdm_admin_init() {
	$ppfrdm_post_types = get_post_types(array(
	'public'   => true,
	'_builtin' => false
	), 'names', 'and');
	array_unshift($ppfrdm_post_types,"post");
	$GLOBALS['ppfrdm_post_types'] = $ppfrdm_post_types;
	$GLOBALS['ppfrdm_post_taxonomies'] = get_object_taxonomies( 'post');
}
add_action( 'admin_init', 'ppfrdm_admin_init' );

function ppfrdm_admin(){
	global $wpdb;
	$ppfrdm_publish = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix . "ppfrdm_publish ORDER BY id ASC");
	$GLOBALS['ppfrdm_widgets_pub'] = $ppfrdm_publish;
	$ppfrdm_pull = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix . "ppfrdm_pull ORDER BY id ASC");
	$GLOBALS['ppfrdm_widgets_pul'] = $ppfrdm_pull;
	$file = ppfrdm_PLUGIN_DIR . 'views/admin/ppfrdm_dashboard.php';
	require_once( $file );
}