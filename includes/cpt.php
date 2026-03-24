<?php
/* ===== START CPT ===== */

function jwem_register_event(){

register_post_type('jwem_event',[
'label'=>__('Events','jw-event-manager'),
'public'=>true,
'has_archive'=>true,
'show_in_rest'=>true,
'supports'=>['title','editor','thumbnail']
]);

}

add_action('init','jwem_register_event');

/* ===== END CPT ===== */