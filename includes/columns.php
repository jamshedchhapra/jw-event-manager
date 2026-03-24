<?php
add_filter('manage_jwem_event_posts_columns',function($cols){

$cols['event_date']='Event Date';
return $cols;

});

add_action('manage_jwem_event_posts_custom_column',function($col,$post_id){

if($col=='event_date'){
echo get_post_meta($post_id,'event_date',true);
}

},10,2);