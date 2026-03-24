<?php
/* ======================================================
   ADMIN FILTERS (Existing Code - Preserved & Documented)
====================================================== */

/**
 * Add filters to Admin Listing Screen
 */
add_action('restrict_manage_posts', function(){

    global $typenow;

    // Only apply for Event CPT
    if($typenow != 'jwem_event') return;

    /**
     * ----------------------------------
     * TEXT SEARCH FIELD
     * ----------------------------------
     */
    ?>
    <input type="text" name="event_search" placeholder="Search title or description"
           value="<?php echo isset($_GET['event_search']) ? esc_attr($_GET['event_search']) : ''; ?>">
    <?php

    /**
     * ----------------------------------
     * EVENT TYPE DROPDOWN
     * ----------------------------------
     */
    wp_dropdown_categories([
        'taxonomy'        => 'event_type',
        'name'            => 'event_type_filter',
        'show_option_all' => 'All Event Types',
        'selected'        => $_GET['event_type_filter'] ?? '',
    ]);

    /**
     * ----------------------------------
     * ORGANIZER FILTER (Dynamic Query)
     * ----------------------------------
     */
    global $wpdb;

    $organizers = $wpdb->get_col("
        SELECT DISTINCT meta_value FROM $wpdb->postmeta
        WHERE meta_key = 'organizer'
    ");
    ?>

    <select name="organizer_filter">
        <option value="">All Organizers</option>
        <?php foreach($organizers as $org): ?>
            <option value="<?php echo esc_attr($org); ?>"
                <?php selected($_GET['organizer_filter'] ?? '', $org); ?>>
                <?php echo esc_html($org); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php

});


/* ======================================================
   ADMIN QUERY FILTERING (Existing Code - Preserved)
====================================================== */

add_action('pre_get_posts', function($query){

    if(!is_admin() || !$query->is_main_query()) return;

    global $pagenow;

    if($pagenow != 'edit.php') return;
    if(($query->get('post_type')) != 'jwem_event') return;

    /**
     * TEXT SEARCH
     */
    if(!empty($_GET['event_search'])){
        $query->set('s', sanitize_text_field($_GET['event_search']));
    }

    /**
     * EVENT TYPE FILTER
     */
    if(!empty($_GET['event_type_filter'])){
        $query->set('tax_query', [[
            'taxonomy' => 'event_type',
            'field'    => 'term_id',
            'terms'    => intval($_GET['event_type_filter']),
        ]]);
    }

    /**
     * ORGANIZER FILTER
     */
    if(!empty($_GET['organizer_filter'])){
        $query->set('meta_query', [[
            'key'   => 'organizer',
            'value' => sanitize_text_field($_GET['organizer_filter']),
        ]]);
    }

});


/* ======================================================
   FRONTEND FILTER SUPPORT (NEW - REQUIRED FOR AUDIT)
====================================================== */

/**
 * Modify Event Archive Query (Frontend)
 */
add_action('pre_get_posts', function($query){

    // Only frontend main query
    if(is_admin() || !$query->is_main_query()) return;

    // Apply only on Event archive
    if(is_post_type_archive('jwem_event')){

        /**
         * KEYWORD SEARCH
         */
        if(!empty($_GET['keyword'])){
            $query->set('s', sanitize_text_field($_GET['keyword']));
        }

        /**
         * TAXONOMY FILTER
         */
        if(!empty($_GET['event_type'])){
            $query->set('tax_query', [[
                'taxonomy' => 'event_type',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_GET['event_type']),
            ]]);
        }

        /**
         * DATE FILTER
         */
        if(!empty($_GET['event_date'])){
            $query->set('meta_query', [[
                'key'     => 'date',
                'value'   => sanitize_text_field($_GET['event_date']),
                'compare' => '='
            ]]);
        }

    }

});