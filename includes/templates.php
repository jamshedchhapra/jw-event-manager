<?php
/**
 * JW Event Manager Template Loader
 *
 * Loads custom frontend templates for:
 * - Event Archive
 * - Single Event
 *
 * Uses WordPress template hierarchy filter.
 */

add_filter('template_include', 'jwem_template_loader');

function jwem_template_loader($template){

    // Load single event template
    if (is_singular('jwem_event')) {

        $single_template = JWEM_PATH . 'templates/single-event.php';

        if (file_exists($single_template)) {
            return $single_template;
        }

    }

    // Load archive template
    if (is_post_type_archive('jwem_event') || is_tax('jwem_event_category')) {

        $archive_template = JWEM_PATH . 'templates/archive-event.php';

        if (file_exists($archive_template)) {
            return $archive_template;
        }

    }

    return $template;
}