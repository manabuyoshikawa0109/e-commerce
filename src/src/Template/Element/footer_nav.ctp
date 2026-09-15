<?php
/**
 * 画面下部の共通ナビゲーション。
 *
 * Home のみ商品一覧（/）へリンクする。
 * Chat / Cart / Settings / Pages は未実装のため # を指している。
 *
 * @var \App\View\AppView $this
 */
?>
<div class="footer-nav-area" id="footerNav">
  <div class="suha-footer-nav">
    <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
      <li><a href="<?= $this->Url->build('/') ?>"><i class="ti ti-home"></i>Home</a></li>
      <li><a href="#"><i class="ti ti-message"></i>Chat</a></li>
      <li><a href="#"><i class="ti ti-basket"></i>Cart</a></li>
      <li><a href="#"><i class="ti ti-settings"></i>Settings</a></li>
      <li><a href="#"><i class="ti ti-heart"></i>Pages</a></li>
    </ul>
  </div>
</div>
