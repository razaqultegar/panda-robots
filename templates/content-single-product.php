<?php

/**
 * The template for displaying product content in the single-product.php template
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

<div id="product-<?php the_ID(); ?>" <?php panda_product_class('', $post); ?>>
    <div id="product_media">
        <?php get_template_part('templates/single-product/product-image'); ?>
    </div>
    <?php
    get_template_part('templates/single-product/header');
    get_template_part('templates/single-product/content');
    get_template_part('templates/single-product/seller');
    get_template_part('templates/single-product/report');
    ?>
    <div id="product_checkout">
        <div class="product_checkout-box">
            <h6>Atur jumlah dan catatan</h6>
            <div class="product_checkout-input">
                <textarea id="input-buyer-note" placeholder="Contoh: Warna Putih, Size M"></textarea>
            </div>
            <div class="product_checkout-price">
                <?php if (!empty(get_post_meta($post->ID, 'sale_price', true))) { ?>
                <p class="onsale"><del><?php echo panda_currency(get_post_meta($post->ID, 'regular_price', true)); ?></del></p>
                <div>
                    <p>Subtotal</p>
                    <p><?php echo panda_currency(get_post_meta($post->ID, 'sale_price', true)); ?></p>
                </div>
                <?php } else { ?>
                <div>
                    <p>Subtotal</p>
                    <p><?php echo panda_currency(get_post_meta($post->ID, 'regular_price', true)); ?></p>
                </div>
                <?php } ?>
            </div>
            <div class="product_checkout-actions">
                <button type="button" class="product_checkout-button">Beli via WhatsApp</button>
            </div>
        </div>
    </div>
</div>
