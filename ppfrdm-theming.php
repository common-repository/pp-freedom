<?php defined( 'ABSPATH' ) || exit;
//These theme helper functions will execute on the front side of the website which includes HTML, CSS, and js code.
function ppfrdm_theme_options($selected = false){
	$selected_txt = ($selected == 'theme1') ? "selected" : '';
	$output_html = '<option '.$selected_txt.' value="theme1">'. esc_html__('Default Theme 1', 'ppfrdm').'</option>';
	$selected_txt = ($selected == 'theme2') ? "selected" : '';
	$output_html .= '<option '.$selected_txt.' value="theme2">'. esc_html__('Default Theme 2', 'ppfrdm').'</option>';
	$selected_txt = ($selected == 'json') ? "selected" : '';
	$output_html .= '<option '.$selected_txt.' value="json">'. esc_html__('JSON', 'ppfrdm').'</option>';
	return $output_html;
}

function ppfrdm_theme_options_pull(){
	$selected_txt = ($selected == 'theme1') ? "selected" : '';
	$output_html = '<option '.$selected_txt.' value="theme1">'. esc_html__('Default Theme 1', 'ppfrdm').'</option>';
	$selected_txt = ($selected == 'theme2') ? "selected" : '';
	$output_html .= '<option '.$selected_txt.' value="theme2">'. esc_html__('Default Theme 2', 'ppfrdm').'</option>';
	return $output_html;
}

function ppfrdm_draw_theme1($options, $elements, $args){
	if(!empty($elements)){
		$GLOBAlS['ppfrdm_options'] = $options;
		$GLOBAlS['ppfrdm_elements'] = $elements;
		$GLOBAlS['ppfrdm_args'] = $args;
		return include(ppfrdm_PLUGIN_DIR . 'views/public/ppfrdm-view-theme1.php');
	}else{
		return '';
	}
}
function ppfrdm_draw_theme2($options, $elements, $args){
	if(!empty($elements)){
		$GLOBAlS['ppfrdm_options'] = $options;
		$GLOBAlS['ppfrdm_elements'] = $elements;
		$GLOBAlS['ppfrdm_args'] = $args;
		return include(ppfrdm_PLUGIN_DIR . 'views/public/ppfrdm-view-theme2.php');
	}else{
		return '';
	}
}
function ppfrdm_draw_json($options, $elements, $args){
	if(!empty($elements)){
		$GLOBAlS['ppfrdm_options'] = $options;
		$GLOBAlS['ppfrdm_elements'] = $elements;
		$GLOBAlS['ppfrdm_args'] = $args;
		return include(ppfrdm_PLUGIN_DIR . 'views/public/ppfrdm-view-json.php');
	}else{
		return '';
	}
}