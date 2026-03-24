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

<form id="jwem-rsvp">

<?php wp_nonce_field('jwem_rsvp_action','jwem_nonce'); ?>

<input type="text" name="name" placeholder="Your Name" required>
<input type="email" name="email" placeholder="Your Email" required>

<input type="hidden" name="event_id" value="<?php echo get_the_ID(); ?>">

<button type="submit">Confirm RSVP</button>

</form>

<div id="jwem-msg"></div>

<?php
return ob_get_clean();
}

/**
 * AJAX Hooks
 */
add_action('wp_ajax_jwem_rsvp','jwem_rsvp_save');
add_action('wp_ajax_nopriv_jwem_rsvp','jwem_rsvp_save');

/**
 * Save RSVP Entry
 */
function jwem_rsvp_save(){

// Verify nonce
if(!isset($_POST['jwem_nonce']) || !wp_verify_nonce($_POST['jwem_nonce'],'jwem_rsvp_action')){
    wp_die('Security check failed');
}

// Sanitize inputs
$id = intval($_POST['event_id']);
$name = sanitize_text_field($_POST['name']);
$email = sanitize_email($_POST['email']);

// Validate email
if(!is_email($email)){
    wp_die('Invalid email');
}

/**
 * RSVP LIMIT CHECK
 */
$limit = get_post_meta($id,'rsvp_limit',true);
$list = get_post_meta($id,'attendees',true);

if(!$list) $list = [];

if($limit && count($list) >= $limit){
    wp_die('RSVP limit reached');
}

/**
 * Save RSVP
 */
$list[] = [
'name'=>$name,
'email'=>$email
];

update_post_meta($id,'attendees',$list);

echo 'RSVP Confirmed';

wp_die();
}