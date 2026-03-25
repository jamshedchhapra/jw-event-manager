<?php
/**
 * Email Notification Handler
 *
 * Purpose:
 * Sends email when an event is published or updated.
 *
 * Hook Used:
 * transition_post_status
 *
 * Security:
 * Only triggers for jwem_event post type.
 */

add_action('transition_post_status','jwem_event_email_notify',10,3);

/**
 * Trigger email notification on publish
 *
 * @param string $new New status
 * @param string $old Old status
 * @param WP_Post $post Post object
 */
function jwem_event_email_notify($new,$old,$post){

    // Run only for event post type
    if($post->post_type!='jwem_event') return;

    // Only run when publishing
    if($new!='publish') return;

    // Check if notification checkbox enabled
    $notify = get_post_meta($post->ID,'email_notify',true);

    if(!$notify) return;

    // Send email to admin
    $admin = get_option('admin_email');

    $subject = 'New Event Published: '.$post->post_title;

    $message = 'Event Published: '.$post->post_title."\n";
    $message .= get_permalink($post->ID);

    wp_mail($admin,$subject,$message);
}
/**
 * Send RSVP Email to User
 */
function jwem_send_rsvp_email($email,$event_id){

$title = get_the_title($event_id);

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