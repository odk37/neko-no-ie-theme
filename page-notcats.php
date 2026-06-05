<?php
/**
 * pages/cats.php
 * 猫の紹介ページ（一覧 + モーダル詳細）
 * PHP/MySQL連動・フィルター・モーダル対応
 */


// ─── 猫データ取得（DB接続できない場合はサンプルデータ使用） ──
$cats = [];
$breeds = [];

try {
  global $wpdb;

  $table = $wpdb->prefix . 'neko_cats'; // ← テーブル名は統一

  // 種類一覧
  $breeds = $wpdb->get_col("
    SELECT DISTINCT breed
    FROM {$table}
    WHERE status = 'available'
    ORDER BY breed
");

  // 猫一覧
  $cats = $wpdb->get_results("
    SELECT id, name, breed, age_months, gender, personality, description,
           price, image_main, image_sub1, image_sub2, is_new, status, created_at
    FROM {$table}
    WHERE status = 'available'
    ORDER BY RAND()
    LIMIT 20
", ARRAY_A);

} catch (Exception $e) {
    // DBなし時のサンプルデータ
    $cats = [
        ['id'=>1,  'name'=>'ミルク',   'breed'=>'マンチカン',                    'age_months'=>3,  'gender'=>'female', 'personality'=>'甘えん坊でとても人懐っこい女の子。膝の上が大好きです。',           'description'=>'ミルクは生後3ヶ月のマンチカンの女の子です。短い脚がとても愛らしく、人懐っこい性格で初めて猫を飼う方にもおすすめです。ワクチン接種済み・健康診断済みです。', 'price'=>198000, 'image_main'=>'placeholder.jpg', 'image_sub1'=>'', 'image_sub2'=>'', 'is_new'=>1],
        ['id'=>2,  'name'=>'ソラ',     'breed'=>'スコティッシュフォールド',      'age_months'=>4,  'gender'=>'male',   'personality'=>'穏やかで落ち着いた性格。初めての方にもおすすめです。',                 'description'=>'ソラは折れ耳が特徴的なスコティッシュフォールドの男の子。おとなしく穏やかな性格で、室内飼いにぴったりです。', 'price'=>248000, 'image_main'=>'placeholder.jpg', 'image_sub1'=>'', 'image_sub2'=>'', 'is_new'=>0],
        ['id'=>3,  'name'=>'ハナ',     'breed'=>'ノルウェージャンフォレストキャット', 'age_months'=>5, 'gender'=>'female', 'personality'=>'ふわふわの被毛が自慢。遊び好きで活発な女の子。',                  'description'=>'ハナは豊かな被毛が魅力のノルウェージャンフォレストキャットです。活発で遊び好きですが、抱っこも大好きです。', 'price'=>178000, 'image_main'=>'placeholder.jpg', 'image_sub1'=>'', 'image_sub2'=>'', 'is_new'=>1],
        ['id'=>4,  'name'=>'コト',     'breed'=>'ラグドール',                    'age_months'=>2,  'gender'=>'female', 'personality'=>'抱っこが大好きなおとなしい子。ブルーアイが印象的。',                   'description'=>'コトは大型猫種のラグドールです。抱っこされると体をぐにゃりと預けてくれる、まさにぬいぐるみのような子です。', 'price'=>228000, 'image_main'=>'placeholder.jpg', 'image_sub1'=>'', 'image_sub2'=>'', 'is_new'=>0],
        ['id'=>5,  'name'=>'ユキ',     'breed'=>'ペルシャ',                      'age_months'=>6,  'gender'=>'male',   'personality'=>'のんびり屋さん。静かな環境が好きな穏やかな男の子。',                  'description'=>'ユキは白く美しい被毛のペルシャ猫です。おとなしく穏やかで、静かな室内での生活に向いています。', 'price'=>268000, 'image_main'=>'placeholder.jpg', 'image_sub1'=>'', 'image_sub2'=>'', 'is_new'=>0],
        ['id'=>6,  'name'=>'モモ',     'breed'=>'マンチカン',                    'age_months'=>3,  'gender'=>'female', 'personality'=>'好奇心旺盛でいたずら好き。元気いっぱいの女の子。',                     'description'=>'モモは好奇心旺盛なマンチカンの女の子。家中を探検するのが大好きで、一緒にいると毎日楽しいです。', 'price'=>188000, 'image_main'=>'placeholder.jpg', 'image_sub1'=>'', 'image_sub2'=>'', 'is_new'=>1],
        ['id'=>7,  'name'=>'レオ',     'breed'=>'メインクーン',                  'age_months'=>4,  'gender'=>'male',   'personality'=>'大型猫種。穏やかで子供にも優しい男の子。',                             'description'=>'レオは大型猫種のメインクーンです。犬のように従順で、家族全員に懐く社交的な性格です。', 'price'=>298000, 'image_main'=>'placeholder.jpg', 'image_sub1'=>'', 'image_sub2'=>'', 'is_new'=>0],
        ['id'=>8,  'name'=>'チョコ',   'breed'=>'スコティッシュフォールド',      'age_months'=>5,  'gender'=>'male',   'personality'=>'茶色の被毛がかわいい。甘えん坊な男の子。',                             'description'=>'チョコはチョコレート色の被毛が特徴的なスコティッシュフォールドです。甘えん坊で飼い主さんのそばを離れません。', 'price'=>238000, 'image_main'=>'placeholder.jpg', 'image_sub1'=>'', 'image_sub2'=>'', 'is_new'=>1],
        ['id'=>9,  'name'=>'シロ',     'breed'=>'ラグドール',                    'age_months'=>3,  'gender'=>'male',   'personality'=>'真っ白な被毛が美しい。おとなしくて優しい男の子。',                     'description'=>'シロは純白の被毛が美しいラグドールです。おとなしく優しい性格で、高齢の方にもおすすめです。', 'price'=>218000, 'image_main'=>'placeholder.jpg', 'image_sub1'=>'', 'image_sub2'=>'', 'is_new'=>0],
        ['id'=>10, 'name'=>'キナコ',   'breed'=>'アメリカンショートヘア',        'age_months'=>4,  'gender'=>'female', 'personality'=>'活発でおてんば。でも甘えん坊な一面も。',                               'description'=>'キナコはキャラクターのある被毛模様が特徴のアメリカンショートヘアです。活発ですが人懐っこく、遊び好きです。', 'price'=>158000, 'image_main'=>'placeholder.jpg', 'image_sub1'=>'', 'image_sub2'=>'', 'is_new'=>0],
    ];

    $breeds = array_unique(array_column($cats, 'breed'));
    sort($breeds);
}

// AJAX リクエスト（モーダル詳細取得）
if (isset($_GET['ajax']) && $_GET['ajax'] === 'cat_detail' && isset($_GET['id'])) {
    header('Content-Type: application/json; charset=UTF-8');
    $cat_id = (int)$_GET['id'];

    try {
    global $wpdb;

    $table = $wpdb->prefix . 'neko_cats';

    $cat = $wpdb->get_row(
      $wpdb->prepare(
        "SELECT * FROM {$table} WHERE id = %d AND status = 'available'",
        $cat_id
      ),
      ARRAY_A
    );
    } catch (Exception $e) {
        // サンプルデータから返す
        $found = array_filter($cats, fn($c) => $c['id'] === $cat_id);
        echo json_encode(array_values($found)[0] ?? ['error' => 'Not found']);
    }
    exit;
}

$page_title       = '猫を見る | ' . get_bloginfo('name');;
$page_description = 'ねこのいえに在籍中の猫たちをご紹介。マンチカン・スコティッシュフォールド・ラグドールなど多数。';
$body_class       = 'page-cats';
$page_css         = ['cats.css'];
$page_js          = ['cats.js'];

get_header();
?>

<!-- ─── ページヘッダー ──────────────────────────────────── -->
<div class="page-header">
  <div class="page-header__inner container">
    <p class="page-header__label">Meet Our Cats</p>
    <h1 class="page-header__title">猫を見る</h1>
    <p class="page-header__lead">現在ご縁を待っている子たちをご紹介します。<br>気になる子がいたら、ぜひ会いに来てください。</p>
    <nav class="breadcrumb" aria-label="パンくずリスト">
      <span class="breadcrumb__item"><a href="<?= esc_url(home_url('/')) ?>" class="breadcrumb__link">TOP</a></span>
      <span class="breadcrumb__item">猫を見る</span>
    </nav>
  </div>
</div>

<!-- ─── フィルタータブ + 猫一覧 ─────────────────────────── -->
<section class="section cats-list" aria-labelledby="cats-list-title">
  <div class="container js-filter-section">

    <h2 id="cats-list-title" class="visually-hidden">猫一覧</h2>

    <!-- フィルタータブ -->
    <div class="filter-tabs" role="tablist" aria-label="猫の種類で絞り込み">
      <button
        class="filter-tabs__btn is-active"
        data-filter="all"
        role="tab"
        aria-selected="true"
      >すべて（<?= count($cats) ?>頭）</button>

      <?php foreach ($breeds as $breed): ?>
      <button
        class="filter-tabs__btn"
        data-filter="<?= htmlspecialchars($breed, ENT_QUOTES, 'UTF-8') ?>"
        role="tab"
        aria-selected="false"
      ><?= htmlspecialchars($breed, ENT_QUOTES, 'UTF-8') ?></button>
      <?php endforeach; ?>
    </div>

    <!-- 猫カードグリッド -->
    <div class="grid grid--cats" id="js-cats-grid">
      <?php foreach ($cats as $cat): ?>
      <article
        class="cat-card js-scroll-reveal"
        data-category="<?= htmlspecialchars($cat['breed'], ENT_QUOTES, 'UTF-8') ?>"
        data-cat-id="<?= (int)$cat['id'] ?>"
        role="button"
        tabindex="0"
        aria-label="<?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?>の詳細を見る"
      >
        <div class="cat-card__image-wrapper">
          <img
            src="<?= esc_url(get_template_directory_uri() . '/assets/images/cats/' . $cat['image_main']) ?>"
            alt="<?= esc_html($cat['name']) ?>"
            class="cat-card__image"
            loading="lazy"
            width="400" height="300"
          >
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
            <span class="btn btn--sm btn--primary">詳しく見る</span>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>

    <!-- 猫が0件の場合 -->
    <div class="cats-list__empty" id="js-cats-empty" style="display:none;">
      <p class="cats-list__empty-text">
        <i class="fa-solid fa-cat" aria-hidden="true"></i><br>
        現在この種類の猫は在籍しておりません。<br>
        お気軽にお問い合わせください。
      </p>
      <a href="<?= esc_url(home_url('/contact/')) ?>" class="btn btn--primary">お問い合わせ</a>
    </div>

  </div>
</section>

<!-- ─── 来店誘導バナー ──────────────────────────────────── -->
<section class="section section--bg-secondary cats-cta" aria-labelledby="cats-cta-title">
  <div class="container text-center">
    <h2 id="cats-cta-title" class="section-title js-scroll-reveal">
      <span class="section-title__label">Come Visit Us</span>
      <span class="section-title__ja">会いに来てください</span>
    </h2>
    <p class="section-lead js-scroll-reveal">
      写真だけではわからない、猫の本当の魅力があります。<br>
      ぜひ実際に触れ合ってみてください。
    </p>
    <div style="display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap;" class="js-scroll-reveal">
      <a href="<?= esc_url(home_url('/contact/')) ?>" class="btn btn--primary btn--lg">
        <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
        見学予約をする
      </a>
      <a href="<?= esc_url(home_url('/cats/')) ?>" class="btn btn--secondary btn--lg">
        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
        条件で猫を探す
      </a>
    </div>
  </div>
</section>

<!-- ─── 猫詳細モーダル ──────────────────────────────────── -->
<div class="modal" id="js-cat-modal" role="dialog" aria-modal="true" aria-labelledby="modal-cat-name">
  <div class="modal__overlay" aria-hidden="true"></div>
  <div class="modal__container">
    <button class="modal__close" aria-label="閉じる">
      <i class="fa-solid fa-xmark" aria-hidden="true"></i>
    </button>

    <!-- 画像スライダー -->
    <div class="modal__image-wrapper">
      <div class="swiper modal__swiper" id="js-modal-swiper">
        <div class="swiper-wrapper" id="js-modal-images">
          <!-- JSで動的挿入 -->
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    </div>

    <div class="modal__body">
      <p class="modal__breed" id="js-modal-breed"></p>
      <h2 class="modal__name" id="modal-cat-name"></h2>

      <div class="modal__profile">
        <div class="modal__profile-item">
          <span class="modal__profile-label">性別</span>
          <span class="modal__profile-value" id="js-modal-gender"></span>
        </div>
        <div class="modal__profile-item">
          <span class="modal__profile-label">月齢</span>
          <span class="modal__profile-value" id="js-modal-age"></span>
        </div>
        <div class="modal__profile-item">
          <span class="modal__profile-label">価格</span>
          <span class="modal__profile-value" id="js-modal-price"></span>
        </div>
        <div class="modal__profile-item">
          <span class="modal__profile-label">ステータス</span>
          <span class="modal__profile-value"><span class="badge badge--accent">見学受付中</span></span>
        </div>
      </div>

      <p class="modal__desc" id="js-modal-desc"></p>

      <div class="modal__actions">
        <a href="<?= esc_url(home_url('/contact/')) ?>" class="btn btn--primary btn--lg">
          <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
          この子に会いに行く
        </a>
        <a href="<?= esc_url(home_url('/contact/')) ?>" class="btn btn--secondary">
          <i class="fa-regular fa-envelope" aria-hidden="true"></i>
          この子について問い合わせる
        </a>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>