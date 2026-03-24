<?php

add_action('rest_api_init',function(){

register_rest_route('jwem/v1','events',[
'methods'=>'GET',
'callback'=>function(){

return get_posts([
'post_type'=>'jwem_event',
'numberposts'=>5
]);

}
]);

});