<?php
/* Template Name: Toko */

get_header();

$post_id              = get_the_ID();
$is_page_builder_used = et_pb_is_pagebuilder_used($post_id);
?>

<div id="main-content">

    <?php if (!$is_page_builder_used) : ?>

        <div class="container">
            <div id="content-area" class="clearfix">
                <div id="left-area">

                <?php
            endif;

            get_template_part('templates/loop/result-count');

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

            wp_reset_postdata();

            if (!$is_page_builder_used) : ?>

                </div>
            </div>
        </div>

    <?php endif; ?>

</div>

<?php

get_footer();
