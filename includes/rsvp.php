<?php
/**
 * RSVP Frontend System
 *
 * Enhanced Version:
 * - Nonce security added
 * - Input validation
 * - RSVP limit check
 */

add_shortcode('jwem_rsvp','jwem_rsvp_form');

function jwem_rsvp_form(){

ob_start();
?>

<form id="jwem-rsvp-form">

<?php wp_nonce_field('jwem_rsvp_action','jwem_nonce'); ?>

<input type="text" name="name" placeholder="<?php _e('Your Name','jw-event-manager'); ?>" required>

<input type="email" name="email" placeholder="<?php _e('Your Email','jw-event-manager'); ?>" required>

<input type="hidden" name="event_id" value="<?php echo get_the_ID(); ?>">

<button type="submit"><?php _e('Confirm RSVP','jw-event-manager'); ?></button>

</form>

<div id="jwem-msg"></div>

<?php
return ob_get_clean();

}

/* AJAX */
add_action('wp_ajax_jwem_rsvp','jwem_rsvp_save');
add_action('wp_ajax_nopriv_jwem_rsvp','jwem_rsvp_save');

function jwem_rsvp_save(){

/* ===== NONCE SECURITY ===== */
if(!isset($_POST['jwem_nonce']) ||
!wp_verify_nonce($_POST['jwem_nonce'],'jwem_rsvp_action')){
echo __('Security failed','jw-event-manager');
wp_die();
}

$id = intval($_POST['event_id']);

/* ===== EVENT VALIDATION ===== */
if(get_post_type($id) !== 'jwem_event'){
echo __('Invalid Event','jw-event-manager');
wp_die();
}

$name = sanitize_text_field($_POST['name']);
$email = sanitize_email($_POST['email']);

if(!is_email($email)){
echo __('Invalid Email','jw-event-manager');
wp_die();
}

/* ===== LIMIT + LIST FETCH ===== */
$limit = intval(get_post_meta($id,'rsvp_limit',true));
$list = get_post_meta($id,'attendees',true);

/* Ensure array safety */
if(!is_array($list)) $list = [];

/* LIMIT CHECK */
if($limit && count($list) >= $limit){
echo __('RSVP Limit Reached','jw-event-manager');
wp_die();
}

/* DUPLICATE CHECK */
foreach($list as $attendee){

if($attendee['email'] === $email){
echo __('You already RSVP’d','jw-event-manager');
wp_die();
}

}

/* SAVE RSVP */
$list[] = [
'name'  => $name,
'email' => $email
];

update_post_meta($id,'attendees',$list);

/* ===== REMAINING SEATS CALCULATION (AFTER SAVE) ===== */
$remaining = $limit ? ($limit - count($list)) : __('Unlimited','jw-event-manager');

/* SEND USER EMAIL */
jwem_send_rsvp_email($email,$id);

/* SUCCESS MESSAGE */
echo '<span class="jwem-success">'.__('RSVP Confirmed ✅','jw-event-manager').' - '.$remaining.' seats left</span>';

wp_die();

}
