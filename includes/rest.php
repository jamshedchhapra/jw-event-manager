<?php
/**
 * REST API Integration
 *
 * Purpose:
 * Expose Event data to external applications.
 *
 * Endpoint:
 * /wp-json/jwem/v1/events
 *
 * Method:
 * GET
 *
 * Security:
 * Public read-only endpoint.
 *
 * Performance:
 * - Limited query size
 * - Transient caching added
 */

add_action('rest_api_init','jwem_register_rest_routes');

/**
 * Register custom REST route
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
 * REST Callback
 * Returns structured event data
 */
function jwem_rest_get_events(){

    /* ===== PERFORMANCE CACHE START ===== */
    /* Avoid repeated DB queries for same REST response */

    $cached = get_transient('jwem_rest_events');
    if ($cached !== false && jwem_rest_cache_is_valid($cached)) {
        return rest_ensure_response($cached);
    }

    /* ===== PERFORMANCE CACHE END ===== */

    $events = get_posts([
        'post_type'      => 'jwem_event',
        'post_status'    => 'publish',
        'numberposts'    => 10,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'suppress_filters' => false
    ]);

    $data = [];

    /* ===== SAFE EMPTY RESULT HANDLING ===== */
    if(!empty($events)){

        foreach($events as $event){

            $data[] = [

                'id'    => $event->ID,
                'title' => $event->post_title,
                'link'  => get_permalink($event->ID),

                'date'  => get_post_meta($event->ID,'date',true),
                'location' => get_post_meta($event->ID,'loc',true),
                'organizer'=> get_post_meta($event->ID,'organizer',true)

            ];

        }

    }

    /* ===== STORE CACHE (5 minutes) ===== */
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
