<?php

/**
 * Panda Shortcodes
 *
 * This functions builds for WP Admin menu items and pages.
 *
 * @package    panda-addons
 * @author     Puskomedia Indonesia <dev@puskomedia.id>
 * @copyright  2023 Puskomedia Indonesia
 * @license    GPL-2.0+
 **/

if (!defined('ABSPATH')) {
    exit;
}

function panda_options_stored_in_one_row()
{
    global $panda_store_options_in_one_row;

    return isset($panda_store_options_in_one_row) ? (bool) $panda_store_options_in_one_row : false;
}

/**
 * Gets option value from the single theme option, stored as an array in the database
 * if all options stored in one row.
 * Stores the serialized array with theme options into the global variable on the first function run on the page.
 *
 * If options are stored as separate rows in database, it simply uses get_option() function.
 *
 * @param string $option_name Theme option name.
 * @param string $default_value Default value that should be set if the theme option isn't set.
 * @param bool   $force_default_value Is return provided default.
 * @return mixed Theme option value or false if not found.
 */
function panda_get_option($option_name, $default_value = '', $force_default_value = false)
{
    if (panda_options_stored_in_one_row()) {
        $et_theme_options_name = 'panda_settings';

        if (!isset($et_theme_options)) {
            $et_theme_options = get_option($et_theme_options_name);
        }

        $option_value = isset($et_theme_options[$option_name]) ? $et_theme_options[$option_name] : false;
    } else {
        $option_value = $force_default_value ? get_option($option_name, $default_value) : get_option($option_name);
    }

    // option value might be equal to false, so check if the option is not set in the database
    if (panda_options_stored_in_one_row() && (!empty($default_value) || $force_default_value)) {
        $option_value = $default_value;
    }

    return $option_value;
}

/**
 * Update option value in theme option, stored as an array in the database
 * if all options stored in one row.
 *
 * If options are stored as separate rows in database, it simply uses update_option() function.
 *
 * @param string $option_name Theme option name.
 * @param string $new_value Theme option value.
 */
function panda_update_option($option_name, $new_value)
{
    if (panda_options_stored_in_one_row()) {
        $et_theme_options_name = 'panda_settings';
        $et_theme_options = get_option($et_theme_options_name);
        $et_theme_options[$option_name] = $new_value;

        update_option($et_theme_options_name, $et_theme_options);
    } else {
        update_option($option_name, $new_value);
    }
}
