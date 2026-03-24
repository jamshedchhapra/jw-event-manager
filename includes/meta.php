<?php
/* ===== START META ===== */

function jwem_meta_box(){

add_meta_box(
'jwem_details',
'Event Details',
'jwem_meta_html',
'jwem_event'
);

}

add_action('add_meta_boxes','jwem_meta_box');


function jwem_meta_html($post){

wp_nonce_field('jwem_save','jwem_nonce');

$date=get_post_meta($post->ID,'date',true);
$loc=get_post_meta($post->ID,'loc',true);

echo 'Date <input type="date" name="date" value="'.esc_attr($date).'"><br>';
echo 'Location <input type="text" name="loc" value="'.esc_attr($loc).'">';

}


function jwem_save_meta($id){

if(!isset($_POST['jwem_nonce'])) return;

if(!wp_verify_nonce($_POST['jwem_nonce'],'jwem_save')) return;

update_post_meta($id,'date',sanitize_text_field($_POST['date']));
update_post_meta($id,'loc',sanitize_text_field($_POST['loc']));

}

add_action('save_post','jwem_save_meta');

/* ===== END META ===== */