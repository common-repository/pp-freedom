<?php
$options = $GLOBAlS['ppfrdm_options'];
$elements = $GLOBAlS['ppfrdm_elements'];
$args = $GLOBAlS['ppfrdm_args'];

$offset = $args['offset'];
$posts_per_page = $args['posts_per_page'];
$next_offset = ($offset + $posts_per_page);
$prvs_offset = ($offset - $posts_per_page);

$this_site_url = $options['ppfrdm_widget_frdm_URL'];
$this_widget_id = $options['ppfrdm_widget_frdm_ID'];
$this_widget_getw = $options['ppfrdm_widget_frdm_GETW'];

$wid_wcount = $options['ppfrdm_pub_wid_wcount'];
$wid_bgclr = $options['ppfrdm_pub_wid_bgclr'];
$wid_prclr = $options['ppfrdm_pub_wid_prclr'];
$wid_scclr = $options['ppfrdm_pub_wid_scclr'];
$wid_ttclr = $options['ppfrdm_pub_wid_ttclr'];
$wid_dirl = $options['ppfrdm_pub_wid_dirl'];
$wid_intl = isset($options['ppfrdm_pub_wid_intl']) ? $options['ppfrdm_pub_wid_intl'] : '';
$wid_srcl = isset($options['ppfrdm_pub_wid_srcl']) ? $options['ppfrdm_pub_wid_srcl'] : '';
$wid_title = $options['ppfrdm_pub_wid_title'];

$first_post = $elements[0]['post'];
$first_post_meta = $elements[0]['post_meta'];
$first_post_att = $elements[0]['post_att'];
$first_date = $elements[0]['get_the_time'];
$first_link = $elements[0]['get_permalink'];
$first_title = $first_post['post_title'];

$first_content = $elements[0]['get_the_excerpt'];
$first_content = ppfrdm_limit_text($first_content, $wid_wcount);
$first_att_thumb = $first_post_att['thumbnail'];
$first_att_medium = $first_post_att['medium'];
$first_att_large = $first_post_att['large'];

$looper = '';
$popper = '';
$first_rndm = $options['ppfrdm_widget_frdm_FRDM'];

$output = $elements;
return $output;