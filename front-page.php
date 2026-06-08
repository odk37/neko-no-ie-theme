<?php

/**
 * index.php
 * トップページ
 */
// ─── データ取得 ────────────────────────────────────────────
// 注目の猫（最新8件）
global $wpdb;

$table_name = $wpdb->prefix . 'neko_cats';

$featured_cats = $wpdb->get_results(
  "
    SELECT id, name, breed, age_months, gender, personality, price, image_main, is_new
    FROM {$table_name}
    WHERE status = 'available'
    ORDER BY created_at DESC
    LIMIT 8
    ",
  ARRAY_A
);

$news_query = new WP_Query([
  'post_type' => 'post',
  'posts_per_page' => 5,
  'post_status' => 'publish',
  'category_name'  => 'news',
]);

$label = get_field('label');
$heading = get_field('heading');
$lead = get_field('lead');

?>
<?php get_header(); ?>
<!-- ─── ヒーロースライダー ──────────────────────────────── -->
<section class="hero" aria-label="メインビジュアル">
  <div class="swiper hero__swiper" id="js-hero-swiper">
    <div class="swiper-wrapper">

      <!-- スライド1 -->
      <div class="swiper-slide hero__slide">
        <img
          src="<?= get_template_directory_uri(); ?>/assets/images/hero/hero-03.jpg"
          alt="猫と穏やかな暮らし"
          class="hero__slide-image"
          width="1920" height="1080"
          fetchpriority="high">
        <div class="hero__slide-overlay"></div>
      </div>

      <!-- スライド2 -->
      <div class="swiper-slide hero__slide">
        <img
          src="<?= get_template_directory_uri(); ?>/assets/images/hero/hero-03.jpg"
          alt="マンチカンの子猫"
          class="hero__slide-image"
          width="1920" height="1080"
          loading="lazy">
        <div class="hero__slide-overlay"></div>
      </div>

      <!-- スライド3 -->
      <div class="swiper-slide hero__slide">
        <img
          src="<?= get_template_directory_uri(); ?>/assets/images/hero/hero-03.jpg"
          alt="スコティッシュフォールド"
          class="hero__slide-image"
          width="1920" height="1080"
          loading="lazy">
        <div class="hero__slide-overlay"></div>
      </div>

    </div>
    <div class="swiper-pagination"></div>
  </div>

  <!-- ヒーローコンテンツ -->
  <div class="hero__content">
    <?php if (!empty($label)): ?>
      <p class="hero__eyebrow u-fade-in-up">
        <?= esc_html($label); ?>
      </p>
    <?php endif; ?>
    <?php if (!empty($heading)): ?>
      <h1 class="hero__title u-fade-in-up">
        <?= nl2br(esc_html($heading)); ?>
      </h1>
    <?php endif; ?>
    <?php if (!empty($lead)): ?>
      <p class="hero__subtitle u-fade-in-up">
        <?= nl2br(esc_html($lead)); ?>
      </p>
    <?php endif; ?>
    <div class="hero__actions btn-group--light u-fade-in-up">
      <a href="<?php echo esc_url(home_url('/cats/')); ?>" class="btn btn--primary btn--lg">
        <i class="fa-solid fa-paw" aria-hidden="true"></i>
        猫を見る
      </a>
      <a href="<?php echo esc_url(home_url('/store/')); ?>" class="btn btn--secondary btn--lg" style="border-color: rgba(255,255,255,0.7); color: #fff;">
        <i class="fa-solid fa-store" aria-hidden="true"></i>
        初めての方へ
      </a>
    </div>
  </div>

  <!-- スクロールインジケーター -->
  <div class="hero__scroll-indicator-wrapper" aria-hidden="true">
    <div class="hero__scroll-indicator">
      <span>Scroll</span>
      <span class="hero__scroll-line"></span>
    </div>
  </div>
</section>

<!-- ─── 特徴セクション ──────────────────────────────────── -->
<section class="section features" aria-labelledby="features-title">
  <div class="container">
    <h2 id="features-title" class="section-title js-scroll-reveal">
      <span class="section-label">Our Promise</span>
      <span class="section-title__ja">ねこのいえが選ばれる理由</span>
    </h2>

    <div class="features__grid">

      <div class="feature-item js-scroll-reveal" data-delay="0">
        <div class="feature-item__icon">
          <i class="fa-solid fa-heart-pulse" aria-hidden="true"></i>
        </div>
        <h3 class="feature-item__title">健康管理の徹底</h3>
        <p class="feature-item__desc">
          すべての猫は獣医師による健康診断を実施。ワクチン接種・ウイルス検査済みで、安心してお迎えいただけます。
        </p>
      </div>

      <div class="feature-item js-scroll-reveal" data-delay="150">
        <div class="feature-item__icon">
          <i class="fa-solid fa-user-nurse" aria-hidden="true"></i>
        </div>
        <h3 class="feature-item__title">専門スタッフによるサポート</h3>
        <p class="feature-item__desc">
          猫を愛するスタッフが、お迎え前から迎えた後まで丁寧にサポート。初めての方も安心してご相談いただけます。
        </p>
      </div>

      <div class="feature-item js-scroll-reveal" data-delay="300">
        <div class="feature-item__icon">
          <i class="fa-solid fa-house-chimney-heart" aria-hidden="true"></i>
        </div>
        <h3 class="feature-item__title">アフターフォロー充実</h3>
        <p class="feature-item__desc">
          お迎え後も安心の生涯サポート。飼育相談・健康相談に随時対応。猫と飼い主さんの幸せな生活を応援します。
        </p>
      </div>

    </div>
  </div>
</section>

<!-- ─── 注目の猫 ─────────────────────────────────────────── -->
<section class="section featured-cats section--bg-secondary" aria-labelledby="featured-cats-title">
  <div class="container">
    <h2 id="featured-cats-title" class="section-title js-scroll-reveal">
      <span class="section-label">Meet Our Cats</span>
      <span class="section-title__ja">今いる猫たち</span>
    </h2>
    <p class="section-lead js-scroll-reveal">現在ご縁を待っている子たちをご紹介します。<br>ぜひ実際に会いに来てください。</p>

    <?php if (!empty($featured_cats)): ?>
      <div class="swiper featured-cats__swiper js-scroll-reveal" id="js-cats-swiper">
        <div class="swiper-wrapper">
          <?php foreach ($featured_cats as $cat): ?>
            <div class="swiper-slide">
              <div
                class="cat-card"
                data-cat-id="<?= (int)$cat['id'] ?>"
                role="button"
                tabindex="0"
                aria-label="<?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?>の詳細を見る">
                <div class="cat-card__image-wrapper">
                  <img
                    src="<?= get_template_directory_uri(); ?>/assets/images/cats/<?= htmlspecialchars($cat['image_main'], ENT_QUOTES, 'UTF-8') ?>"
                    alt="<?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?>"
                    class="cat-card__image"
                    loading="lazy"
                    width="400" height="300">
                  <?php if ($cat['is_new']): ?>
                    <div class="cat-card__badge">
                      <span class="badge badge--new">NEW</span>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="cat-card__body">
                  <p class="cat-card__breed"><?= htmlspecialchars($cat['breed'], ENT_QUOTES, 'UTF-8') ?></p>
                  <h3 class="cat-card__name"><?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?></h3>
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
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    <?php else: ?>
      <!-- サンプル表示（DBなし時のフォールバック） -->
      <div class="grid grid--cats">
        <?php
        $sample_cats = [
          ['name' => 'ミルク', 'breed' => 'マンチカン', 'gender' => 'female', 'age' => 3, 'personality' => '甘えん坊でとても人懐っこい女の子。膝の上が大好きです。', 'price' => 198000, 'img' => 'cat-sample-01.jpg', 'new' => true],
          ['name' => 'ソラ',  'breed' => 'スコティッシュフォールド', 'gender' => 'male', 'age' => 4, 'personality' => '穏やかで落ち着いた性格。初めて猫を飼う方にもおすすめです。', 'price' => 248000, 'img' => 'cat-sample-02.jpg', 'new' => false],
          ['name' => 'ハナ',  'breed' => 'ノルウェージャンフォレストキャット', 'gender' => 'female', 'age' => 5, 'personality' => 'ふわふわの被毛が自慢。遊び好きで活発な女の子。', 'price' => 178000, 'img' => 'cat-sample-03.jpg', 'new' => true],
          ['name' => 'コト',  'breed' => 'ラグドール', 'gender' => 'female', 'age' => 2, 'personality' => '抱っこが大好きなおとなしい子。ブルーアイが印象的です。', 'price' => 228000, 'img' => 'cat-sample-04.jpg', 'new' => false],
        ];
        foreach ($sample_cats as $cat):
        ?>
          <div class="cat-card js-cat-card" data-cat-id="0">
            <div class="cat-card__image-wrapper">
              <img
                src="<?= get_template_directory_uri(); ?>/assets/images/cats/placeholder.jpg"
                alt="<?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?>"
                class="cat-card__image"
                loading="lazy">
              <?php if ($cat['new']): ?>
                <div class="cat-card__badge"><span class="badge badge--new">NEW</span></div>
              <?php endif; ?>
            </div>
            <div class="cat-card__body">
              <p class="cat-card__breed"><?= htmlspecialchars($cat['breed'], ENT_QUOTES, 'UTF-8') ?></p>
              <h3 class="cat-card__name"><?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?></h3>
              <div class="cat-card__meta">
                <span class="cat-card__meta-item">
                  <i class="fa-solid fa-venus-mars" aria-hidden="true"></i>
                  <?= $cat['gender'] === 'female' ? 'メス' : 'オス' ?>
                </span>
                <span class="cat-card__meta-item">
                  <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                  <?= $cat['age'] ?>ヶ月
                </span>
              </div>
              <p class="cat-card__desc"><?= htmlspecialchars($cat['personality'], ENT_QUOTES, 'UTF-8') ?></p>
              <div class="cat-card__footer">
                <span class="cat-card__price">¥<?= number_format($cat['price']) ?></span>
                <span class="btn btn--sm btn--primary">詳しく見る</span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="text-center" style="margin-top: var(--space-10);">
      <a href="<?php echo esc_url(home_url('/cats/')); ?>" class="btn btn--primary btn--lg js-scroll-reveal">
        <i class="fa-solid fa-paw" aria-hidden="true"></i>
        すべての猫を見る
      </a>
    </div>
  </div>
</section>

<!-- ─── 初めての方へ ─────────────────────────────────────── -->
<section class="section first-visit" aria-labelledby="first-visit-title">
  <div class="container">
    <div class="first-visit__inner">
      <div class="first-visit__content js-scroll-reveal js-scroll-reveal--left">
        <p class="first-visit__eyebrow">For First Visitors</p>
        <h2 id="first-visit__title" class="first-visit__title">
          初めての方も<br>安心してお越しください
        </h2>
        <p class="first-visit__desc">
          「猫を飼うのは初めて」という方も大歓迎です。<br>
          見学だけでも構いません。スタッフが丁寧にご案内します。
        </p>
        <div class="first-visit__steps">
          <div class="first-visit__step">
            <span class="first-visit__step-num">1</span>
            <p class="first-visit__step-text">まずはお気軽にご来店。予約不要で見学できます。</p>
          </div>
          <div class="first-visit__step">
            <span class="first-visit__step-num">2</span>
            <p class="first-visit__step-text">スタッフが猫の性格・飼育方法を詳しくご説明します。</p>
          </div>
          <div class="first-visit__step">
            <span class="first-visit__step-num">3</span>
            <p class="first-visit__step-text">気に入った子がいれば、じっくりお話しながら検討できます。</p>
          </div>
        </div>
        <div class="first-visit__actions btn-group--light">
          <a href="<?php echo esc_url(home_url('/store/')); ?>" class="btn btn--primary">
            <i class="fa-solid fa-store" aria-hidden="true"></i>
            店舗のご案内
          </a>
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--secondary">
            <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
            見学予約
          </a>
        </div>
      </div>
      <div class="first-visit__image-wrapper js-scroll-reveal js-scroll-reveal--right">
        <img
          src="<?= get_template_directory_uri(); ?>/assets/images/store/store-interior.jpg"
          alt="ねこのいえ店内の様子"
          class="first-visit__image"
          loading="lazy"
          width="600" height="750">
      </div>
    </div>
  </div>
</section>

<!-- ─── お知らせ ─────────────────────────────────────────── -->
<section class="section top-news" aria-labelledby="top-news-title">
  <div class="container">
    <div class="top-news__inner">
      <div class="top-news__heading js-scroll-reveal">
        <span class="top-news__title-en">News</span>
        <h2 id="top-news-title" class="top-news__title">お知らせ</h2>
        <a href="<?php echo esc_url(home_url('/news/')); ?>" class="btn btn--secondary btn--sm" style="margin-top: var(--space-6);">
          すべて見る
          <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
      </div>

      <div class="top-news__list js-scroll-reveal">
        <?php if ($news_query->have_posts()): ?>
          <?php while ($news_query->have_posts()): $news_query->the_post(); ?>

            <a href="<?php the_permalink(); ?>" class="top-news__item">
              <span class="top-news__date"><?php echo get_the_date('Y.m.d'); ?></span>
              <span class="top-news__item-title"><?php the_title(); ?></span>
            </a>

          <?php endwhile; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- ─── ギャラリープレビュー ────────────────────────────── -->
<section class="section top-gallery section--bg-secondary" aria-labelledby="top-gallery-title">
  <div class="container">
    <h2 id="top-gallery-title" class="section-title js-scroll-reveal">
      <span class="section-label">Gallery</span>
      <span class="section-title__ja">ギャラリー</span>
    </h2>
    <p class="section-lead js-scroll-reveal">お迎えした子たちの笑顔をご紹介します。</p>

    <div class="top-gallery__grid js-scroll-reveal">
      <div class="top-gallery__item">
        <img src="<?= get_template_directory_uri(); ?>/assets/images/gallery/gallery-01.jpg" alt="ギャラリー1" class="top-gallery__img" loading="lazy">
      </div>
      <div class="top-gallery__item">
        <img src="<?= get_template_directory_uri(); ?>/assets/images/gallery/gallery-02.jpg" alt="ギャラリー2" class="top-gallery__img" loading="lazy">
      </div>
      <div class="top-gallery__item">
        <img src="<?= get_template_directory_uri(); ?>/assets/images/gallery/gallery-03.jpg" alt="ギャラリー3" class="top-gallery__img" loading="lazy">
      </div>
      <div class="top-gallery__item">
        <img src="<?= get_template_directory_uri(); ?>/assets/images/gallery/gallery-04.jpg" alt="ギャラリー4" class="top-gallery__img" loading="lazy">
      </div>
      <div class="top-gallery__item">
        <img src="<?= get_template_directory_uri(); ?>/assets/images/gallery/gallery-05.jpg" alt="ギャラリー5" class="top-gallery__img" loading="lazy">
      </div>
    </div>

    <div class="text-center">
      <a href="<?php echo esc_url(home_url('/gallery/')); ?>" class="btn btn--primary js-scroll-reveal">
        <i class="fa-regular fa-images" aria-hidden="true"></i>
        ギャラリーをもっと見る
      </a>
    </div>
  </div>
</section>

<!-- ─── CTAバナー ────────────────────────────────────────── -->
<section class="cta-banner" aria-labelledby="cta-title">
  <div class="container">
    <h2 id="cta-title" class="cta-banner__title js-scroll-reveal">
      あなたにぴったりの猫が、きっといます。
    </h2>
    <p class="cta-banner__desc js-scroll-reveal">
      見学だけでも大歓迎です。<br>
      猫との穏やかな暮らしを、ぜひ一緒に考えさせてください。
    </p>
    <div class="cta-banner__actions js-scroll-reveal">
      <a href="<?php echo esc_url(home_url('/cats/')); ?>" class="btn btn--primary btn--lg">
        <i class="fa-solid fa-paw" aria-hidden="true"></i>
        猫を見る
      </a>
      <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--secondary btn--lg">
        <i class="fa-regular fa-envelope" aria-hidden="true"></i>
        お問い合わせ・予約
      </a>
    </div>
  </div>
</section>
<?php get_footer(); ?>