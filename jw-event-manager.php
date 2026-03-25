<?php
/**
 * Plugin Name: JW Event Manager
 * Description: Event Management Plugin built for technical audition.
 * Version: 1.0.1
 * Author: Jamshed Chhapra
 * Text Domain: jw-event-manager
 */

if (!defined('ABSPATH')) exit;

/* ===== START CONSTANTS ===== */
define('JWEM_PATH', plugin_dir_path(__FILE__));
define('JWEM_URL', plugin_dir_url(__FILE__));
/* ===== END CONSTANTS ===== */


/* ===== START LOCALIZATION ===== */

/**
 * Load Plugin Translation Files
 */
function jwem_load_textdomain(){

    load_plugin_textdomain(
        'jw-event-manager',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages/'
    );

}
add_action('plugins_loaded','jwem_load_textdomain');

/* ===== END LOCALIZATION ===== */

/* ===== SAFE FILE LOADER  ===== */

$jwem_files = [

'cpt.php',
'taxonomy.php',
'meta.php',
'columns.php',
'shortcode.php',
'filter.php',
'rsvp.php',
'rest.php',
'cli.php',
'templates.php',
'enqueue.php',
'cache.php',
'email.php',
'performance.php'

];

foreach ($jwem_files as $file) {

    $path = JWEM_PATH . 'includes/' . $file;

    if (file_exists($path)) {

        require_once $path;

    }

}