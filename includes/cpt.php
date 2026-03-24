<?php
/* ===== START CPT ===== */

add_action('init', function () {

    register_post_type('jwem_event', [

        /* ===== LABELS ===== */
        'labels' => [
            'name'               => __('Events', 'jw-event-manager'),
            'singular_name'      => __('Event', 'jw-event-manager'),
            'add_new'            => __('Add Event', 'jw-event-manager'),
            'add_new_item'       => __('Add New Event', 'jw-event-manager'),
            'edit_item'          => __('Edit Event', 'jw-event-manager'),
            'new_item'           => __('New Event', 'jw-event-manager'),
            'view_item'          => __('View Event', 'jw-event-manager'),
            'search_items'       => __('Search Events', 'jw-event-manager'),
            'not_found'          => __('No Events Found', 'jw-event-manager'),
            'menu_name'          => __('Events', 'jw-event-manager'),
        ],

        /* ===== CORE SETTINGS ===== */
        'public'        => true,
        'has_archive'   => true,
        'menu_icon'     => 'dashicons-calendar',

        /* ===== GUTENBERG + API ===== */
        'show_in_rest'  => true,

        /* ===== FEATURES ===== */
        'supports'      => ['title', 'editor', 'thumbnail'],

        /* ===== CLEAN URL ===== */
        'rewrite' => [
            'slug'       => 'events',
            'with_front' => false
        ],

    ]);

});

/* ===== END CPT ===== */