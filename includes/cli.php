<?php
/* ===== START CLI ===== */
if(defined('WP_CLI') && WP_CLI){

class JWEM_CLI{

function seed(){

for($i=1;$i<=5;$i++){

wp_insert_post([
'post_title'=>"CLI Event $i",
'post_type'=>'jwem_event',
'post_status'=>'publish'
]);
}

WP_CLI::success("Events Seeded");

}

}

WP_CLI::add_command('jwem','JWEM_CLI');

}

/* ===== END CLI ===== */