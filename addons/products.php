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

// Register product post types
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
            'slug'       => 'produk-warga',
            'with_front' => false,
            'feeds'      => true,
        ),
        'query_var'           => true,
        'supports'            => array('title', 'editor', 'thumbnail'),
        'has_archive'         => true,
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

/**
 * Define primary column.
 *
 * @return string
 */
function table_product_primary_column($default, $screen)
{
    if ('edit-product' === $screen) {
        $default = 'name';
    }

    return $default;
}
add_filter('list_table_primary_column', 'table_product_primary_column', 10, 2);

/**
 * Get row actions to show in the list table.
 *
 * @param array   $actions Array of actions.
 * @param WP_Post $post Current post object.
 * @return array
 */
function table_product_row_actions($actions, $post)
{
    if ($post->post_type == "product") {
        return array_merge(array('id' => sprintf(__('ID: %d', 'panda-addons'), $post->ID)), $actions);
    }

    return $actions;
}
add_filter('post_row_actions', 'table_product_row_actions', 100, 2);

/**
 * Define which columns to show on this screen.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function define_columns($columns)
{
    if (empty($columns) && !is_array($columns)) {
        $columns = array();
    }

    unset($columns['title'], $columns['comments'], $columns['date']);

    $show_columns = array();
    $show_columns['cb'] = '<input type="checkbox" />';
    $show_columns['thumb'] = '<span class="panda-image">' . __('Gambar', 'panda-addons') . '</span>';
    $show_columns['name'] = __('Nama', 'panda-addons');
    $show_columns['seller'] = __('Penjual', 'panda-addons');
    $show_columns['price'] = __('Harga', 'panda-addons');
    $show_columns['product_cat'] = __('Kategori', 'panda-addons');
    $show_columns['date'] = __('Tanggal', 'panda-addons');

    return array_merge($show_columns, $columns);
}
add_filter('manage_product_posts_columns', 'define_columns');

// Render column
function render_product_column($column, $post_id)
{
    switch ($column) {
        case 'thumb':
            echo '<a href="' . esc_url(get_edit_post_link($post_id)) . '">' . get_the_post_thumbnail($post_id, 'thumbnail') . '</a>';
            break;
        case 'name':
            echo '<strong><a href="' . esc_url(get_edit_post_link($post_id)) . '" class="row-title">' . get_the_title($post_id) . '</a></strong>';
            break;
        case 'seller':
            echo '<a href="#">' . esc_attr(get_post_meta($post_id, 'seller_name', true)) . '</a>';
            break;
        case 'price':
            echo (!empty(get_post_meta($post_id, 'sale_price', true))) ? '<del aria-hidden="true">' . panda_currency(get_post_meta($post_id, 'regular_price', true)) . '</del> <ins>' . panda_currency(get_post_meta($post_id, 'sale_price', true)) . '</ins>' : panda_currency(get_post_meta($post_id, 'regular_price', true));
            break;
        case 'product_cat':
            $terms = get_the_terms($post_id, 'product_cat');
            if (!$terms) {
                echo '<span class="na">&ndash;</span>';
            } else {
                $termlist = array();
                foreach ($terms as $term) {
                    $termlist[] = '<a href="' . esc_url(admin_url('edit.php?product_cat=' . $term->slug . '&post_type=product')) . ' ">' . esc_html($term->name) . '</a>';
                }

                echo implode(', ', $termlist);
            }
            break;
    }
}
add_action('manage_product_posts_custom_column', 'render_product_column', 10, 2);

/**
 * Define which columns are sortable.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function define_sortable_columns($columns)
{
    $custom = array(
        'name'  => 'title',
        'price' => 'price',
    );

    return wp_parse_args($custom, $columns);
}
add_filter('manage_edit-product_sortable_columns', 'define_sortable_columns');
