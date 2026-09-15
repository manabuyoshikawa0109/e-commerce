<?php
use Migrations\AbstractMigration;

class CreateProducts extends AbstractMigration
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
        $table = $this->table('products', [
            'collation' => 'utf8mb4_unicode_ci',
            'comment' => '商品',
        ]);

        $table
            ->addColumn('user_id', 'integer', [
                'null' => false,
                'comment' => 'ユーザーID',
            ])
            ->addColumn('name', 'string', [
                'limit' => 255,
                'null' => false,
                'comment' => '商品名',
            ])
            ->addColumn('status', 'integer', [
                'limit' => 1,
                'signed' => false,
                'null' => false,
                'comment' => 'ステータス',
            ])
            ->addColumn('category', 'integer', [
                'limit' => 1,
                'signed' => false,
                'null' => false,
                'comment' => 'カテゴリー',
            ])
            ->addColumn('condition_rank', 'integer', [
                'limit' => 1,
                'signed' => false,
                'null' => false,
                'comment' => '状態ランク',
            ])
            ->addColumn('brand_name', 'string', [
                'limit' => 255,
                'null' => true,
                'comment' => 'ブランド名',
            ])
            ->addColumn('description', 'text', [
                'null' => true,
                'default' => null,
                'comment' => '商品説明',
            ])
            // 金額は誤差の出る float ではなく decimal を使う（税抜・円）
            ->addColumn('price', 'decimal', [
                'precision' => 10,
                'scale' => 2,
                'null' => false,
                'comment' => '販売価格',
            ])
            // CakePHP の Timestamp ビヘイビアが自動で埋めるカラム名
            ->addColumn('created', 'datetime', [
                'null' => false,
                'comment' => '作成日時',
            ])
            ->addColumn('modified', 'datetime', [
                'null' => false,
                'comment' => '更新日時',
            ]);

        $table
            // 一覧で「ステータス『販売中』『売り切れ』の商品を新着順」を引くための複合インデックス
            ->addIndex(['status', 'created'], ['name' => 'idx_products_status_created']);

        $table->create();
    }
}
