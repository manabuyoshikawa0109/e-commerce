<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property int $category
 * @property int $condition_rank
 * @property string|null $brand_name
 * @property string|null $description
 * @property string $price
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\ProductImage[] $product_images
 */
class Product extends Entity
{

    /**
     * ステータス
     */
    const STATUS_ON_SALE = 1;
    const STATUS_DRAFT = 2;
    const STATUS_SOLD_OUT = 3;

    /**
     * カテゴリー
     */
    const CATEGORY_FASHION = 1;
    const CATEGORY_BABY_KIDS = 2;
    const CATEGORY_GAMES_TOYS_GOODS = 3;
    const CATEGORY_HOBBY_MUSIC_ART = 4;
    const CATEGORY_TICKETS = 5;
    const CATEGORY_BOOKS_MAGAZINES_COMICS = 6;
    const CATEGORY_CD_DVD_BLU_RAY = 7;
    const CATEGORY_SMARTPHONE_TABLET_PC = 8;
    const CATEGORY_TV_AUDIO_CAMERA = 9;
    const CATEGORY_HOME_APPLIANCES_AIR_CONDITIONING = 10;
    const CATEGORY_SPORTS = 11;
    const CATEGORY_OUTDOOR_FISHING_TRAVEL = 12;
    const CATEGORY_COSMETICS_BEAUTY = 13;
    const CATEGORY_DIET_HEALTH = 14;
    const CATEGORY_FOOD_DRINK_ALCOHOL = 15;
    const CATEGORY_KITCHEN_DAILY_GOODS_OTHERS = 16;
    const CATEGORY_FURNITURE_INTERIOR = 17;
    const CATEGORY_PET_SUPPLIES = 18;
    const CATEGORY_DIY_TOOLS = 19;
    const CATEGORY_FLOWER_GARDENING = 20;
    const CATEGORY_HANDMADE_CRAFTS = 21;
    const CATEGORY_CAR_MOTORCYCLE_BICYCLE = 22;
    const CATEGORY_OTHERS = 23;

    /**
     * 商品の状態（1が最も良い）
     */
    const CONDITION_NEW = 1;
    const CONDITION_LIKE_NEW = 2;
    const CONDITION_GOOD = 3;
    const CONDITION_FAIR = 4;
    const CONDITION_POOR = 5;

    /**
     * ステータスの表示ラベル
     *
     * @var array
     */
    public static $statusLabels = [
        self::STATUS_ON_SALE => '販売中',
        self::STATUS_DRAFT => '下書き',
        self::STATUS_SOLD_OUT => '売り切れ',
    ];

    /**
     * カテゴリーの表示ラベル
     *
     * @var array
     */
    public static $categoryLabels = [
        self::CATEGORY_FASHION => 'ファッション',
        self::CATEGORY_BABY_KIDS => 'ベビー・キッズ',
        self::CATEGORY_GAMES_TOYS_GOODS => 'ゲーム・おもちゃ・グッズ',
        self::CATEGORY_HOBBY_MUSIC_ART => 'ホビー・楽器・アート',
        self::CATEGORY_TICKETS => 'チケット',
        self::CATEGORY_BOOKS_MAGAZINES_COMICS => '本・雑誌・漫画',
        self::CATEGORY_CD_DVD_BLU_RAY => 'CD・DVD・ブルーレイ',
        self::CATEGORY_SMARTPHONE_TABLET_PC => 'スマホ・タブレット・パソコン',
        self::CATEGORY_TV_AUDIO_CAMERA => 'テレビ・オーディオ・カメラ',
        self::CATEGORY_HOME_APPLIANCES_AIR_CONDITIONING => '生活家電・空調',
        self::CATEGORY_SPORTS => 'スポーツ',
        self::CATEGORY_OUTDOOR_FISHING_TRAVEL => 'アウトドア・釣り・旅行用品',
        self::CATEGORY_COSMETICS_BEAUTY => 'コスメ・美容',
        self::CATEGORY_DIET_HEALTH => 'ダイエット・健康',
        self::CATEGORY_FOOD_DRINK_ALCOHOL => '食品・飲料・酒',
        self::CATEGORY_KITCHEN_DAILY_GOODS_OTHERS => 'キッチン・日用品・その他',
        self::CATEGORY_FURNITURE_INTERIOR => '家具・インテリア',
        self::CATEGORY_PET_SUPPLIES => 'ペット用品',
        self::CATEGORY_DIY_TOOLS => 'DIY・工具',
        self::CATEGORY_FLOWER_GARDENING => 'フラワー・ガーデニング',
        self::CATEGORY_HANDMADE_CRAFTS => 'ハンドメイド・手芸',
        self::CATEGORY_CAR_MOTORCYCLE_BICYCLE => '車・バイク・自転車',
        self::CATEGORY_OTHERS => 'その他',
    ];

    /**
     * 商品の状態の表示ラベル
     *
     * @var array
     */
    public static $conditionLabels = [
        self::CONDITION_NEW => '新品・未使用', // ['label' => 'Sold Out', 'class' => 'badge-danger']
        self::CONDITION_LIKE_NEW => '未使用に近い',
        self::CONDITION_GOOD => '目立った傷や汚れなし',
        self::CONDITION_FAIR => 'やや傷や汚れあり',
        self::CONDITION_POOR => '傷や汚れあり',
    ];

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * `id` と `created` / `modified` は許可しない。
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'status' => true,
        'category' => true,
        'condition_rank' => true,
        'brand_name' => true,
        'description' => true,
        'price' => true,
        'product_images' => true,
    ];

    /**
     * 一覧・詳細のメイン画像。
     *
     * product_images が contain されていない、または画像が無い場合は null を返す。
     * テンプレート側で null チェックしてプレースホルダーに切り替えられるようにする。
     *
     * @return string|null 画像パス
     */
    protected function _getMainImagePath()
    {
        if (empty($this->product_images)) {
            return null;
        }

        return $this->product_images[0]->path;
    }

    /**
     * 商品が売り切れか
     *
     * @return boolean
     */
    protected function _getIsSoldOut()
    {
        return $this->status === self::STATUS_SOLD_OUT;
    }

    /**
     * カテゴリーの表示ラベル
     *
     * @return string|null
     */
    protected function _getCategoryLabel()
    {
        return static::$categoryLabels[$this->category] ?? null;
    }

    /**
     * 商品の状態の表示ラベル
     *
     * @return string|null
     */
    protected function _getConditionLabel()
    {
        return static::$conditionLabels[$this->condition_rank] ?? null;
    }
}
