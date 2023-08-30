<?php

/**
 * Loop Seller
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

<div class="product-content_seller">
    <i class="product-seller_icon"></i>
    <div class="product-seller_info">
        <span class="product-seller_name"><?php echo get_post_meta($post->ID, 'seller_name', true) ?></span>
    </div>
</div>
