<?php

/**
 * Panda Master
 *
 * Functions used by master
 *
 * @package    panda-master
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
function panda_log($log_trigger, $log_data = '')
{
    $panda_log = get_option('panda_log');
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

    update_option('panda_log', wp_json_encode($panda_log));
}

/**
 * Display Panda Robots Log in HTML table
 *
 * * @return void
 **/
function panda_display_log()
{
    $panda_log = get_option('panda_log');
    echo '
    <table class="widefat striped logs-table">
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
        array_multisort(array_column($panda_log, 'time'), SORT_ASC, $panda_log);

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
