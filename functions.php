<?php

if (file_exists(get_stylesheet_directory() . '/master/panda-master.php') && !defined('PANDA_PATH')) {
    include_once(get_stylesheet_directory() . '/master/panda-master.php');
}

// Checking if Panda SID themes is activated
function panda_setup()
{
    add_action('admin_notices', 'panda_notices');
    panda_logs('Inisialisasi tema Panda SID telah berhasil', 'Sistem Operasi: ' . PHP_OS . ', Versi PHP: ' . PHP_VERSION);
}
add_action('after_switch_theme', 'panda_setup');

// Custom Notices
function panda_notices()
{
    echo '
    <div class="notice notice-info panda-notice is-dismissible">
        <span class="icon">
            <img src="' . get_stylesheet_directory_uri() . '/master/assets/images/panda-icons.png" alt="Panda SID" width="250">
        </span>
        <div class="notice-content">
            <h2>Terima kasih telah menggunakan Panda SID, Anda hebat! 🐼</h2>
            <p>Silahkan lakukan pengaturan awal melalui <a href="admin.php?page=panda_robots">Robot Panda</a>.</p>
        </div>
    </div>
    ';
}

// Gettings CSS and Scripts
function panda_enqueue_scripts()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_script('panda-custom-script', get_stylesheet_directory_uri() . '/scripts.js', array('jquery'), wp_get_theme()->get('Version'), true);
}
add_action('wp_enqueue_scripts', 'panda_enqueue_scripts');
