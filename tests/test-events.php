<?php
/**
 * ==========================================
 * UNIT TEST: EVENT CREATION
 * ==========================================
 */
class Test_Events extends WP_UnitTestCase{

function test_event_creation(){

$post_id = $this->factory->post->create([
'post_type'=>'jwem_event'
]);

$this->assertTrue($post_id>0);

}

}