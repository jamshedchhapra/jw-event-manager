<?php

add_action('wp_enqueue_scripts','jwem_frontend_assets');

function jwem_frontend_assets(){

wp_enqueue_style(
'bootstrap',
'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'
);

wp_enqueue_style(
'jwem-css',
JWEM_URL.'assets/frontend.css'
);

}
wp_enqueue_script(
'jwem-js',
JWEM_URL.'assets/rsvp.js',
['jquery'],
null,
true
);

wp_localize_script('jwem-js','jwem',[
'ajax'=>admin_url('admin-ajax.php')
]);