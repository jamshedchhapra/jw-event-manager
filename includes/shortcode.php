<?php
/**
 * Event listing shortcode.
 *
 * Usage: [jwem_events]
 */

add_action('init', 'jwem_register_shortcodes');

function jwem_register_shortcodes(){
    add_shortcode('jwem_events', 'jwem_list');
}

/**
 * Ensure shortcode parsing remains active even if another theme/plugin removes it.
 */
add_action('init', 'jwem_restore_shortcode_content_filter', 20);

function jwem_restore_shortcode_content_filter(){
    if (!has_filter('the_content', 'do_shortcode')) {
        add_filter('the_content', 'do_shortcode', 11);
    }
}

function jwem_list($atts = []){
    $events = get_posts([
        'post_type'      => 'jwem_event',
        'post_status'    => 'publish',
        'posts_per_page' => 10,
        'orderby'        => 'date',
        'order'          => 'DESC'
    ]);

    if (empty($events)) {
        return '<p>' . esc_html__('No events found', 'jw-event-manager') . '</p>';
    }

    ob_start();

    foreach ($events as $event) {
        $event_id = $event->ID;
        $date = get_post_meta($event_id, 'date', true);
        $loc  = get_post_meta($event_id, 'loc', true);

        echo '<div class="jwem-event">';
        echo '<h3><a href="' . esc_url(get_permalink($event_id)) . '">' . esc_html(get_the_title($event_id)) . '</a></h3>';
        echo '<p>' . esc_html__('Date:', 'jw-event-manager') . ' ' . esc_html($date) . '</p>';
        echo '<p>' . esc_html__('Location:', 'jw-event-manager') . ' ' . esc_html($loc) . '</p>';
        echo '</div>';
    }

    return ob_get_clean();
}
