<?php
/**
 * Admin and frontend event filters.
 */

/**
 * Add filters to Admin Listing Screen
 */
add_action('restrict_manage_posts', function(){

    global $typenow;

    // Only apply for Event CPT
    if($typenow !== 'jwem_event') return;

    $event_search = isset($_GET['event_search']) ? sanitize_text_field(wp_unslash($_GET['event_search'])) : '';
    $event_type_filter = isset($_GET['event_type_filter']) ? absint(wp_unslash($_GET['event_type_filter'])) : 0;
    $organizer_filter = isset($_GET['organizer_filter']) ? sanitize_text_field(wp_unslash($_GET['organizer_filter'])) : '';

    /** Render the admin search field. */
    ?>
    <input type="text" name="event_search" placeholder="Search title or description"
           value="<?php echo esc_attr($event_search); ?>">
    <?php

    /** Render the event type dropdown. */
    wp_dropdown_categories([
        'taxonomy'        => 'event_type',
        'name'            => 'event_type_filter',
        'show_option_all' => __('All Event Types', 'jw-event-manager'),
        'selected'        => $event_type_filter,
    ]);

    /** Build the organizer filter from existing event meta. */
    $organizers = [];
    $event_ids = get_posts([
        'post_type'      => 'jwem_event',
        'post_status'    => ['publish', 'draft', 'pending', 'future', 'private'],
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ]);

    foreach ($event_ids as $event_id) {
        $organizer = get_post_meta($event_id, 'organizer', true);

        if ($organizer !== '') {
            $organizers[] = sanitize_text_field($organizer);
        }
    }

    $organizers = array_values(array_unique($organizers));
    sort($organizers, SORT_NATURAL | SORT_FLAG_CASE);
    ?>

    <select name="organizer_filter">
        <option value=""><?php esc_html_e('All Organizers', 'jw-event-manager'); ?></option>
        <?php foreach($organizers as $org): ?>
            <option value="<?php echo esc_attr($org); ?>"
                <?php selected($organizer_filter, $org); ?>>
                <?php echo esc_html($org); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php

});

add_action('pre_get_posts', function($query){

    if(!is_admin() || !$query->is_main_query()) return;

    global $pagenow;

    if($pagenow != 'edit.php') return;
    if(($query->get('post_type')) != 'jwem_event') return;

    /** Apply admin text search. */
    if(!empty($_GET['event_search'])){
        $query->set('s', sanitize_text_field(wp_unslash($_GET['event_search'])));
    }

    /** Apply admin event type filter. */
    if(!empty($_GET['event_type_filter'])){
        $query->set('tax_query', [[
            'taxonomy' => 'event_type',
            'field'    => 'term_id',
            'terms'    => absint(wp_unslash($_GET['event_type_filter'])),
        ]]);
    }

    /** Apply admin organizer filter. */
    if(!empty($_GET['organizer_filter'])){
        $query->set('meta_query', [[
            'key'   => 'organizer',
            'value' => sanitize_text_field(wp_unslash($_GET['organizer_filter'])),
        ]]);
    }

});

/**
 * Modify Event Archive Query (Frontend)
 */
add_action('pre_get_posts', function($query){

    // Only frontend main query
    if(is_admin() || !$query->is_main_query()) return;

    // Apply only on Event archive
    if(is_post_type_archive('jwem_event')){

        /** Apply frontend keyword search. */
        if(!empty($_GET['keyword'])){
            $query->set('s', sanitize_text_field(wp_unslash($_GET['keyword'])));
        }

        /** Apply frontend event type filter. */
        if(!empty($_GET['event_type'])){
            $query->set('tax_query', [[
                'taxonomy' => 'event_type',
                'field'    => 'slug',
                'terms'    => sanitize_title(wp_unslash($_GET['event_type'])),
            ]]);
        }

        /** Apply frontend date filter. */
        if(!empty($_GET['event_date'])){
            $query->set('meta_query', [[
                'key'     => 'date',
                'value'   => sanitize_text_field(wp_unslash($_GET['event_date'])),
                'compare' => '='
            ]]);
        }

    }

});
