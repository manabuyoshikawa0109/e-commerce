<?php
/**
 * ヘッダー・フッター付きの共通レイアウト。
 * 商品一覧（Products/list.ctp）と商品詳細（Products/detail.ctp）で使う。
 *
 * ヘッダーの左右は画面ごとに中身が変わるため、ビューブロックで差し込む。
 *   - title       : ヘッダー中央に出すページ名
 *   - headerLeft  : 戻るボタンなど
 *   - headerRight : フィルターアイコン、ナビゲーショントグルなど
 *
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <?= $this->element('html_head') ?>
  </head>
  <body>
    <!-- Preloader-->
    <div class="preloader" id="preloader">
      <div class="spinner-grow text-secondary" role="status">
        <div class="sr-only"></div>
      </div>
    </div>
    <!-- Header Area-->
    <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between gap-2">
        <?= $this->fetch('headerLeft') ?>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0"><?= $this->fetch('title') ?></h6>
        </div>
        <?= $this->fetch('headerRight') ?>
      </div>
    </div>
    <?= $this->fetch('offcanvas') ?>
    <div class="page-content-wrapper">
      <?= $this->Flash->render() ?>
      <?= $this->fetch('content') ?>
    </div>
    <!-- Internet Connection Status-->
    <div class="internet-connection-status" id="internetStatus"></div>
    <?= $this->element('footer_nav') ?>
    <?= $this->element('scripts') ?>
  </body>
</html>
