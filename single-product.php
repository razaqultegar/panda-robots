<?php get_header(); ?>

<div id="main-content">
    <div class="container">
        <div id="content-area" class="clearfix">
            <div id="left-area">

                <?php
                while (have_posts()) :
                    the_post();

                    get_template_part('templates/content-single', 'product');
                endwhile;
                ?>

            </div>
        </div>
    </div>
</div>

<?php get_footer();
