<?php

/**
 * Single Product Report
 *
 * @package    panda-templates
 * @author     Puskomedia Indonesia <dev@puskomedia.id>
 * @copyright  2023 Puskomedia Indonesia
 * @license    GPL-2.0+
 */

if (!defined('ABSPATH')) {
    exit;
}

global $post;
?>

<div id="product_report">
    <div style="background: #f0f3f7; height: 1px; margin: 16px 0px;"></div>
    <div class="product_report-content">
        <div>Ada masalah dengan produk ini?</div>
        <button type="button" class="product_report-button"><svg class="unf-icon" viewBox="0 0 24 24" width="16" height="16" fill="var(--color-icon-enabled, #2E3137)" style="display: inline-block; margin-right: 6px; vertical-align: middle;"><path fill-rule="evenodd" clip-rule="evenodd" d="M21.65 19.63l-9-16a.77.77 0 00-1.3 0l-9 16A.74.74 0 003 20.74h18a.74.74 0 00.65-1.11zm-17.37-.39L12 5.52l7.72 13.72H4.28zm6.97-8.75V14a.75.75 0 101.5 0v-3.51a.75.75 0 10-1.5 0zm1.55 6.31a.8.8 0 11-1.6 0 .8.8 0 011.6 0z"></path></svg>Laporkan</button>
    </div>
</div>
