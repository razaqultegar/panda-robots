<?php

if (file_exists(get_stylesheet_directory() . '/master/panda-master.php') && !defined('PANDA_PATH')) {
    include_once(get_stylesheet_directory() . '/master/panda-master.php');
}

// Initial Panda SID Themes
function panda_setup()
{
    // Update Divi Options
    et_update_option('divi_fixed_nav', 'off');
    et_update_option('divi_show_twitter_icon', 'off');
    et_update_option('divi_date_format', 'j F Y');
    et_update_option('et_pb_product_tour_global', 'off');
    et_update_option('et_enable_bfb', 'off');
    et_update_option('et_enable_classic_editor', 'on');
    et_update_option('heading_font', 'Montserrat');
    et_update_option('body_font', 'Montserrat');

    // Add Logs
    panda_logs('Inisialisasi tema Panda SID telah berhasil', 'Sistem Operasi: ' . PHP_OS . ', Versi PHP: ' . PHP_VERSION);
}
add_action('after_switch_theme', 'panda_setup');

// Remove Divi Project
function panda_remove_project()
{
    unregister_post_type('project');
    unregister_taxonomy('project_category');
    unregister_taxonomy('project_tag');
}
add_action('init', 'panda_remove_project');

// Gettings CSS and Scripts
function panda_enqueue_scripts()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_script('panda-custom-script', get_stylesheet_directory_uri() . '/scripts.js', array('jquery'), wp_get_theme()->get('Version'), true);
}
add_action('wp_enqueue_scripts', 'panda_enqueue_scripts');

function panda_accent_color()
{
    echo '<style type="text/css">

    /* Background Color */
    #top-header,#page-container span.menu-closed.menu-open:before,#top-menu-nav #top-menu li.current-menu-item>a::before,#top-menu-nav #top-menu li li a:hover:before,.panda-top-button .et_pb_button,.panda-top-button .et_pb_button:hover,.et_pb_button,.feature .et_pb_animation_off,.panda-blog-grid .post-meta a,.panda-category a,.panda-tags a,.et_pb_search_0_tb_body input.et_pb_searchsubmit
    {background-color: ' . esc_attr(panda_get_option('accent_color')) . ' !important;}

    /* Background Color - Link */
    .link-effect a
    {background-image: linear-gradient(to bottom, ' . esc_attr(panda_get_option('accent_color')) . ' 0%, ' . esc_attr(panda_get_option('accent_color')) . ' 98%) !important;}

    /* Background Color - Mark Shy */
    mark-shy-text
    {background-color: ' . esc_attr(panda_get_option('accent_color')) . '1a !important;}

    /* Border Color */
    hr.hr-primary,.et_pb_search_0_tb_body input.et_pb_searchsubmit
    {border-color: ' . esc_attr(panda_get_option('accent_color')) . ' !important;}

    /* Box Shadow */
    .feature:hover .et_pb_animation_off
    {box-shadow: 35px -15px 0px ' . esc_attr(panda_get_option('accent_color')) . '1f, -25px 15px 0px ' . esc_attr(panda_get_option('accent_color')) . '1f !important;}

    /* Color */
    span.site-description,.mobile_menu_bar:before,.mobile_menu_bar:after,#top-menu li.current-menu-ancestor>a,#top-menu li.current-menu-item>a,.text-primary,hr.hr-primary,#page-container span.menu-closed:before,mark-shy-text,.panda-team p, .panda-percent .percent-value,.panda_blurb:hover .et_pb_module_header a,.panda_blurb .et-pb-icon,.panda-blog-grid .et_pb_post:hover .entry-title a,.panda-blog-grid:hover .not-found-title,.panda-blog-list .et_pb_post:hover .entry-title a, .panda-blog-list:hover .not-found-title,.et_pb_post_content_0_tb_body.et_pb_post_content a,.powered-by-panda,#footer-info a
    {color: ' . esc_attr(panda_get_option('accent_color')) . ' !important;}

    </style>';
}
add_action('wp_head', 'panda_accent_color');
