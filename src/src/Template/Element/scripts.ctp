<?php
/**
 * 全ページ共通の JavaScript 読み込み。
 * 読み込み順に依存があるため（jquery → 各プラグイン → active.js）並びを変えないこと。
 *
 * @var \App\View\AppView $this
 */
?>
<?= $this->Html->script([
    '/assets/js/bootstrap.bundle.min.js',
    '/assets/js/jquery.min.js',
    '/assets/js/waypoints.min.js',
    '/assets/js/jquery.easing.min.js',
    '/assets/js/swiper-bundle.min.js',
    '/assets/js/jquery.magnific-popup.min.js',
    '/assets/js/jquery.counterup.min.js',
    '/assets/js/jquery.countdown.min.js',
    '/assets/js/jquery.passwordstrength.js',
    '/assets/js/jquery.nice-select.min.js',
    '/assets/js/theme-switching.js',
    '/assets/js/no-internet.js',
    '/assets/js/active.js',
    '/assets/js/pwa.js',
]) ?>
<?= $this->fetch('script') ?>
