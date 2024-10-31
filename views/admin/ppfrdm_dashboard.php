<div class="wrap ppfrdm-wrap">
<nav class="nav-tab-wrapper">
	<a href="<?php echo ppfrdm_get_admin_url(true,'publish-options',false,false); ?>" class="nav-tab <?php if(isset($_GET['tab'])): if($_GET['tab'] == 'publish-options'): echo 'nav-tab-active'; endif; endif; ?>" style="width:40%;float:left;"><?php esc_html_e('Publish Section', 'ppfrdm'); ?></a>
	<a href="<?php echo ppfrdm_get_admin_url(true,'pull-options',false,false); ?>" class="nav-tab <?php if(isset($_GET['tab'])): if($_GET['tab'] == 'pull-options'): echo 'nav-tab-active'; endif; endif; ?>" style="width:40%;float:left;"><?php esc_html_e('Pull Section', 'ppfrdm'); ?></a>
</nav>
<div class="tab-content">
<?php if(isset($_GET['tab'])): ?>
<?php if($_GET['tab'] == 'publish-options'): ?>
	<?php include('ppfrdm_publish_section.php'); ?>
<?php elseif($_GET['tab'] == 'pull-options'): ?>
	<?php include('ppfrdm_pull_section.php'); ?>
<?php endif; ?>
<?php else: ?>
	<h1><?php esc_html_e('Welcome to PP Freedom', 'ppfrdm'); ?></h1>
	<p><?php esc_html_e('Are you looking to connect your multiple WordPress sites or do you want to show your WordPress content like blog posts, custom blog posts, and woocommerce products in other WordPress or non-WordPress sites? You are at the right place, and PP Freedom is the one and only best solution for you. <br> By using PP Freedom you can easily show WordPress content like blog posts, custom blog posts, or woocommerce products in this site or any other WordPress or non-wordpress sites, in the form of widgets with all customizable options, and you can create unlimited private or public widgets.', 'ppfrdm'); ?></p>
	<a href="<?php echo ppfrdm_get_admin_url(true,'publish-options',false,false); ?>" class="button button-primary"><?php esc_html_e('Publish Section', 'ppfrdm'); ?></a>
  	<a href="<?php echo ppfrdm_get_admin_url(true,'pull-options',false,false); ?>" class="button button-primary"><?php esc_html_e('Pull Section', 'ppfrdm'); ?></a>
<?php endif; ?>
</div>
</div>