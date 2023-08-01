<?php

/**
 * Panda Robots Menus
 *
 * Class: Panda_Robots
 * This class builds the WP Admin menu items and pages.
 *
 * @package    panda-master
 * @author     Puskomedia Indonesia <dev@puskomedia.id>
 * @copyright  2023 Puskomedia Indonesia
 * @license    GPL-2.0+
 **/

if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('Panda_Robots')) :
	// Panda Admin Menu & Pages
	class Panda_Robots
	{
		/**
		 * $panda_menu_title - Menu Title
		 * 
		 * @var string 
		 **/
		public $panda_menu_title = 'Robot Panda';

		/**
		 * $panda_menu_slug - Menu Slug
		 * 
		 * @var string 
		 **/
		public $panda_menu_slug = 'panda_robots';

		// Initializes Admin Menus
		public function __construct()
		{
			add_action('admin_menu', array($this, 'admin_menu'), 8000);
			add_action('admin_enqueue_scripts', array($this, 'load_panda_robots_style'));
		}

		// Builds the WP Admin Page Menus
		public function admin_menu()
		{
			add_menu_page(
				$this->panda_menu_title,
				$this->panda_menu_title,
				'import',
				$this->panda_menu_slug,
				array($this, 'panda_robots_menu_page'),
				null,
				'3.01'
			);
		}

		// Load Admin Menus CSS and JS
		public function load_panda_robots_style()
		{
			wp_enqueue_style('wp-jquery-ui-dialog');
			wp_register_style(
				'panda_robots_css',
				get_stylesheet_directory_uri() . '/master/assets/css/panda_robots.css',
				array(),
				wp_get_theme()->get('Version')
			);
			wp_enqueue_style('panda_robots_css');

			wp_enqueue_script('jquery-ui-tabs');
			wp_enqueue_script('jquery-ui-dialog');
			wp_enqueue_script('panda', get_stylesheet_directory_uri() . '/master/assets/js/panda_robots.js', array('jquery'), wp_get_theme()->get('Version'), true);
		}

		// Main Pages for Admin Menus
		public function panda_robots_menu_page()
		{
			echo '<div class="wrap">';

			echo '<header>';
			echo '<div class="panda-container">';
			echo '<img id="logo-icon" src="' . get_stylesheet_directory_uri() . '/master/assets/images/panda.png" title="Robot Panda" alt="Robot Panda">';
			echo '</div>';
			echo '</header>';

			echo '<div id="panda-tabs" class="ui-tabs" style="display:none">';

			// tabs
			echo '<nav>';
			echo '<div class="panda-container">';
			echo '<ul class="panda-main-tab">';
			echo '<li><a href="#tab-configurations">Konfigurasi</a></li>';
			echo '<li><a href="#tab-imports">Impor Demo</a></li>';
			echo '<li><a href="#tab-logs">Log</a></li>';
			echo '<li><a href="#tab-supports">Bantuan</a></li>';
			echo '</ul>';
			echo '</div>';
			echo '</nav>';

			// tab
			echo '<div class="panda-container">';
			echo '<div id="panda-content">';

			echo '<div id="tab-configurations" style="display:none">';
			$this->tab_configurations();
			echo '</div>';

			echo '<div id="tab-imports" style="display:none">';
			$this->tab_imports();
			echo '</div>';

			echo '<div id="tab-logs" style="display:none">';
			$this->tab_logs();
			echo '</div>';

			echo '<div id="tab-supports" style="display:none">';
			$this->tab_supports();
			echo '</div>';

			echo '</div>'; //content
			echo '<div>'; // container

			echo '</div>'; // tabs

			echo '</div>'; // wrap
		}

		/**
		 * Content for Configuration Tab
		 *
		 * @return null
		 */
		private function tab_configurations()
		{
			if (isset($_POST['conf_submit'])) :
				update_option('conf_alias', trim($_POST['conf_alias']));
				update_option('blogname', trim($_POST['blogname']));
				update_option('blogdescription', trim($_POST['blogdescription']));
				update_option('conf_address', trim($_POST['conf_address']));
				update_option('admin_email', trim($_POST['new_admin_email']));
				update_option('conf_phone', trim($_POST['conf_phone']));

				echo '<div class="updated notice notice-success is-dismissible" style="padding-top: 10px; padding-bottom: 10px;"><strong>Robot Panda :</strong> Konfigruasi berhasil diperbarui</div>';

				$update = array(get_option('conf_alias'), get_option('blogname'), get_option('blogdescription'), get_option('conf_address'), get_option('admin_email'), get_option('conf_phone'));
				panda_log('Konfigurasi berhasil diperbarui', wp_json_encode($update));
			endif;

			echo '<p>The following table details what data will be deleted (reset or destroyed) when a selected reset tool is run. Please read it! ';
			echo 'If something is not clear <a href="#" class="change-tab" data-tab="4">contact support</a> before running any tools. It\'s better to ask than to be sorry!';
			echo '</p><hr>';

			echo '<form action="" method="post" class="form-wrap validate">';

			echo '<div class="form-field form-required"><label for="conf-alias">Nama Alias</label><input type="text" id="conf-alias" name="conf_alias" value="' . get_option('conf_alias') . '" size="40" aria-required="true" aria-describedby="conf-alias-description"><p id="conf-alias-description">Nama Alias adalah sebutan untuk nama desa di wilayah masing-masing.</p></div>';
			echo '<div class="form-field form-required"><label for="blogname">Nama Desa</label><input type="text" id="blogname" name="blogname" value="' . get_option('blogname') . '" size="40" aria-required="true"></div>';
			echo '<div class="form-field form-required"><label for="blogdescription">Kabupaten</label><input type="text" id="blogdescription" name="blogdescription" value="' . get_option('blogdescription') . '" size="40" aria-required="true"></div>';
			echo '<div class="form-field form-required"><label for="conf-address">Alamat Lengkap</label><textarea id="conf-address" name="conf_address" rows="5" cols="40" aria-describedby="name-address">' . get_option('conf_address') . '</textarea><p id="name-address">Berisi alamat jalan, nomor kantor, desa, kecamatan, kabupaten, provinsi, dan kode pos.</p></div>';
			echo '<div class="form-field form-required"><label for="new_admin_email">Alamat Surel</label><input type="email" id="new_admin_email" name="new_admin_email" value="' . get_option('admin_email') . '" size="40" aria-required="true"></div>';
			echo '<div class="form-field form-required"><label for="conf-phone">No. Telepon/WhatsApp</label><input type="text" id="conf-phone" name="conf_phone" value="' . get_option('conf_phone') . '" size="40" aria-required="true" aria-describedby="name-phone"><p id="name-phone">Jika berisi nomor whatsap awali dengan kode negara (62).</p></div>';

			echo '<p class="submit"><input type="submit" class="button button-primary" name="conf_submit" value="Simpan Perubahan"></p>';
			echo '</form>';
		}

		/**
		 * Content for Import Tab
		 *
		 * @return null
		 */
		private function tab_imports()
		{
			echo '<p>The following table details what data will be deleted (reset or destroyed) when a selected reset tool is run. Please read it! ';
			echo 'If something is not clear <a href="#" class="change-tab" data-tab="4">contact support</a> before running any tools. It\'s better to ask than to be sorry!';
			echo '</p><hr>';

			echo '<form action="" method="post" class="form-wrap validate">';

			echo '<div class="form-field form-required"><label for="post-size">Ukuran Pasca Batch</label><input type="text" id="post-size" name="batch_size_field" value="10" size="40" aria-required="true"></div>';
			echo '<div class="form-field form-required"><label for="media-size">Ukuran Batch Media</label><input type="text" id="media-size" name="media_batch_size_field" value="10" size="40" aria-required="true"></div>';

			echo '<p class="submit"><input type="submit" class="button button-primary" name="imp_submit" value="Simpan Perubahan"></p>';
			echo '</form>';
		}

		/**
		 * Content for Logs Tab
		 *
		 * @return null
		 */
		private function tab_logs()
		{
			if(isset($_POST['logs_reset'])) {
				delete_option('panda_log');

				echo '<div class="updated notice notice-success is-dismissible" style="padding-top: 10px; padding-bottom: 10px;"><strong>Robot Panda :</strong> Log berhasil dihapus</div>';
			}

			panda_display_log();
		}

		/**
		 * Content for Support Tab
		 *
		 * @return null
		 */
		private function tab_supports()
		{
			echo '<p>The following table details what data will be deleted (reset or destroyed) when a selected reset tool is run. Please read it! ';
			echo 'If something is not clear <a href="#" class="change-tab" data-tab="4">contact support</a> before running any tools. It\'s better to ask than to be sorry!';
			echo '</p><hr>';
		}
	}
endif;
