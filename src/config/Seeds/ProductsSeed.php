<?php
use Migrations\AbstractSeed;

/**
 * Products / ProductImages のダミーデータ。
 *
 * 実行: bin/cake migrations seed --seed ProductsSeed
 *
 * 何度実行しても同じ結果になるよう、先に全件削除してから投入する。
 * 開発用のシードなので本番では実行しないこと。
 */
class ProductsSeed extends AbstractSeed
{
    /**
     * 全商品で共有するサンプル画像。webroot からの絶対パスで持たせる。
     */
    const SAMPLE_IMAGE = '/img/products/sample.png';

    /**
     * Run Method.
     *
     * @return void
     */
    public function run()
    {
        // 子テーブルから先に消す（product_id が孤立するのを避けるため）
        $this->execute('DELETE FROM product_images');
        $this->execute('DELETE FROM products');
        $this->execute('ALTER TABLE product_images AUTO_INCREMENT = 1');
        $this->execute('ALTER TABLE products AUTO_INCREMENT = 1');

        $now = date('Y-m-d H:i:s');

        // [商品名, ステータス, カテゴリー, 状態ランク, ブランド, 価格]
        // ステータス 1:販売中 2:下書き 3:売り切れ
        // カテゴリー 1:ファッション 17:家具・インテリア
        // 状態ランク 1:新品・未使用 〜 5:傷や汚れあり
        $rows = [
            [1, 'Beach Cap',     1, 1,  1, 'Zara',   1300.00],
            [1, 'Wooden Sofa',   2, 17, 1, null,     74000.00],
            [1, 'Roof Lamp',     1, 17, 2, null,     9900.00],
            [2, 'Sneaker Shoes', 1, 1,  2, 'Nike',   8700.00],
            [2, 'Wooden Chair',  2, 17, 1, null,     21000.00],
            [2, 'Polo Shirts',   1, 1,  3, 'Gucci',  3800.00],
            [2, 'Summer Dress',  2, 1,  1, 'Zara',   5600.00],
            [2, 'Running Shoes', 3, 1,  4, 'Addidas', 6400.00],
            [3, 'Denim Jacket',  1, 1,  3, 'Denim',  8900.00],
            [3, 'Table Lamp',    2, 17, 5, null,     4300.00],
        ];

        $products = [];
        foreach ($rows as $row) {
            list($userId, $name, $status, $category, $conditionRank, $brandName, $price) = $row;

            $products[] = [
                'user_id' => $userId,
                'name' => $name,
                'status' => $status,
                'category' => $category,
                'condition_rank' => $conditionRank,
                'brand_name' => $brandName,
                'description' => $name . ' is a sample product for development. '
                    . 'Replace this description with real content.',
                'price' => $price,
                'created' => $now,
                'modified' => $now,
            ];
        }

        $this->table('products')->insert($products)->save();

        // 商品1件につき画像1枚。採番された id を引き直して product_id に使う
        $ids = $this->fetchAll('SELECT id FROM products ORDER BY id');

        $images = [];
        foreach ($ids as $row) {
            $images[] = [
                'product_id' => $row['id'],
                'path' => self::SAMPLE_IMAGE,
                'sort_order' => 1,
                'created' => $now,
                'modified' => $now,
            ];
        }

        $this->table('product_images')->insert($images)->save();
    }
}
