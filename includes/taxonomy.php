<?php
/* ===== START TAXONOMY ===== */

function jwem_tax(){

register_taxonomy(
'event_type',
'jwem_event',
[
'label'=>__('Event Type','jw-event-manager'),
'hierarchical'=>true,
'show_in_rest'=>true
]
);

}

add_action('init','jwem_tax');

/* ===== END TAXONOMY ===== */