<?php
add_action('restrict_manage_posts',function(){

global $typenow;

if($typenow!='jwem_event') return;

echo '<input type="text" name="event_filter" placeholder="Search Event">';

});