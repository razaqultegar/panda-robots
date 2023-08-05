<?php

/**
 * Panda Master
 *
 * This is the main driver file for panda master.
 *
 * @package    panda-master
 * @author     Puskomedia Indonesia <dev@puskomedia.id>
 * @copyright  2023 Puskomedia Indonesia
 * @license    GPL-2.0+
 **/

if (!defined('ABSPATH')) {
    exit;
}

if (defined('PANDA_PATH')) {
    if (function_exists('panda_logs')) {
        panda_logs('Membatalkan Inisialisasi karena PANDA_PATH sudah ditentukan');
    }

    return;
}

// Define Paths - Includes trailing slash
define('PANDA_PATH', plugin_dir_path(__FILE__));
define('PANDA_URL', panda_get_url());

// Load required dependencies
if (file_exists(PANDA_PATH . 'includes')) {
    foreach (glob(PANDA_PATH . 'includes/*.php') as $required) {
        require_once $required;
    }
}

// Load Panda addons
if (file_exists(PANDA_PATH . 'addons')) {
    foreach (glob(PANDA_PATH . 'addons/*.php') as $addon) {
        require_once $addon;
    }
}

/**
 * Gets the URL to Panda Master folder.
 *
 * Tests if standard WP function works first, then tries an alternate method.
 *
 * @return URL string
 **/
function panda_get_url()
{
    $installer_slug = basename(dirname(__FILE__, 2));

    if (strpos(__FILE__, get_stylesheet_directory()) !== false) {
        $url = get_stylesheet_directory_uri() . '/master/';
    } else {
        $url = plugins_url() . '/' . $installer_slug . '/master/';
    }

    return $url;
}

// Load Panda Robot menu
$panda_robots = new Panda_Robots();

// Disables Gutenberg.
add_filter('gutenberg_use_widgets_block_editor', '__return_false');
add_filter('use_widgets_block_editor', '__return_false');
add_filter('use_block_editor_for_post', '__return_false');
add_filter('use_widgets_block_editor', '__return_false');
add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('global-styles');
}, 20);
