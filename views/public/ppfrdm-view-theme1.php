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
foreach($elements as $key => $row){
  if($key == 0){
    $loop_rndm = $first_rndm;
  }else{
    $loop_rndm = mt_rand(1111,9999);
  }
  $this_post = $row['post'];
  $this_post_meta = $row['post_meta'];
  $this_post_att = $row['post_att'];
  $loop_post_date = $row['get_the_time'];
  $author_name = $row['author_name'];

  $loop_post_author = $author_name;
  $loop_post_link = $row['get_permalink'];
  $loop_post_title = $this_post['post_title'];
  $loop_post_content = $row['get_content'];
  $loop_post_content = ppfrdm_limit_text($loop_post_content, $wid_wcount);
  $loop_post_content = ppfrdm_parse_content($options, $loop_post_content);
  $loop_post_att_thumb = $this_post_att['thumbnail'];
  $loop_post_att_medium = $this_post_att['medium'];
  $loop_post_att_large = $this_post_att['large'];

  if($wid_dirl == 'disable'){
    if($wid_srcl == 'enable'){
      $source_link = ' &nbsp; <a class="ppfrdm-modal-source-link_'.$first_rndm.'" href="'.$loop_post_link.'"> Source Link </a>';
    }else{
      $source_link = '';
    }
    $popper .= '<div class="ppfrdm-modal_'.$first_rndm.'" id="ppfrdm_pop_'.$loop_rndm.'"><div class="ppfrdm-modal-content_'.$first_rndm.'"><span class="ppfrdm-modal-close_'.$first_rndm.'" id="ppfrdm_pop_cls_'.$loop_rndm.'">&times;</span><img class="ppfrdm-modal-primary-img_'.$first_rndm.'" src="'.$loop_post_att_large.'" alt="'.$loop_post_title.'" loading="lazy" width="1024"><h3 class="ppfrdm-modal-title_'.$first_rndm.'">'.$loop_post_title.'</h3><small class="ppfrdm-modal-title-meta_'.$first_rndm.'">'.$loop_post_date.' | '.$loop_post_author.'</small><hr class="ppfrdm-modal-title-hr_'.$first_rndm.'"><div class="ppfrdm-modal-content-main_'.$first_rndm.'">'.$loop_post_content . $source_link.'</div></div></div>
    <script>
    // Get the modal
    var ppfrdm_modal_'.$loop_rndm.' = document.getElementById("ppfrdm_pop_'.$loop_rndm.'");

    // Get the button that opens the modal
    var ppfrdm_btn_'.$loop_rndm.' = document.getElementsByClassName("ppfrdm_pop_trig_'.$loop_rndm.'");
    for (var i = 0; i < ppfrdm_btn_'.$loop_rndm.'.length; i++) {
        
        // When the user clicks the button, open the modal 
        ppfrdm_btn_'.$loop_rndm.'[i].onclick = function() {
          event.preventDefault();
          ppfrdm_modal_'.$loop_rndm.'.style.display = "block";
        }

        // Get the <span> element that closes the modal
        var ppfrdm_span_'.$loop_rndm.' = document.getElementById("ppfrdm_pop_cls_'.$loop_rndm.'");

        // When the user clicks on <span> (x), close the modal
        ppfrdm_span_'.$loop_rndm.'.onclick = function() {
          ppfrdm_modal_'.$loop_rndm.'.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        ppfrdm_modal_'.$loop_rndm.'.onclick = function(event) {
          if (event.target == ppfrdm_modal_'.$loop_rndm.') {
            ppfrdm_modal_'.$loop_rndm.'.style.display = "none";
          }
        }
    }
    </script>';
  }

  if($key == 0) continue;

  $looper .= '<li class="ppfrdm-small-posts-item_'.$first_rndm.' ppfrdm-clearfix_'.$first_rndm.'">
    <figure class="ppfrdm-small-posts-thumb_'.$first_rndm.'">
       <a class="ppfrdm_pop_trig_'.$loop_rndm.'" href="'.$loop_post_link.'" title="'.$loop_post_title.'"><img src="'.$loop_post_att_thumb.'" alt="'.$loop_post_title.'" loading="lazy" width="80" height="60"> </a>
    </figure>
    <div class="ppfrdm-small-posts-header_'.$first_rndm.'">
       <h4 class="ppfrdm-small-posts-title_'.$first_rndm.'">
          <a class="ppfrdm_pop_trig_'.$loop_rndm.'" href="'.$loop_post_link.'" title="'.$loop_post_title.'">'.$loop_post_title.'</a>
       </h4>
       <div class="ppfrdm-meta_'.$first_rndm.'">
          <span>'.$loop_post_date.'</span>
       </div>
    </div>
  </li>';
}

$style = <<<HTML
<style>
/* Modal Code */
.ppfrdm-modal_{$first_rndm}{
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0,0.4);
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  padding-bottom: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  z-index: 999999;
}
.ppfrdm-modal-content_{$first_rndm}{
  background-color: {$wid_bgclr} !important;
  margin: auto;
  padding: 2px 20px 20px 20px;
  border: 1px solid #888;
  width: 84%;
  max-width:1024px;
  min-width: 291px;
  overflow: auto;
}
.ppfrdm-modal-content_{$first_rndm} a{
  text-decoration: underline 1px dotted currentColor !important;
}
.ppfrdm-modal-primary-img_{$first_rndm}{
  width: 100%;
  margin: 6px 0px 20px 0px;
}
.ppfrdm-modal-title_{$first_rndm}{
  color: {$wid_prclr} !important;
  font-weight: 600;
  font-size: 24px;
  font-size: 1.45rem;
}
.ppfrdm-modal-title-meta_{$first_rndm}{
  color: {$wid_ttclr} !important;
  margin-bottom:6px;
  display: block;
  font-size: .9rem;
}
.ppfrdm-modal-title-hr_{$first_rndm}{
  border: 1px solid {$wid_prclr} !important;
  margin-bottom:10px;
}
.ppfrdm-modal-content-main_{$first_rndm}{
  color: {$wid_scclr} !important;
}
.ppfrdm-modal-source-link_{$first_rndm}{
  color: {$wid_prclr} !important;
  display:block;
  margin-top:6px;
}
.ppfrdm-modal-close_{$first_rndm}{
  color: {$wid_ttclr} !important;
  float: right;
  font-size: 28px;
  font-weight: bold;
}
.ppfrdm-modal-close_{$first_rndm}:hover,
.ppfrdm-modal-close_{$first_rndm}:focus {
  color: {$wid_scclr} !important;
  text-decoration: none;
  cursor: pointer;
}

/* Main Container */
.ppfrdm-container_{$first_rndm}{
  margin-top: 0;
  float: none;
  width: 96%;
  margin: 0;
  padding: 2%;
  background: {$wid_bgclr} !important; 
  border-radius:3px;
  height: auto !important
}
.ppfrdm-container_{$first_rndm} a{
  color: {$wid_prclr} !important;
  text-decoration: none;
}
.ppfrdm-container_{$first_rndm} ul{
  list-style: none;
  padding:0;
  margin:0;
}
.ppfrdm-widget_{$first_rndm}{
  margin-bottom: 20px;
  overflow: hidden;
}
.ppfrdm-widget-title_{$first_rndm}{
  color: {$wid_prclr} !important;
  position: relative;
  font-size: 16px;
  font-size: 1.2rem;
  padding-bottom: 5px;
  margin-bottom: 20px;
  margin-bottom: 1.25rem;
  text-transform: uppercase;
  border-bottom: 3px solid {$wid_prclr} !important;
}
.ppfrdm-posts-large-item_{$first_rndm}{
  margin-top: 20px;
  padding-bottom: 20px;
  border-bottom: 1px dotted {$wid_ttclr} !important;
}
.ppfrdm-posts-large-thumb_{$first_rndm}{
  height: 251px;
  border-radius: 6px;
  position: relative;
  margin-bottom: 10px;
}
.ppfrdm-posts-large-thumb_{$first_rndm} img{
  height: 100%;
  width: auto;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%,-50%) scale(1);
  backface-visibility: hidden;
  transition: all .3s ease-in-out;
}
.ppfrdm-posts-large-title_{$first_rndm}{
  font-size: 1.35rem;
}
.ppfrdm-meta_{$first_rndm}{
  font-size: 0.8rem;
  color: {$wid_ttclr} !important;
}
.ppfrdm-meta_{$first_rndm} span{
  margin-right: 10px;
}
.ppfrdm-posts-large-excerpt_{$first_rndm}{
  margin-top: 10px;
}
.ppfrdm-posts-large-excerpt_{$first_rndm} p{
  color:{$wid_scclr} !important;
  font-size: 22px;
  font-size: 1.1rem;
}
.ppfrdm-excerpt_{$first_rndm} .more-link_{$first_rndm}{
  display:none;
}
.ppfrdm-small-posts-widget_{$first_rndm}{
  float: left;
  width: 100%;
}
.ppfrdm-small-posts-item_{$first_rndm}:first-child {
  padding-top: 0;
}
.ppfrdm-small-posts-item_{$first_rndm}{
  padding: 20px 0;
  padding-top: 20px;
}
.ppfrdm-small-posts-thumb_{$first_rndm}{
  float: left;
  margin-right: 15px;
}
.ppfrdm-small-posts-header_{$first_rndm}{
  overflow: hidden;
}
.ppfrdm-small-posts-title_{$first_rndm}{
  font-size: 16px;
  font-size: 1rem;
  font-weight: 700;
  line-height: 1.3;
  margin-bottom: 5px;
  margin-bottom: .3125rem;
}
.ppfrdm-clearfix_{$first_rndm}{
    display: block;
}
.frdm_browse_nav_{$first_rndm}{
  background: {$wid_prclr} !important;
  color: {$wid_bgclr} !important;
  margin-top:15px;
  padding: 6px 29px;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
}
.frdm_browse_nav_left_{$first_rndm}{
  float:left;
}
.frdm_browse_nav_right_{$first_rndm}{
  float:right;
}
</style>
HTML;

if($prvs_offset >= 0){
  $prvs_bttn = '<button id="frdm_browse_nav_left_'.$first_rndm.'" class="frdm_browse_nav_'.$first_rndm.' frdm_browse_nav_left_'.$first_rndm.'" onclick="ppfrdm_page_nav_'.$first_rndm.'(\''.$prvs_offset.'\', this.id)"> << </button>';
}else{
  $prvs_bttn = '';
}
if($options['ppfrdm_widget_OFFSET']){
  $next_bttn = '<button id="frdm_browse_nav_right_'.$first_rndm.'" class="frdm_browse_nav_'.$first_rndm.' frdm_browse_nav_right_'.$first_rndm.'" onclick="ppfrdm_page_nav_'.$first_rndm.'(\''.$next_offset.'\', this.id)"> >> </button>';
}else{
  $next_bttn = '';
}

$html = <<<HTML
<div class="ppfrdm-container_{$first_rndm}" id="ppfrdm_widget_body_{$first_rndm}">
   <div class="ppfrdm-widget_{$first_rndm}">
      <h2 class="ppfrdm-widget-title_{$first_rndm}">{$wid_title}</h2>
      <div class="ppfrdm-posts-large-widget_{$first_rndm}">
         <article class="ppfrdm-posts-large-item_{$first_rndm}">
            <figure class="ppfrdm-posts-large-thumb_{$first_rndm}">
               <a class="ppfrdm_pop_trig_{$first_rndm}" href="{$first_link}" title="{$first_title}"><img class="wp-post-image" src="{$first_att_large}" alt="{$first_title}" loading="lazy" width="678" height="381"> </a>
            </figure>
            <div class="ppfrdm-posts-large-content_{$first_rndm}">
               <div class="ppfrdm-posts-large-header_{$first_rndm}">
                  <h3 class="ppfrdm-posts-large-title_{$first_rndm}">
                     <a class="ppfrdm_pop_trig_{$first_rndm}" href="{$first_link}" title="{$first_title}" rel="bookmark">{$first_title}</a>
                  </h3>
                  <div class="ppfrdm-meta_{$first_rndm}">
                     <span>{$first_date}</span>
                  </div>
               </div>
               <div class="ppfrdm-posts-large-excerpt_{$first_rndm} ppfrdm-clearfix_{$first_rndm}">
                  <div class="ppfrdm-excerpt_{$first_rndm}">
                     <p>{$first_content} <a class="ppfrdm_pop_trig_{$first_rndm} ppfrdm-excerpt-more_{$first_rndm}" href="{$first_link}" title="{$first_title}">[Read More]</a></p>
                  </div>
               </div>
            </div>
         </article>
      </div>
   </div>
   <div class="ppfrdm-widget_{$first_rndm}">
      <ul class="ppfrdm-small-posts-widget_{$first_rndm} ppfrdm-clearfix_{$first_rndm}">
        {$looper}
      </ul>
      {$popper}
      {$prvs_bttn}
      {$next_bttn}
   </div>
</div>
HTML;

if($this_widget_getw == 2){
  $more_att = "&first_rndm=".$first_rndm."&frdm_pull=1&site=".urlencode($options['ppfrdm_widget_frdm_URL_'])."&pulid=".$options['ppfrdm_widget_frdm_PULID'];
}else{
  $more_att = "&first_rndm=".$first_rndm;
}

if($options['ppfrdm_widget_frdm_PKEY']){
 $more_att .= "&pkey=".$options['ppfrdm_widget_frdm_PKEY']; 
}

$script = <<<HTML
<script>
function ppfrdm_page_nav_{$first_rndm}(offset, getid){
  document.getElementById(getid).innerHTML = "Loading";

  var xhr = new XMLHttpRequest();
  var url = '{$this_site_url}/pp-frdm?get_widget={$this_widget_getw}&id={$this_widget_id}&offset='+offset+'{$more_att}';

  // Setup the POST request
  xhr.open('POST', url, true);
xhr.withCredentials = false;  
  // Set up a callback function to handle the response
  xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
          // Successful response
          //console.log(xhr.responseText);
          var resulst = JSON.parse(xhr.responseText);
          document.getElementById('ppfrdm_widget_body_{$first_rndm}').innerHTML = resulst.ppfrdm_body;
      } else {
          // Handle errors
          console.error(xhr.status, xhr.statusText);
      }
  };
  xhr.send();
}
</script>
HTML;

$output = ($offset == 0) ? $style . $html . $script : $html;
return $output;
