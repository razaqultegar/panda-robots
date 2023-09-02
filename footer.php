<?php
            /**
             * Fires after the main content, before the footer is output.
             *
             * @since 3.10
             */
            do_action('et_after_main_content');

            if ('on' === et_get_option('divi_back_to_top', 'false')) : ?>
                <span class="et_pb_scroll_top et-pb-icon"></span>
            <?php endif;

            if (!is_page_template('page-template-blank.php')) : ?>
                <footer id="main-footer">
                    <?php get_sidebar( 'footer' ); ?>
                    <div id="footer-bottom">
                        <div class="container clearfix">
                            <div id="footer-info">&copy; <?php echo date('Y'); ?> Pemerintah <?php echo (!empty(panda_get_option('alias')) ? panda_get_option('alias') : 'Desa') . ' ' . get_option('blogname'); ?> <span class="powered-by-panda">Menggunakan <a href="https://www.panda.id/">Teknologi Panda</a></span></div>
                            <?php
                            get_template_part('includes/social_icons', 'footer');
                            
                            if (has_nav_menu('footer-menu')) : ?>
                            <div id="et-footer-nav">
                                <?php
                                wp_nav_menu(array(
                                    'theme_location' => 'footer-menu',
                                    'depth'          => '1',
                                    'menu_class'     => 'bottom-nav',
                                    'container'      => '',
                                    'fallback_cb'    => '',
                                ));
                                ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </footer>
            </div>
            <?php endif; ?>
        </div>
    <?php wp_footer(); ?>
    </body>
</html>
