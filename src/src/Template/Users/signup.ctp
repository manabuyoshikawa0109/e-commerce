<?php
/**
 * 会員登録画面。template/register.html を反映したもの。
 * レイアウトは UsersController::beforeRender() で auth に切り替えている。
 *
 * 元テンプレートには無いが、users テーブルに合わせて電話番号・郵便番号・住所を追加している。
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', '会員登録');
?>
<!-- Background Shape-->
<div class="background-shape"></div>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-10 col-lg-8">
      <?= $this->Html->image('/assets/img/core-img/logo-white.png', ['class' => 'big-logo', 'alt' => '']) ?>
      <!-- Register Form-->
      <div class="register-form mt-5">
        <?= $this->Form->create($user, ['url' => ['action' => 'signup']]) ?>
        <div class="form-group text-start mb-4">
          <span>氏名</span>
          <label for="name"><i class="ti ti-user"></i></label>
          <?= $this->Form->text('name', [
              'class' => 'form-control',
              'id' => 'name',
              'placeholder' => '山田 太郎',
          ]) ?>
          <?= $this->Form->error('name') ?>
        </div>
        <div class="form-group text-start mb-4">
          <span>メールアドレス</span>
          <label for="email"><i class="ti ti-at"></i></label>
          <?= $this->Form->email('email', [
              'class' => 'form-control',
              'id' => 'email',
              'placeholder' => 'help@example.com',
          ]) ?>
          <?= $this->Form->error('email') ?>
        </div>
        <div class="form-group text-start mb-4">
          <span>パスワード</span>
          <label for="registerPassword"><i class="ti ti-key"></i></label>
          <?php
          /*
           * value を明示的に空にする。指定しないと、バリデーション失敗時に
           * CakePHP が _invalid に退避した「入力された生パスワード」を
           * value 属性に書き戻してしまう。
           */
          ?>
          <?= $this->Form->password('password', [
              'class' => 'input-psswd form-control',
              'id' => 'registerPassword',
              'placeholder' => '8〜72文字（大文字・小文字・数字を各1文字以上）',
              'value' => '',
          ]) ?>
          <?= $this->Form->error('password') ?>
        </div>
        <button class="btn btn-warning btn-lg w-100" type="submit">
          登録する
          <i class="ti ti-arrow-right"></i>
        </button>
        <?= $this->Form->end() ?>
      </div>
      <!-- Login Meta-->
      <div class="login-meta-data">
        <p class="mt-3 mb-0">すでにアカウントをお持ちの方は<?= $this->Html->link('ログイン', ['action' => 'login'], ['class' => 'mx-1']) ?></p>
      </div>
    </div>
  </div>
</div>
