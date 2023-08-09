<ul class="social-media-follow">
	<li class="et-social-facebook">
		<a href="<?php echo esc_url(strval(et_get_option('divi_facebook_url', '#'))); ?>" class="icon"></a>
	</li>
	<li class="et-social-instagram">
		<a href="<?php echo esc_url(strval(et_get_option('divi_instagram_url', '#'))); ?>" class="icon"></a>
	</li>
	<?php
	$et_rss_url = !empty(et_get_option('divi_rss_url'))
		? et_get_option('divi_rss_url')
		: get_bloginfo('rss2_url');
	?>
	<li class="et-social-rss">
		<a href="<?php echo esc_url($et_rss_url); ?>" class="icon"></a>
	</li>
</ul>