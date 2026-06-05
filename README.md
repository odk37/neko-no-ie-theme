# ねこのいえ ペットショップ — Webサイト 実装ドキュメント

> **技術スタック:** HTML5 / CSS3 / JavaScript / jQuery 3.7 / PHP 8.1+ / WordPress 6.x / MySQL 8.0+  
> **CSS設計:** BEM記法（Block__Element--Modifier）  
> **対象ブラウザ:** Chrome / Firefox / Safari / Edge（最新2バージョン）/ iOS Safari / Android Chrome

---

## 1. ディレクトリ構成

```
neko-petshop/
├── index.php                   # トップページ
├── .htaccess                   # Apache設定・セキュリティ
├── README.md                   # このファイル
│
├── includes/                   # 共通インクルードファイル
│   ├── config.php              # DB接続・定数・ユーティリティ関数
│   ├── header.php              # 共通ヘッダー（ナビゲーション）
│   └── footer.php              # 共通フッター（SNS・スクリプト）
│
├── pages/                      # 静的ページ
│   ├── cats.php                # 猫一覧・詳細（PHP/MySQL連動）
│   └── store.php               # 店舗紹介（Google Maps・スタッフ）
│
├── search/
│   └── index.php               # 猫検索（条件フォーム・結果表示）
│
├── news/
│   ├── index.php               # お知らせ一覧（WordPress REST API）
│   └── detail.php              # お知らせ詳細
│
├── column/
│   └── index.php               # 豆知識・コラム（アコーディオン）
│
├── gallery/
│   └── index.php               # ギャラリー・お客様の声（ライトボックス）
│
├── contact/
│   └── index.php               # お問い合わせ・見学予約フォーム（PHP処理）
│
├── assets/
│   ├── css/
│   │   ├── variables.css       # CSS変数（カラー・フォント・スペーシング）
│   │   ├── base.css            # リセット・タイポグラフィ・ユーティリティ
│   │   ├── components.css      # 共通コンポーネント（ボタン・カード・モーダル等）
│   │   ├── layout.css          # ヘッダー・フッター・グリッドレイアウト
│   │   ├── top.css             # トップページ専用
│   │   ├── store.css           # 店舗紹介ページ専用
│   │   ├── cats.css            # 猫一覧ページ専用
│   │   ├── search.css          # 検索ページ専用
│   │   ├── news.css            # お知らせページ専用
│   │   ├── column.css          # コラムページ専用
│   │   ├── gallery.css         # ギャラリーページ専用
│   │   └── contact.css         # お問い合わせページ専用
│   │
│   ├── js/
│   │   ├── common.js           # 共通JS（ハンバーガー・スクロール・アニメーション）
│   │   ├── top.js              # トップページ専用（Swiperスライダー）
│   │   ├── cats.js             # 猫一覧専用（フィルター・モーダル・AJAX）
│   │   ├── gallery.js          # ギャラリー専用（ライトボックス）
│   │   └── contact.js          # お問い合わせ専用（バリデーション）
│   │
│   └── images/                 # 画像ファイル格納ディレクトリ
│       ├── cats/               # 猫の写真
│       ├── gallery/            # ギャラリー画像
│       ├── voices/             # お客様の声アバター
│       ├── staff/              # スタッフ写真
│       ├── logo.svg            # ロゴ（カラー）
│       ├── logo-white.svg      # ロゴ（白）
│       ├── og-image.jpg        # OGP画像
│       └── favicon.ico         # ファビコン
│
├── database/
│   ├── schema.sql              # DBテーブル定義
│   └── sample_data.sql         # サンプルデータ
│
└── wordpress/
    ├── wp-config-template.php  # WordPress設定テンプレート
    └── functions.php           # テーマ functions.php（REST API・カスタム投稿）
```

---

## 2. セットアップ手順

### 2-1. データベース作成

```bash
mysql -u root -p < database/schema.sql
mysql -u root -p neko_petshop < database/sample_data.sql
```

### 2-2. 設定ファイルの編集

`includes/config.php` を開き、以下を実際の値に変更してください。

| 定数 | 説明 | 変更例 |
|---|---|---|
| `DB_HOST` | MySQLホスト | `localhost` |
| `DB_NAME` | データベース名 | `neko_petshop` |
| `DB_USER` | DBユーザー名 | `neko_user` |
| `DB_PASS` | DBパスワード | `your_password` |
| `SITE_NAME` | サイト名 | `ねこのいえ` |
| `SITE_URL` | サイトURL（末尾スラッシュなし） | `https://www.example.com` |
| `WP_API_URL` | WordPress REST API URL | `https://www.example.com/wp/wp-json/wp/v2` |
| `MAIL_TO` | 問い合わせ受信メール | `info@example.com` |
| `DEBUG_MODE` | デバッグモード | 本番では `false` |

### 2-3. WordPress セットアップ

1. WordPress を `/wp/` サブディレクトリにインストール
2. `wordpress/wp-config-template.php` を `wp-config.php` にリネームして設置
3. `wordpress/functions.php` の内容をテーマの `functions.php` に追加
4. WordPress 管理画面でパーマリンク設定を「投稿名」に変更
5. REST API が有効になっていることを確認（デフォルトで有効）

### 2-4. 画像の配置

`assets/images/` 以下に実際の画像を配置してください。

| ディレクトリ | 推奨サイズ | 用途 |
|---|---|---|
| `cats/` | 800×600px | 猫の写真（メイン・サブ） |
| `gallery/` | 800×600px | ギャラリー画像 |
| `voices/` | 128×128px | お客様アバター |
| `staff/` | 400×500px | スタッフ写真 |

---

## 3. 技術仕様

### 3-1. CSS設計（BEM記法）

```css
/* Block */
.cat-card { }

/* Element */
.cat-card__image { }
.cat-card__title { }

/* Modifier */
.cat-card--featured { }
.cat-card__title--large { }

/* 状態クラス（BEM外） */
.is-active { }
.is-open { }
.js-* { }   /* JavaScriptフック専用 */
```

### 3-2. CSS変数（カスタムプロパティ）

`assets/css/variables.css` で全サイトのデザイントークンを一元管理しています。

```css
/* カラー変更例 */
:root {
  --color-primary: #e8a598;       /* メインカラー（ピンク系） */
  --color-primary-dark: #c4756a;  /* ダークバリアント */
  --color-secondary: #f5e6d3;     /* セカンダリ（ベージュ） */
}
```

### 3-3. JavaScript・jQuery

- **jQuery 3.7.1** をCDNから読み込み（フッターで読み込み）
- **Swiper 11** をスライダーに使用
- **Font Awesome 6.5** をアイコンに使用
- ページ固有JSは `$page_js` 変数で制御（不要なページでは読み込まない）

### 3-4. PHP・MySQL

- **PHP 8.1+** 推奨（名前付き引数・nullsafe演算子を使用）
- **PDO** でDB接続（プリペアドステートメントでSQLインジェクション対策）
- **CSRF トークン** でフォーム保護
- **セッション** は `cookie_httponly`, `cookie_samesite` で保護

### 3-5. WordPress REST API 連携

お知らせ・キャンペーンページは WordPress の REST API を利用して記事を取得します。

```
GET {WP_API_URL}/posts?categories={id}&per_page=10&_embed
GET {WP_API_URL}/posts/{id}?_embed
```

---

## 4. 各ページ機能一覧

| ページ | ファイル | 主な機能 |
|---|---|---|
| トップ | `index.php` | ヒーロースライダー（Swiper）・猫カードスライダー・アニメーション |
| 猫一覧 | `pages/cats.php` | MySQL連動・種類別タブフィルター・モーダル詳細・AJAX読み込み |
| 猫検索 | `search/index.php` | 種類・性別・月齢・キーワードの複合条件検索 |
| 店舗紹介 | `pages/store.php` | Google Maps埋め込み・スタッフ紹介・アクセス情報 |
| お知らせ | `news/index.php` | WordPress REST API連携・ページネーション |
| コラム | `column/index.php` | アコーディオン形式のQ&A |
| ギャラリー | `gallery/index.php` | ライトボックス（キーボード・スワイプ対応） |
| お問い合わせ | `contact/index.php` | PHP処理・CSRFトークン・クライアント＋サーバーバリデーション |

---

## 5. セキュリティ対策

- **SQLインジェクション対策**: PDO プリペアドステートメント
- **XSS対策**: `htmlspecialchars()` / `h()` 関数による全出力エスケープ
- **CSRF対策**: フォームにCSRFトークンを実装
- **セッション保護**: `httponly`, `samesite=Lax`, `use_strict_mode`
- **ファイルアクセス制限**: `.htaccess` で `includes/`, `database/`, `logs/` を保護
- **セキュリティヘッダー**: `X-Content-Type-Options`, `X-Frame-Options`, `X-XSS-Protection`
- **WordPress**: ファイル編集禁止・バージョン情報非表示

---

## 6. カスタマイズガイド

### 店舗情報の変更

`includes/config.php` の定数と `includes/footer.php` の住所・電話番号を変更してください。

### Google Maps の設定

`pages/store.php` 内の `<iframe>` の `src` 属性を実際の店舗のGoogle Maps埋め込みURLに変更してください。

### カラーテーマの変更

`assets/css/variables.css` の `--color-primary` と `--color-secondary` を変更するだけでサイト全体の色が変わります。

### 猫データの追加

`database/sample_data.sql` を参考に `cats` テーブルにINSERT、または管理画面（別途実装）から追加してください。

---

## 7. 推奨プラグイン（WordPress）

| プラグイン | 用途 |
|---|---|
| Yoast SEO | SEO対策・OGP設定 |
| WP Super Cache | ページキャッシュ |
| Wordfence Security | セキュリティ強化 |
| Advanced Custom Fields | カスタムフィールド管理 |
| WP Mail SMTP | メール送信設定 |
| Regenerate Thumbnails | サムネイル再生成 |

---

## 8. 保守・運用メモ

- **定期バックアップ**: DBとファイルを週1回以上バックアップ
- **WordPress更新**: コア・プラグイン・テーマを定期的に更新
- **SSL証明書**: Let's Encrypt等で常時HTTPS化
- **エラーログ**: `logs/error.log` を定期確認（本番環境）
- **画像最適化**: WebP形式の使用を推奨（`<picture>` タグで対応）

---

*ねこのいえ ペットショップ Webサイト — 実装ドキュメント v1.0*
