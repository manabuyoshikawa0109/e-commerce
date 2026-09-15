<?php
use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('users', [
            'collation' => 'utf8mb4_unicode_ci',
            'comment' => '利用者',
        ]);

        $table
            ->addColumn('email', 'string', [
                'limit' => 255,
                'null' => false,
                'comment' => 'メールアドレス（ログインID）',
            ])
            // bcrypt のハッシュは 60 文字。将来アルゴリズムが変わっても収まるよう 255
            ->addColumn('password', 'string', [
                'limit' => 255,
                'null' => false,
                'comment' => 'パスワード（bcryptハッシュ）',
            ])
            ->addColumn('name', 'string', [
                'limit' => 100,
                'null' => false,
                'comment' => '氏名',
            ])
            ->addColumn('tel', 'string', [
                'limit' => 11,
                'null' => true,
                'comment' => '電話番号',
            ])
            ->addColumn('zip', 'string', [
                'limit' => 7,
                'null' => true,
                'comment' => '郵便番号',
            ])
            ->addColumn('address', 'string', [
                'limit' => 255,
                'null' => true,
                'comment' => '住所',
            ])
            ->addColumn('created', 'datetime', [
                'null' => false,
                'comment' => '作成日時',
            ])
            ->addColumn('modified', 'datetime', [
                'null' => false,
                'comment' => '更新日時',
            ]);

        // ログインIDなので一意制約は必須（アプリ側の検証だけでは同時登録をすり抜ける）
        $table->addIndex(['email'], ['unique' => true, 'name' => 'idx_users_email']);

        $table->create();
    }
}
