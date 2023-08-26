<?php

/**
 * Panda Imports
 *
 * Functions used by import data
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
 * Get default import data from file
 *
 * @return array
 **/
function panda_import_data()
{
    $panda_import_file = PANDA_PATH . 'demo/panda_data_export.dat';

    if (file_exists($panda_import_file)) {
        $panda_data_import = unserialize(file_get_contents($panda_import_file));

        if (false === $panda_data_import) {
            panda_order('Tidak dapat memuat data impor');
        }
    } else {
        panda_order('Tidak dapat memuat file pengaturan', $panda_import_file);
    }

    return $panda_data_import;
}
