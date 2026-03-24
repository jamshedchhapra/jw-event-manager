<?php
/**
 * ==========================================
 * UNIT TEST: CUSTOM POST TYPE
 * ==========================================
 */

class Test_JWEM_CPT extends WP_UnitTestCase {

    /**
     * Check if CPT exists
     */
    function test_post_type_exists(){

        $this->assertTrue(
            post_type_exists('jwem_event')
        );

    }

}