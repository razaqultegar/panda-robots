<?php

/**
 * The template for displaying product content within loops
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

<li <?php panda_product_class('', $post); ?>>
	<a href="<?php the_permalink(); ?>">
		<span class="et_shop_image">
			<img src="<?php the_post_thumbnail_url(); ?>" class="attachment-panda_thumbnail size-panda_thumbnail" alt="<?php the_title(); ?>" width="300" height="300" decoding="async" loading="lazy">
			<span class="onsale">Promo!</span>
		</span>
		<h2 class="panda-loop-product__title"><?php the_title(); ?></h2>
		<?php get_template_part('templates/loop/price'); ?>
	</a>
</li>
