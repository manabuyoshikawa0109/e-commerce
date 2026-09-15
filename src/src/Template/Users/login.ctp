<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users form content">
    <?= $this->Form->create($user, ['url' => ['action' => 'login']]) ?>
    <fieldset>
        <legend><?= __('ログイン') ?></legend>
        <?= $this->Form->control('email', [
            'label' => 'メールアドレス',
            'type' => 'email',
        ]) ?>
        <?= $this->Form->control('password', [
            'label' => 'パスワード',
        ]) ?>
    </fieldset>
    <?= $this->Form->button(__('ログイン')) ?>
    <?= $this->Form->end() ?>

    <p><?= $this->Html->link('アカウントをお持ちでない方はこちら', ['action' => 'signup']) ?></p>
</div>
