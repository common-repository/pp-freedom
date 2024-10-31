<?php defined( 'ABSPATH' ) || exit;
add_action('admin_enqueue_scripts', 'ppfrdm_disable_other_notices');
add_action('login_enqueue_scripts', 'ppfrdm_disable_other_notices');
function ppfrdm_disable_other_notices() {
	echo '<style>.update-nag, .updated, .error, .is-dismissible, .notice { display: none !important; }</style>';
}
add_action('admin_notices', 'ppfrdm_admin_notice');
function ppfrdm_admin_notice(){
    if (isset($_GET['noti'])) {
    	$sanitized_noti = sanitize_text_field($_GET['noti']);
    	if($sanitized_noti == 1){
			echo '<div class="ppfrdm_noti notice notice-success is-dismissible" style="display:block !important;"><p>'.esc_html__("Widget Successfully Added!").'</p></div>';
		}elseif($sanitized_noti == 2){
			echo '<div class="ppfrdm_noti notice notice-info is-dismissible" style="display:block !important;"><p>'.esc_html__("Widget Successfully Updated!", "ppfrdm").'</p></div>';
		}elseif($sanitized_noti == 3){
			echo '<div class="ppfrdm_noti notice notice-error is-dismissible" style="display:block !important;"><p>'.esc_html__("Widget Successfully Deleted!", "ppfrdm").'</p></div>';
		}else{
			if($sanitized_noti != ''){
				echo '<div class="ppfrdm_noti notice notice-error is-dismissible" style="display:block !important;"><p>'.esc_html__($sanitized_noti, "ppfrdm").'</p></div>';
			}
		}
    }
}

add_action( 'wp_ajax_ppfrdm_get_pkey', 'ppfrdm_get_pkey' );
function ppfrdm_get_pkey() {
	$gen_pkey = ppfrdm_get_rand_key(84);
	echo json_encode(array('pkey'=>$gen_pkey));
	wp_die();
}

add_action( 'wp_ajax_ppfrdm_get_texs', 'ppfrdm_get_texs' );
function ppfrdm_get_texs() {
	if(isset($_POST['get_taxonomies'])){
		$post_type = sanitize_text_field($_POST['post_type']);
		echo ppfrdm_get_taxonomies($post_type);
	}elseif(isset($_POST['get_terms'])){
		$post_type = sanitize_text_field($_POST['post_type']);
		$taxonomy = sanitize_text_field($_POST['taxonomy']);
		echo ppfrdm_get_terms($post_type, $taxonomy);
	}
	wp_die();
}

add_action( 'admin_action_ppfrdm_publish_widgets', 'ppfrdm_publish_widgets' );
function ppfrdm_publish_widgets()
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'ppfrdm_publish';
	$ppfrdm_pub_wid_id = sanitize_text_field($_POST['ppfrdm_pub_wid_id']);
	if(isset($_POST['save'])){
		unset($_POST['action']);
		unset($_POST['ppfrdm_pub_wid_id']);
		unset($_POST['submit']);
		foreach($_POST as $key => $row){
			$options_arr[$key] = sanitize_text_field($_POST[$key]);
		}
		$options = serialize($options_arr);

		//validation
		if($_POST['ppfrdm_pub_wid_title'] == ''){
			wp_redirect(ppfrdm_get_admin_url(false,'publish-options',$ppfrdm_pub_wid_id,esc_html__('Invalid Title!', 'ppfrdm')));
		}elseif($_POST['ppfrdm_pub_wid_scope'] == 'private' && $_POST['ppfrdm_pub_wid_pkey'] == ''){
			wp_redirect(ppfrdm_get_admin_url(false,'publish-options',$ppfrdm_pub_wid_id,esc_html__('Invalid Private Key!', 'ppfrdm')));
		}else{
			if($ppfrdm_pub_wid_id){
				$wpdb->update($table_name, array('options' => $options), array('id' => $ppfrdm_pub_wid_id));
				nocache_headers();
				wp_redirect(ppfrdm_get_admin_url(false,'publish-options',$ppfrdm_pub_wid_id,2));
			}else{
				$wpdb->insert($table_name, array('options' => $options));
				$lastid = $wpdb->insert_id;
				nocache_headers();
				wp_redirect(ppfrdm_get_admin_url(false,'publish-options',$lastid,1));
			}
		}
    }elseif(isset($_POST['delete'])){
    	$wpdb->delete( $table_name, array('id' => $ppfrdm_pub_wid_id));
    	nocache_headers();
		wp_redirect(ppfrdm_get_admin_url(true,'publish-options',false,3));
    }
    exit();
}

add_action( 'admin_action_ppfrdm_pull_widgets', 'ppfrdm_pull_widgets' );
function ppfrdm_pull_widgets()
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'ppfrdm_pull';
	$ppfrdm_pul_wid_id = sanitize_text_field($_POST['ppfrdm_pul_wid_id']);
	if(isset($_POST['save'])){
		unset($_POST['action']);
		unset($_POST['ppfrdm_pul_wid_id']);
		unset($_POST['submit']);
		foreach($_POST as $key => $row){
			$options_arr[$key] = sanitize_text_field($_POST[$key]);
		}
		$options = serialize($options_arr);

		//validation
		if($_POST['ppfrdm_pul_wid_domain'] == ''){
			wp_redirect(ppfrdm_get_admin_url(false,'pull-options',false,esc_html__('Invalid Domain!', 'ppfrdm')));
		}elseif($_POST['ppfrdm_pul_widet'] == ''){
			wp_redirect(ppfrdm_get_admin_url(false,'pull-options',false,esc_html__('Select Widget!', 'ppfrdm')));
		}elseif($_POST['ppfrdm_pul_wid_title'] == ''){
			wp_redirect(ppfrdm_get_admin_url(false,'pull-options',false,esc_html__('Invalid Title!', 'ppfrdm')));
		}else{
			if($ppfrdm_pul_wid_id){
				$wpdb->update($table_name, array('options' => $options), array('id' => $ppfrdm_pul_wid_id));
				nocache_headers();
				wp_redirect(ppfrdm_get_admin_url(false,'pull-options',$ppfrdm_pul_wid_id,2));
			}else{
				$wpdb->insert($table_name, array('options' => $options));
				$lastid = $wpdb->insert_id;
				nocache_headers();
				wp_redirect(ppfrdm_get_admin_url(false,'pull-options',$lastid,1));
			}
		}
    }elseif(isset($_POST['delete'])){
    	$wpdb->delete( $table_name, array('id' => $ppfrdm_pul_wid_id));
    	nocache_headers();
		wp_redirect(ppfrdm_get_admin_url(true,'pull-options',false,3));
    }
    exit();
}

add_action( 'wp_ajax_ppfrdm_get_widgets', 'ppfrdm_get_widgets' );
function ppfrdm_get_widgets() {
	$sanitized_domain = sanitize_text_field($_POST['domain']);
	$sanitized_pkey = sanitize_text_field($_POST['pkey']);
	echo (ppfrdm_get_widgets_($sanitized_domain,$sanitized_pkey,false));
	wp_die();
}