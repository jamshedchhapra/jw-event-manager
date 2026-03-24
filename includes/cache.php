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