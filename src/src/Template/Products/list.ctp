<?php
/**
 * 商品一覧。template/shop-grid.html を反映したもの。
 * ログイン前後ともトップページ（/）として表示される。
 *
 * ヘッダーとフッターは Layout/default.ctp が描画する。
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface $products
 */
$this->assign('title', 'Product List');

// ヘッダー左側
$this->start('headerLeft');
?>
<div></div>
<?php
$this->end();
// ヘッダー右側のフィルターアイコン
$this->start('headerRight');
?>
<div class="filter-option ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaFilterOffcanvas" aria-controls="suhaFilterOffcanvas">
  <i class="ti ti-adjustments-horizontal"></i>
</div>
<?php
$this->end();

// 絞り込みパネル。現時点では見た目のみで、絞り込み処理は未実装
$this->start('offcanvas');
?>
<div class="offcanvas offcanvas-start suha-filter-offcanvas-wrap" tabindex="-1" id="suhaFilterOffcanvas" aria-labelledby="suhaFilterOffcanvasLabel">
  <!-- Close button-->
  <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="閉じる"></button>
  <!-- Offcanvas body-->
  <div class="offcanvas-body py-5">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <!-- Condition-->
          <div class="widget catagory mb-4">
            <h6 class="widget-title mb-2">商品の状態</h6>
            <div class="widget-desc">
              <?php foreach (\App\Model\Entity\Product::$conditionLabels as $rank => $label) : ?>
                <div class="form-check">
                  <input class="form-check-input" id="condition-<?= $rank ?>" type="checkbox">
                  <label class="form-check-label" for="condition-<?= $rank ?>"><?= h($label) ?></label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <div class="col-12">
          <!-- Price Range-->
          <div class="widget price-range mb-4">
            <h6 class="widget-title mb-2">キーワード</h6>
            <div class="widget-desc">
              <div class="col-12">
                <div class="form-floating">
                  <input class="form-control" id="keyWord" type="text" placeholder="キーワードから探す">
                  <label for="keyWord">キーワードから探す</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <!-- Price Range-->
          <div class="widget price-range mb-4">
            <h6 class="widget-title mb-2">価格帯</h6>
            <div class="widget-desc">
              <div class="row g-2">
                <div class="col-12">
                  <div class="form-floating">
                    <input class="form-control" id="priceMin" type="text" placeholder="0">
                    <label for="priceMin">最低価格</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <input class="form-control" id="priceMax" type="text" placeholder="100000">
                    <label for="priceMax">最高価格</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <!-- Apply Filter-->
          <div class="apply-filter-btn">
            <a class="btn btn-lg btn-success w-100" href="#">
              <i class="ti ti-search"></i>
              絞り込む
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$this->end();
?>
<div class="py-3">
  <div class="container">
    <div class="row g-1 align-items-center">
      <div class="col-8">
        <!-- Product Categories Slide-->
        <div class="product-catagories swiper catagory-slides">
          <div class="swiper-wrapper">
            <?php foreach (\App\Model\Entity\Product::$categoryLabels as $categoryLabel) : ?>
              <a class="shadow-sm swiper-slide" href="#"><?= h($categoryLabel) ?></a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="col-4">
        <!-- Sort-->
        <div class="select-product-catagory">
          <select class="right small border-0" id="selectProductCatagory" name="selectProductCatagory" aria-label="並び替え">
            <option value="" selected>並び替え</option>
            <option value="1">新着順</option>
            <option value="2">人気順</option>
            <option value="3">評価順</option>
          </select>
        </div>
      </div>
    </div>
    <div class="mb-3"></div>
    <div class="row g-2">
      <?php if (count($products) === 0) : ?>
        <div class="col-12">
          <p class="text-center text-muted py-5 mb-0">商品がまだ登録されていません。</p>
        </div>
      <?php endif; ?>
      <?php foreach ($products as $product) : ?>
        <!-- Product Card -->
        <div class="col-6 col-md-4">
          <?= $this->element('product_card', ['product' => $product]) ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
