<?php

/**
 * news/detail.php
 * お知らせ詳細ページ（WordPress REST API連携）
 */


$post_id = (int)($_GET['id'] ?? 0);

if ($post_id <= 0) {
  wp_redirect(home_url('/news/'));
  exit;
}

$query = new WP_Query([
  'post_type' => 'post',
  'posts_per_page' => 10,
  'paged' => get_query_var('paged') ?: 1
]);

if (!$query->have_posts()) {
  status_header(404);
  include get_404_template();
  exit;
}

$query->the_post();

$title   = get_the_title();
$content = get_the_content();
$date    = get_the_date('Y年m月d日');

$page_title = $title . ' | ' . get_bloginfo('name');
$page_description = mb_strimwidth(strip_tags(get_the_excerpt()), 0, 120, '…');

$body_class = 'page-news-detail';
$page_css = ['news.css'];

get_header();
?>

<!-- ─── ページヘッダー ──────────────────────────────────── -->
<div class="page-header">
  <div class="page-header__inner container">
    <p class="page-header__label">News Detail</p>
    <h1 class="page-header__title" style="font-size: var(--font-size-2xl);">
      <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>
    </h1>
    <nav class="breadcrumb" aria-label="パンくずリスト">
      <span class="breadcrumb__item"><a href="<?= esc_url(home_url('/')) ?>" class="breadcrumb__link">TOP</a></span>
      <span class="breadcrumb__item"><a href="<?= esc_url(home_url('/news/')) ?>" class="breadcrumb__link">お知らせ</a></span>
      <span class="breadcrumb__item">記事詳細</span>
    </nav>
  </div>
</div>

<!-- ─── 記事本文 ─────────────────────────────────────────── -->
<section class="section news-detail-section">
  <div class="container container--narrow">

    <article class="news-detail">
      <header class="news-detail__header">
        <?php if (!empty($post)): ?>
          <time datetime="<?= esc_attr($post['date']) ?>">
            <?= esc_html($date) ?>
          </time>
        <?php endif; ?>
        <h1 class="news-detail__title"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>
      </header>

      <div class="news-detail__content wp-content">
        <?= $content ?>
      </div>

      <!-- 来店誘導 -->
      <div class="news-detail__cta">
        <p>ご不明な点はお気軽にお問い合わせください。</p>
        <div style="display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; margin-top: var(--space-5);">
          <a href="<?= esc_url(home_url('/contact/')) ?>" class="btn btn--primary">
            <i class="fa-regular fa-envelope" aria-hidden="true"></i>
            お問い合わせ・予約
          </a>
          <a href="<?= esc_url(home_url('/pages/store.php')) ?>" class="btn btn--secondary">
            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
            店舗MAP・アクセス
          </a>
        </div>
      </div>

      <div class="news-detail__back">
        <a href="<?= esc_url(home_url('/news/')) ?>" class="btn btn--secondary btn--sm">
          <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
          お知らせ一覧に戻る
        </a>
      </div>
    </article>

  </div>
</section>

<?php get_footer(); ?>