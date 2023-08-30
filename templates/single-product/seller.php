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
            <img src="https://images.tokopedia.net/img/cache/215-square/GAnVPX/2021/7/5/d37d8b94-d993-4a7b-8f60-f2f71a43ac5b.jpg" alt="<?php echo get_post_meta($post->ID, 'seller_name', true) ?>">
        </div>
        <div>
            <div style="display: flex;">
                <div class="product_seller-name">
                    <img data-testid="pdpShopBadgeOS" class="css-ebxddb" src="https://images.tokopedia.net/img/official_store/badge_os.png" alt="Official Store">
                    <h2 data-unify="Typography" class="css-1wdzqxj-unf-heading e1qvo2ff2"><?php echo get_post_meta($post->ID, 'seller_name', true) ?></h2>
                </div>
            </div>
            <span class="product_seller-address"><?php echo get_post_meta($post->ID, 'seller_address', true) ?></span>
        </div>
    </div>
</div>
