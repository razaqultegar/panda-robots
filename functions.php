<?php

// Initial Panda SID Themes
function panda_setup()
{
    // Update Divi Options
    et_update_option('divi_fixed_nav', 'off');
    et_update_option('divi_show_twitter_icon', 'off');
    et_update_option('divi_show_rss_icon', 'off');
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
    // Divi
    unregister_post_type('project');
    unregister_taxonomy('project_category');
    unregister_taxonomy('project_tag');

    // Advanced iFrame
    unregister_post_type('ai_content_page');

    // WordPress
    add_filter('gutenberg_use_widgets_block_editor', '__return_false');
    add_filter('use_widgets_block_editor', '__return_false');
    add_filter('use_block_editor_for_post', '__return_false');
    add_filter('use_widgets_block_editor', '__return_false');
}
add_action('init', 'panda_remove_project');

// Gettings CSS and Scripts
function panda_enqueue_scripts()
{
    $version = wp_get_theme()->get('Version');

    // Parent
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_script('panda-custom-script', get_stylesheet_directory_uri() . '/scripts.js', array('jquery'), $version, true);

    // Single Product
    if (is_product()) {
        wp_enqueue_script(
            'flexslider',
            get_stylesheet_directory_uri() . '/assets/vendor/flexslider/jquery.flexslider.min.js',
            array('jquery'),
            $version,
            true
        );

        wp_enqueue_script('photoswipe', get_stylesheet_directory_uri() . '/assets/vendor/photoswipe/photoswipe.min.js', array(), $version, true);
        wp_enqueue_script('photoswipe-ui-default', get_stylesheet_directory_uri() . '/assets/vendor/photoswipe/photoswipe-ui-default.min.js', array('photoswipe'), $version, true);
        wp_enqueue_style('photoswipe', get_stylesheet_directory_uri() . '/assets/vendor/photoswipe/photoswipe.min.css', array(), $version);
        wp_enqueue_style('photoswipe-default-skin', get_stylesheet_directory_uri() . '/assets/vendor/photoswipe/default-skin/default-skin.min.css', array(), $version);

        wp_enqueue_script(
            'panda-single-product',
            get_stylesheet_directory_uri() . '/assets/js/single-product.js',
            array('jquery'),
            $version,
            true
        );
        wp_enqueue_script(
            'zoom',
            get_stylesheet_directory_uri() . '/assets/vendor/zoom/jquery.zoom.min.js',
            array('jquery'),
            $version,
            true
        );
        add_action('wp_footer', 'panda_photoswipe');

        wp_localize_script(
            'panda-single-product',
            'panda_single_product_params',
            array(
                'flexslider' => array(
                    'animation' => 'slide',
                    'smoothHeight' => true,
                    'directionNav' => false,
                    'controlNav' => 'thumbnails',
                    'slideshow' => false,
                    'animationSpeed' => 500,
                    'animationLoop' => false, // Breaks photoswipe pagination if true.
                    'allowOneSlide' => false,
                ),
                'zoom_enabled' => true,
                'zoom_options' => array(),
                'photoswipe_enabled' => true,
                'photoswipe_options' => array(
                    'shareEl' => false,
                    'closeOnScroll' => false,
                    'history' => false,
                    'hideAnimationDuration' => 0,
                    'showAnimationDuration' => 0,
                ),
                'flexslider_enabled' => true,
            )
        );

        // WordPress
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('global-styles');
    }
}
add_action('wp_enqueue_scripts', 'panda_enqueue_scripts');

function panda_accent_color()
{
    echo '<style type="text/css">

    /* Background Color */
    #top-header,#page-container span.menu-closed.menu-open:before,#top-menu-nav #top-menu li.current-menu-item>a::before,#top-menu-nav #top-menu li li a:hover:before,.panda-top-button .et_pb_button,.panda-top-button .et_pb_button:hover,.et_pb_button,.feature .et_pb_animation_off,.panda-blog-grid .post-meta a,.panda-category a,.panda-tags a,.et_pb_search_0_tb_body input.et_pb_searchsubmit,.single-product #product_checkout .product_checkout-button
    {background-color: ' . esc_attr(panda_get_option('accent_color')) . ' !important;}

    /* Background Color - Link */
    .link-effect a
    {background-image: linear-gradient(to bottom, ' . esc_attr(panda_get_option('accent_color')) . ' 0%, ' . esc_attr(panda_get_option('accent_color')) . ' 98%) !important;}

    /* Background Color - Mark Shy */
    mark-shy-text,.post-type-archive-product .product .product-content_price .onsale div:nth-child(1),.single-product #product_header .product-header_price .onsale div:nth-child(1)
    {background-color: ' . esc_attr(panda_get_option('accent_color')) . '1a !important;}

    /* Border Color */
    hr.hr-primary,.et_pb_search_0_tb_body input.et_pb_searchsubmit,.single-product .product .panda-product-gallery > ol li:has(img.flex-active),.single-product #product_checkout .product_checkout-input textarea:focus
    {border-color: ' . esc_attr(panda_get_option('accent_color')) . ' !important;}

    /* Box Shadow */
    .feature:hover .et_pb_animation_off
    {box-shadow: 35px -15px 0px ' . esc_attr(panda_get_option('accent_color')) . '1f, -25px 15px 0px ' . esc_attr(panda_get_option('accent_color')) . '1f !important;}

    /* Color */
    span.site-description,.mobile_menu_bar:before,.mobile_menu_bar:after,#top-menu li.current-menu-ancestor>a,#top-menu li.current-menu-item>a,.text-primary,hr.hr-primary,#page-container span.menu-closed:before,.link-effect a,mark-shy-text,.panda-team p, .panda-percent .percent-value,.et_clickable:hover .et_pb_module_header span,.panda_blurb:hover .et_pb_module_header a,.panda_blurb .et-pb-icon,.panda-blog-grid .et_pb_post:hover .entry-title a,.panda-blog-grid:hover .not-found-title,.panda-blog-list .et_pb_post:hover .entry-title a, .panda-blog-list:hover .not-found-title,.et_pb_post_content_0_tb_body.et_pb_post_content a,.panda-accordion .et_pb_toggle_title:before,.panda-dak-menu ul li.current-menu-item a,.post-type-archive-product .product .product-content_price .onsale div:nth-child(1),.post-type-archive-product .product .product-content_price,.single-product #product_header .product-header_price .onsale div:nth-child(1),.single-product #product_content .product-content_more,.powered-by-panda,#footer-info a,#et-footer-nav .bottom-nav li.current-menu-item a
    {color: ' . esc_attr(panda_get_option('accent_color')) . ' !important;}

    </style>';
}
add_action('wp_head', 'panda_accent_color');

global $panda_store_options_in_one_row;
$panda_store_options_in_one_row = true;
$panda_path = get_stylesheet_directory();

// Load required dependencies
require_once $panda_path . '/includes/class-panda-imports.php';
require_once $panda_path . '/includes/class-panda-products.php';
require_once $panda_path . '/includes/class-panda-robots.php';
require_once $panda_path . '/includes/class-tgm-plugin-activation.php';
require_once $panda_path . '/includes/panda-common-functions.php';

// Load Panda addons
require_once $panda_path . '/addons/admin.php';
require_once $panda_path . '/addons/metaboxes.php';
require_once $panda_path . '/addons/plugins.php';
require_once $panda_path . '/addons/products.php';
require_once $panda_path . '/addons/shortcodes.php';
require_once $panda_path . '/addons/themes.php';

// Load Panda Robot menu
$panda_robots = new Panda_Robots();
