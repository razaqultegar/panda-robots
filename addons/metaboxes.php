<?php

/**
 * Panda Meta Boxes
 *
 * Sets up the write panels used by products (custom post types).
 *
 * @package    panda-addons
 * @author     Puskomedia Indonesia <dev@puskomedia.id>
 * @copyright  2023 Puskomedia Indonesia
 * @license    GPL-2.0+
 **/

if (!defined('ABSPATH')) {
    exit;
}

// Constructor
function add_meta_boxes()
{
    add_meta_box('panda-product-data', __('Data Produk', 'panda-addons'), 'Panda_Meta_Box_Product_Data', 'product', 'normal', 'high');
    add_meta_box('panda-product-images', __('Galeri Produk', 'panda-addons'), 'Panda_Meta_Box_Product_Images', 'product', 'side', 'low');
}
add_action('add_meta_boxes', 'add_meta_boxes');

// Displays the product data box, tabbed, with several input covering price and seller info
function Panda_Meta_Box_Product_Data()
{
?>
    <div id="general_product_data" class="panda_options_panel">
        <div class="options-group">
            <p class="form-field regular_price_field">
                <label for="regular_price">Harga Normal (Rp)</label>
                <input type="text" id="regular_price" name="regular_price" value="<?php echo esc_attr(get_post_meta(get_the_ID(), 'regular_price', true)); ?>">
            </p>
            <p class="form-field sale_price_field">
                <label for="sale_price">Harga Promo (Rp)</label>
                <input type="text" id="sale_price" name="sale_price" value="<?php echo esc_attr(get_post_meta(get_the_ID(), 'sale_price', true)); ?>">
            </p>
        </div>
        <div class="options-group">
            <p class="form-field seller_name_field">
                <label for="seller_name">Nama Penjual</label>
                <input type="text" id="seller_name" name="seller_name" value="<?php echo esc_attr(get_post_meta(get_the_ID(), 'seller_name', true)); ?>">
            </p>
            <p class="form-field seller_contact_field">
                <label for="seller_contact">No. WhatsApp Penjual (+628xxx)</label>
                <input type="text" id="seller_contact" name="seller_contact" value="<?php echo esc_attr(get_post_meta(get_the_ID(), 'seller_contact', true)); ?>">
            </p>
            <p class="form-field seller_address_field">
                <label for="seller_address">Alamat Penjual</label>
                <textarea id="seller_address" name="seller_address" rows="2" cols="20"><?php echo esc_attr(get_post_meta(get_the_ID(), 'seller_address', true)); ?></textarea>
            </p>
        </div>
    </div>
<?php
}

// Display the product images meta box
function Panda_Meta_Box_Product_Images($post)
{
    wp_nonce_field('panda_save_data', 'panda_meta_nonce');
?>
    <div id="product_images_container">
        <ul class="product_images">
            <?php
            $product_image_gallery = get_post_meta($post->ID, 'product_image_gallery', true);

            $attachments         = is_array($product_image_gallery) ? array_filter($product_image_gallery) : array();
            $update_meta         = false;
            $updated_gallery_ids = array();

            if (!empty($attachments)) {
                foreach ($attachments as $attachment_id) {
                    $attachment = wp_get_attachment_image($attachment_id, 'thumbnail');

                    // if attachment is empty skip.
                    if (empty($attachment)) {
                        $update_meta = true;
                        continue;
                    }
            ?>
                    <li class="image" data-attachment_id="<?php echo esc_attr($attachment_id); ?>">
                        <?php echo $attachment; ?>
                        <ul class="actions">
                            <li><a href="#" class="delete tips" data-tip="<?php esc_attr_e('Hapus Gambar', 'panda-addons'); ?>"><?php esc_html_e('Hapus', 'panda-addons'); ?></a></li>
                        </ul>
                    </li>
            <?php

                    // rebuild ids to be saved.
                    $updated_gallery_ids[] = $attachment_id;
                }

                // need to update product meta to set new gallery ids
                if ($update_meta) {
                    update_post_meta($post_id, 'product_image_gallery', implode(',', $updated_gallery_ids));
                }
            }
            ?>
        </ul>

        <input type="hidden" id="product_image_gallery" name="product_image_gallery" value="<?php echo esc_attr( implode( ',', $updated_gallery_ids ) ); ?>" />

    </div>
    <p class="add_product_images hide-if-no-js">
        <a href="#" data-choose="<?php esc_attr_e('Tambahkan gambar ke galeri produk', 'panda-product'); ?>" data-update="<?php esc_attr_e('Tambahkan ke galeri', 'panda-product'); ?>" data-delete="<?php esc_attr_e('Hapus gambar', 'panda-product'); ?>" data-text="<?php esc_attr_e('Hapus', 'panda-product'); ?>"><?php esc_html_e('Tambahkan gambar galeri produk', 'panda-product'); ?></a>
    </p>
<?php
}

// Save Product Meta Boxes
function Panda_Meta_Box_Save($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if ($parent_id = wp_is_post_revision($post_id)) {
        $post_id = $parent_id;
    }

    $fields = [
        'regular_price',
        'sale_price',
        'seller_name',
        'seller_contact',
        'seller_address',
    ];

    foreach ($fields as $field) {
        if (array_key_exists($field, $_POST)) {
            $attachment_ids = isset($_POST['product_image_gallery']) ? array_filter(explode(',', panda_clean($_POST['product_image_gallery']))) : array();
            update_post_meta($post_id, 'product_image_gallery', $attachment_ids);
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'Panda_Meta_Box_Save');
