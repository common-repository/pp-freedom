<?php defined( 'ABSPATH' ) || exit;
if(isset($_GET['frdm_pull'])){
	global $wpdb;

	$sanitized_site = sanitize_text_field($_GET['site']);
	$sanitized_get_widget = sanitize_text_field($_GET['get_widget']);
	$sanitized_id = sanitize_text_field($_GET['id']);
	$sanitized_offset = sanitize_text_field($_GET['offset']);
	$sanitized_pkey = sanitize_text_field($_GET['pkey']);
	$sanitized_pulid = sanitize_text_field($_GET['pulid']);
	$sanitized_first_rndm = sanitize_text_field($_GET['first_rndm']);
	$check_domain = ppfrdm_filter_domain(urldecode($sanitized_site));
	$response = wp_remote_request(ppfrdm_get_frdm_url($check_domain,$sanitized_get_widget,$sanitized_id,$sanitized_offset,array('pkey'=>$sanitized_pkey)));
	if($response['response']['code'] == 200){
		$response_body = json_decode($response['body'], true);
		if($response_body['ppfrdm_response'] == 'success'){
			$options = $response_body['ppfrdm_body']['options'];
			$collector = $response_body['ppfrdm_body']['collector'];
			$args = $response_body['ppfrdm_body']['args'];

			$row = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix . "ppfrdm_pull WHERE id = '".$sanitized_pulid."'");
			$this_options = unserialize($row->options);

			$options['ppfrdm_pub_wid_theme'] = $this_options['ppfrdm_pul_wid_theme'];
			$options['ppfrdm_pub_wid_bgclr'] = $this_options['ppfrdm_pul_wid_bgclr'];
			$options['ppfrdm_pub_wid_prclr'] = $this_options['ppfrdm_pul_wid_prclr'];
			$options['ppfrdm_pub_wid_scclr'] = $this_options['ppfrdm_pul_wid_scclr'];
			$options['ppfrdm_pub_wid_ttclr'] = $this_options['ppfrdm_pul_wid_ttclr'];
			$options['ppfrdm_pub_wid_title'] = $this_options['ppfrdm_pul_wid_title'];
			$options['ppfrdm_widget_frdm_URL_'] = $sanitized_site;
			$options['ppfrdm_widget_frdm_URL'] = get_site_url();
			$options['ppfrdm_widget_frdm_PULID'] = $sanitized_pulid;
			$options['ppfrdm_widget_frdm_FRDM'] = $sanitized_first_rndm;
			
			$wid_theme = $options['ppfrdm_pub_wid_theme'];
			$theme_function = 'ppfrdm_draw_'.$wid_theme;
		    if(function_exists($theme_function)) {
			  	$get_allowd_widget = $theme_function($options, $collector, $args);
			}else{
				$get_allowd_widget = '';
			}
		}
	}

	if(!empty($get_allowd_widget)){
		header('Content-Type: application/json');
		echo json_encode(array('ppfrdm_response'=>'success','ppfrdm_body'=>$get_allowd_widget));
	}else{
		header('Content-Type: application/json');
		echo json_encode(array('ppfrdm_response'=>'error','ppfrdm_body'=>''));
	}
}elseif(isset($_GET['get_widgets'])){
	$get_allowd_widgets = ppfrdm_check_get_widgets();
	if(!empty($get_allowd_widgets)){
		header('Content-Type: application/json');
		echo json_encode(array('ppfrdm_response'=>'success','ppfrdm_body'=>$get_allowd_widgets));
	}else{
		header('Content-Type: application/json');
		echo json_encode(array('ppfrdm_response'=>'error','ppfrdm_body'=>''));
	}
}elseif(isset($_GET['get_widget']) && isset($_GET['id'])){
	$sanitized_id = sanitize_text_field($_GET['id']);
	$get_allowd_widget = ppfrdm_check_get_widget($sanitized_id);
	if(!empty($get_allowd_widget)){
		header('Content-Type: application/json');
		echo json_encode(array('ppfrdm_response'=>'success','ppfrdm_body'=>$get_allowd_widget));
	}else{
		header('Content-Type: application/json');
		echo json_encode(array('ppfrdm_response'=>'error','ppfrdm_body'=>''));
	}
}else{ //executes if anyone openn it directly
	include plugin_dir_path( __FILE__ ) . 'views/public/ppfrdm-view-public.php';
}

//code to get widgets
function ppfrdm_check_get_widgets(){
	global $wpdb;
	$ppfrdm_publish = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix . "ppfrdm_publish ORDER BY id ASC");
	$return_widgets = [];
	if($ppfrdm_publish){
		foreach($ppfrdm_publish as $key=>$row){
			$this_options = unserialize($row->options);
			if($this_options['ppfrdm_pub_wid_type'] == 'global'){
				if($this_options['ppfrdm_pub_wid_scope'] == 'public'){
					$row->options = unserialize($row->options);
					$return_widgets[] = $row;
				}elseif($this_options['ppfrdm_pub_wid_scope'] == 'private'){
					if ($this_options['ppfrdm_pub_wid_pkey'] == $_GET['pkey']) {
						$row->options = unserialize($row->options);
						$return_widgets[] = $row;
					}
				}
			}
		}
	}
	return $return_widgets;
}

//code to get widget frontend
function ppfrdm_check_get_widget($id){
	global $wpdb;
	$row = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix . "ppfrdm_publish WHERE id = '".$id."'");
	$return_widget = '';
	if($row){
		$this_options = unserialize($row->options);
		if($this_options['ppfrdm_pub_wid_type'] == 'global'){
			if($this_options['ppfrdm_pub_wid_scope'] == 'public'){
				$return_widget = ppfrdm_draw_widget($this_options,$_GET);
			}elseif($this_options['ppfrdm_pub_wid_scope'] == 'private'){
				if ($this_options['ppfrdm_pub_wid_pkey'] == $_GET['pkey']) {
					$return_widget = ppfrdm_draw_widget($this_options,$_GET);
				}
			}
		}elseif($this_options['ppfrdm_pub_wid_type'] == 'local'){
			$get_requested_domain = ppfrdm_get_domain($_SERVER['HTTP_USER_AGENT']);
			return $_SERVER['USER_AGENT'];
			$get_this_domain = $_SERVER['SERVER_NAME'];
			if($get_this_domain == $get_requested_domain){
				$return_widget = ppfrdm_draw_widget($this_options,$_GET);
			}
		}
	}
	return $return_widget;
}