<?php
/* ===== ADD ADMIN COLUMNS ===== */

add_filter('manage_jwem_event_posts_columns', function($cols){

    $cols['event_date'] = 'Event Date';
    $cols['location']   = 'Location';
    $cols['organizer']  = 'Organizer';
    $cols['rsvp_limit'] = 'RSVP Limit';

    return $cols;
});


/* ===== POPULATE COLUMNS ===== */

add_action('manage_jwem_event_posts_custom_column', function($col, $post_id){

    switch($col){

        case 'event_date':
            echo esc_html(get_post_meta($post_id,'date',true));
        break;

        case 'location':
            echo esc_html(get_post_meta($post_id,'loc',true));
        break;

        case 'organizer':
            echo esc_html(get_post_meta($post_id,'organizer',true));
        break;

        case 'rsvp_limit':
            echo esc_html(get_post_meta($post_id,'rsvp_limit',true));
        break;
    }

}, 10, 2);