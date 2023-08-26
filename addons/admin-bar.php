<?php

/**
 * Panda Admin Bar
 *
 * This functions builds for the modify WP Admin bar.
 *
 * @package    panda-addons
 * @author     Puskomedia Indonesia <dev@puskomedia.id>
 * @copyright  2023 Puskomedia Indonesia
 * @license    GPL-2.0+
 **/

if (!defined('ABSPATH')) {
    exit;
}

// Modifies the Site name menu
function panda_site_menu()
{
    global $wp_admin_bar;

    $blogname = (!empty(panda_get_option('alias')) ? panda_get_option('alias') : 'Desa') . ' ' . get_bloginfo('name');

    if (!$blogname) {
        $blogname = preg_replace('#^(https?://)?(www.)?#', '', get_home_url());
    }

    $title = wp_html_excerpt($blogname, 40, '&hellip;');

    $wp_admin_bar->add_node(
        array(
            'id'    => 'site-name',
            'title' => $title,
            'href'  => home_url('/'),
        )
    );
}
add_action('wp_before_admin_bar_render', 'panda_site_menu', 999);
