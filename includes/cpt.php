<?php
/* ===== START CPT ===== */

add_action('init', function () {

    register_post_type('jwem_event', [

        'labels' => [
            'name'               => 'Events',
            'singular_name'      => 'Event',
            'add_new'            => 'Add Event',
            'add_new_item'       => 'Add New Event',
            'edit_item'          => 'Edit Event',
            'new_item'           => 'New Event',
            'view_item'          => 'View Event',
            'search_items'       => 'Search Events',
            'not_found'          => 'No Events Found',
            'menu_name'          => 'Events'
        ],

        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-calendar',

        'supports' => ['title', 'editor'],

        'show_in_rest' => true

    ]);

});

/* ===== END CPT ===== */