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
 * Limited query size.
 */

add_action('rest_api_init','jwem_register_rest_routes');

/**
 * Register custom REST route
 */
function jwem_register_rest_routes(){

    register_rest_route('jwem/v1','/events',[

        'methods'  => 'GET',

        'callback' => 'jwem_rest_get_events',

        'permission_callback' => '__return_true'

    ]);

}


/**
 * REST Callback
 * Returns structured event data
 */
function jwem_rest_get_events(){

    $events = get_posts([
        'post_type'   => 'jwem_event',
        'numberposts' => 10
    ]);

    $data = [];

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

    return $data;

}