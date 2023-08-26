<?php

/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for child theme Panda
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

// Include the TGM_Plugin_Activation class
require_once get_stylesheet_directory() . '/includes/class-tgm-plugin-activation.php';

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function panda_register_required_plugins()
{
    /*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
    $plugins = array(

        // This is an example of how to include a plugin from the WordPress Plugin Repository.
        array(
            'name' => 'Advanced iFrame',
            'slug' => 'advanced-iframe',
            'required' => true,
        ),

        array(
            'name' => 'Autoptimize',
            'slug' => 'autoptimize',
            'required' => true,
        ),

        array(
            'name' => 'Better Search Replace',
            'slug' => 'better-search-replace',
            'required' => false,
        ),

		array(
            'name' => 'Jetpack - Keamanan, Pencadangan, Kecepatan, & Perkembangan WP',
            'slug' => 'jetpack',
            'required' => false,
        ),

        array(
            'name' => 'WebP Express',
            'slug' => 'webp-express',
            'required' => true,
        ),

    );

    /*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
    $config = array(
        'id' => 'panda',
        'default_path' => '',
        'menu' => 'plugins-required',
        'parent_slug' => 'plugins.php',
        'capability' => 'edit_theme_options',
        'has_notices' => true,
        'dismissable' => true,
        'dismiss_msg' => '',
        'is_automatic' => false,
        'message' => '',
		'strings' => array(
			'page_title' => __( 'Instal Plugin yang Diperlukan', 'panda' ),
			'menu_title' => __( 'Plugin Diperlukan', 'panda' ),
			'installing' => __( 'Menginstal Plugin: %s', 'panda' ),
			'oops' => __( 'Ada yang tidak beres dengan API plugin.', 'panda' ),
			'notice_can_install_required' => _n_noop(
				'Tema ini memerlukan plugin berikut: %1$s.',
				'Tema ini memerlukan plugin berikut: %1$s.',
				'panda'
			),
			'notice_can_install_recommended' => _n_noop(
				'Tema ini merekomendasikan plugin berikut: %1$s.',
				'Tema ini merekomendasikan plugin berikut: %1$s.',
				'panda'
			),
			'notice_can_activate_required' => _n_noop(
				'Plugin yang diperlukan berikut ini saat ini tidak aktif: %1$s.',
				'Plugin yang diperlukan berikut ini saat ini tidak aktif: %1$s.',
				'panda'
			),
			'notice_can_activate_recommended' => _n_noop(
				'Plugin yang direkomendasikan berikut ini saat ini tidak aktif: %1$s.',
				'Plugin yang direkomendasikan berikut ini saat ini tidak aktif: %1$s.',
				'panda'
			),
			'install_link' => _n_noop(
				'Mulai menginstal plugin',
				'Mulai menginstal plugin',
				'panda'
			),
			'activate_link' => _n_noop(
				'Mulai mengaktifkan plugin',
				'Mulai mengaktifkan plugin',
				'panda'
			),
			'return' => __( 'Kembali ke Penginstal Plugin yang Diperlukan', 'panda' ),
			'plugin_activated' => __( 'Plugin berhasil diaktifkan.', 'panda' ),
			'activated_successfully' => __( 'Plugin berikut berhasil diaktifkan:', 'panda' ),
			'plugin_already_active' => __( 'Tidak ada tindakan yang diambil. Plugin %1$s sudah aktif.', 'panda' ),
			'complete' => __( 'Semua plugin berhasil diinstal dan diaktifkan. %1$s', 'panda' ),
			'dismiss' => __( 'Tutup pemberitahuan ini', 'panda' ),
			'nag_type' => '',
		),
    );

    tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'panda_register_required_plugins');
