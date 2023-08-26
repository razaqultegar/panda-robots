<?php

/**
 * Panda Meta Boxes
 *
 * This functions builds for custom meta boxes on product post types.
 *
 * @package    panda-addons
 * @author     Puskomedia Indonesia <dev@puskomedia.id>
 * @copyright  2023 Puskomedia Indonesia
 * @license    GPL-2.0+
 **/

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('add_meta_boxes')) :
    function add_meta_boxes()
    {
        add_meta_box('panda-product-data', __('Data Produk', 'panda-addons'), 'Panda_Meta_Box_Product_Data', 'product', 'normal', 'high');
        add_meta_box('panda-product-images', __('Galeri Produk', 'panda-addons'), 'Panda_Meta_Box_Product_Images', 'product', 'side', 'low');
    }
    add_action('add_meta_boxes', 'add_meta_boxes');
endif;

if (!function_exists('Panda_Meta_Box_Product_Data')) :
    function Panda_Meta_Box_Product_Data()
    {
?>
        <div id="general_product_data" class="panda_options_panel">
            <div class="options-group">
                <p class="form-field _regular_price_field">
                    <label for="_regular_price">Harga normal (Rp)</label>
                    <input type="text" id="_regular_price" name="_regular_price" value="">
                </p>
                <p class="form-field _sale_price_field">
                    <label for="_sale_price">Harga obral (Rp)</label>
                    <input type="text" id="_sale_price" name="_sale_price" value="">
                </p>
            </div>
            <div class="options-group">
                <p class="form-field _sku_field">
                    <label for="_sku">SKU</label>
                    <input type="text" id="_sku" name="_sku" value="">
                </p>
                <fieldset class="form-field _stock_status_field stock_status_field">
                    <legend>Status stok</legend>
                    <ul class="input-radios">
                        <li>
                            <label>
                                <input name="_stock_status" value="instock" type="radio" class="select short" checked="checked"> Tersedia
                            </label>
                        </li>
                        <li>
                            <label>
                                <input name="_stock_status" value="outofstock" type="radio" class="select short"> Stok habis
                            </label>
                        </li>
                    </ul>
                </fieldset>
            </div>
        </div>
    <?php
    }
endif;

if (!function_exists('Panda_Meta_Box_Product_Images')) :
    function Panda_Meta_Box_Product_Images($post)
    {
        wp_nonce_field('panda_save_data', 'panda_meta_nonce');
    ?>
        <div id="product_images_container">
            <ul class="product_images"></ul>

            <input type="hidden" id="product_image_gallery" name="product_image_gallery" value="" />

        </div>
        <p class="add_product_images hide-if-no-js">
            <a href="#" data-choose="<?php esc_attr_e('Tambahkan gambar ke galeri produk', 'panda-product'); ?>" data-update="<?php esc_attr_e('Tambahkan ke galeri', 'panda-product'); ?>" data-delete="<?php esc_attr_e('Hapus gambar', 'panda-product'); ?>" data-text="<?php esc_attr_e('Hapus', 'panda-product'); ?>"><?php esc_html_e('Tambahkan gambar galeri produk', 'panda-product'); ?></a>
        </p>
<?php
    }
endif;
