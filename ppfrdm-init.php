<?php defined( 'ABSPATH' ) || exit;
function ppfrdm_filter_domain($url){
	if (filter_var($url, FILTER_VALIDATE_URL)) {
		$new_url = trim($url, '/');
		return $new_url;
	}else{
	    return false;
	}
}
function ppfrdm_get_domain($url){
	if (strpos($url, 'localhost') !== false) {
		  return 'localhost';
	}else{
		$pieces = parse_url($url);
		  $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
		  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
		    return $regs['domain'];
		  }
		  return false;
	}
}

function ppfrdm_get_taxonomies($post_type,$selected=false){
	$taxonomies = get_object_taxonomies( $post_type );
	$terms_txt = '<option value="all" >All</option>';
	$taxonomies_txt = '<option value="all" >All</option>';
	if($taxonomies){ foreach($taxonomies as $key => $row){
		$selected_txt = '';
		if($selected){
			if($selected == $row){
				$selected_txt = 'selected';
			}
		}
		$taxonomies_txt .= "<option ".$selected_txt." value='".$row."'>".$row."</option>";
	}}
    return json_encode(array('taxonomies'=>$taxonomies_txt,'terms'=>$terms_txt));
}

function ppfrdm_get_terms($post_type,$taxonomy,$selected=false){
	$terms_txt = '<option value="all" >All</option>';
	if($taxonomy != 'all'){
		$terms = get_terms( array('taxonomy' => $taxonomy) );
		if($terms){ foreach($terms as $key => $row){
			$selected_txt = '';
			if($selected){
				if($selected == $row->slug){
					$selected_txt = 'selected';
				}
			}
			$terms_txt .= "<option ".$selected_txt." value='".$row->slug."'>".$row->name."</option>";
		}}
	    return json_encode(array('terms'=>$terms_txt));
	}else{
		return json_encode(array('terms'=>$terms_txt));
	}
}

function ppfrdm_get_admin_url($default_check, $tab, $stab, $noti=false){
	$noti = ($noti) ? urlencode($noti) : $noti;
	if($default_check){
		global $wpdb;
		if($tab == 'publish-options'){
			$get_data = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix . "ppfrdm_publish ORDER BY id ASC");	
		}else{
			$get_data = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix . "ppfrdm_pull ORDER BY id ASC");
		}
		if($get_data){
			$return = "?page=".ppfrdm_PLUGIN_ADMP."&tab=".$tab."&stab=".$get_data[0]->id."&noti=".$noti;
		}else{
			$return = "?page=".ppfrdm_PLUGIN_ADMP."&tab=".$tab."&stab=0&noti=".$noti;
		}
	}else{
		$return = "?page=".ppfrdm_PLUGIN_ADMP."&tab=".$tab."&stab=".$stab."&noti=".$noti;
	}
	return $return;
}

function ppfrdm_get_frdm_url($domain, $seg1, $seg2, $seg3, $extra = false){
	$extra_pars = '';
	if(is_array($extra)){
		foreach($extra as $key => $row){
			$extra_pars .= "&".$key."=".$row;
		}
	}
	if($seg1 == 'get_widgets'){
		$return = $domain . '/pp-frdm?get_widgets=1'.$extra_pars;
	}else{
		$return = $domain . '/pp-frdm?get_widget='.$seg1.'&id='.$seg2.'&offset='.$seg3 . $extra_pars;
	}
	
	return $return;
}

function ppfrdm_get_widgets_($domain,$pkey,$selected=false){
	if($selected){
		$widgets_txt = '<option value="" disabled > Select </option>';	
	}else{
		$widgets_txt = '<option value="" disabled selected > Select </option>';
	}
	
	$check_domain = ppfrdm_filter_domain($domain);
	if($check_domain){
		$response = wp_remote_request(ppfrdm_get_frdm_url($check_domain,'get_widgets',false,false,array('pkey'=>$pkey)));
		if($response['response']['code'] == 200){
			$response_body = json_decode($response['body']);
			if($response_body->ppfrdm_response == 'success'){  foreach($response_body->ppfrdm_body as $key => $row){
				$selected_txt = '';
				if($selected){
					if($selected == $row->id){
						$selected_txt = 'selected';
					}
				}
				$widgets_txt .= "<option ".$selected_txt." value='".$row->id."'>".$row->options->ppfrdm_pub_wid_title."</option>";
			}}
		    return json_encode(array('widgets'=>$widgets_txt));
		}else{
			return json_encode(array('widgets'=>$widgets_txt));
		}
	}else{
		return json_encode(array('widgets'=>$widgets_txt));
	}
}

function ppfrdm_change_excerpt_more( $more ) {
    return '';
}

function ppfrdm_draw_widget($options, $input_params){
	foreach($input_params as $key => $row){
		$params[$key] = sanitize_text_field($row);
	}
	$wid_ptype = $options['ppfrdm_pub_wid_ptype'];
	$wid_tax = $options['ppfrdm_pub_wid_tax'];
	$wid_trm = $options['ppfrdm_pub_wid_trm'];
	$wid_sort = $options['ppfrdm_pub_wid_sort'];
	$wid_pcount = $options['ppfrdm_pub_wid_pcount'];
	$wid_wcount = $options['ppfrdm_pub_wid_wcount'];
	$wid_theme = $options['ppfrdm_pub_wid_theme'];
	$wid_title = $options['ppfrdm_pub_wid_title'];

	$args = array(
		'post_type' => $wid_ptype
	);

	$args['posts_per_page'] = 5;
	$args['offset'] = $params['offset'];

	if($wid_sort == 'latest'){
		$args['order'] = 'DESC';
	}else{
		$args['order'] = 'ASC';
	}

	if($wid_tax != 'all'){
		$args['tax_query'] = array(
	            'taxonomy' => $wid_tax,
	            'field'    => 'slug'
	        );
	}
	if($wid_trm != 'all'){
		$args['tax_query']['terms'] = $wid_trm;
	}
	if($wid_tax != 'all' || $wid_trm != 'all'){
		$args['tax_query']['include_children'] = true;
		$args['tax_query']['operator'] = 'IN';
		$args['tax_query'] = array($args['tax_query']);
	}
	if(isset($params['s'])){
		$args['s'] = $params['s'];
	}

	$the_query = new WP_Query( $args );
	$total_posts_found = ($wid_pcount) ? ($the_query->found_posts >= $wid_pcount) ? $wid_pcount : $the_query->found_posts : $the_query->found_posts;
	$collector = [];
	while ( $the_query->have_posts() ) : $the_query->the_post();
		$post_obj = get_post();
		$getting_data['post'] = (array) get_post();
		$getting_data['post_meta'] = get_post_meta($post_obj->ID);
		$getting_data['post_att']['thumbnail'] = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail')[0];
		$getting_data['post_att']['medium'] = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium')[0];
		$getting_data['post_att']['large'] = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large')[0];

		$getting_data['get_the_time'] = get_the_time('d-M-Y', $post_obj);
		$getting_data['get_permalink'] = get_permalink($post_obj);
		add_filter('excerpt_more', 'ppfrdm_change_excerpt_more');
		$getting_data['get_the_excerpt'] =  get_the_excerpt($post_obj);
		$getting_data['get_content'] = apply_filters('the_content', $getting_data['post']['post_content']);
		$author_id = get_post_field( 'post_author', $post_obj );
		$getting_data['author_name'] = get_the_author_meta( 'display_name', $author_id );


        $collector[] = $getting_data;
        if($wid_pcount){
        	$this_loop_total_count = count($collector);
        	$this_loop_total_count = ($this_loop_total_count + $args['offset']);
        	if($this_loop_total_count >= $total_posts_found){
        		break;
        	}
        }
    endwhile;
    
    $check_this_count = $args['offset'] + $args['posts_per_page'];
    if($total_posts_found > $check_this_count){
    	$options['ppfrdm_widget_OFFSET'] = true;
    }else{
    	$options['ppfrdm_widget_OFFSET'] = false;
    }
	wp_reset_postdata();

	$options['ppfrdm_widget_frdm_URL'] = get_site_url();
	$options['ppfrdm_widget_frdm_GETW'] = sanitize_text_field($_GET['get_widget']);
	$options['ppfrdm_widget_frdm_ID'] = sanitize_text_field($_GET['id']);
	$options['ppfrdm_widget_frdm_FRDM'] = isset($_GET['first_rndm']) ? sanitize_text_field($_GET['first_rndm']) : mt_rand(1111,9999);
	$options['ppfrdm_widget_frdm_PKEY'] = isset($_GET['pkey']) ? sanitize_text_field($_GET['pkey']) : false;

	if(isset($params['get_widget'])){
		if($params['get_widget'] == 1){
			$theme_function = 'ppfrdm_draw_'.$wid_theme;
		    if(function_exists($theme_function)) {
			  	$return = $theme_function($options, $collector, $args);
			}else{
				$return = '';
			}
		}elseif($params['get_widget'] == 2){
			$return['options'] = $options;
			$return['collector'] = $collector;
			$return['args'] = $args;
		}else{
			$return = '';
		}
	}else{
		$return = '';
	}
    
	return ($return);
}

function ppfrdm_get_shortcode($type,$pars){
	$pars_txt = '';
	if(is_array($pars)){
		foreach($pars as $key => $row){
			$pars_txt .= " ".$key."='".$row."'";
		}
	}
	if($type == 'local'){
		return "[ppfrdm_local$pars_txt]";
	}elseif($type == 'global'){
		return "[ppfrdm_global$pars_txt]";
	}elseif($type == 'pull'){
		return "[ppfrdm_pull$pars_txt]";
	}else{
		return "";
	}
}

function ppfrdm_limit_text($text, $limit) {
	if($limit){
		if (str_word_count($text, 0) > $limit) {
		    $words = str_word_count($text, 2);
		    $pos   = array_keys($words);
		    $text  = substr($text, 0, $pos[$limit]) . '...';
		}
    }
    return $text;
}

function ppfrdm_parse_content($options, $content) {
	$wid_dirl = $options['ppfrdm_pub_wid_dirl'];
	$wid_intl = isset($options['ppfrdm_pub_wid_intl']) ? $options['ppfrdm_pub_wid_intl'] : '';
	$wid_srcl = isset($options['ppfrdm_pub_wid_srcl']) ? $options['ppfrdm_pub_wid_srcl'] : '';

	if($wid_dirl == 'disable'){
		if($wid_intl == 'disable'){
			$final_content = preg_replace('#<a.*?>([^>]*)</a>#i', '$1', $content);
		}else{
			$final_content = $content;
		}
	}else{
		$final_content = $content;
	}

    return $final_content;
}

function ppfrdm_get_rand_key($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    return $randomString;
}