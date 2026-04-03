<?php
/**
 * REST API integration for event data.
 */

add_action('rest_api_init','jwem_register_rest_routes');

/**
 * Register the public events REST route.
 */
function jwem_register_rest_routes(){

    register_rest_route('jwem/v1','/events',[

        'methods'  => 'GET',

        'callback' => 'jwem_rest_get_events',

        /* Public read-only endpoint */
        'permission_callback' => '__return_true'

    ]);

}


/**
 * Return structured event data for the REST endpoint.
 */
function jwem_rest_get_events(){

    /* Reuse cached event data when the stored payload is valid. */

    $cached = get_transient('jwem_rest_events');
    if ($cached !== false && jwem_rest_cache_is_valid($cached)) {
        return rest_ensure_response($cached);
    }

    $events = get_posts([
        'post_type'      => 'jwem_event',
        'post_status'    => 'publish',
        'numberposts'    => 10,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'suppress_filters' => false
    ]);

    $data = [];

    /* Build the response payload only when events exist. */
    if(!empty($events)){

        foreach($events as $event){

            $data[] = [

                'id'        => absint($event->ID),
                'title'     => sanitize_text_field(get_the_title($event->ID)),
                'link'      => esc_url_raw(get_permalink($event->ID)),
                'date'      => sanitize_text_field(get_post_meta($event->ID,'date',true)),
                'location'  => sanitize_text_field(get_post_meta($event->ID,'loc',true)),
                'organizer' => sanitize_text_field(get_post_meta($event->ID,'organizer',true))

            ];

        }

    }

    /* Cache the structured response for repeated requests. */
    set_transient('jwem_rest_events',$data,5 * MINUTE_IN_SECONDS);

    return rest_ensure_response($data);

}

/**
 * Validate cached REST payload shape.
 * Prevent stale WP_Post objects from being served.
 */
function jwem_rest_cache_is_valid($cached){
    if (!is_array($cached)) {
        return false;
    }

    foreach ($cached as $item) {
        if (!is_array($item)) {
            return false;
        }

        $required = ['id', 'title', 'link', 'date', 'location', 'organizer'];
        foreach ($required as $key) {
            if (!array_key_exists($key, $item)) {
                return false;
            }
        }
    }

    return true;
}
