<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />
        <?php
        elegant_description();
        elegant_keywords();
        elegant_canonical();

        /**
         * Fires in the head, before {@see wp_head()} is called. This action can be used to
         * insert elements into the beginning of the head before any styles or scripts.
         *
         * @since 1.0
         */
        do_action('et_head_meta');

        $template_directory_uri = get_template_directory_uri();
        ?>
        <title><?php wp_title('-', true, 'right'); ?><?php echo (!empty(panda_get_option('alias')) ? panda_get_option('alias') : 'Desa') . ' ' . get_bloginfo('name') . ' | Kab. ' . get_bloginfo('description'); ?></title>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <script type="text/javascript">
            document.documentElement.className = 'js';
        </script>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <?php
        wp_body_open();

        $product_tour_enabled = et_builder_is_product_tour_enabled();
        $page_container_style = $product_tour_enabled ? ' style="padding-top: 0px;"' : '';
        ?>
        <div id="page-container" <?php echo et_core_intentionally_unescaped($page_container_style, 'fixed_string'); ?>>
            <?php
            if ($product_tour_enabled || is_page_template('page-template-blank.php')) {
                return;
            }

            ob_start();
            ?>
            <div id="top-header">
                <div class="flex container clearfix">
                    <div id="et-info">
                        <?php if (!empty(panda_get_option('phone'))) : ?>
                        <div class="panda-blurb">
                            <div class="panda-blurb-content">
                                <div class="panda-blurb-image">
                                    <span class="panda-image-wrap">
                                        <span id="et-info-phone"></span>
                                    </span>
                                </div>
                                <div class="panda-blurb-container">
                                    <h4>
                                        <span><?php echo panda_get_option('phone'); ?></span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty(get_option('admin_email'))) : ?>
                        <div class="panda-blurb">
                            <div class="panda-blurb-content">
                                <div class="panda-blurb-image">
                                    <span class="panda-image-wrap">
                                        <span id="et-info-email"></span>
                                    </span>
                                </div>
                                <div class="panda-blurb-container">
                                    <h4>
                                        <span><?php echo get_bloginfo('admin_email'); ?></span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div id="et-social">
                        <?php get_template_part('includes/social_icons', 'header'); ?>
                    </div>
                </div>
            </div>
            <?php
            $top_header = ob_get_clean();

            /**
             * Filters the HTML output for the top header.
             *
             * @since 3.10
             *
             * @param string $top_header
             */
            echo et_core_intentionally_unescaped(apply_filters('et_html_top_header', $top_header), 'html');

            ob_start();
            ?>
            <header id="main-header" data-height-onload="<?php echo esc_attr(et_get_option('menu_height', '66')); ?>">
                <div class="container clearfix et_menu_container">
                    <?php
                    $logo = ($user_logo = et_get_option('divi_logo')) && !empty($user_logo)
                        ? $user_logo
                        : $template_directory_uri . '/images/logo.png';

                    // Get logo image size based on attachment URL.
                    $logo_size   = et_get_attachment_size_by_url($logo);
                    $logo_width  = (!empty($logo_size) && is_numeric($logo_size[0]))
                        ? $logo_size[0]
                        : '93'; // 93 is the width of the default logo.
                    $logo_height = (!empty($logo_size) && is_numeric($logo_size[1]))
                        ? $logo_size[1]
                        : '43'; // 43 is the height of the default logo.

                    ob_start();
                    ?>
                    <div class="logo_container">
                        <span class="logo_helper"></span>
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <img src="<?php echo esc_attr($logo); ?>" width="<?php echo esc_attr($logo_width); ?>" height="<?php echo esc_attr($logo_height); ?>" alt="<?php echo get_bloginfo('name'); ?>" id="logo" data-height-percentage="<?php echo esc_attr(et_get_option('logo_height', '54')); ?>" />
                        </a>
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <div class="site_info">
                                <span class="site-name"><?php echo get_bloginfo('name'); ?></span>
                                <span class="site-description">Kab. <?php echo get_bloginfo('description'); ?></span>
                            </div>
                        </a>
                    </div>
                    <?php
                    $logo_container = ob_get_clean();

                    /**
                     * Filters the HTML output for the logo container.
                     *
                     * @since 3.10
                     *
                     * @param string $logo_container
                     */
                    echo et_core_intentionally_unescaped(apply_filters('et_html_logo_container', $logo_container), 'html');
                    ?>
                    <div id="et-top-navigation" data-height="<?php echo esc_attr(et_get_option('menu_height', '66')); ?>" data-fixed-height="<?php echo esc_attr(et_get_option('minimized_menu_height', '40')); ?>">
                        <nav id="top-menu-nav">
                            <?php
                            $menuClass = 'nav';
                            if ('on' === et_get_option('divi_disable_toptier')) $menuClass .= ' et_disable_top_tier';
                            $primaryNav = '';

                            $primaryNav = wp_nav_menu(array('theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => 'top-menu', 'echo' => false));
                            if (empty($primaryNav)) :
                            ?>
                            <ul id="top-menu" class="<?php echo esc_attr($menuClass); ?>">
                                <?php if ('on' === et_get_option('divi_home_link')) { ?>
                                    <li <?php if (is_home()) echo ('class="current_page_item"'); ?>><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'Divi'); ?></a></li>
                                <?php }; ?>

                                <?php show_page_menu($menuClass, false, false); ?>
                                <?php show_categories_menu($menuClass, false); ?>
                            </ul>
                            <?php
                            else :
                                echo et_core_esc_wp($primaryNav);
                            endif;
                            ?>
                        </nav>

                        <div class="panda-top-button">
                            <a href="javascript:void(0)" class="et_pb_button molti-custom-menu">Layanan Online</a>
					    </div>

                        <?php
                        /**
                         * Fires at the end of the 'et-top-navigation' element, just before its closing tag.
                         *
                         * @since 1.0
                         */
                        do_action('et_header_top');
                        ?>
                    </div> <!-- #et-top-navigation -->
                </div> <!-- .container -->
            </header> <!-- #main-header -->
            <?php
            $main_header = ob_get_clean();

            /**
             * Filters the HTML output for the main header.
             *
             * @since 3.10
             *
             * @param string $main_header
             */
            echo et_core_intentionally_unescaped(apply_filters('et_html_main_header', $main_header), 'html');
            ?>
            <div id="et-main-area">
                <?php
                /**
                 * Fires after the header, before the main content is output.
                 *
                 * @since 3.10
                 */
                do_action('et_before_main_content');
