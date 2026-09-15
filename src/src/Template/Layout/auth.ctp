<?php
/**
 * ヘッダー・フッターを持たないレイアウト。
 * ログイン（Users/login.ctp）と会員登録（Users/signup.ctp）で使う。
 *
 * 元テンプレートの login.html / register.html にヘッダー・フッターが無いため、
 * default.ctp とは分けている。head と script は Element で共有。
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
    <div class="login-wrapper d-flex align-items-center justify-content-center text-center">
      <?= $this->Flash->render() ?>
      <?= $this->fetch('content') ?>
    </div>
    <!-- Internet Connection Status-->
    <div class="internet-connection-status" id="internetStatus"></div>
    <?= $this->element('scripts') ?>
  </body>
</html>
