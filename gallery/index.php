<?php

/**
 * gallery/index.php
 * ギャラリー・お客様の声ページ
 */


// お客様の声データ（DBまたは静的）
$voices = [
  [
    'id'       => 1,
    'name'     => 'M.Tさん（40代・女性）',
    'cat_name' => 'ミルク（マンチカン）',
    'comment'  => 'スタッフの方がとても丁寧に猫の性格や飼い方を説明してくださり、安心してお迎えできました。ミルクは今や家族の一員で、毎日癒されています。見学だけのつもりが一目惚れしてしまいました（笑）',
    'rating'   => 5,
    'image'    => 'voice-01.jpg',
    'date'     => '2026年4月',
  ],
  [
    'id'       => 2,
    'name'     => 'K.Sさん（35代・女性）',
    'cat_name' => 'ソラ（スコティッシュフォールド）',
    'comment'  => '初めての猫飼いで不安でしたが、お迎え後も何度も相談に乗っていただき感謝しています。ソラはとても穏やかで、毎日一緒に過ごすのが楽しみです。',
    'rating'   => 5,
    'image'    => 'voice-02.jpg',
    'date'     => '2026年3月',
  ],
  [
    'id'       => 3,
    'name'     => 'A.Nさんご夫婦（50代）',
    'cat_name' => 'コト（ラグドール）',
    'comment'  => '子育てが終わり、二人で猫を迎えることにしました。コトはとても大人しくて抱っこが大好き。夫婦ともに夢中になっています。清潔な店内と健康管理の徹底ぶりが信頼できました。',
    'rating'   => 5,
    'image'    => 'voice-03.jpg',
    'date'     => '2026年2月',
  ],
  [
    'id'       => 4,
    'name'     => 'Y.Hさん（42代・女性）',
    'cat_name' => 'ハナ（ノルウェージャンフォレストキャット）',
    'comment'  => 'ふわふわの被毛に一目惚れ！ハナは活発で毎日家中を走り回っています。スタッフさんが「この子はこういう性格です」と詳しく教えてくれたので、覚悟を持ってお迎えできました（笑）',
    'rating'   => 5,
    'image'    => 'voice-04.jpg',
    'date'     => '2026年1月',
  ],
  [
    'id'       => 5,
    'name'     => 'R.Oさん（38代・女性）',
    'cat_name' => 'キナコ（アメリカンショートヘア）',
    'comment'  => '何度か見学に来て、スタッフさんと相談しながらキナコをお迎えしました。お迎え後も気軽に相談できる環境が嬉しいです。キナコは元気いっぱいで毎日笑顔をくれます。',
    'rating'   => 5,
    'image'    => 'voice-05.jpg',
    'date'     => '2025年12月',
  ],
  [
    'id'       => 6,
    'name'     => 'T.Mさん（45代・女性）',
    'cat_name' => 'ユキ（ペルシャ）',
    'comment'  => 'ペルシャ猫が欲しくてずっと探していました。ユキは本当に穏やかで、毎日一緒にソファでくつろいでいます。健康診断済みで安心してお迎えできました。',
    'rating'   => 5,
    'image'    => 'voice-06.jpg',
    'date'     => '2025年11月',
  ],
];

// ギャラリー画像データ
$gallery_images = [
  ['src' => 'gallery-01.jpg', 'alt' => '店内で遊ぶマンチカン'],
  ['src' => 'gallery-02.jpg', 'alt' => '窓辺でくつろぐスコティッシュフォールド'],
  ['src' => 'gallery-03.jpg', 'alt' => 'ラグドールのアップ'],
  ['src' => 'gallery-04.jpg', 'alt' => '遊ぶ子猫たち'],
  ['src' => 'gallery-05.jpg', 'alt' => 'ノルウェージャンフォレストキャット'],
  ['src' => 'gallery-06.jpg', 'alt' => 'ペルシャ猫のポートレート'],
  ['src' => 'gallery-07.jpg', 'alt' => 'スタッフと猫'],
  ['src' => 'gallery-08.jpg', 'alt' => 'メインクーンの子猫'],
  ['src' => 'gallery-09.jpg', 'alt' => '店内の様子'],
  ['src' => 'gallery-10.jpg', 'alt' => 'アメリカンショートヘア'],
  ['src' => 'gallery-11.jpg', 'alt' => '猫たちのお昼寝'],
  ['src' => 'gallery-12.jpg', 'alt' => 'ラグドールとお客様'],
];

$page_title       = 'ギャラリー・お客様の声 | ' . get_bloginfo('name');;
$page_description = 'ねこのいえのギャラリーとお客様の声。お迎えした猫たちの写真とオーナーさんのコメントをご紹介します。';
$body_class       = 'page-gallery';
$page_css         = ['gallery.css'];
$page_js          = ['gallery.js'];

require_once dirname(__DIR__) . '/includes/header.php';
?>

<!-- ─── ページヘッダー ──────────────────────────────────── -->
<div class="page-header">
  <div class="page-header__inner container">
    <p class="page-header__label">Gallery & Voices</p>
    <h1 class="page-header__title">ギャラリー・お客様の声</h1>
    <p class="page-header__lead">お迎えした猫たちと、飼い主さんからのうれしいお声をご紹介します。</p>
    <nav class="breadcrumb" aria-label="パンくずリスト">
      <span class="breadcrumb__item"><a href="<?php echo esc_url(home_url('/')); ?>" class="breadcrumb__link">TOP</a></span>
      <span class="breadcrumb__item">ギャラリー・お客様の声</span>
    </nav>
  </div>
</div>

<!-- ─── フォトギャラリー ─────────────────────────────────── -->
<section class="section gallery-section" aria-labelledby="gallery-title">
  <div class="container">
    <h2 id="gallery-title" class="section-title js-scroll-reveal">
      <span class="section-title__label">Photo Gallery</span>
      <span class="section-title__ja">フォトギャラリー</span>
    </h2>
    <p class="section-lead js-scroll-reveal">
      店内の猫たちの日常をご覧ください。
    </p>

    <div class="gallery-grid js-scroll-reveal" id="js-gallery-grid">
      <?php foreach ($gallery_images as $i => $img): ?>
        <div
          class="gallery-grid__item"
          data-index="<?= $i ?>"
          role="button"
          tabindex="0"
          aria-label="<?= htmlspecialchars($img['alt'], ENT_QUOTES, 'UTF-8') ?>を拡大表示">
          <img
            src="<?= get_template_directory_uri(); ?>/assets/images/gallery/<?= htmlspecialchars($img['src'], ENT_QUOTES, 'UTF-8') ?>"
            alt="<?= htmlspecialchars($img['alt'], ENT_QUOTES, 'UTF-8') ?>"
            class="gallery-grid__image"
            loading="lazy"
            width="400" height="300">
          <div class="gallery-grid__overlay">
            <i class="fa-solid fa-magnifying-glass-plus" aria-hidden="true"></i>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- SNS誘導 -->
    <div class="gallery-sns js-scroll-reveal">
      <p class="gallery-sns__text">
        <i class="fa-brands fa-instagram" aria-hidden="true"></i>
        Instagramでも毎日猫たちの様子を発信中！
      </p>
      <a
        href="https://www.instagram.com/"
        target="_blank"
        rel="noopener noreferrer"
        class="btn btn--instagram">
        <i class="fa-brands fa-instagram" aria-hidden="true"></i>
        Instagramをフォローする
      </a>
    </div>
  </div>
</section>

<!-- ─── お客様の声 ───────────────────────────────────────── -->
<section class="section section--bg-secondary voices-section" aria-labelledby="voices-title">
  <div class="container">
    <h2 id="voices-title" class="section-title js-scroll-reveal">
      <span class="section-title__label">Customer Voices</span>
      <span class="section-title__ja">お客様の声</span>
    </h2>
    <p class="section-lead js-scroll-reveal">
      猫をお迎えいただいた飼い主さんからのうれしいお声です。
    </p>

    <div class="grid grid--2 voices-grid">
      <?php foreach ($voices as $i => $voice): ?>
        <div class="voice-card js-scroll-reveal" data-delay="<?= ($i % 2) * 150 ?>">
          <div class="voice-card__header">
            <div class="voice-card__avatar-wrapper">
              <img
                src="<?= get_template_directory_uri(); ?>/assets/images/voices/<?= htmlspecialchars($voice['image'], ENT_QUOTES, 'UTF-8') ?>"
                alt="<?= htmlspecialchars($voice['name'], ENT_QUOTES, 'UTF-8') ?>"
                class="voice-card__avatar"
                loading="lazy"
                width="64" height="64">
            </div>
            <div class="voice-card__info">
              <p class="voice-card__name"><?= htmlspecialchars($voice['name'], ENT_QUOTES, 'UTF-8') ?></p>
              <p class="voice-card__cat">
                <i class="fa-solid fa-paw" aria-hidden="true"></i>
                <?= htmlspecialchars($voice['cat_name'], ENT_QUOTES, 'UTF-8') ?>
              </p>
              <div class="voice-card__stars" aria-label="評価：<?= $voice['rating'] ?>点">
                <?php for ($s = 1; $s <= 5; $s++): ?>
                  <i class="fa-solid fa-star <?= $s <= $voice['rating'] ? 'is-filled' : '' ?>" aria-hidden="true"></i>
                <?php endfor; ?>
              </div>
            </div>
            <time class="voice-card__date"><?= htmlspecialchars($voice['date'], ENT_QUOTES, 'UTF-8') ?></time>
          </div>
          <blockquote class="voice-card__comment">
            <i class="fa-solid fa-quote-left voice-card__quote-icon" aria-hidden="true"></i>
            <?= htmlspecialchars($voice['comment'], ENT_QUOTES, 'UTF-8') ?>
          </blockquote>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- 来店誘導 -->
    <div class="text-center" style="margin-top: var(--space-12);" class="js-scroll-reveal">
      <p style="font-size: var(--font-size-md); color: var(--color-text-secondary); margin-bottom: var(--space-6);">
        あなたも大切な猫との出会いを見つけてください。
      </p>
      <a href="<?php echo esc_url(home_url('/pages/cats/')); ?>" class="btn btn--primary btn--lg">
        <i class="fa-solid fa-paw" aria-hidden="true"></i>
        猫を見てみる
      </a>
    </div>
  </div>
</section>

<!-- ─── ライトボックスモーダル ──────────────────────────── -->
<div class="lightbox" id="js-lightbox" role="dialog" aria-modal="true" aria-label="画像拡大表示">
  <div class="lightbox__overlay"></div>
  <div class="lightbox__container">
    <button class="lightbox__close" aria-label="閉じる">
      <i class="fa-solid fa-xmark" aria-hidden="true"></i>
    </button>
    <button class="lightbox__prev" aria-label="前の画像">
      <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
    </button>
    <div class="lightbox__image-wrapper">
      <img src="" alt="" class="lightbox__image" id="js-lightbox-image">
    </div>
    <button class="lightbox__next" aria-label="次の画像">
      <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
    </button>
    <p class="lightbox__caption" id="js-lightbox-caption"></p>
  </div>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>