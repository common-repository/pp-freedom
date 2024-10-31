<h1><?php esc_html_e('Publish Widgets', 'ppfrdm'); ?></h1>
<p><?php esc_html_e('Here you can create n number of widgets based on Post Type (Ex. Post, Custom Post, Product), Taxonomy, Term (Category) and lots of other options.', 'ppfrdm'); ?></p>
<nav class="nav-tab-wrapper">
<?php if($GLOBALS['ppfrdm_widgets_pub']): $ppfrdm_wid_num = 1; foreach($GLOBALS['ppfrdm_widgets_pub'] as $key => $row): ?>
<a href="<?php echo ppfrdm_get_admin_url(false,'publish-options',$row->id,false); ?>" class="nav-tab <?php if(isset($_GET['stab'])): if($_GET['stab'] == $row->id): echo 'nav-tab-active'; endif; endif; ?>" style="float:left;"><?php esc_html_e('Widget '.$ppfrdm_wid_num, 'ppfrdm'); ?></a>
<?php $ppfrdm_wid_num++; endforeach; $ppfrdm_next_id = 0; $ppfrdm_next_num = $ppfrdm_wid_num; unset($key); unset($row); ?>
<a href="<?php echo ppfrdm_get_admin_url(false,'publish-options',0,false); ?>" class="nav-tab <?php if(isset($_GET['stab'])): if($_GET['stab'] == 0): echo 'nav-tab-active'; endif; endif; ?>" style="float:left;"><?php esc_html_e('Add Widget '.$ppfrdm_next_num, 'ppfrdm'); ?></a>
<?php else: ?>
<a href="<?php echo ppfrdm_get_admin_url(false,'publish-options',0,false); ?>" class="nav-tab <?php if(isset($_GET['stab'])): if($_GET['stab'] == 0): echo 'nav-tab-active'; endif; endif; ?>" style="float:left;"><?php esc_html_e('Add Widget 1', 'ppfrdm'); ?></a>
<?php endif; ?>
</nav>

<div class="sub-tab-content">
<?php if(isset($_GET['stab'])):
	$ppfrdm_widgets_pub = $GLOBALS['ppfrdm_widgets_pub'];
	$ppfrdm_founder = false;
	if($ppfrdm_widgets_pub):
		foreach($ppfrdm_widgets_pub as $key => $row):
			if($row->id == $_GET['stab']):
				$ppfrdm_founder = true;
				$ppfrdm_options = unserialize($row->options);
?>
<form method="post" action="<?php echo admin_url( 'admin.php' ); ?>" novalidate="novalidate">
	<input type="hidden" name="action" value="ppfrdm_publish_widgets" />
	<input type="hidden" name="ppfrdm_pub_wid_id" value="<?php echo $row->id; ?>" />
	<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Type', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_type" id="ppfrdm_pub_wid_type" >
						<option <?php echo ($ppfrdm_options['ppfrdm_pub_wid_type'] == 'global') ? 'selected' : ''; ?> value="global"><?php esc_html_e('Global', 'ppfrdm'); ?></option>
						<option <?php echo ($ppfrdm_options['ppfrdm_pub_wid_type'] == 'local') ? 'selected' : ''; ?> value="local"><?php esc_html_e('Local', 'ppfrdm'); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Scope', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_scope" id="ppfrdm_pub_wid_scope" <?php echo ($ppfrdm_options['ppfrdm_pub_wid_type'] == 'local') ? 'disabled' : ''; ?> >
						<option <?php echo isset($ppfrdm_options['ppfrdm_pub_wid_scope']) ? ($ppfrdm_options['ppfrdm_pub_wid_scope'] == 'private') ? 'selected' : '' : ''; ?> value="private"><?php esc_html_e('Private', 'ppfrdm'); ?></option>
						<option <?php echo isset($ppfrdm_options['ppfrdm_pub_wid_scope']) ? ($ppfrdm_options['ppfrdm_pub_wid_scope'] == 'public') ? 'selected' : '' : ''; ?> value="public"><?php esc_html_e('Public', 'ppfrdm'); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Private Key', 'ppfrdm'); ?></label>
				</th>
				<td>
					<textarea class="regular-text" name="ppfrdm_pub_wid_pkey" id="ppfrdm_pub_wid_pkey" <?php echo ($ppfrdm_options['ppfrdm_pub_wid_type'] != 'local') ? isset($ppfrdm_options['ppfrdm_pub_wid_scope']) ? ($ppfrdm_options['ppfrdm_pub_wid_scope'] == 'public') ? 'disabled' : '' : '' : 'disabled'; ?> ><?php echo isset($ppfrdm_options['ppfrdm_pub_wid_pkey']) ? esc_textarea($ppfrdm_options['ppfrdm_pub_wid_pkey']) : ''; ?></textarea>
					<input <?php echo ($ppfrdm_options['ppfrdm_pub_wid_type'] != 'local') ? isset($ppfrdm_options['ppfrdm_pub_wid_scope']) ? ($ppfrdm_options['ppfrdm_pub_wid_scope'] == 'public') ? 'disabled' : '' : '' : 'disabled'; ?> type="button" class='button' id="ppfrdm_pub_gen_pkey" value="<?php esc_html_e('Generate', 'ppfrdm'); ?>" >
					<p class="description"><?php esc_html_e('Use this private key while pulling this widget.', 'ppfrdm'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Post Type', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_ptype" id="ppfrdm_pub_wid_ptype" >
						<?php foreach($GLOBALS['ppfrdm_post_types'] as $key2 => $row2): ?>
							<option <?php echo ($ppfrdm_options['ppfrdm_pub_wid_ptype'] == $row2) ? 'selected' : ''; ?> value="<?php echo $row2; ?>" ><?php echo $row2; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Taxonomy', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select  class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_tax" id="ppfrdm_pub_wid_tax">
						<?php echo json_decode(ppfrdm_get_taxonomies($ppfrdm_options['ppfrdm_pub_wid_ptype'],$ppfrdm_options['ppfrdm_pub_wid_tax']))->taxonomies; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Term', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_trm" id="ppfrdm_pub_wid_trm">
						<?php echo json_decode(ppfrdm_get_terms($ppfrdm_options['ppfrdm_pub_wid_ptype'],$ppfrdm_options['ppfrdm_pub_wid_tax'],$ppfrdm_options['ppfrdm_pub_wid_trm']))->terms; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Sorting', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_sort" id="ppfrdm_pub_wid_sort" >
						<option <?php echo ($ppfrdm_options['ppfrdm_pub_wid_sort'] == 'latest') ? 'selected' : ''; ?> value="latest"><?php esc_html_e('Latest', 'ppfrdm'); ?></option>
						<option <?php echo ($ppfrdm_options['ppfrdm_pub_wid_sort'] == 'beginning') ? 'selected' : ''; ?> value="beginning"><?php esc_html_e('Beginning', 'ppfrdm'); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('No. of Posts', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="number" class="regular-text" name="ppfrdm_pub_wid_pcount" id="ppfrdm_pub_wid_pcount" value="<?php echo $ppfrdm_options['ppfrdm_pub_wid_pcount']; ?>" >
					<p class="description"><?php esc_html_e('Use 0 to access all posts.', 'ppfrdm'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('No. of Words', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="number" class="regular-text" name="ppfrdm_pub_wid_wcount" id="ppfrdm_pub_wid_wcount" value="<?php echo $ppfrdm_options['ppfrdm_pub_wid_wcount']; ?>" >
					<p class="description"><?php esc_html_e('Use 0 to access full content. (This will work approximately)', 'ppfrdm'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Direct Link', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_dirl" id="ppfrdm_pub_wid_dirl">
						<option <?php echo isset($ppfrdm_options['ppfrdm_pub_wid_dirl']) ? ($ppfrdm_options['ppfrdm_pub_wid_dirl'] == 'disable') ? 'selected' : '' : ''; ?> value="disable"><?php esc_html_e('Disable', 'ppfrdm'); ?></option>
						<option <?php echo isset($ppfrdm_options['ppfrdm_pub_wid_dirl']) ? ($ppfrdm_options['ppfrdm_pub_wid_dirl'] == 'enable') ? 'selected' : '' : ''; ?> value="enable"><?php esc_html_e('Enable', 'ppfrdm'); ?></option>
					</select>
					<p class="description"><?php esc_html_e('Disable this to show the popup with content or Enable this to direct the link to the source.', 'ppfrdm'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Links in the content', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_intl" id="ppfrdm_pub_wid_intl" <?php echo ($ppfrdm_options['ppfrdm_pub_wid_dirl'] == 'enable') ? 'disabled' : ''; ?> >
						<option <?php echo isset($ppfrdm_options['ppfrdm_pub_wid_intl']) ? ($ppfrdm_options['ppfrdm_pub_wid_intl'] == 'enable') ? 'selected' : '' : ''; ?> value="enable"><?php esc_html_e('Enable', 'ppfrdm'); ?></option>
						<option <?php echo isset($ppfrdm_options['ppfrdm_pub_wid_intl']) ? ($ppfrdm_options['ppfrdm_pub_wid_intl'] == 'disable') ? 'selected' : '' : ''; ?> value="disable"><?php esc_html_e('Disable', 'ppfrdm'); ?></option>
					</select>
					<p class="description"><?php esc_html_e('Use this to show or hide the links in the content. ', 'ppfrdm'); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Source Link', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_srcl" id="ppfrdm_pub_wid_srcl" <?php echo ($ppfrdm_options['ppfrdm_pub_wid_dirl'] == 'enable') ? 'disabled' : ''; ?> >
						<option <?php echo isset($ppfrdm_options['ppfrdm_pub_wid_srcl']) ? ($ppfrdm_options['ppfrdm_pub_wid_srcl'] == 'enable') ? 'selected' : '' : ''; ?> value="enable"><?php esc_html_e('Enable', 'ppfrdm'); ?></option>
						<option <?php echo isset($ppfrdm_options['ppfrdm_pub_wid_srcl']) ? ($ppfrdm_options['ppfrdm_pub_wid_srcl'] == 'disable') ? 'selected' : '' : ''; ?> value="disable"><?php esc_html_e('Disable', 'ppfrdm'); ?></option>
					</select>
					<p class="description"><?php esc_html_e('Use this to show or hide the source link in the content.', 'ppfrdm'); ?>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<h2 class="title"><?php esc_html_e('Appearance', 'ppfrdm'); ?></h2>
					<p><?php esc_html_e('Only appearance options can be changed by the users while pulling this widget.', 'ppfrdm'); ?></p>
				</th>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Theme', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_theme" id="ppfrdm_pub_wid_theme" >
						<?php echo ppfrdm_theme_options($ppfrdm_options['ppfrdm_pub_wid_theme']); ?>
					</select>
					<p class="description"><?php esc_html_e('Theme name will descript the design of the widget.', 'ppfrdm'); ?></p>
				</td>
			</tr>
			<tr class="theme_options_row" <?php echo ($ppfrdm_options['ppfrdm_pub_wid_theme'] == 'json') ? 'style="display: none;"' : ''; ?> >
				<th scope="row">
					<label><?php esc_html_e('Background Color', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="ppfrdm-color-field" name="ppfrdm_pub_wid_bgclr" id="ppfrdm_pub_wid_bgclr" value="<?php echo $ppfrdm_options['ppfrdm_pub_wid_bgclr']; ?>" >
				</td>
			</tr>
			<tr class="theme_options_row" <?php echo ($ppfrdm_options['ppfrdm_pub_wid_theme'] == 'json') ? 'style="display: none;"' : ''; ?>>
				<th scope="row">
					<label><?php esc_html_e('Primary Color', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="ppfrdm-color-field" name="ppfrdm_pub_wid_prclr" id="ppfrdm_pub_wid_prclr" value="<?php echo $ppfrdm_options['ppfrdm_pub_wid_prclr']; ?>" >
				</td>
			</tr>
			<tr class="theme_options_row" <?php echo ($ppfrdm_options['ppfrdm_pub_wid_theme'] == 'json') ? 'style="display: none;"' : ''; ?>>
				<th scope="row">
					<label><?php esc_html_e('Secondary Color', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="ppfrdm-color-field" name="ppfrdm_pub_wid_scclr" id="ppfrdm_pub_wid_scclr" value="<?php echo $ppfrdm_options['ppfrdm_pub_wid_scclr']; ?>" >
				</td>
			</tr>
			<tr class="theme_options_row" <?php echo ($ppfrdm_options['ppfrdm_pub_wid_theme'] == 'json') ? 'style="display: none;"' : ''; ?>>
				<th scope="row">
					<label><?php esc_html_e('Tertiary Color', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="ppfrdm-color-field" name="ppfrdm_pub_wid_ttclr" id="ppfrdm_pub_wid_ttclr" value="<?php echo $ppfrdm_options['ppfrdm_pub_wid_ttclr']; ?>" >
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Widget Title', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="regular-text" name="ppfrdm_pub_wid_title" id="ppfrdm_pub_wid_title" value="<?php echo $ppfrdm_options['ppfrdm_pub_wid_title']; ?>" >
				</td>
			</tr>
		</tbody>
	</table>
	<p class="submit">
		<input type="submit" name="save" id="submit" class="button button-primary" value="<?php esc_html_e('Save Changes', 'ppfrdm'); ?>">
		<input type="submit" name="delete" id="delete" class="button ppfrdm-wid-del-btn" value="<?php esc_html_e('Delete This Widget', 'ppfrdm'); ?>">
	</p>
</form>
<h2 class="title" id="local-publish-h2"><?php esc_html_e('Local Publish', 'ppfrdm'); ?></h2>
<p><?php esc_html_e('Use this shortcode in this site:', 'ppfrdm'); ?> <code><?php echo ppfrdm_get_shortcode('local', array('id'=>$row->id)); ?></code></p>
<?php if($ppfrdm_options['ppfrdm_pub_wid_type'] != 'local'): ?>

<?php
$whitelist = array(
    '127.0.0.1',
    '::1'
);
if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
    echo "<p class='ppfrdm_warning_txt' >".esc_html__('Global options wont work in localhost.', 'ppfrdm')."</p>";
}
?>

<h2 class="title"><?php esc_html_e('Global Publish ( PP Freedom )', 'ppfrdm'); ?></h2>
<p><?php esc_html_e('Use this shortcode in another wordpress site with PP Freedom installed:', 'ppfrdm'); ?> <code>
	<?php if($ppfrdm_options['ppfrdm_pub_wid_scope'] == 'private'): ?>
	<?php echo ppfrdm_get_shortcode('global', array('id'=>$row->id,'site'=>get_site_url(),'pkey'=>$ppfrdm_options['ppfrdm_pub_wid_pkey'])); ?>
	<?php else: ?>	
	<?php echo ppfrdm_get_shortcode('global', array('id'=>$row->id,'site'=>get_site_url())); ?>
	<?php endif; ?>
	</code></p>
<h2 class="title"><?php esc_html_e('Global Publish ( Anywhere )', 'ppfrdm'); ?></h2>
<p><?php esc_html_e('You can use the below code options to pull this widget anywhere using PHP Curl code or REST API.', 'ppfrdm'); ?></p>
<p class='ppfrdm_warning_txt' ><?php esc_html_e('Load jQuery wherever you are using this code to work.', 'ppfrdm'); ?></p>
<div style="margin-left:11px;" >
	<h3><?php esc_html_e('REST API', 'ppfrdm'); ?></h3>
	<p><?php esc_html_e('Use this REST API URL to get this widget data in JSON format:', 'ppfrdm'); ?>
	<br><code>
		<?php
		if($ppfrdm_options['ppfrdm_pub_wid_scope'] == 'private'){
			$extra_atts = array('pkey'=>$ppfrdm_options['ppfrdm_pub_wid_pkey']);
		}else{
			$extra_atts = false;
		}
		echo ppfrdm_get_frdm_url(get_site_url(),1,$row->id,0,$extra_atts);
		?>
		</code></p>
</div>
<?php endif; ?>
<?php
break;
endif; endforeach; unset($key); unset($row);
endif;
if(!$ppfrdm_founder):
?>
<form method="post" action="<?php echo admin_url( 'admin.php' ); ?>" novalidate="novalidate">
	<input type="hidden" name="action" value="ppfrdm_publish_widgets" />
	<input type="hidden" name="ppfrdm_pub_wid_id" value="0" />
	<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Type', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_type" id="ppfrdm_pub_wid_type" >
						<option value="global"><?php esc_html_e('Global', 'ppfrdm'); ?></option>
						<option value="local"><?php esc_html_e('Local', 'ppfrdm'); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Scope', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_scope" id="ppfrdm_pub_wid_scope" >
						<option value="private"><?php esc_html_e('Private', 'ppfrdm'); ?></option>
						<option value="public"><?php esc_html_e('Public', 'ppfrdm'); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Private Key', 'ppfrdm'); ?></label>
				</th>
				<td>
					<textarea class="regular-text" name="ppfrdm_pub_wid_pkey" id="ppfrdm_pub_wid_pkey" ><?php echo ppfrdm_get_rand_key(84); ?></textarea>
					<input type="button" class='button' id="ppfrdm_pub_gen_pkey" value="<?php esc_html_e('Generate', 'ppfrdm'); ?>" >
					<p class="description"><?php esc_html_e('Use this private key while pulling this widget.', 'ppfrdm'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Post Type', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_ptype" id="ppfrdm_pub_wid_ptype" >
						<?php foreach($GLOBALS['ppfrdm_post_types'] as $key => $row): ?>
							<option value="<?php echo $row; ?>" ><?php echo $row; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Taxonomy', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select  class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_tax" id="ppfrdm_pub_wid_tax">
						<option value="all" ><?php esc_html_e('All', 'ppfrdm'); ?></option>
						<?php foreach($GLOBALS['ppfrdm_post_taxonomies'] as $key => $row): ?>
							<option value="<?php echo $row; ?>" ><?php echo $row; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Term', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_trm" id="ppfrdm_pub_wid_trm">
						<option value="all" ><?php esc_html_e('All', 'ppfrdm'); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Sorting', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_sort" id="ppfrdm_pub_wid_sort" >
						<option value="latest"><?php esc_html_e('Latest', 'ppfrdm'); ?></option>
						<option value="beginning"><?php esc_html_e('Beginning', 'ppfrdm'); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('No. of Posts', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="regular-text" name="ppfrdm_pub_wid_pcount" id="ppfrdm_pub_wid_pcount" value="0" >
					<p class="description"><?php esc_html_e('Use 0 to access all posts.', 'ppfrdm'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('No. of Words', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="regular-text" name="ppfrdm_pub_wid_wcount" id="ppfrdm_pub_wid_wcount" value="0" >
					<p class="description"><?php esc_html_e('Use 0 to access full content. (This will work approximately)', 'ppfrdm'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Direct Link', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_dirl" id="ppfrdm_pub_wid_dirl">
						<option value="disable"><?php esc_html_e('Disable', 'ppfrdm'); ?></option>
						<option value="enable"><?php esc_html_e('Enable', 'ppfrdm'); ?></option>
					</select>
					<p class="description"><?php esc_html_e('Disable this to show the popup with content or Enable this to direct the link to the source.', 'ppfrdm'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Links in the content', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_intl" id="ppfrdm_pub_wid_intl">
						<option value="enable"><?php esc_html_e('Enable', 'ppfrdm'); ?></option>
						<option value="disable"><?php esc_html_e('Disable', 'ppfrdm'); ?></option>
					</select>
					<p class="description"><?php esc_html_e('Use this to show or hide the links in the content. ', 'ppfrdm'); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Source Link', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_srcl" id="ppfrdm_pub_wid_srcl">
						<option value="enable"><?php esc_html_e('Enable', 'ppfrdm'); ?></option>
						<option value="disable"><?php esc_html_e('Disable', 'ppfrdm'); ?></option>
					</select>
					<p class="description"><?php esc_html_e('Use this to show or hide the source link in the content.', 'ppfrdm'); ?>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<h2 class="title"><?php esc_html_e('Appearance', 'ppfrdm'); ?></h2>
					<p><?php esc_html_e('Only appearance options can be changed by the users while pulling this widget.', 'ppfrdm'); ?></p>
				</th>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Theme', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pub_wid_theme" id="ppfrdm_pub_wid_theme" >
						<?php echo ppfrdm_theme_options(); ?>
					</select>
					<p class="description"><?php esc_html_e('Theme name will descript the design of the widget.', 'ppfrdm'); ?></p>
				</td>
			</tr>
			<tr class="theme_options_row">
				<th scope="row">
					<label><?php esc_html_e('Background Color', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="ppfrdm-color-field" name="ppfrdm_pub_wid_bgclr" id="ppfrdm_pub_wid_bgclr" value="#f9f9f9" >
				</td>
			</tr>
			<tr class="theme_options_row">
				<th scope="row">
					<label><?php esc_html_e('Primary Color', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="ppfrdm-color-field" name="ppfrdm_pub_wid_prclr" id="ppfrdm_pub_wid_prclr" value="#141414" >
				</td>
			</tr>
			<tr class="theme_options_row">
				<th scope="row">
					<label><?php esc_html_e('Secondary Color', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="ppfrdm-color-field" name="ppfrdm_pub_wid_scclr" id="ppfrdm_pub_wid_scclr" value="#141414" >
				</td>
			</tr>
			<tr class="theme_options_row">
				<th scope="row">
					<label><?php esc_html_e('Tertiary Color', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="ppfrdm-color-field" name="ppfrdm_pub_wid_ttclr" id="ppfrdm_pub_wid_ttclr" value="#1c1c1c" >
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Widget Title', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="regular-text" name="ppfrdm_pub_wid_title" id="ppfrdm_pub_wid_title">
				</td>
			</tr>
		</tbody>
	</table>
	<p class="submit">
		<input type="submit" name="save" id="submit" class="button button-primary" value="<?php esc_html_e('Submit', 'ppfrdm'); ?>">
	</p>
</form>
<h2 class="title"><?php esc_html_e('After adding the widget you will get shortcodes and other options to use this widget.', 'ppfrdm'); ?></h2>
<?php endif; ?>
<?php endif; ?>
</div>