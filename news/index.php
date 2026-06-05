<?php
/**
 * news/index.php
 * お知らせ・キャンペーン一覧ページ（WordPress REST API連携）
 */
// ─── WordPress REST API からデータ取得 ────────────────────
$current_page = max(1, (int)($_GET['paged'] ?? 1));
$per_page     = 10;
$posts        = [];
$total_pages  = 1;
$total_posts  = 0;

// カテゴリIDマッピング（WordPress側で設定したカテゴリIDに合わせる）
$category_map = [
    'campaign' => 2,   // キャンペーン
    'health'   => 3,   // 健康・ワクチン
    'event'    => 4,   // イベント・見学会
    'info'     => 5,   // お知らせ
];

$filter_cat = $_GET['cat'] ?? '';
$cat_param  = '';
if ($filter_cat && isset($category_map[$filter_cat])) {
    $cat_param = '&categories=' . $category_map[$filter_cat];
}

    $args = [
      'post_type'      => 'post',
      'posts_per_page' => $per_page,
      'paged'          => $current_page,
    ];

    if ($filter_cat && isset($category_map[$filter_cat])) {
      $args['cat'] = $category_map[$filter_cat];
    }

    $query = new WP_Query($args);

    $posts = [];

    if ($query->have_posts()) {
      while ($query->have_posts()) {
        $query->the_post();

        $posts[] = [
          'id' => get_the_ID(),
          'date' => get_the_date('Y-m-d H:i:s'),
          'title' => [
            'rendered' => get_the_title()
          ],
          'excerpt' => [
            'rendered' => get_the_excerpt()
          ],
          'categories' => wp_get_post_categories(get_the_ID()),
          'featured_media_url' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
        ];
      }
      wp_reset_postdata();
    }

    // ページ数
    $total_pages = $query->max_num_pages;
    $total_posts = $query->found_posts;

// フォールバック：サンプルデータ
if (empty($posts)) {
    $posts = [
        ['id'=>1, 'date'=>'2026-05-20T10:00:00', 'title'=>['rendered'=>'【お迎えキャンペーン】6月限定！トライアル期間延長のお知らせ'], 'slug'=>'campaign-june-2026', 'excerpt'=>['rendered'=>'<p>6月中にお迎えいただいた方を対象に、トライアル期間を通常の2倍に延長するキャンペーンを実施します。</p>'], 'categories'=>[2], 'featured_media_url'=>''],
        ['id'=>2, 'date'=>'2026-05-15T10:00:00', 'title'=>['rendered'=>'マンチカン・スコティッシュの新しい子が入荷しました'], 'slug'=>'new-cats-may-2026', 'excerpt'=>['rendered'=>'<p>春生まれのかわいい子猫たちが仲間入りしました。元気いっぱいの子たちにぜひ会いに来てください。</p>'], 'categories'=>[5], 'featured_media_url'=>''],
        ['id'=>3, 'date'=>'2026-05-10T10:00:00', 'title'=>['rendered'=>'【見学会】5月25日（土）子猫ふれあい見学会を開催します'], 'slug'=>'event-may-25', 'excerpt'=>['rendered'=>'<p>毎月恒例の子猫ふれあい見学会を開催します。予約不要・入場無料です。お気軽にご参加ください。</p>'], 'categories'=>[4], 'featured_media_url'=>''],
        ['id'=>4, 'date'=>'2026-05-01T10:00:00', 'title'=>['rendered'=>'ゴールデンウィーク期間中の営業時間についてのお知らせ'], 'slug'=>'gw-hours-2026', 'excerpt'=>['rendered'=>'<p>ゴールデンウィーク期間中（5/3〜5/6）は通常通り営業いたします。ご来店をお待ちしております。</p>'], 'categories'=>[5], 'featured_media_url'=>''],
        ['id'=>5, 'date'=>'2026-04-20T10:00:00', 'title'=>['rendered'=>'全頭ワクチン接種・健康診断の実施についてご報告'], 'slug'=>'vaccine-report-april', 'excerpt'=>['rendered'=>'<p>在籍中の全猫について、春のワクチン接種と健康診断を実施しました。全頭健康を確認しています。</p>'], 'categories'=>[3], 'featured_media_url'=>''],
        ['id'=>6, 'date'=>'2026-04-10T10:00:00', 'title'=>['rendered'=>'【春のお迎えキャンペーン】グッズプレゼント実施中'], 'slug'=>'spring-campaign-2026', 'excerpt'=>['rendered'=>'<p>4月・5月にお迎えいただいた方に、猫用スターターセット（トイレ・フード・おもちゃ）をプレゼントします。</p>'], 'categories'=>[2], 'featured_media_url'=>''],
    ];
    $total_posts = count($posts);
    $total_pages = 1;
}

// カテゴリラベルマッピング
$cat_labels = [
    2 => ['label' => 'キャンペーン', 'class' => 'badge--accent'],
    3 => ['label' => '健康・ワクチン', 'class' => 'badge--primary'],
    4 => ['label' => 'イベント',      'class' => 'badge--new'],
    5 => ['label' => 'お知らせ',      'class' => 'badge--primary'],
];

$page_title       = 'お知らせ | ' . get_bloginfo('name');
$page_description = 'ねこのいえからのお知らせ・キャンペーン・見学会情報。';
$body_class       = 'page-news';
$page_css         = ['news.css'];

get_header();
?>

<!-- ─── ページヘッダー ──────────────────────────────────── -->
<div class="page-header">
  <div class="page-header__inner container">
    <p class="page-header__label">News & Campaign</p>
    <h1 class="page-header__title">お知らせ</h1>
    <p class="page-header__lead">キャンペーン・見学会・新着情報をお届けします。</p>
    <nav class="breadcrumb" aria-label="パンくずリスト">
      <span class="breadcrumb__item"><a href="<?= esc_url(home_url('/')) ?>" class="breadcrumb__link">TOP</a></span>
      <span class="breadcrumb__item">お知らせ</span>
    </nav>
  </div>
</div>

<!-- ─── お知らせ一覧 ─────────────────────────────────────── -->
<section class="section news-section">
  <div class="container">

    <!-- カテゴリフィルター -->
    <div class="filter-tabs js-scroll-reveal" role="tablist" aria-label="カテゴリで絞り込み">
      <a href="<?= esc_url(home_url('/news/')) ?>" class="filter-tabs__btn <?= !$filter_cat ? 'is-active' : '' ?>" role="tab">
        すべて
      </a>
      <a href="<?= esc_url(home_url('/news/?cat=campaign')) ?>" class="filter-tabs__btn <?= $filter_cat === 'campaign' ? 'is-active' : '' ?>" role="tab">
        キャンペーン
      </a>
      <a href="<?= esc_url(home_url('/news/?cat=event')) ?>" class="filter-tabs__btn <?= $filter_cat === 'event' ? 'is-active' : '' ?>" role="tab">
        イベント・見学会
      </a>
      <a href="<?= esc_url(home_url('/news/?cat=health')) ?>" class="filter-tabs__btn <?= $filter_cat === 'health' ? 'is-active' : '' ?>" role="tab">
        健康・ワクチン
      </a>
      <a href="<?= esc_url(home_url('/news/?cat=info')) ?>" class="filter-tabs__btn <?= $filter_cat === 'info' ? 'is-active' : '' ?>" role="tab">
        お知らせ
      </a>
    </div>

    <!-- 記事一覧 -->
    <div class="news-list">
      <?php foreach ($posts as $post): ?>
      <?php
        $date     = date('Y年m月d日', strtotime($post['date']));
        $title    = strip_tags($post['title']['rendered']);
        $excerpt  = strip_tags($post['excerpt']['rendered']);
        $cat_id   = $post['categories'][0] ?? 5;
        $cat_info = $cat_labels[$cat_id] ?? ['label' => 'お知らせ', 'class' => 'badge--primary'];

        // アイキャッチ画像URL
        $thumb_url = $post['featured_media_url'] ?? '';
        if (empty($thumb_url) && isset($post['_embedded']['wp:featuredmedia'][0]['source_url'])) {
            $thumb_url = $post['_embedded']['wp:featuredmedia'][0]['source_url'];
        }
        if (empty($thumb_url)) {
            $thumb_url = esc_url(get_template_directory_uri() . '/assets/images/news/news-default.jpg');
        }

        $detail_url = esc_url(home_url('/news/detail/')) . '?id=' . (int)$post['id'];
      ?>
      <article class="news-article js-scroll-reveal">
        <a href="<?= $detail_url ?>" class="news-article__link">
          <div class="news-article__image-wrapper">
            <img
              src="<?= htmlspecialchars($thumb_url, ENT_QUOTES, 'UTF-8') ?>"
              alt="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>"
              class="news-article__image"
              loading="lazy"
              width="240" height="160"
            >
          </div>
          <div class="news-article__body">
            <div class="news-article__meta">
              <time class="news-article__date" datetime="<?= $post['date'] ?>">
                <?= $date ?>
              </time>
              <span class="badge <?= $cat_info['class'] ?>"><?= htmlspecialchars($cat_info['label'], ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <h2 class="news-article__title"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h2>
            <p class="news-article__excerpt"><?= htmlspecialchars(mb_strimwidth($excerpt, 0, 100, '…'), ENT_QUOTES, 'UTF-8') ?></p>
            <span class="news-article__more">
              続きを読む
              <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </span>
          </div>
        </a>
      </article>
      <?php endforeach; ?>
    </div>

    <!-- ページネーション -->
    <?php if ($total_pages > 1): ?>
    <nav class="pagination" aria-label="ページナビゲーション">
      <?php if ($current_page > 1): ?>
      <a href="?paged=<?= $current_page - 1 ?><?= $filter_cat ? '&cat=' . $filter_cat : '' ?>" class="pagination__btn" aria-label="前のページ">
        <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
      </a>
      <?php endif; ?>

      <?php for ($p = 1; $p <= $total_pages; $p++): ?>
      <a href="?paged=<?= $p ?><?= $filter_cat ? '&cat=' . $filter_cat : '' ?>"
         class="pagination__btn <?= $p === $current_page ? 'is-active' : '' ?>"
         aria-label="<?= $p ?>ページ目"
         <?= $p === $current_page ? 'aria-current="page"' : '' ?>>
        <?= $p ?>
      </a>
      <?php endfor; ?>

      <?php if ($current_page < $total_pages): ?>
      <a href="?paged=<?= $current_page + 1 ?><?= $filter_cat ? '&cat=' . $filter_cat : '' ?>" class="pagination__btn" aria-label="次のページ">
        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
      </a>
      <?php endif; ?>
    </nav>
    <?php endif; ?>

  </div>
</section>
<?php get_footer(); ?>