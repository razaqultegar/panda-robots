<?php

/**
 * Single Product Image
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

$columns           = 5;
$post_thumbnail_id = get_post_thumbnail_id($post->ID);
$wrapper_classes   = array(
    'panda-product-gallery',
    'panda-product-gallery--' . ($post_thumbnail_id ? 'with-images' : 'without-images'),
    'panda-product-gallery--columns-' . absint($columns),
    'images',
);
?>
<div class="<?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))); ?>" data-columns="<?php echo esc_attr($columns); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
    <div class="panda-product-gallery__wrapper">
        <?php
        echo panda_get_gallery_image_html($post_thumbnail_id, true);
        get_template_part('templates/single-product/product-thumbnails');
        ?>
    </div>
</div>
