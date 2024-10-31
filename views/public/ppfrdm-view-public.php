<!doctype html>
<html lang="en-US">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?php esc_html_e('PP Freedom', 'ppfrdm'); ?></title>
	<style type="text/css">
		body{
			margin: 0;
			font-family: sans-serif;
			padding:20px;
		}
		code{
		    padding: 3px 5px 2px 5px;
		    margin: 0 1px;
		    background: #f0f0f1;
		    background: rgba(0,0,0,.07);
		    font-size: 13px;
		}
	</style>
</head>
<body>
	<h1><?php esc_html_e('Welcome to PP Freedom', 'ppfrdm'); ?></h1>
	<p><?php esc_html_e('Here you can find all the public widgets of this site.', 'ppfrdm'); ?></p>
<?php
global $wpdb;
$ppfrdm_publish = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix . "ppfrdm_publish ORDER BY id ASC");
$ppfrdm_publich_wid_check = true;
if($ppfrdm_publish){
	echo "<div style='padding:10px;'>";
	foreach($ppfrdm_publish as $key=>$row){
		$this_options = unserialize($row->options);
		if($this_options['ppfrdm_pub_wid_scope'] == 'public'){
			$ppfrdm_publich_wid_check = false;
			$row->options = unserialize($row->options);
			echo "<h2>".$row->options['ppfrdm_pub_wid_title']."</h2>";
			echo "<p>";
			esc_html_e('Use this shortcode in another wordpress site with PP Freedom installed:', 'ppfrdm');
			echo "<code>";
			echo ppfrdm_get_shortcode('global', array('id'=>$row->id,'site'=>get_site_url()));
			echo "</code><br><br>";
			esc_html_e('Use this REST API URL to get this widget data in JSON format:', 'ppfrdm');
			echo "<code>";
				echo  ppfrdm_get_frdm_url(get_site_url(),1,$row->id,0);
			echo "</code><br>";
			echo "</p>";
		}
	}
	if($ppfrdm_publich_wid_check){
		esc_html_e('This site does not have any public widgets.', 'ppfrdm');
	}
	echo "</div>";
}
?>
</body>
</html>