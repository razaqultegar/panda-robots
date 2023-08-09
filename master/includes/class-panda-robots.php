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
				'manage_options',
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
			wp_enqueue_style('wp-color-picker');
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
			wp_enqueue_script('panda_panel_uploader', get_stylesheet_directory_uri() . '/master/assets/js/custom_uploader.js', array('jquery', 'media-upload', 'thickbox', 'wp-color-picker'), wp_get_theme()->get('Version'));
			wp_enqueue_media();
			wp_localize_script('panda_panel_uploader', 'panda_uploader', array(
				'media_window_title' => 'Pilih Gambar',
			));
		}

		// Main Pages for Admin Menus
		public function panda_robots_menu_page()
		{
?>
			<div class="wrap">
				<header>
					<img id="logo-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/master/assets/images/panda.png" title="Robot Panda" alt="Robot Panda" />
				</header>
				<div class="col-left">
					<div id="panda-tabs" class="ui-tabs" style="display:none">
						<nav>
							<div class="panda-container">
								<ul class="panda-main-tab">
									<li><a href="#tab-configurations">Konfigurasi</a></li>
									<li><a href="#tab-imports">Impor Demo</a></li>
									<li><a href="#tab-logs">Log</a></li>
									<li><a href="#tab-helps">Bantuan</a></li>
								</ul>
							</div>
						</nav>
						<div class="panda-container">
							<div id="panda-content">
								<div id="tab-configurations" style="display:none">
									<?php echo $this->tab_configurations(); ?>
								</div>
								<div id="tab-imports" style="display:none">
									<?php echo $this->tab_imports(); ?>
								</div>
								<div id="tab-logs" style="display:none">
									<?php echo $this->tab_logs(); ?>
								</div>
								<div id="tab-helps" style="display:none">
									<?php echo $this->tab_helps(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-right">
					<?php echo $this->panda_feeds(); ?>
				</div>
			</div>
		<?php
		}

		/**
		 * Content for Configuration Tab
		 *
		 * @return null
		 */
		private function tab_configurations()
		{
			if (isset($_POST['conf_submit'])) :
				et_update_option('divi_logo', trim($_POST['divi_logo']));
				update_option('primary_color', trim($_POST['primary_color']));
				update_option('conf_alias', trim($_POST['conf_alias']));
				update_option('blogname', trim($_POST['blogname']));
				update_option('blogdescription', trim($_POST['blogdescription']));
				update_option('conf_address', trim($_POST['conf_address']));
				update_option('admin_email', trim($_POST['new_admin_email']));
				update_option('conf_phone', trim($_POST['conf_phone']));

				$update = array(
					et_get_option('divi_logo'),
					get_option('primary_color'),
					get_option('conf_alias'),
					get_option('blogname'),
					get_option('blogdescription'),
					get_option('conf_address'),
					get_option('admin_email'),
					get_option('conf_phone'),
				);

				panda_logs('Konfigurasi berhasil diperbarui', wp_json_encode($update));
			endif;
		?>
			<p>Form berikut merinci data apa saja yang dibutuhkan untuk website desa Anda sehingga data akan ditampilkan secara dinamis. Silahkan diisi! Jika ada sesuatu yang tidak jelas, <a href="javascript:void(0)" class="change-tab" data-tab="3">hubungi bantuan</a> sebelum menyimpan apa pun. Lebih baik bertanya daripada tersesat!</p>
			<hr>
			<form action="" method="post" class="form-wrap">
				<div class="form-field">
					<label for="divi_logo">Logo</label>
					<input id="divi_logo" class="panda-upload-field" type="text" size="40" name="divi_logo" value="<?php echo et_get_option('divi_logo'); ?>" />
					<div class="panda-upload-buttons">
						<input class="panda-upload-image-button button button-primary" type="button" data-button_text="Atur sebagai Logo" value="Unggah" />
					</div>
				</div>
				<div class="form-field">
					<label for="primary_color">Warna Utama</label>
					<input type="text" id="primary_color" name="primary_color" value="<?php echo get_option('primary_color'); ?>" data-default-color="<?php echo get_option('primary_color'); ?>" aria-describedby="primary-color-description" />
					<p id="primary-color-description">Warna Utama adalah warna utama yang digunakan untuk situs Anda.</p>
				</div>
				<div class="form-field">
					<label for="conf-alias">Nama Alias</label>
					<input type="text" id="conf-alias" name="conf_alias" value="<?php echo get_option('conf_alias'); ?>" size="40" aria-describedby="conf-alias-description" />
					<p id="conf-alias-description">Nama Alias adalah sebutan untuk nama desa di wilayah masing-masing.</p>
				</div>
				<div class="form-field">
					<label for="blogname">Nama Desa</label>
					<input type="text" id="blogname" name="blogname" value="<?php echo get_bloginfo('name'); ?>" size="40" />
				</div>
				<div class="form-field">
					<label for="blogdescription">Kabupaten</label>
					<input type="text" id="blogdescription" name="blogdescription" value="<?php echo get_bloginfo('description'); ?>" size="40" />
				</div>
				<div class="form-field">
					<label for="conf-address">Alamat Lengkap</label>
					<textarea id="conf-address" name="conf_address" rows="5" cols="40" aria-describedby="name-address"><?php echo get_option('conf_address'); ?></textarea>
					<p id="name-address">Berisi alamat jalan, nomor kantor, desa, kecamatan, kabupaten, provinsi, dan kode pos.</p>
				</div>
				<div class="form-field">
					<label for="new_admin_email">Alamat Surel</label>
					<input type="email" id="new_admin_email" name="new_admin_email" value="<?php echo get_bloginfo('admin_email'); ?>" size="40" />
				</div>
				<div class="form-field">
					<label for="conf-phone">No. Telepon/WhatsApp</label>
					<input type="text" id="conf-phone" name="conf_phone" value="<?php echo get_option('conf_phone'); ?>" size="40" aria-describedby="name-phone" />
					<p id="name-phone">Jika berisi nomor whatsap awali dengan kode negara (62).</p>
				</div>
				<p class="submit">
					<input type="submit" class="button button-primary" name="conf_submit" value="Simpan Perubahan" />
				</p>
			</form>
		<?php
		}

		/**
		 * Content for Import Tab
		 *
		 * @return null
		 */
		private function tab_imports()
		{
		?>
			<p>Form berikut merinci data apa saja yang harus diimporkan untuk website desa Anda sehingga akan menampilkan data website sama persis seperti website contoh Panda. Silahkan centang! Jika ada sesuatu yang tidak jelas, <a href="javascript:void(0)" class="change-tab" data-tab="3">hubungi bantuan</a> sebelum mengimpor data apa pun. Lebih baik bertanya daripada tersesat!</p>
			<hr>

			<form action="" method="post">
				<input type="hidden" id="post-size" name="batch_size_field" value="10" />
				<input type="hidden" id="media-size" name="media_batch_size_field" value="10" />
				<p>
					<label for="import-posts">
						<input type="checkbox" id="import-posts" name="panda_import_posts_checkbox" value="1" checked /> Impor Postingan
					</label>
				</p>
				<p>
					<label for="import-media">
						<input type="checkbox" id="import-media" name="panda_import_media_checkbox" value="1" checked /> Impor Media
					</label>
				</p>
				<p>
					<label for="import-menus">
						<input type="checkbox" id="import-menus" name="panda_import_menus_checkbox" value="1" checked /> Impor Menu
					</label>
				</p>
				<p>
					<label for="import-homepage">
						<input type="checkbox" id="import-homepage" name="panda_import_homepage_checkbox" value="1" checked /> Impor Halaman Utama &amp; Kabar Desa
					</label>
				</p>
				<p>
					<label for="import-options">
						<input type="checkbox" id="import-options" name="panda_import_options_checkbox" value="1" checked /> Impor Pengaturan Tema
					</label>
				</p>
				<p>
					<label for="import-builder">
						<input type="checkbox" id="import-builder" name="panda_import_builder_checkbox" value="1" checked /> Impor Template Halaman
					</label>
				</p>
				<p>
					<label for="import-wordpress">
						<input type="checkbox" id="import-wordpress" name="panda_import_wordpress_checkbox" value="1" checked /> Impor Pengaturan WordPress
					</label>
				</p>
				<p class="submit">
					<input type="submit" class="button button-primary" name="imp_submit" value="Mulai Impor" />
				</p>
			</form>
		<?php
		}

		/**
		 * Content for Logs Tab
		 *
		 * @return null
		 */
		private function tab_logs()
		{
			if (isset($_POST['logs_reset'])) {
				delete_option('panda_logs');
			}

			panda_display_logs();
		}

		/**
		 * Content for Support Tab
		 *
		 * @return null
		 */
		private function tab_helps()
		{
		?>
			<p>The following table details what data will be deleted (reset or destroyed) when a selected reset tool is run. Please read it! If something is not clear <a href="#" class="change-tab" data-tab="4">contact support</a> before running any tools. It\'s better to ask than to be sorry!</p>
			<hr>

		<?php
		}

		/**
		 * Content for Feeds on Sidebar
		 *
		 * @return null
		 */
		private function panda_feeds()
		{
		?>
			<div class="panda-feed">
				<div class="panda-feed-header">
					<h2>Feed Desa</h2>
				</div>
				<div class="panda-feed-body hide-if-no-js">
					<div class="activity-block">
						<p>Baca kabar desa lainnya yang sudah menggunakan Teknologi Panda.</p>
					</div>
					<?php init_panda_feeds(); ?>
				</div>
				<p class="panda-feed-footer">
					<a href="https://feed.panda.id" target="_blank">
						Feed Desa
						<span class="screen-reader-text">(opens in a new tab)</span>
						<span aria-hidden="true" class="dashicons dashicons-external"></span>
					</a>
					|
					<a href="https://panda.id" target="_blank">
						Panda SID
						<span class="screen-reader-text">(opens in a new tab)</span>
						<span aria-hidden="true" class="dashicons dashicons-external"></span>
					</a>
					|
					<a href="https://puskomedia.id" target="_blank">
						Puskomedia Indonesia
						<span class="screen-reader-text">(opens in a new tab)</span>
						<span aria-hidden="true" class="dashicons dashicons-external"></span>
					</a>
				</p>
			</div>
<?php
		}
	}
endif;
