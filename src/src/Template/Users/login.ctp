<?php
/**
 * ログイン画面。template/login.html を反映したもの。
 * レイアウトは UsersController::beforeRender() で auth に切り替えている。
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'ログイン');
?>
<!-- Background Shape-->
<div class="background-shape"></div>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-10 col-lg-8">
      <?= $this->Html->image('/assets/img/core-img/logo-white.png', ['class' => 'big-logo', 'alt' => '']) ?>
      <!-- Login Form-->
      <div class="register-form mt-5">
        <?= $this->Form->create($user, ['url' => ['action' => 'login']]) ?>
        <div class="form-group text-start mb-4">
          <span>メールアドレス</span>
          <label for="email"><i class="ti ti-at"></i></label>
          <?= $this->Form->email('email', [
              'class' => 'form-control',
              'id' => 'email',
              'placeholder' => 'info@example.com',
          ]) ?>
          <?= $this->Form->error('email') ?>
        </div>
        <div class="form-group text-start mb-4">
          <span>パスワード</span>
          <label for="password"><i class="ti ti-key"></i></label>
          <?php // value を空に固定して、入力されたパスワードが HTML に戻らないようにする ?>
          <?= $this->Form->password('password', [
              'class' => 'form-control',
              'id' => 'password',
              'placeholder' => 'パスワード',
              'value' => '',
          ]) ?>
          <?= $this->Form->error('password') ?>
        </div>
        <button class="btn btn-warning btn-lg w-100" type="submit">ログイン<i class="ti ti-arrow-right"></i></button>
        <?= $this->Form->end() ?>
      </div>
      <!-- Login Meta-->
      <div class="login-meta-data">
        <a class="forgot-password d-block mt-3 mb-1" href="#">パスワードをお忘れですか？</a>
        <p class="mb-0">アカウントをお持ちでない方は<?= $this->Html->link('新規登録', ['action' => 'signup'], ['class' => 'mx-1']) ?></p>
      </div>
      <!-- View As Guest-->
      <div class="view-as-guest mt-3">
        <a class="btn btn-primary btn-sm" href="<?= $this->Url->build('/') ?>">
          ゲストとして閲覧
          <i class="ti ti-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>
</div>
