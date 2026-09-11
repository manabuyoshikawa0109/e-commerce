<?php
use Migrations\AbstractMigration;

class CreateProductImages extends AbstractMigration
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
        $table = $this->table('product_images', [
            'collation' => 'utf8mb4_unicode_ci',
            'comment' => '商品画像',
        ]);

        $table
            ->addColumn('product_id', 'integer', [
                'null' => false,
                'comment' => '商品ID',
            ])
            ->addColumn('path', 'string', [
                'limit' => 255,
                'null' => false,
                'comment' => '画像パス',
            ])
            ->addColumn('sort_order', 'integer', [
                'limit' => 1,
                'signed' => false,
                'null' => false,
                'comment' => '並び順',
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

        $table->create();
    }
}
