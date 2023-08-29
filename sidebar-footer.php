<?php
$et_active_sidebars = et_divi_footer_active_sidebars();

if ($et_active_sidebars === false) {
	return;
}
?>

<div id="footer-widgets">
	<div class="container clearfix">
		<?php
		foreach ($et_active_sidebars as $footer_sidebar) :
			echo '<div class="footer-widget">';
			dynamic_sidebar($footer_sidebar);
			echo '</div>';
		endforeach;
		?>
	</div>
</div>
