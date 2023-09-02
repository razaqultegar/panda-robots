<?php

/**
 * Single Product Seller
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

<div id="product_seller">
    <div style="background: #f0f3f7; height: 1px; margin: 16px 0px;"></div>
    <div class="product_seller-info">
        <div class="product_seller-logo">
            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/seller.png'; ?>" alt="<?php echo get_post_meta($post->ID, 'seller_name', true); ?>">
        </div>
        <div>
            <div style="display: flex;">
                <div class="product_seller-name">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/badge.png'; ?>" alt="Penjual Terverifikasi">
                    <h2><?php echo get_post_meta($post->ID, 'seller_name', true); ?></h2>
                </div>
            </div>
            <span class="product_seller-address"><?php echo get_post_meta($post->ID, 'seller_address', true); ?></span>
        </div>
    </div>
</div>
