<?php defined( 'ABSPATH' ) || exit;
function ppfrdm_shortcode_local($atts = array(), $content = null, $tag = ''){
	$response = wp_remote_request(ppfrdm_get_frdm_url(get_site_url(),1,$atts['id'],0));
	if($response['response']['code'] == 200){
		$response_body = json_decode($response['body']);
		if($response_body->ppfrdm_response == 'success'){
			_e($response_body->ppfrdm_body);
		}
	}
}
add_shortcode('ppfrdm_local', 'ppfrdm_shortcode_local');

function ppfrdm_shortcode_global($atts = array(), $content = null, $tag = '') { 
	$check_domain = ppfrdm_filter_domain($atts['site']);
	if(isset($atts['pkey'])){
		$extra_atts = array('pkey'=>$atts['pkey']);
	}else{
		$extra_atts = false;
	}
	$response = wp_remote_request(ppfrdm_get_frdm_url($check_domain,1,$atts['id'],0,$extra_atts));
	if($response['response']['code'] == 200){
		$response_body = json_decode($response['body']);
		if($response_body->ppfrdm_response == 'success'){
			_e($response_body->ppfrdm_body);
		}
	}
}
add_shortcode('ppfrdm_global', 'ppfrdm_shortcode_global');

function ppfrdm_shortcode_pull($atts = array(), $content = null, $tag = '') {
	global $wpdb;
	$row = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix . "ppfrdm_pull WHERE id = '".$atts['id']."'");
	$this_options = unserialize($row->options);
	$check_domain = ppfrdm_filter_domain($this_options['ppfrdm_pul_wid_domain']);
	$response = wp_remote_request(ppfrdm_get_frdm_url($check_domain,2,$this_options['ppfrdm_pul_widet'],0,array('pkey'=>$this_options['ppfrdm_pul_wid_pkey'])));
	if($response['response']['code'] == 200){
		$response_body = json_decode($response['body'], true);
		if($response_body['ppfrdm_response'] == 'success'){
			$options = $response_body['ppfrdm_body']['options'];
			$collector = $response_body['ppfrdm_body']['collector'];
			$args = $response_body['ppfrdm_body']['args'];

			$options['ppfrdm_pub_wid_theme'] = $this_options['ppfrdm_pul_wid_theme'];
			$options['ppfrdm_pub_wid_bgclr'] = $this_options['ppfrdm_pul_wid_bgclr'];
			$options['ppfrdm_pub_wid_prclr'] = $this_options['ppfrdm_pul_wid_prclr'];
			$options['ppfrdm_pub_wid_scclr'] = $this_options['ppfrdm_pul_wid_scclr'];
			$options['ppfrdm_pub_wid_ttclr'] = $this_options['ppfrdm_pul_wid_ttclr'];
			$options['ppfrdm_pub_wid_title'] = $this_options['ppfrdm_pul_wid_title'];
			$options['ppfrdm_widget_frdm_URL_'] = $options['ppfrdm_widget_frdm_URL'];
			$options['ppfrdm_widget_frdm_URL'] = get_site_url();
			$options['ppfrdm_widget_frdm_PULID'] = $atts['id'];
			$options['ppfrdm_widget_frdm_FRDM'] = mt_rand(1111,9999);
			$options['ppfrdm_widget_frdm_PKEY'] = $this_options['ppfrdm_pul_wid_pkey'];

			$wid_theme = $options['ppfrdm_pub_wid_theme'];
			$theme_function = 'ppfrdm_draw_'.$wid_theme;
		    if(function_exists($theme_function)) {
			  	$return = $theme_function($options, $collector, $args);
			}else{
				$return = '';
			}
			_e($return);
		}
	}
}
add_shortcode('ppfrdm_pull', 'ppfrdm_shortcode_pull');

