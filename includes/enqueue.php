<?php
/**
 * ==========================================
 * JWEM FRONTEND ASSETS (FIXED VERSION)
 * ==========================================
 *
 * Fix:
 * - Moved script enqueue INSIDE function
 * - Ensures WordPress hook compliance
 * - Removes fatal notice
 */

/**
 * Hook into frontend asset loading
 */
add_action('wp_enqueue_scripts','jwem_frontend_assets');

function jwem_frontend_assets(){

    /**
     * ==========================
     * LOAD BOOTSTRAP CSS
     * ==========================
     */
    wp_enqueue_style(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'
    );

    /**
     * ==========================
     * LOAD PLUGIN CSS
     * ==========================
     */
    wp_enqueue_style(
        'jwem-css',
        JWEM_URL.'assets/frontend.css'
    );

    /**
     * ==========================
     * LOAD RSVP JS (FIXED)
     * ==========================
     */
    wp_enqueue_script(
        'jwem-js',
        JWEM_URL.'assets/rsvp.js',
        ['jquery'],
        filemtime(JWEM_PATH . 'assets/rsvp.js'),
        true
    );

    /**
     * ==========================
     * PASS AJAX DATA TO JS
     * ==========================
     */
    wp_localize_script('jwem-js','jwem',[
    'ajax' => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('jwem_rsvp_action')
]);

}
