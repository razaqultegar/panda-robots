<?php

/**
 * Panda Includes
 *
 * Functions used by common
 *
 * @package    panda-includes
 * @author     Puskomedia Indonesia <dev@puskomedia.id>
 * @copyright  2023 Puskomedia Indonesia
 * @license    GPL-2.0+
 **/

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Writes logging information to file.
 *
 * @param string $log_trigger - Provides information about what calls the function.
 * @param mixed  $log_data - Provides extra data about the logged event.
 **/
function panda_logs($log_trigger, $log_data = '')
{
    $panda_log = get_option('panda_logs');
    if (false === $panda_log) {
        $panda_log = array();
    } else {
        $panda_log = json_decode($panda_log);
    }

    $entries = count($panda_log);
    if ($entries > 500) {
        $panda_log = array_slice($panda_log, $entries - 500);
    }

    // Convert log data as needed
    if (is_wp_error($log_data)) {
        $log_data = $log_data->get_error_message();
    } elseif (is_array($log_data) || is_object($log_data)) {
        $log_data = wp_json_encode($log_data);
    }

    // Prepare log entry
    $log_entry = array(
        'time'    => gmdate('d-m-Y H:i:s'),
        'trigger' => $log_trigger,
        'data'    => $log_data,
    );
    $panda_log[] = $log_entry;

    update_option('panda_logs', wp_json_encode($panda_log));
}

/**
 * Log errors that cause a Panda Import process to die
 * Then display error message to user
 *
 * @param string $error_message Optional. The error message.
 * @param mixed  $error_data Optional. Provides extra data about the error.
 **/
function panda_order($error_message = '', $error_data = '')
{
    panda_logs('order', $error_message);

    if (is_wp_error($error_data)) {
        panda_logs('Error Kode', $error_data->errors);
        panda_logs('Error Data', $error_data->error_data);
    } else {
        panda_logs('Error Kode: ', $error_data);
    }

    wp_die(esc_attr($error_message));
}

/**
 * Display Panda Robots Log in HTML table
 *
 * @return void
 **/
function panda_display_logs()
{
    $panda_log = get_option('panda_logs');
    echo '
    <table class="widefat fixed striped logs-table">
        <thead>
            <tr>
                <td>Waktu</td>
                <td>Nama</td>
                <td>Data</td>
            <tr>
        </thead>
        <tbody>
    ';

    if (false === $panda_log) {
        echo '
        <tr class="no-items">
            <td class="colspanchange" colspan="3">Tidak ada data yang ditemukan.</td>
        </tr>
        ';
    } else {
        $panda_log = json_decode($panda_log);
        array_multisort(array_column($panda_log, 'time'), SORT_DESC, $panda_log);

        if (is_array($panda_log)) {
            foreach ($panda_log as $log_entry) {
                echo '
        <tr>
            <td>' . esc_html($log_entry->time) . '</td>
            <td>' . esc_html($log_entry->trigger) . '</td>
            <td>' . esc_html($log_entry->data) . '</td>
        </tr>
                ';
            }
        } else {
            echo '
        <tr class="no-items">
            <td>-</td>
            <td>Data tidak valid.</td>
            <td>' . wp_json_encode($panda_log) . '</td>
        </tr>
            ';
        }
    }

    echo '
        </tbody>
    </table>
    ';

    if (count($panda_log) > 0 && is_array($panda_log)) {
        echo '<form action="" method="post" class="form-wrap validate">';
        echo '<p class="submit"><input type="submit" class="button button-primary button-danger" name="logs_reset" value="Hapus Log"></p>';
        echo '</form>';
    }
}

// Check if Divi Theme or Plugin is active
function panda_is_divi()
{
    $is_divi = false;

    if (function_exists('et_setup_theme')) {
        $is_divi = true;
    }
    if (defined('ET_BUILDER_THEME')) {
        $is_divi = true;
    }
    if (defined('ET_BUILDER_PLUGIN_DIR')) {
        $is_divi = true;
    }

    return $is_divi;
}

// Init Panda Feeds Options
function init_panda_feeds()
{
    $feeds = array(
        'panda'   => array(
            'link'         => 'https://feed.panda.id/',
            'url'          => 'https://feed.panda.id/feed/',
            'title'        => 'Panda Feed',
            'items'        => 20,
        ),
    );

    panda_feeds_output('panda_feeds', $feeds);
}

/**
 * Displays the Panda Feeds.
 * 
 * @param string $section   Section ID.
 * @param array  $feeds     Array of RSS feeds.
 */
function panda_feeds_output($section, $feeds)
{
    foreach ($feeds as $type => $args) {
        $args['type'] = $type;
        echo '<div class="rss-widget">';
        wp_widget_rss_output($args['url'], $args);
        echo '</div>';
    }
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
    $page = apply_filters('panda_get_' . $page . '_page_id', get_option('panda_' . $page . '_page_id'));

    return $page ? absint($page) : -1;
}

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

    $post_classes = apply_filters('post_class', $post_classes, $class, $product->ID);

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
