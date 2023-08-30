<?php

/**
 * Loop Price
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

<div class="product-content_price">
    
    <?php if (!empty(get_post_meta($post->ID, 'sale_price', true))) { ?>
        <div><?php echo panda_currency(get_post_meta($post->ID, 'sale_price', true)); ?></div>
        <div><?php echo panda_currency(get_post_meta($post->ID, 'regular_price', true)); ?></div>
    <?php } else { ?>
        <div><?php echo panda_currency(get_post_meta($post->ID, 'regular_price', true)); ?></div>
    <?php } ?>
    
</div>
