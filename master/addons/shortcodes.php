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

// New Admin Column
function pd_create_shortcode_column($columns)
{
    $columns['pd_shortcode_id'] = 'Module Shortcode';
    return $columns;
}
add_filter('manage_et_pb_layout_posts_columns', 'pd_create_shortcode_column', 5);

// Display Shortcode
function pd_shortcode_content($column, $id)
{
    if ('pd_shortcode_id' == $column) {
?>
        <p>[sj_layout id="<?php echo $id ?>"]</p>
<?php
    }
}
add_action('manage_et_pb_layout_posts_custom_column', 'pd_shortcode_content', 5, 2);

// Create New Shortcode
function pd_shortcode_mod($pd_mod_id)
{
    extract(shortcode_atts(array('id' => '*'), $pd_mod_id));
    return do_shortcode('[et_pb_section global_module="' . $id . '"][/et_pb_section]');
}
add_shortcode('pd_layout', 'pd_shortcode_mod');

function pd_conf_alias()
{
    return get_option('conf_alias');
}
add_shortcode('conf_alias', 'pd_conf_alias');

function pd_blogname()
{
    return get_option('blogname');
}
add_shortcode('blogname', 'pd_blogname');

function pd_blogdescription()
{
    return get_option('blogdescription');
}
add_shortcode('blogdescription', 'pd_blogdescription');

function pd_conf_address()
{
    return get_option('conf_address');
}
add_shortcode('conf_address', 'pd_conf_address');

function pd_admin_email()
{
    return get_option('admin_email');
}
add_shortcode('admin_email', 'pd_admin_email');

function pd_conf_phone()
{
    return get_option('conf_phone');
}
add_shortcode('conf_phone', 'pd_conf_phone');
