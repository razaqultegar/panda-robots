<?php

/**
 * Panda Themes
 *
 * This functions builds for themes update.
 *
 * @package    panda-addons
 * @author     Puskomedia Indonesia <dev@puskomedia.id>
 * @copyright  2023 Puskomedia Indonesia
 * @license    GPL-2.0+
 **/

if (!defined('ABSPATH')) {
    exit;
}

function panda_update_themes($transient)
{
    $theme = get_stylesheet();
    $version = wp_get_theme()->get('Version');

    if (false == $remote = get_transient('panda-theme-update' . $version)) {
        $remote = wp_remote_get(
            'https://demo.panda.id/wp-content/uploads/themes.json',
            array(
                'timeout' => 10,
                'headers' => array(
                    'Accept' => 'application/json',
                ),
            ),
        );

        if (
            is_wp_error($remote)
            || 200 !== wp_remote_retrieve_response_code($remote)
            || empty(wp_remote_retrieve_body($remote))
        ) {
            return $transient;
        }

        $remote = json_decode(wp_remote_retrieve_body($remote));

        if (!$remote) {
            return $transient;
        }

        set_transient('panda-theme-update' . $version, $remote, HOUR_IN_SECONDS);
    }

    $data = array(
        'theme' => $theme,
        'new_version' => $remote->version,
        'package' => $remote->download_url,
        'url' => $remote->details_url,
    );

    if ($remote && version_compare($version, $remote->version, '<')) {
        $transient->response[$theme] = $data;
    } else {
        $transient->no_update[$theme] = $data;
    }

    return $transient;
}
add_filter('site_transient_update_themes', 'panda_update_themes');
