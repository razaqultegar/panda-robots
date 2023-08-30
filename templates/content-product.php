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

<div <?php panda_product_class('', $post); ?>>
	<div class="product-box">
		<div class="product-wrapper">
			<div class="product-card">
				<div class="product-card_wrapper">
					<div class="product-card_container">
						<div class="product-card_thumbnail">
							<a href="<?php the_permalink(); ?>">
								<div>
									<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
								</div>
							</a>
						</div>
						<div class="product-card_info">
							<a href="<?php the_permalink(); ?>" class="product-info_content" title="<?php the_title(); ?>">
								<div class="product-content_name"><?php the_title(); ?></div>
								<?php
								get_template_part('templates/loop/price');
								get_template_part('templates/loop/seller');
								?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
