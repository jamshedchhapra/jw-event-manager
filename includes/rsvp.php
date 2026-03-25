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

<script>
jQuery('#jwem-rsvp-form').on('submit',function(e){

e.preventDefault();

let form = jQuery(this);

jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>',
form.serialize() + '&action=jwem_rsvp',
function(res){

jQuery('#jwem-msg').html(res);

if(res.includes('RSVP Confirmed')){

form.find('input,button').prop('disabled',true);
form[0].reset();

}

});

});
</script>

<?php
return ob_get_clean();

}

/* AJAX */
add_action('wp_ajax_jwem_rsvp','jwem_rsvp_save');
add_action('wp_ajax_nopriv_jwem_rsvp','jwem_rsvp_save');

function jwem_rsvp_save(){

if(!isset($_POST['jwem_nonce']) ||
!wp_verify_nonce($_POST['jwem_nonce'],'jwem_rsvp_action')){
echo __('Security failed','jw-event-manager');
wp_die();
}

$id = intval($_POST['event_id']);
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

/* LIMIT */
$limit = intval(get_post_meta($id,'rsvp_limit',true));
$list = get_post_meta($id,'attendees',true);

if(!$list) $list=[];

if($limit && count($list)>=$limit){
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

/* SAVE */
$list[]=[
'name'=>$name,
'email'=>$email
];

update_post_meta($id,'attendees',$list);

/* SEND USER EMAIL */
jwem_send_rsvp_email($email,$id);

echo '<span class="jwem-success">'.__('RSVP Confirmed ✅','jw-event-manager').'</span>';

wp_die();

}