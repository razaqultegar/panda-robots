<?php

if (file_exists(get_stylesheet_directory() . '/master/panda-master.php') && !defined('PANDA_PATH')) {
    include_once(get_stylesheet_directory() . '/master/panda-master.php');
}

// Checking if Panda SID themes is activated
function panda_setup()
{
    panda_log('Inisialisasi tema Panda SID telah berhasil', 'Sistem Operasi: ' . PHP_OS . ', Versi PHP: ' . PHP_VERSION);
}
add_action('after_switch_theme', 'panda_setup');

// Gettings CSS
function panda_enqueue_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'panda_enqueue_styles');

// Every Divi Layout as Shortcode with the Below Code
/// New Admin Column
function pd_create_shortcode_column($columns)
{
    $columns['pd_shortcode_id'] = 'Module Shortcode';
    return $columns;
}
add_filter('manage_et_pb_layout_posts_columns', 'pd_create_shortcode_column', 5);

/// Display Shortcode
function pd_shortcode_content($column, $id)
{
    if ('pd_shortcode_id' == $column) {
?>
        <p>[sj_layout id="<?php echo $id ?>"]</p>
<?php
    }
}
add_action('manage_et_pb_layout_posts_custom_column', 'pd_shortcode_content', 5, 2);

/// Create New Shortcode
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
