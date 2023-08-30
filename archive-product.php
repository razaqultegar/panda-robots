<?php get_header(); ?>

<div id="main-content">
    <div class="container">
        <div id="content-area" class="clearfix">
            <div id="left-area">

                <header class="panda-products-header">
                    <h1>Rekomendasi Untukmu</h1>
                </header>

                <?php
                $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 12,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'ASC',
                );
                $query = new WP_Query($args);

                if ($query->have_posts()) {
                    get_template_part('templates/loop/loop-start');

                    while ($query->have_posts()) {
                        $query->the_post();

                        get_template_part('templates/content', 'product');
                    }

                    get_template_part('templates/loop/loop-end');
                }

                wp_reset_postdata(); ?>

            </div>
        </div>
    </div>
</div>

<?php get_footer();
