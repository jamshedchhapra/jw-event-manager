<?php
/* ===== START META ===== */
/**
 * JW Event Manager - Meta Box Handler
 * 
 * Handles adding, displaying, and saving custom meta fields
 * for the 'jwem_event' custom post type.
 *
 * Security, validation, and sanitization are included.
 *
 * @package JW Event Manager
 */


/* ===== REGISTER META BOX ===== */
function jwem_meta_box() {
    add_meta_box(
        'jwem_details',       // Unique ID
        __('Event Details', 'jw-event-manager'), // Box title with translation
        'jwem_meta_html',     // Callback function to display HTML
        'jwem_event',         // Post type
        'normal',             // Context: normal, side, advanced
        'high'                // Priority
    );
}
add_action('add_meta_boxes', 'jwem_meta_box');


/* ===== META BOX HTML ===== */
function jwem_meta_html($post) {
    // Security nonce field for verification
    wp_nonce_field('jwem_save', 'jwem_nonce');

    // Fetch existing meta values safely
    $date         = get_post_meta($post->ID, 'date', true);
    $loc          = get_post_meta($post->ID, 'loc', true);
    $organizer    = get_post_meta($post->ID, 'organizer', true);
    $rsvp_limit   = get_post_meta($post->ID, 'rsvp_limit', true);
    $email_notify = get_post_meta($post->ID, 'email_notify', true);

    ?>

    <!-- Event Date -->
    <p>
        <label for="jwem_date"><strong><?php _e('Event Date', 'jw-event-manager'); ?></strong></label><br>
        <input type="date" id="jwem_date" name="date" value="<?php echo esc_attr($date); ?>">
    </p>

    <!-- Event Location -->
    <p>
        <label for="jwem_loc"><strong><?php _e('Location', 'jw-event-manager'); ?></strong></label><br>
        <input type="text" id="jwem_loc" name="loc" value="<?php echo esc_attr($loc); ?>" style="width:100%;">
    </p>

    <hr>

    <!-- Organizer -->
    <p>
        <label for="jwem_organizer"><strong><?php _e('Organizer', 'jw-event-manager'); ?></strong></label><br>
        <input type="text" id="jwem_organizer" name="organizer" value="<?php echo esc_attr($organizer); ?>" style="width:100%;">
    </p>

    <!-- RSVP Limit -->
    <p>
        <label for="jwem_rsvp_limit"><strong><?php _e('RSVP Limit', 'jw-event-manager'); ?></strong></label><br>
        <input type="number" id="jwem_rsvp_limit" name="rsvp_limit" value="<?php echo esc_attr($rsvp_limit); ?>" style="width:100%;">
    </p>

    <!-- Email Notification -->
    <p>
        <label>
            <input type="checkbox" name="email_notify" value="1" <?php checked($email_notify, 1); ?>>
            <?php _e('Send Email Notification on Publish/Update', 'jw-event-manager'); ?>
        </label>
    </p>

    <?php
}


/* ===== SAVE META DATA SAFELY ===== */
function jwem_save_meta($post_id) {

    // 1. Verify nonce
    if (!isset($_POST['jwem_nonce']) || !wp_verify_nonce($_POST['jwem_nonce'], 'jwem_save')) {
        return;
    }

    // 2. Prevent auto-save overwriting data
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // 3. Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // 4. Sanitize and save Event Date
    if (isset($_POST['date'])) {
        $date_sanitized = sanitize_text_field($_POST['date']);
        update_post_meta($post_id, 'date', $date_sanitized);
    }

    // 5. Sanitize and save Location
    if (isset($_POST['loc'])) {
        $loc_sanitized = sanitize_text_field($_POST['loc']);
        update_post_meta($post_id, 'loc', $loc_sanitized);
    }

    // 6. Sanitize and save Organizer
    if (isset($_POST['organizer'])) {
        $organizer_sanitized = sanitize_text_field($_POST['organizer']);
        update_post_meta($post_id, 'organizer', $organizer_sanitized);
    }

    // 7. Sanitize and save RSVP Limit (ensure integer)
    if (isset($_POST['rsvp_limit'])) {
        $rsvp_limit_sanitized = intval($_POST['rsvp_limit']);
        update_post_meta($post_id, 'rsvp_limit', $rsvp_limit_sanitized);
    }

    // 8. Save Email Notification as boolean
    $email_notify = isset($_POST['email_notify']) ? 1 : 0;
    update_post_meta($post_id, 'email_notify', $email_notify);

    // 9. Trigger Email Notification if checked
    if ($email_notify) {
        jwem_send_email_notification($post_id);
    }
}
add_action('save_post', 'jwem_save_meta');
delete_transient('jwem_events_cache');


/* ===== EMAIL NOTIFICATION FUNCTION ===== */
function jwem_send_email_notification($post_id) {
    // Ensure post type
    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'jwem_event') return;

    $subject = sprintf(__('Event Updated: %s', 'jw-event-manager'), $post->post_title);
    $message = sprintf(__('The event "%s" has been published/updated. Check details here: %s', 'jw-event-manager'), $post->post_title, get_permalink($post_id));

    // Send to admin by default (extendable to subscribers)
    wp_mail(get_option('admin_email'), $subject, $message);
}

/* ===== END META ===== */