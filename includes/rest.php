<?php
/* ===== START REST ===== */

add_action('rest_api_init', function () {

    register_rest_route('jwem/v1', '/events', [
        'methods'  => 'GET',

        /* ===== START CALLBACK ===== */
        'callback' => function () {

            return get_posts([
                'post_type'   => 'jwem_event',
                'numberposts' => 5
            ]);

        },
        /* ===== END CALLBACK ===== */


        /* ===== START PERMISSION CALLBACK ===== */
        'permission_callback' => '__return_true'
        /* ===== END PERMISSION CALLBACK ===== */

    ]);

});

/* ===== END REST ===== */