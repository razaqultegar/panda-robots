<?php

/**
 * Single Product Price
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

<div class="product-header_price">

    <?php if (!empty(get_post_meta($post->ID, 'sale_price', true))) { ?>
        <div class="price"><?php echo panda_currency(get_post_meta($post->ID, 'sale_price', true)); ?></div>
        <div class="onsale">
            <div>Sedang Promo</div>
            <div><?php echo panda_currency(get_post_meta($post->ID, 'regular_price', true)); ?></div>
        </div>
    <?php } else { ?>
        <div class="price"><?php echo panda_currency(get_post_meta($post->ID, 'regular_price', true)); ?></div>
    <?php } ?>

</div>
