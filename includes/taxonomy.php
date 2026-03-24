<?php
/* ===== START TAXONOMY ===== */

add_action('init', function () {

    register_taxonomy('event_type', ['jwem_event'], [

        /* ===== LABELS ===== */
        'labels' => [
            'name'              => __('Event Types', 'jw-event-manager'),
            'singular_name'     => __('Event Type', 'jw-event-manager'),
            'search_items'      => __('Search Event Types', 'jw-event-manager'),
            'all_items'         => __('All Event Types', 'jw-event-manager'),
            'parent_item'       => __('Parent Event Type', 'jw-event-manager'),
            'parent_item_colon' => __('Parent Event Type:', 'jw-event-manager'),
            'edit_item'         => __('Edit Event Type', 'jw-event-manager'),
            'update_item'       => __('Update Event Type', 'jw-event-manager'),
            'add_new_item'      => __('Add New Event Type', 'jw-event-manager'),
            'new_item_name'     => __('New Event Type Name', 'jw-event-manager'),
            'menu_name'         => __('Event Types', 'jw-event-manager'),
        ],

        /* ===== CORE SETTINGS ===== */
        'public'             => true,
        'hierarchical'       => true, // behaves like categories
        'show_ui'            => true,
        'show_admin_column'  => true, // shows column in event list
        'show_in_rest'       => true, // Gutenberg + API support

        /* ===== URL STRUCTURE ===== */
        'rewrite' => [
            'slug' => 'event-type'
        ],

    ]);

});

/* ===== END TAXONOMY ===== */