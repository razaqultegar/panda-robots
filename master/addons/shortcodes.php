<?php

/**
 * Panda Shortcodes
 *
 * This class builds the WP Admin menu items and pages.
 *
 * @package    panda-addons
 * @author     Puskomedia Indonesia <dev@puskomedia.id>
 * @copyright  2023 Puskomedia Indonesia
 * @license    GPL-2.0+
 **/

if (!defined('ABSPATH')) {
    exit;
}

// Create New Shortcode
function pd_primary_color()
{
    return get_option('primary_color');
}
add_shortcode('primary_color', 'pd_primary_color');

function pd_conf_alias()
{
    return get_option('conf_alias');
}
add_shortcode('conf_alias', 'pd_conf_alias');

function pd_conf_address()
{
    return get_option('conf_address');
}
add_shortcode('conf_address', 'pd_conf_address');

function pd_conf_phone()
{
    return get_option('conf_phone');
}
add_shortcode('conf_phone', 'pd_conf_phone');
