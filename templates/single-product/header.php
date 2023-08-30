<?php

/**
 * Single Product Header
 *
 * @package    panda-templates
 * @author     Puskomedia Indonesia <dev@puskomedia.id>
 * @copyright  2023 Puskomedia Indonesia
 * @license    GPL-2.0+
 */

if (!defined('ABSPATH')) {
    exit;
}

global $post;
?>

<div id="product_header">
    <div class="product-header_content">
        <h1 class="product-header_title"><?php the_title(); ?></h1>
        <?php get_template_part('templates/single-product/price'); ?>
    </div>
</div>
