<?php
/* ===== START SHORTCODE ===== */

function jwem_list(){

$q=new WP_Query([
'post_type'=>'jwem_event'
]);

ob_start();

while($q->have_posts()){
$q->the_post();
echo '<h3>'.get_the_title().'</h3>';
}

wp_reset_postdata();

return ob_get_clean();

}

add_shortcode('jwem_events','jwem_list');

/* ===== END SHORTCODE ===== */