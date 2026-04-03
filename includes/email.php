<?php
/**
 * Event email notification helpers.
 */

add_action('transition_post_status','jwem_event_email_notify',10,3);

/**
 * Trigger the admin email when an event is published.
 *
 * @param string  $new  New post status.
 * @param string  $old  Previous post status.
 * @param WP_Post $post Post object.
 */
function jwem_event_email_notify($new,$old,$post){

    // Run only for event post type
    if(!($post instanceof WP_Post) || $post->post_type !== 'jwem_event') return;

    // Only run when publishing
    if($new !== 'publish') return;

    // Check if notification checkbox enabled
    $notify = get_post_meta($post->ID,'email_notify',true);

    if(!$notify) return;

    // Send email to admin
    $admin = get_option('admin_email');

    $subject = sprintf(__('New Event Published: %s', 'jw-event-manager'), wp_strip_all_tags($post->post_title));

    $message = sprintf(
        "%s\n%s",
        sprintf(__('Event Published: %s', 'jw-event-manager'), wp_strip_all_tags($post->post_title)),
        esc_url_raw(get_permalink($post->ID))
    );

    wp_mail($admin,$subject,$message);
}
/**
 * Send the RSVP confirmation email to the attendee.
 */
function jwem_send_rsvp_email($email,$event_id){

$title = wp_strip_all_tags(get_the_title($event_id));

$message = sprintf(
__('Your RSVP for "%s" is confirmed. We look forward to seeing you!','jw-event-manager'),
$title
);

wp_mail(
$email,
__('RSVP Confirmation','jw-event-manager'),
$message
);

}
