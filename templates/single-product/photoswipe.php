<?php

/**
 * Photoswipe markup
 *
 * @package    panda-templates
 * @author     Puskomedia Indonesia <dev@puskomedia.id>
 * @copyright  2023 Puskomedia Indonesia
 * @license    GPL-2.0+
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" aria-label="<?php esc_attr_e('Keluar (Esc)', 'panda-templates'); ?>"></button>
                <button class="pswp__button pswp__button--share" aria-label="<?php esc_attr_e('Bagikan', 'panda-templates'); ?>"></button>
                <button class="pswp__button pswp__button--fs" aria-label="<?php esc_attr_e('Beralih ke layar penuh', 'panda-templates'); ?>"></button>
                <button class="pswp__button pswp__button--zoom" aria-label="<?php esc_attr_e('Memperbesar/memperkecil', 'panda-templates'); ?>"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>
            <button class="pswp__button pswp__button--arrow--left" aria-label="<?php esc_attr_e('Sebelumnya (panah kiri)', 'panda-templates'); ?>"></button>
            <button class="pswp__button pswp__button--arrow--right" aria-label="<?php esc_attr_e('Berikutnya (panah kanan)', 'panda-templates'); ?>"></button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>