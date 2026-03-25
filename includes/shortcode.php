<?php
/* FINAL EVENT LISTING SHORTCODE */

function jwem_list(){

$events = get_transient('jwem_events_cache');

if(false === $events){

$events = new WP_Query([
'post_type'=>'jwem_event',
'posts_per_page'=>10
]);

set_transient('jwem_events_cache',$events,HOUR_IN_SECONDS);

}

ob_start();

while($events->have_posts()){
$events->the_post();

$date = get_post_meta(get_the_ID(),'date',true);
$loc  = get_post_meta(get_the_ID(),'loc',true);

echo '<div class="jwem-event">';
echo '<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
echo '<p>'.__('Date:','jw-event-manager').' '.$date.'</p>';
echo '<p>'.__('Location:','jw-event-manager').' '.$loc.'</p>';
echo '</div>';

}

wp_reset_postdata();

return ob_get_clean();

}

add_shortcode('jwem_events','jwem_list');

/* ===== END SHORTCODE ===== */