<?php

/**
 * Single Product Content
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

<div id="product_content">
    <div style="background: #f0f3f7; height: 1px; margin: 16px 0px;"></div>
    <div class="product-content_description" style="height: 160px;"><?php the_content(); ?></div>
    <div class="product-content_mask"></div>
    <button type="button" class="product-content_more">Lihat Selengkapnya</button>
</div>
