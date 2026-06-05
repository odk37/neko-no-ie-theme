<?php
/**
 * neko-theme functions.php
 * WordPress標準準拠・$wpdb対応版
 */

// ─── テーマサポート ────────────────────────────────────────
function neko_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'gallery', 'caption'));
    register_nav_menus([
        'global-menu' => 'グローバルメニュー',
        'footer-menu' => 'フッターメニュー',
    ]);
}
add_action('after_setup_theme', 'neko_theme_setup');

function neko_theme_add_header_menu_li_class($classes, $item, $args)
{
    if (isset($args->li_class)) {
        $classes[] = $args->li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'neko_theme_add_header_menu_li_class', 10, 3);

function neko_theme_add_header_menu_link_class($atts, $item, $args)
{
    if (isset($args->link_class)) {
        $atts['class'] = $args->link_class;
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'neko_theme_add_header_menu_link_class', 10, 3);

// ─── スクリプト・スタイルの読み込み ────────────────────────
function neko_scripts() {
    // CSS
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css');
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_style('neko-variables', get_template_directory_uri() . '/assets/css/variables.css');
    wp_enqueue_style('neko-base', get_template_directory_uri() . '/assets/css/base.css');
    wp_enqueue_style('neko-components', get_template_directory_uri() . '/assets/css/components.css');
    wp_enqueue_style('neko-animation', get_template_directory_uri() . '/assets/css/animation.css');
    wp_enqueue_style('nekoUtility', get_template_directory_uri() . '/assets/css/utility.css');
    wp_enqueue_style('neko-layout', get_template_directory_uri() . '/assets/css/layout.css');
    wp_enqueue_style('neko-style', get_stylesheet_uri());

    // ページ別CSS
    if (is_front_page()) wp_enqueue_style('neko-top', get_template_directory_uri() . '/assets/css/top.css');
    if (is_page('cats')) wp_enqueue_style('neko-cats', get_template_directory_uri() . '/assets/css/cats.css');
    if (is_page('store')) wp_enqueue_style('neko-store', get_template_directory_uri() . '/assets/css/store.css');
    if (is_page('contact')) wp_enqueue_style('neko-contact', get_template_directory_uri() . '/assets/css/contact.css');

    // JS
    wp_enqueue_script('jquery');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), null, true);
    wp_enqueue_script('neko-common', get_template_directory_uri() . '/assets/js/common.js', array('jquery'), null, true);

    if (is_front_page()) wp_enqueue_script('neko-top-js', get_template_directory_uri() . '/assets/js/top.js', array('jquery', 'swiper-js'), null, true);
    if (is_page('cats')) wp_enqueue_script('neko-cats-js', get_template_directory_uri() . '/assets/js/cats.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'neko_scripts');

// ─── カスタムテーブルの作成（テーマ有効化時） ──────────────
function neko_create_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'neko_cats';

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(50) NOT NULL,
        breed varchar(100) NOT NULL,
        age_months tinyint(3) NOT NULL DEFAULT 0,
        gender enum('male','female') NOT NULL,
        personality varchar(200) DEFAULT '',
        description text,
        price int(10) NOT NULL DEFAULT 0,
        image_main varchar(255) DEFAULT '',
        is_new tinyint(1) NOT NULL DEFAULT 0,
        status enum('available','reserved','sold') NOT NULL DEFAULT 'available',
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_switch_theme', 'neko_create_tables');

// ─── カスタム投稿タイプ：キャンペーン ─────────────────────
function neko_register_campaign_post_type(): void {
    register_post_type('campaign', [
        'labels' => [
            'name'          => 'キャンペーン',
            'singular_name' => 'キャンペーン',
            'add_new_item'  => 'キャンペーンを追加',
            'edit_item'     => 'キャンペーンを編集',
        ],
        'public'       => true,
        'show_in_rest' => true,
        'supports'     => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'menu_icon'    => 'dashicons-megaphone',
        'has_archive'  => true,
        'rewrite'      => ['slug' => 'campaign'],
    ]);
}
add_action('init', 'neko_register_campaign_post_type');

// ACFのJSON保存先をテーマ内に変更
add_filter('acf/settings/save_json', function () {
    return get_stylesheet_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
});

// ─── AJAX: 猫詳細取得 ──────────────────────────────────────
function get_cat_details() {
    global $wpdb;
    $id = intval($_POST['id']);
    $table_name = $wpdb->prefix . 'neko_cats';
    $cat = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));

    if ($cat) {
        wp_send_json_success($cat);
    } else {
        wp_send_json_error('Not found');
    }
}
add_action('wp_ajax_get_cat_details', 'get_cat_details');
add_action('wp_ajax_nopriv_get_cat_details', 'get_cat_details');

// ─── セキュリティ設定 ──────────────────────────────────────
remove_action('wp_head', 'wp_generator');
add_filter('login_errors', fn() => 'ログイン情報が正しくありません。');
