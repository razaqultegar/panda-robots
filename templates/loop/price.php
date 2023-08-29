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

<span class="price">
    <?php if (!empty(get_post_meta($post->ID, 'sale_price', true))) { ?>
        <del aria-hidden="true"><?php echo panda_currency(get_post_meta($post->ID, 'regular_price', true)); ?></del>
        <ins><?php echo panda_currency(get_post_meta($post->ID, 'sale_price', true)); ?></ins>
    <?php } else {
        echo panda_currency(get_post_meta($post->ID, 'regular_price', true));
    } ?>
</span>
