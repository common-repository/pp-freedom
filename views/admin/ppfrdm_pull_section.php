<h1><?php esc_html_e('Pull Options', 'ppfrdm'); ?></h1>
<p><?php esc_html_e('Here you can pull n number of public or private widgets to use on this site.', 'ppfrdm'); ?></p>
<nav class="nav-tab-wrapper">
<?php if($GLOBALS['ppfrdm_widgets_pul']): $ppfrdm_wid_num = 1; foreach($GLOBALS['ppfrdm_widgets_pul'] as $key => $row): ?>
<a href="<?php echo ppfrdm_get_admin_url(false,'pull-options',$row->id,false); ?>" class="nav-tab <?php if(isset($_GET['stab'])): if($_GET['stab'] == $row->id): echo 'nav-tab-active'; endif; endif; ?>" style="float:left;"><?php esc_html_e('Widget '.$ppfrdm_wid_num, 'ppfrdm'); ?></a>
<?php $ppfrdm_wid_num++; endforeach; $ppfrdm_next_id = 0; $ppfrdm_next_num = $ppfrdm_wid_num; unset($key); unset($row); ?>
<a href="<?php echo ppfrdm_get_admin_url(false,'pull-options',0,false); ?>" class="nav-tab <?php if(isset($_GET['stab'])): if($_GET['stab'] == 0): echo 'nav-tab-active'; endif; endif; ?>" style="float:left;"><?php esc_html_e('Add Widget '.$ppfrdm_next_num, 'ppfrdm'); ?></a>
<?php else: ?>
<a href="<?php echo ppfrdm_get_admin_url(false,'pull-options',0,false); ?>" class="nav-tab <?php if(isset($_GET['stab'])): if($_GET['stab'] == 0): echo 'nav-tab-active'; endif; endif; ?>" style="float:left;"><?php esc_html_e('Add Widget 1', 'ppfrdm'); ?></a>
<?php endif; ?>
</nav>

<div class="sub-tab-content">
<?php if(isset($_GET['stab'])):
	$ppfrdm_widgets_pub = $GLOBALS['ppfrdm_widgets_pul'];
	$ppfrdm_founder = false;
	if($ppfrdm_widgets_pub):
		foreach($ppfrdm_widgets_pub as $key => $row):
			if($row->id == $_GET['stab']):
				$ppfrdm_founder = true;
				$ppfrdm_options = unserialize($row->options);
?>
<form method="post" action="<?php echo admin_url( 'admin.php' ); ?>" novalidate="novalidate">
	<input type="hidden" name="action" value="ppfrdm_pull_widgets" />
	<input type="hidden" name="ppfrdm_pul_wid_id" value="<?php echo $row->id; ?>" />
	<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Domain', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="regular-text" name="ppfrdm_pul_wid_domain" id="ppfrdm_pul_wid_domain" value="<?php echo $ppfrdm_options['ppfrdm_pul_wid_domain']; ?>" >
					<p class="description"><?php esc_html_e('Add domain with protocol (http/https).', 'ppfrdm'); ?></p>
					<br><textarea class="regular-text" name="ppfrdm_pul_wid_pkey" id="ppfrdm_pul_wid_pkey" ><?php echo isset($ppfrdm_options['ppfrdm_pul_wid_pkey']) ? esc_textarea($ppfrdm_options['ppfrdm_pul_wid_pkey']) : ''; ?></textarea>
					<p class="description"><?php esc_html_e('Add private key to get private widgets.', 'ppfrdm'); ?></p>
					<br>
					<input type="button" class='button' id="ppfrdm_pul_get_widgets" value="<?php esc_html_e('Pull Widgets', 'ppfrdm'); ?>" >
				</td>

			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Select Widget', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pul_widet" id="ppfrdm_pul_widet" >
						<?php echo json_decode(ppfrdm_get_widgets_($ppfrdm_options['ppfrdm_pul_wid_domain'],$ppfrdm_options['ppfrdm_pul_wid_pkey'],$ppfrdm_options['ppfrdm_pul_widet']))->widgets; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Theme', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pul_wid_theme" id="ppfrdm_pul_wid_theme" >
						<?php echo ppfrdm_theme_options_pull($ppfrdm_options['ppfrdm_pul_wid_theme']); ?>
					</select>
					<p class="description"><?php esc_html_e('Theme name will descript the design of the widget.', 'ppfrdm'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Background Color', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="ppfrdm-color-field" name="ppfrdm_pul_wid_bgclr" id="ppfrdm_pul_wid_bgclr" value="<?php echo $ppfrdm_options['ppfrdm_pul_wid_bgclr']; ?>" >
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Primary Color', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="ppfrdm-color-field" name="ppfrdm_pul_wid_prclr" id="ppfrdm_pul_wid_prclr" value="<?php echo $ppfrdm_options['ppfrdm_pul_wid_prclr']; ?>" >
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Secondary Color', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="ppfrdm-color-field" name="ppfrdm_pul_wid_scclr" id="ppfrdm_pul_wid_scclr" value="<?php echo $ppfrdm_options['ppfrdm_pul_wid_scclr']; ?>" >
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Tertiary Color', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="ppfrdm-color-field" name="ppfrdm_pul_wid_ttclr" id="ppfrdm_pul_wid_ttclr" value="<?php echo $ppfrdm_options['ppfrdm_pul_wid_ttclr']; ?>" >
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Widget Title', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="regular-text" name="ppfrdm_pul_wid_title" id="ppfrdm_pul_wid_title" value="<?php echo $ppfrdm_options['ppfrdm_pul_wid_title']; ?>" >
				</td>
			</tr>
		</tbody>
	</table>
	<p class="submit">
		<input type="submit" name="save" id="submit" class="button button-primary" value="<?php esc_html_e('Save Changes', 'ppfrdm'); ?>">
		<input type="submit" name="delete" id="delete" class="button ppfrdm-wid-del-btn" value="<?php esc_html_e('Delete This Widget', 'ppfrdm'); ?>">
	</p>
</form>
<h2 class="title"><?php esc_html_e('Pull Options', 'ppfrdm'); ?></h2>
<p><?php esc_html_e('Use this shortcode for these custom options:', 'ppfrdm'); ?> <code><?php echo ppfrdm_get_shortcode('pull', array('id'=>$row->id)); ?></code></p>
<p><?php esc_html_e('Use this shortcode for default options from the publisher:', 'ppfrdm'); ?> <code>
	<?php if($ppfrdm_options['ppfrdm_pul_wid_pkey'] == ''): ?>
	<?php echo ppfrdm_get_shortcode('global', array('id'=>$ppfrdm_options['ppfrdm_pul_widet'],'site'=>$ppfrdm_options['ppfrdm_pul_wid_domain'])); ?>
	<?php else: ?>
	<?php echo ppfrdm_get_shortcode('global', array('id'=>$ppfrdm_options['ppfrdm_pul_widet'],'site'=>$ppfrdm_options['ppfrdm_pul_wid_domain'],'pkey'=>$ppfrdm_options['ppfrdm_pul_wid_pkey'])); ?>
	<?php endif; ?>
	</code></p>
<?php
break;
endif; endforeach; unset($key); unset($row);
endif;
if(!$ppfrdm_founder):
?>
<form method="post" action="<?php echo admin_url( 'admin.php' ); ?>" novalidate="novalidate">
	<input type="hidden" name="action" value="ppfrdm_pull_widgets" />
	<input type="hidden" name="ppfrdm_pul_wid_id" value="0" />
	<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Domain', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="regular-text" name="ppfrdm_pul_wid_domain" id="ppfrdm_pul_wid_domain" required>
					<p class="description"><?php esc_html_e('Add domain with protocol (http/https).', 'ppfrdm'); ?></p>
					<br><textarea class="regular-text" name="ppfrdm_pul_wid_pkey" id="ppfrdm_pul_wid_pkey" ></textarea>
					<p class="description"><?php esc_html_e('Add private key to get private widgets.', 'ppfrdm'); ?></p>
					<br>
					<input type="button" class='button' id="ppfrdm_pul_get_widgets" value="<?php esc_html_e('Pull Widgets', 'ppfrdm'); ?>" >
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Select Widget', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pul_widet" id="ppfrdm_pul_widet" >
						<option value="" disabled selected="" > <?php esc_html_e('Click Pull Widgets', 'ppfrdm'); ?> </option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Theme', 'ppfrdm'); ?></label>
				</th>
				<td>
					<select class="ppfrdm_fld_sel" name="ppfrdm_pul_wid_theme" id="ppfrdm_pul_wid_theme" >
						<?php echo ppfrdm_theme_options_pull(); ?>
					</select>
					<p class="description"><?php esc_html_e('Theme name will descript the design of the widget.', 'ppfrdm'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Background Color', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="ppfrdm-color-field" name="ppfrdm_pul_wid_bgclr" id="ppfrdm_pul_wid_bgclr" value="#f9f9f9" >
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Primary Color', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="ppfrdm-color-field" name="ppfrdm_pul_wid_prclr" id="ppfrdm_pul_wid_prclr" value="#141414" >
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Secondary Color', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="ppfrdm-color-field" name="ppfrdm_pul_wid_scclr" id="ppfrdm_pul_wid_scclr" value="#141414" >
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Tertiary Color', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="ppfrdm-color-field" name="ppfrdm_pul_wid_ttclr" id="ppfrdm_pul_wid_ttclr" value="#1c1c1c" >
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label><?php esc_html_e('Widget Title', 'ppfrdm'); ?></label>
				</th>
				<td>
					<input type="text" class="regular-text" name="ppfrdm_pul_wid_title" id="ppfrdm_pul_wid_title">
				</td>
			</tr>
		</tbody>
	</table>
	<p class="submit">
		<input type="submit" name="save" id="submit" class="button button-primary" value="<?php esc_html_e('Submit', 'ppfrdm'); ?>">
	</p>
</form>
<h2 class="title"><?php esc_html_e('After adding the widget you will get shortcodes to use this widget.', 'ppfrdm'); ?></h2>
<?php endif; ?>
<?php endif; ?>
</div>