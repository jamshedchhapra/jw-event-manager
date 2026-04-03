<?php
/**
 * RSVP frontend system.
 */

add_shortcode('jwem_rsvp','jwem_rsvp_form');

function jwem_rsvp_form(){

ob_start();
?>

<form id="jwem-rsvp-form">

<?php wp_nonce_field('jwem_rsvp_action','jwem_nonce'); ?>

<input type="text" name="name" placeholder="<?php _e('Your Name','jw-event-manager'); ?>" required>

<input type="email" name="email" placeholder="<?php _e('Your Email','jw-event-manager'); ?>" required>

<input type="hidden" name="event_id" value="<?php echo esc_attr(get_the_ID()); ?>">

<button type="submit"><?php _e('Confirm RSVP','jw-event-manager'); ?></button>

</form>

<div id="jwem-msg"></div>

<?php
return ob_get_clean();

}

/** Register RSVP AJAX handlers. */
add_action('wp_ajax_jwem_rsvp','jwem_rsvp_save');
add_action('wp_ajax_nopriv_jwem_rsvp','jwem_rsvp_save');

/**
 * Validate and store an RSVP submission.
 */
function jwem_rsvp_save(){

/* Validate the AJAX nonce before processing the request. */
if(!isset($_POST['jwem_nonce']) ||
!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['jwem_nonce'])),'jwem_rsvp_action')){
echo esc_html__('Security failed','jw-event-manager');
wp_die();
}

$id = isset($_POST['event_id']) ? absint(wp_unslash($_POST['event_id'])) : 0;

/* Ensure the RSVP targets a valid event post. */
if(get_post_type($id) !== 'jwem_event'){
echo esc_html__('Invalid Event','jw-event-manager');
wp_die();
}

$name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
$email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';

if(!is_email($email)){
echo esc_html__('Invalid Email','jw-event-manager');
wp_die();
}

/* Load current RSVP capacity and attendee list. */
$limit = intval(get_post_meta($id,'rsvp_limit',true));
$list = get_post_meta($id,'attendees',true);

/* Normalize attendees so later checks are safe. */
if(!is_array($list)) $list = [];

/* Block submissions when the event has reached capacity. */
if($limit && count($list) >= $limit){
echo esc_html__('RSVP Limit Reached','jw-event-manager');
wp_die();
}

/* Prevent duplicate RSVP submissions for the same email. */
foreach($list as $attendee){

if($attendee['email'] === $email){
echo esc_html__('You already RSVP’d','jw-event-manager');
wp_die();
}

}

/* Store the attendee after validation passes. */
$list[] = [
'name'  => $name,
'email' => $email
];

update_post_meta($id,'attendees',$list);

/* Calculate remaining seats for the success response. */
$remaining = $limit ? (string) ($limit - count($list)) : __('Unlimited','jw-event-manager');

/* Send the confirmation email after saving. */
jwem_send_rsvp_email($email,$id);

/* Return a user-facing success message. */
printf(
    '<span class="jwem-success">%1$s - %2$s %3$s</span>',
    esc_html__('RSVP Confirmed ✅','jw-event-manager'),
    esc_html($remaining),
    esc_html__('seats left', 'jw-event-manager')
);

wp_die();

}
