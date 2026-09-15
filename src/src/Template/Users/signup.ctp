<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users form content">
    <?= $this->Form->create($user, ['url' => ['action' => 'signup']]) ?>
    <fieldset>
        <legend><?= __('会員登録') ?></legend>
        <?= $this->Form->control('name', [
            'label' => '氏名',
        ]) ?>
        <?= $this->Form->control('email', [
            'label' => 'メールアドレス',
            'type' => 'email',
        ]) ?>
        <?= $this->Form->control('password', [
            'label' => 'パスワード',
            'help' => '8〜72文字。大文字・小文字・数字をそれぞれ1文字以上含めてください。',
        ]) ?>
        <?= $this->Form->control('tel', [
            'label' => '電話番号（任意）',
            'help' => 'ハイフンなし',
        ]) ?>
        <?= $this->Form->control('zip', [
            'label' => '郵便番号（任意）',
            'help' => 'ハイフンなし7桁。住所を入力する場合は必須です。',
        ]) ?>
        <?= $this->Form->control('address', [
            'label' => '住所（任意）',
            'help' => '郵便番号を入力する場合は必須です。',
        ]) ?>
    </fieldset>
    <?= $this->Form->button(__('登録する')) ?>
    <?= $this->Form->end() ?>

    <p><?= $this->Html->link('ログイン画面へ戻る', ['action' => 'login']) ?></p>
</div>
