<?php

/**
 * Single Product Thumbnails
 *
 * @package    panda-templates
 * @author     Puskomedia Indonesia <dev@puskomedia.id>
 * @copyright  2023 Puskomedia Indonesia
 * @license    GPL-2.0+
 */

if (!defined('ABSPATH')) {
    exit;
}

// Note: `panda_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if (!function_exists('panda_get_gallery_image_html')) {
    return;
}

global $post;

$attachment_ids = get_post_meta($post->ID, 'product_image_gallery', true);

if ($attachment_ids && get_post_thumbnail_id($post->ID)) {
    foreach ($attachment_ids as $attachment_id) {
        echo panda_get_gallery_image_html($attachment_id);
    }
}
