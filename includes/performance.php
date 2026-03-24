<?php
add_action('save_post_jwem_event',function($post_id){

delete_transient('jwem_events_cache');

});