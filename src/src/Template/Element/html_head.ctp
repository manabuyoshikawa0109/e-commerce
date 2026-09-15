<?php
/**
 * <head> の共通部分。
 * Layout/default.ctp と Layout/auth.ctp の両方から読み込まれる。
 *
 * @var \App\View\AppView $this
 */
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
<meta name="description" content="Suha - Multipurpose E-commerce Mobile HTML Template">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="theme-color" content="#625AFA">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<?= $this->Html->charset() ?>
<title><?= $this->fetch('title') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&amp;display=swap" rel="stylesheet">
<!-- Favicon -->
<link rel="icon" href="<?= $this->Url->build('/assets/img/icons/icon-72x72.png') ?>">
<!-- Apple Touch Icon -->
<link rel="apple-touch-icon" href="<?= $this->Url->build('/assets/img/icons/icon-96x96.png') ?>">
<link rel="apple-touch-icon" sizes="152x152" href="<?= $this->Url->build('/assets/img/icons/icon-152x152.png') ?>">
<link rel="apple-touch-icon" sizes="167x167" href="<?= $this->Url->build('/assets/img/icons/icon-167x167.png') ?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?= $this->Url->build('/assets/img/icons/icon-180x180.png') ?>">
<!-- CSS Libraries -->
<?= $this->Html->css([
    '/assets/css/bootstrap.min.css',
    '/assets/css/tabler-icons.min.css',
    '/assets/css/animate.css',
    '/assets/css/swiper-bundle.min.css',
    '/assets/css/magnific-popup.css',
    '/assets/css/nice-select.css',
    '/style.css',
]) ?>
<!-- Web App Manifest -->
<link rel="manifest" href="<?= $this->Url->build('/manifest.json') ?>">
<?= $this->fetch('meta') ?>
<?= $this->fetch('css') ?>
