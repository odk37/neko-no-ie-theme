<?php
/**
 * Template Name: 猫一覧ページ
 */

global $wpdb;
$table_name = $wpdb->prefix . 'neko_cats';

// フィルター処理
$breed = isset($_GET['breed']) ? sanitize_text_field($_GET['breed']) : '';
$gender = isset($_GET['gender']) ? sanitize_text_field($_GET['gender']) : '';

$query = "SELECT * FROM $table_name WHERE status = 'available'";
$params = [];

if ($breed) {
    $query .= " AND breed = %s";
    $params[] = $breed;
}
if ($gender) {
    $query .= " AND gender = %s";
    $params[] = $gender;
}
$query .= " ORDER BY created_at DESC";

if (!empty($params)) {
    $cats = $wpdb->get_results($wpdb->prepare($query, ...$params));
} else {
    $cats = $wpdb->get_results($query);
}

// 猫種リスト取得
$breeds = $wpdb->get_col("SELECT DISTINCT breed FROM $table_name");

get_header();

?>

<section class="cats-list section">
  <div class="container">
    <h2 class="section__title">猫ちゃん一覧</h2>
    
    <!-- フィルター -->
    <div class="cats-filter">
      <form action="<?php echo esc_url(home_url('/cats/')); ?>" method="GET" class="cats-filter__form">
        <select name="breed" class="cats-filter__select">
          <option value="">すべての種類</option>
          <?php foreach ($breeds as $b): ?>
            <option value="<?php echo esc_attr($b); ?>" <?php selected($breed, $b); ?>><?php echo esc_html($b); ?></option>
          <?php endforeach; ?>
        </select>
        <select name="gender" class="cats-filter__select">
          <option value="">すべての性別</option>
          <option value="male" <?php selected($gender, 'male'); ?>>男の子</option>
          <option value="female" <?php selected($gender, 'female'); ?>>女の子</option>
        </select>
        <button type="submit" class="btn btn--primary">検索</button>
      </form>
    </div>

    <div class="cats-grid">
      <?php if ($cats): foreach ($cats as $cat): ?>
        <article class="cat-card js-modal-open" data-cat-id="<?php echo esc_attr($cat->id); ?>">
          <div class="cat-card__image">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/cats/' . $cat->image_main); ?>" alt="<?php echo esc_html($cat->name); ?>">
            <?php if ($cat->is_new): ?><span class="cat-card__tag">NEW</span><?php endif; ?>
          </div>
          <div class="cat-card__body">
            <h3 class="cat-card__title"><?php echo esc_html($cat->name); ?></h3>
            <p class="cat-card__info"><?php echo esc_html($cat->breed); ?> / <?php echo esc_html($cat->age_months); ?>ヶ月 / <?php echo $cat->gender === 'male' ? '男の子' : '女の子'; ?></p>
            <p class="cat-card__price">¥<?php echo number_format($cat->price); ?><span>(税込)</span></p>
          </div>
        </article>
      <?php endforeach; else: ?>
        <p>該当する猫ちゃんは見つかりませんでした。</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
