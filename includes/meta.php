<?php
/* ===== START META ===== */

/**
 * Register Meta Box
 */
function jwem_meta_box(){

    add_meta_box(
        'jwem_details',
        'Event Details',
        'jwem_meta_html',
        'jwem_event'
    );

}
add_action('add_meta_boxes','jwem_meta_box');


/**
 * Meta Box HTML
 */
function jwem_meta_html($post){

    wp_nonce_field('jwem_save','jwem_nonce');

    // Existing fields
    $date = get_post_meta($post->ID,'date',true);
    $loc  = get_post_meta($post->ID,'loc',true);

    // NEW fields
    $organizer   = get_post_meta($post->ID,'organizer',true);
    $rsvp_limit  = get_post_meta($post->ID,'rsvp_limit',true);
    $email_notify = get_post_meta($post->ID,'email_notify',true);

    ?>

    <p>
        <label><strong>Event Date</strong></label><br>
        <input type="date" name="date" value="<?php echo esc_attr($date); ?>">
    </p>

    <p>
        <label><strong>Location</strong></label><br>
        <input type="text" name="loc" value="<?php echo esc_attr($loc); ?>" style="width:100%;">
    </p>

    <hr>

    <p>
        <label><strong>Organizer</strong></label><br>
        <input type="text" name="organizer" value="<?php echo esc_attr($organizer); ?>" style="width:100%;">
    </p>

    <p>
        <label><strong>RSVP Limit</strong></label><br>
        <input type="number" name="rsvp_limit" value="<?php echo esc_attr($rsvp_limit); ?>" style="width:100%;">
    </p>

    <p>
        <label>
            <input type="checkbox" name="email_notify" value="1" <?php checked($email_notify,1); ?>>
            Send Email Notification on Publish/Update
        </label>
    </p>

    <?php
}


/**
 * Save Meta Data
 */
function jwem_save_meta($id){

    if(!isset($_POST['jwem_nonce'])) return;
    if(!wp_verify_nonce($_POST['jwem_nonce'],'jwem_save')) return;

    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Existing fields
    if(isset($_POST['date'])){
        update_post_meta($id,'date',sanitize_text_field($_POST['date']));
    }

    if(isset($_POST['loc'])){
        update_post_meta($id,'loc',sanitize_text_field($_POST['loc']));
    }

    // NEW fields
    if(isset($_POST['organizer'])){
        update_post_meta($id,'organizer',sanitize_text_field($_POST['organizer']));
    }

    if(isset($_POST['rsvp_limit'])){
        update_post_meta($id,'rsvp_limit',intval($_POST['rsvp_limit']));
    }

    $email_notify = isset($_POST['email_notify']) ? 1 : 0;
    update_post_meta($id,'email_notify',$email_notify);

}
add_action('save_post','jwem_save_meta');

/* ===== END META ===== */