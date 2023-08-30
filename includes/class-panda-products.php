<?php

/**
 * Panda Products
 *
 * Functions used by products
 *
 * @package    panda-products
 * @author     Puskomedia Indonesia <dev@puskomedia.id>
 * @copyright  2023 Puskomedia Indonesia
 * @license    GPL-2.0+
 **/

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 *
 * @param string|array $var Data to sanitize.
 * @return string|array
 */
function panda_clean($var)
{
    if (is_array($var)) {
        return array_map('panda_clean', $var);
    } else {
        return is_scalar($var) ? sanitize_text_field($var) : $var;
    }
}

/**
 * Retrieve page ids - used for shop returns -1 if no page is found.
 *
 * @param string $page Page slug.
 * @return int
 */
function panda_get_page_id($page)
{
    return $page ? absint($page) : -1;
}

/**
 * Retrieve page permalink.
 *
 * @param string      $page page slug.
 * @param string|bool $fallback Fallback URL if page is not set. Defaults to home URL.
 * @return string
 */
function panda_get_page_permalink($page, $fallback = null)
{
    $page_id   = panda_get_page_id($page);
    $permalink = 0 < $page_id ? get_permalink($page_id) : '';

    if (!$permalink) {
        $permalink = is_null($fallback) ? get_home_url() : $fallback;
    }

    return $permalink;
}

/**
 * Is_shop - Returns true when viewing the product type archive (shop).
 *
 * @return bool
 */
function is_shop()
{
    return (is_post_type_archive('product') || is_page(panda_get_page_id('shop')));
}

/**
 * Is_product_category - Returns true when viewing a product category.
 *
 * @param  string $term (default: '') The term slug your checking for. Leave blank to return true on any.
 * @return bool
 */
function is_product_category($term = '')
{
    return is_tax('product_cat', $term);
}

/**
 * Is_product - Returns true when viewing a single product.
 *
 * @return bool
 */
function is_product()
{
    return is_singular(array('product'));
}

/**
 * Add body classes for Panda Product pages.
 *
 * @param  array $classes Body Classes.
 * @return array
 */
function panda_body_class($classes)
{
    $classes = (array) $classes;

    if (is_shop()) {
        $classes[] = 'et_full_width_page';
    }

    return array_unique($classes);
}
add_filter('body_class', 'panda_body_class');

/**
 * Get product taxonomy HTML classes.
 *
 * @param array  $term_ids Array of terms IDs or objects.
 * @param string $taxonomy Taxonomy.
 * @return array
 */
function panda_get_product_taxonomy_class($term_ids, $taxonomy)
{
    $classes = array();

    foreach ($term_ids as $term_id) {
        $term = get_term($term_id, $taxonomy);

        if (empty($term->slug)) {
            continue;
        }

        $term_class = sanitize_html_class($term->slug, $term->term_id);
        if (is_numeric($term_class) || !trim($term_class, '-')) {
            $term_class = $term->term_id;
        }

        $classes[] = sanitize_html_class($taxonomy . '-' . $term_class, $taxonomy . '-' . $term->term_id);
    }

    return $classes;
}

/**
 * Retrieves the classes for the post div as an array.
 *
 * This method was modified from WordPress's get_post_class() to allow the removal of taxonomies
 * (for performance reasons). Previously panda_product_post_class was hooked into post_class.
 *
 * @param string|array              $class      One or more classes to add to the class list.
 * @param int|WP_Post|Panda_Product $product Product ID or product object.
 * @return array
 */
function panda_get_product_class($class = '', $post)
{
    $product = $post;

    if ($class) {
        if (!is_array($class)) {
            $class = preg_split('#\s+#', $class);
        }
    } else {
        $class = array();
    }

    $post_classes = array_map('esc_attr', $class);

    if (!$product) {
        return $post_classes;
    }

    $classes = array_merge(
        $post_classes,
        array(
            'product',
            'type-product',
            'post-' . $product->ID,
            'status-' . $product->post_status
        ),
        panda_get_product_taxonomy_class(get_the_terms($post->ID, 'product_cat'), 'product_cat')
    );

    if (has_post_thumbnail($post->ID)) {
        $classes[] = 'has-post-thumbnail';
    }

    return array_map('esc_attr', array_unique(array_filter($classes)));
}

/**
 * Display the classes for the product div.
 *
 * @param string|array              $class      One or more classes to add to the class list.
 * @param int|WP_Post|Panda_Product $product_id Product ID or product object.
 */
function panda_product_class($class = '', $post = null)
{
    echo 'class="' . esc_attr(implode(' ', panda_get_product_class($class, $post))) . '"';
}

function panda_currency($price)
{
    $price = "Rp" . number_format($price, 0, ',', '.');
    return $price;
}

/**
 * Get HTML for a gallery image.
 *
 * Hooks: panda_gallery_thumbnail_size, panda_gallery_image_size and panda_gallery_full_size accept name based image sizes, or an array of width/height values.
 *
 * @param int  $attachment_id Attachment ID.
 * @param bool $main_image Is this the main image or a thumbnail?.
 * @return string
 */
function panda_get_gallery_image_html($attachment_id, $main_image = false)
{
    $flexslider        = (bool) true;
    $thumbnail_size    = array(600, 600);
    $image_size        = $flexslider || $main_image ? 'panda_single' : $thumbnail_size;
    $thumbnail_src     = wp_get_attachment_image_src($attachment_id, $thumbnail_size);
    $full_src          = wp_get_attachment_image_src($attachment_id, 'full');
    $alt_text          = trim(wp_strip_all_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true)));
    $image             = wp_get_attachment_image(
        $attachment_id,
        $image_size,
        false,
        array(
            'title'                   => _wp_specialchars(get_post_field('post_title', $attachment_id), ENT_QUOTES, 'UTF-8', true),
            'data-caption'            => _wp_specialchars(get_post_field('post_excerpt', $attachment_id), ENT_QUOTES, 'UTF-8', true),
            'data-src'                => esc_url($full_src[0]),
            'data-large_image'        => esc_url($full_src[0]),
            'data-large_image_width'  => esc_attr($full_src[1]),
            'data-large_image_height' => esc_attr($full_src[2]),
            'class'                   => esc_attr($main_image ? 'wp-post-image' : ''),
        ),
        $attachment_id,
        $image_size,
        $main_image,
    );

    return '<div data-thumb="' . esc_url($thumbnail_src[0]) . '" data-thumb-alt="' . esc_attr($alt_text) . '" class="panda-product-gallery__image"><a href="' . esc_url($full_src[0]) . '">' . $image . '</a></div>';
}

/**
 * Get the shop sidebar template.
 */
function panda_photoswipe()
{
    get_template_part('templates/single-product/photoswipe');
}
add_action('wp_footer', 'panda_photoswipe');
