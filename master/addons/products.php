<?php

/**
 * Panda Products
 *
 * This functions builds for Register 'product' post types and 'product_category' taxonomies.
 *
 * @package    panda-addons
 * @author     Puskomedia Indonesia <dev@puskomedia.id>
 * @copyright  2023 Puskomedia Indonesia
 * @license    GPL-2.0+
 **/

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('panda_register_posttypes')) :
    function panda_register_posttypes()
    {
        $product = array(
            'labels'              => array(
                'name'                  => __('Produk', 'panda-addons'),
                'singular_name'         => __('Produk', 'panda-addons'),
                'all_items'             => __('Semua Produk', 'panda-addons'),
                'menu_name'             => _x('Produk', 'Admin menu name', 'panda-addons'),
                'add_new'               => __('Tambah baru', 'panda-addons'),
                'add_new_item'          => __('Tambahkan produk baru', 'panda-addons'),
                'edit'                  => __('Sunting', 'panda-addons'),
                'edit_item'             => __('Sunting produk', 'panda-addons'),
                'new_item'              => __('Produk baru', 'panda-addons'),
                'view_item'             => __('Lihat produk', 'panda-addons'),
                'view_items'            => __('Lihat produk', 'panda-addons'),
                'search_items'          => __('Cari produk', 'panda-addons'),
                'not_found'             => __('Tidak ada produk yang ditemukan', 'panda-addons'),
                'not_found_in_trash'    => __('Tidak ada produk yang ditemukan di tempat sampah', 'panda-addons'),
                'featured_image'        => __('Gambar produk', 'panda-addons'),
                'set_featured_image'    => __('Tetapkan gambar produk', 'panda-addons'),
                'remove_featured_image' => __('Hapus gambar produk', 'panda-addons'),
                'use_featured_image'    => __('Gunakan sebagai gambar produk', 'panda-addons'),
                'insert_into_item'      => __('Masukkan ke dalam produk', 'panda-addons'),
                'uploaded_to_this_item' => __('Diunggah ke produk ini', 'panda-addons'),
                'filter_items_list'     => __('Filter produk', 'panda-addons'),
            ),
            'description'         => __('Di sinilah Anda dapat menelusuri produk di situs ini.', 'panda-addons'),
            'public'              => true,
            'show_ui'             => true,
            'menu_icon'           => 'dashicons-archive',
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'hierarchical'        => false,
            'rewrite'             => array(
                'slug'       => 'produk',
                'with_front' => false,
                'feeds'      => true,
            ),
            'query_var'           => true,
            'supports'            => array('title', 'editor', 'thumbnail'),
            'has_archive'         => 'toko',
            'show_in_nav_menus'   => true,
            'show_in_rest'        => true,
        );
        register_post_type('product', $product);

        $product_cat = array(
            'hierarchical'          => true,
            'label'                 => __('Kategori', 'panda-addons'),
            'labels'                => array(
                'name'                  => __('Kategori Produk', 'panda-addons'),
                'singular_name'         => __('Kategori', 'panda-addons'),
                'menu_name'             => _x('Kategori', 'Admin menu name', 'panda-addons'),
                'search_items'          => __('Cari kategori', 'panda-addons'),
                'all_items'             => __('Semua kategori', 'panda-addons'),
                'parent_item'           => __('Kategori induk', 'panda-addons'),
                'parent_item_colon'     => __('Kategori induk:', 'panda-addons'),
                'edit_item'             => __('Sunting kategori', 'panda-addons'),
                'update_item'           => __('Perbarui kategori', 'panda-addons'),
                'add_new_item'          => __('Tambahkan kategori baru', 'panda-addons'),
                'new_item_name'         => __('Nama kategori baru', 'panda-addons'),
                'not_found'             => __('Tidak ada kategori yang ditemukan', 'panda-addons'),
            ),
            'show_in_rest'          => true,
            'show_ui'               => true,
            'query_var'             => true,
            'rewrite'               => array(
                'slug'         => 'kategori-produk',
                'with_front'   => false,
                'hierarchical' => true,
            ),
        );
        register_taxonomy('product_cat', array('product'), $product_cat);
    }
    add_action('init', 'panda_register_posttypes');
endif;
