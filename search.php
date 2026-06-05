<?php

/**
 * search/index.php
 * 猫の条件検索ページ
 */


// ─── 検索条件取得・サニタイズ ──────────────────────────────
$search = [
  'breed'    => trim($_GET['breed']    ?? ''),
  'gender'   => trim($_GET['gender']   ?? ''),
  'age_min'  => (int)($_GET['age_min'] ?? 0),
  'age_max'  => (int)($_GET['age_max'] ?? 99),
  'keyword'  => trim($_GET['keyword']  ?? ''),
  'sort'     => $_GET['sort'] ?? 'newest',
];

$has_searched = !empty(array_filter([
  $search['breed'],
  $search['gender'],
  $search['keyword'],
  ($search['age_min'] > 0 || $search['age_max'] < 99),
]));

// ─── 検索実行 ─────────────────────────────────────────────
$results = [];
$total   = 0;
$breeds  = [];

try {
  // 種類一覧
  global $wpdb;

  $table = $wpdb->prefix . 'neko_cats';

  $breeds = $wpdb->get_col("
    SELECT DISTINCT breed
    FROM {$table}
    WHERE status = 'available'
    ORDER BY breed
");

  if ($has_searched || isset($_GET['search'])) {
    $where  = ["status = %s"];
    $params = ['available'];

    if ($search['breed']) {
      $where[]  = "breed = %s";
      $params[] = $search['breed'];
    }

    if ($search['gender']) {
      $where[]  = "gender = %s";
      $params[] = $search['gender'];
    }

    if ($search['age_min'] > 0) {
      $where[]  = "age_months >= %d";
      $params[] = $search['age_min'];
    }

    if ($search['age_max'] < 99) {
      $where[]  = "age_months <= %d";
      $params[] = $search['age_max'];
    }

    if ($search['keyword']) {
      $where[] = "(name LIKE %s OR breed LIKE %s OR personality LIKE %s OR description LIKE %s)";
      $kw = '%' . $wpdb->esc_like($search['keyword']) . '%';
      $params = array_merge($params, [$kw, $kw, $kw, $kw]);
    }

    $order = match ($search['sort']) {
      'price_asc'  => 'price ASC',
      'price_desc' => 'price DESC',
      'age_asc'    => 'age_months ASC',
      default      => 'created_at DESC',
    };

    $sql = "SELECT * FROM {$table} WHERE " . implode(' AND ', $where) . " ORDER BY {$order}";

    $sql = $wpdb->prepare($sql, ...$params);

    $results = $wpdb->get_results($sql, ARRAY_A);

    $total = count($results);
  }
} catch (Exception $e) {
  // サンプルデータ
  $breeds = ['マンチカン', 'スコティッシュフォールド', 'ラグドール', 'ノルウェージャンフォレストキャット', 'ペルシャ', 'メインクーン', 'アメリカンショートヘア'];

  if ($has_searched || isset($_GET['search'])) {
    $all_cats = [
      ['id' => 1,  'name' => 'ミルク', 'breed' => 'マンチカン', 'age_months' => 3, 'gender' => 'female', 'personality' => '甘えん坊でとても人懐っこい女の子。膝の上が大好きです。', 'description' => 'ミルクは生後3ヶ月のマンチカンの女の子です。', 'price' => 198000, 'image_main' => 'placeholder.jpg', 'is_new' => 1],
      ['id' => 2,  'name' => 'ソラ',   'breed' => 'スコティッシュフォールド', 'age_months' => 4, 'gender' => 'male', 'personality' => '穏やかで落ち着いた性格。初めての方にもおすすめです。', 'description' => 'ソラは折れ耳が特徴的なスコティッシュフォールドの男の子。', 'price' => 248000, 'image_main' => 'placeholder.jpg', 'is_new' => 0],
      ['id' => 3,  'name' => 'ハナ',   'breed' => 'ノルウェージャンフォレストキャット', 'age_months' => 5, 'gender' => 'female', 'personality' => 'ふわふわの被毛が自慢。遊び好きで活発な女の子。', 'description' => 'ハナは豊かな被毛が魅力のノルウェージャンフォレストキャットです。', 'price' => 178000, 'image_main' => 'placeholder.jpg', 'is_new' => 1],
      ['id' => 4,  'name' => 'コト',   'breed' => 'ラグドール', 'age_months' => 2, 'gender' => 'female', 'personality' => '抱っこが大好きなおとなしい子。ブルーアイが印象的。', 'description' => 'コトは大型猫種のラグドールです。', 'price' => 228000, 'image_main' => 'placeholder.jpg', 'is_new' => 0],
      ['id' => 5,  'name' => 'ユキ',   'breed' => 'ペルシャ', 'age_months' => 6, 'gender' => 'male', 'personality' => 'のんびり屋さん。静かな環境が好きな穏やかな男の子。', 'description' => 'ユキは白く美しい被毛のペルシャ猫です。', 'price' => 268000, 'image_main' => 'placeholder.jpg', 'is_new' => 0],
    ];

    $results = array_filter($all_cats, function ($cat) use ($search) {
      if ($search['breed']  && $cat['breed']  !== $search['breed'])  return false;
      if ($search['gender'] && $cat['gender'] !== $search['gender']) return false;
      if ($search['age_min'] > 0 && $cat['age_months'] < $search['age_min']) return false;
      if ($search['age_max'] < 99 && $cat['age_months'] > $search['age_max']) return false;
      if ($search['keyword']) {
        $kw = mb_strtolower($search['keyword']);
        $haystack = mb_strtolower($cat['name'] . $cat['breed'] . $cat['personality']);
        if (strpos($haystack, $kw) === false) return false;
      }
      return true;
    });
    $results = array_values($results);
    $total   = count($results);
  }
}

$page_title       = '猫を探す | ' . get_bloginfo('name');;
$page_description = '条件から猫を検索。種類・性別・月齢・キーワードで絞り込み。';
$body_class       = 'page-search';
$page_css         = ['search.css'];

get_header();
?>

<!-- ─── ページヘッダー ──────────────────────────────────── -->
<div class="page-header">
  <div class="page-header__inner container">
    <p class="page-header__label">Search Cats</p>
    <h1 class="page-header__title">猫を探す</h1>
    <p class="page-header__lead">条件を指定して、あなたにぴったりの猫を見つけましょう。</p>
    <nav class="breadcrumb" aria-label="パンくずリスト">
      <span class="breadcrumb__item"><a href="<?php echo esc_url(home_url('/')); ?>" class="breadcrumb__link">TOP</a></span>
      <span class="breadcrumb__item">猫を探す</span>
    </nav>
  </div>
</div>

<!-- ─── 検索フォーム + 結果 ──────────────────────────────── -->
<section class="section search-section">
  <div class="container">
    <div class="search-layout">

      <!-- 検索フォーム（サイドバー） -->
      <aside class="search-sidebar" aria-label="検索条件">
        <div class="search-form-card">
          <h2 class="search-form-card__title">
            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
            条件で絞り込む
          </h2>

          <form class="form" method="GET" action="" id="js-search-form">
            <input type="hidden" name="search" value="1">

            <!-- 種類 -->
            <div class="form__group">
              <label class="form__label" for="breed">猫の種類</label>
              <select class="form__select" id="breed" name="breed">
                <option value="">すべての種類</option>
                <?php foreach ($breeds as $b): ?>
                  <option value="<?= htmlspecialchars($b, ENT_QUOTES, 'UTF-8') ?>"
                    <?= $search['breed'] === $b ? 'selected' : '' ?>>
                    <?= htmlspecialchars($b, ENT_QUOTES, 'UTF-8') ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- 性別 -->
            <div class="form__group">
              <label class="form__label">性別</label>
              <div class="form__radio-group">
                <label class="form__radio-label">
                  <input type="radio" name="gender" value="" class="form__radio-input"
                    <?= $search['gender'] === '' ? 'checked' : '' ?>>
                  指定なし
                </label>
                <label class="form__radio-label">
                  <input type="radio" name="gender" value="male" class="form__radio-input"
                    <?= $search['gender'] === 'male' ? 'checked' : '' ?>>
                  オス
                </label>
                <label class="form__radio-label">
                  <input type="radio" name="gender" value="female" class="form__radio-input"
                    <?= $search['gender'] === 'female' ? 'checked' : '' ?>>
                  メス
                </label>
              </div>
            </div>

            <!-- 月齢 -->
            <div class="form__group">
              <label class="form__label">月齢</label>
              <div class="search-age-range">
                <select class="form__select" name="age_min" id="age_min">
                  <option value="0">指定なし</option>
                  <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= $i ?>" <?= $search['age_min'] === $i ? 'selected' : '' ?>><?= $i ?>ヶ月〜</option>
                  <?php endfor; ?>
                </select>
                <span class="search-age-range__sep">〜</span>
                <select class="form__select" name="age_max" id="age_max">
                  <option value="99">指定なし</option>
                  <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= $i ?>" <?= $search['age_max'] === $i ? 'selected' : '' ?>><?= $i ?>ヶ月まで</option>
                  <?php endfor; ?>
                </select>
              </div>
            </div>

            <!-- キーワード -->
            <div class="form__group">
              <label class="form__label" for="keyword">キーワード</label>
              <input
                type="text"
                class="form__input"
                id="keyword"
                name="keyword"
                value="<?= htmlspecialchars($search['keyword'], ENT_QUOTES, 'UTF-8') ?>"
                placeholder="例：おとなしい、初心者向け、甘えん坊">
              <span class="form__hint">性格・特徴などで検索できます</span>
            </div>

            <!-- 並び順 -->
            <div class="form__group">
              <label class="form__label" for="sort">並び順</label>
              <select class="form__select" id="sort" name="sort">
                <option value="newest" <?= $search['sort'] === 'newest'     ? 'selected' : '' ?>>新着順</option>
                <option value="price_asc" <?= $search['sort'] === 'price_asc'  ? 'selected' : '' ?>>価格が安い順</option>
                <option value="price_desc" <?= $search['sort'] === 'price_desc' ? 'selected' : '' ?>>価格が高い順</option>
                <option value="age_asc" <?= $search['sort'] === 'age_asc'    ? 'selected' : '' ?>>月齢が若い順</option>
              </select>
            </div>

            <button type="submit" class="btn btn--primary" style="width: 100%;">
              <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
              この条件で検索する
            </button>

            <?php if ($has_searched || isset($_GET['search'])): ?>
              <a href="<?php echo esc_url(home_url('/search/')); ?>" class="btn btn--secondary" style="width: 100%; margin-top: var(--space-3);">
                <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                条件をリセット
              </a>
            <?php endif; ?>
          </form>
        </div>
      </aside>

      <!-- 検索結果 -->
      <main class="search-results" aria-live="polite">

        <?php if ($has_searched || isset($_GET['search'])): ?>
          <!-- 検索結果ヘッダー -->
          <div class="search-results__header">
            <p class="search-results__count">
              <?php if ($total > 0): ?>
                <strong><?= $total ?></strong> 頭の猫が見つかりました
              <?php else: ?>
                条件に合う猫が見つかりませんでした
              <?php endif; ?>
            </p>
            <?php if ($search['breed'] || $search['gender'] || $search['keyword']): ?>
              <div class="search-results__tags">
                <?php if ($search['breed']): ?>
                  <span class="search-tag"><?= htmlspecialchars($search['breed'], ENT_QUOTES, 'UTF-8') ?></span>
                <?php endif; ?>
                <?php if ($search['gender']): ?>
                  <span class="search-tag"><?= $search['gender'] === 'male' ? 'オス' : 'メス' ?></span>
                <?php endif; ?>
                <?php if ($search['keyword']): ?>
                  <span class="search-tag">"<?= htmlspecialchars($search['keyword'], ENT_QUOTES, 'UTF-8') ?>"</span>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>

          <?php if ($total > 0): ?>
            <!-- 結果グリッド -->
            <div class="grid grid--cats">
              <?php foreach ($results as $cat): ?>
                <article
                  class="cat-card js-scroll-reveal"
                  data-cat-id="<?= (int)$cat['id'] ?>"
                  role="button"
                  tabindex="0"
                  aria-label="<?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?>の詳細を見る">
                  <div class="cat-card__image-wrapper">
                    <img
                      src="<?= esc_url(get_template_directory_uri()) ?>/assets/images/cats/<?= htmlspecialchars($cat['image_main'], ENT_QUOTES, 'UTF-8') ?>"
                      alt="<?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?>"
                      class="cat-card__image"
                      loading="lazy"
                      width="400" height="300">
                    <?php if ($cat['is_new']): ?>
                      <div class="cat-card__badge"><span class="badge badge--new">NEW</span></div>
                    <?php endif; ?>
                  </div>
                  <div class="cat-card__body">
                    <p class="cat-card__breed"><?= htmlspecialchars($cat['breed'], ENT_QUOTES, 'UTF-8') ?></p>
                    <h2 class="cat-card__name"><?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?></h2>
                    <div class="cat-card__meta">
                      <span class="cat-card__meta-item">
                        <i class="fa-solid fa-venus-mars" aria-hidden="true"></i>
                        <?= $cat['gender'] === 'female' ? 'メス' : 'オス' ?>
                      </span>
                      <span class="cat-card__meta-item">
                        <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                        <?= (int)$cat['age_months'] ?>ヶ月
                      </span>
                    </div>
                    <p class="cat-card__desc"><?= htmlspecialchars($cat['personality'], ENT_QUOTES, 'UTF-8') ?></p>
                    <div class="cat-card__footer">
                      <span class="cat-card__price">¥<?= number_format((int)$cat['price']) ?></span>
                      <a href="<?= esc_url(home_url('/contact/')) ?>?cat_id=<?= (int)$cat['id'] ?>&cat_name=<?= urlencode($cat['name']) ?>" class="btn btn--sm btn--accent">
                        <i class="fa-solid fa-paw" aria-hidden="true"></i>
                        会いに行く
                      </a>
                    </div>
                  </div>
                </article>
              <?php endforeach; ?>
            </div>

            <!-- 来店誘導 -->
            <div class="search-results__cta">
              <p>気になる子はいましたか？<br>まずはお気軽に見学にお越しください。</p>
              <div style="display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; margin-top: var(--space-5);">
                <a href="<?= esc_url(home_url('/contact/')) ?>" class="btn btn--primary">
                  <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                  見学予約をする
                </a>
                <a href="<?= esc_url(home_url('/pages/store/')) ?>" class="btn btn--secondary">
                  <i class="fa-solid fa-store" aria-hidden="true"></i>
                  店舗案内を見る
                </a>
              </div>
            </div>

          <?php else: ?>
            <!-- 0件 -->
            <div class="search-results__empty">
              <i class="fa-solid fa-cat" aria-hidden="true"></i>
              <h3>条件に合う猫が見つかりませんでした</h3>
              <p>検索条件を変えてお試しください。<br>お探しの猫についてはお気軽にお問い合わせください。</p>
              <a href="<?= esc_url(home_url('/contact/')) ?>" class="btn btn--primary">
                <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                お問い合わせ
              </a>
            </div>
          <?php endif; ?>

        <?php else: ?>
          <!-- 初期状態 -->
          <div class="search-results__initial">
            <i class="fa-solid fa-paw" aria-hidden="true"></i>
            <h3>条件を選んで検索してください</h3>
            <p>左のフォームから猫の種類・性別・月齢・キーワードで絞り込めます。</p>
            <a href="<?= esc_url(home_url('/pages/cats/')) ?>" class="btn btn--primary">
              <i class="fa-solid fa-paw" aria-hidden="true"></i>
              すべての猫を見る
            </a>
          </div>
        <?php endif; ?>

      </main>
    </div>
  </div>
</section>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>