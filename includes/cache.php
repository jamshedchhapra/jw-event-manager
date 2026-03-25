<?php
/**
 * Event Query Caching Layer
 */

function jwem_get_events(){

// Attempt to fetch cache
$cache = get_transient('jwem_events');

if($cache !== false){
    return $cache;
}

// Query database
$events = get_posts([
'post_type'=>'jwem_event',
'numberposts'=>10
]);

// Store in cache for 1 hour
set_transient('jwem_events',$events,3600);

return $events;

}

/**
 * Clear all event-related transients when event records change.
 */
function jwem_clear_event_transients($post_id = 0){
if($post_id){
    $post_type = get_post_type($post_id);
    if($post_type && $post_type !== 'jwem_event'){
        return;
    }
}

delete_transient('jwem_events');
delete_transient('jwem_events_cache');
delete_transient('jwem_rest_events');
}

add_action('save_post_jwem_event','jwem_clear_event_transients');
add_action('trashed_post','jwem_clear_event_transients');
add_action('untrashed_post','jwem_clear_event_transients');
add_action('deleted_post','jwem_clear_event_transients');
