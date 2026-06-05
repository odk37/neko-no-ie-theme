-- ═══════════════════════════════════════════════════════════
-- ねこのいえ ペットショップ データベーススキーマ
-- MySQL 8.0+ 対応
-- 文字コード: utf8mb4 / 照合順序: utf8mb4_unicode_ci
-- ═══════════════════════════════════════════════════════════

-- データベース作成
CREATE DATABASE IF NOT EXISTS `neko_petshop`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `neko_petshop`;

-- ─────────────────────────────────────────────────────────
-- テーブル: cats（猫情報）
-- ─────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `cats` (
  `id`           INT UNSIGNED     NOT NULL AUTO_INCREMENT COMMENT '猫ID',
  `name`         VARCHAR(50)      NOT NULL                COMMENT '猫の名前',
  `breed`        VARCHAR(100)     NOT NULL                COMMENT '猫種',
  `age_months`   TINYINT UNSIGNED NOT NULL DEFAULT 0      COMMENT '月齢',
  `gender`       ENUM('male','female') NOT NULL           COMMENT '性別',
  `personality`  VARCHAR(200)     NOT NULL DEFAULT ''     COMMENT '性格（一言）',
  `description`  TEXT             NOT NULL                COMMENT '詳細説明',
  `price`        INT UNSIGNED     NOT NULL DEFAULT 0      COMMENT '価格（円）',
  `image_main`   VARCHAR(255)     NOT NULL DEFAULT ''     COMMENT 'メイン画像ファイル名',
  `image_sub1`   VARCHAR(255)     NOT NULL DEFAULT ''     COMMENT 'サブ画像1',
  `image_sub2`   VARCHAR(255)     NOT NULL DEFAULT ''     COMMENT 'サブ画像2',
  `video_url`    VARCHAR(500)     NOT NULL DEFAULT ''     COMMENT '動画URL（YouTube等）',
  `is_new`       TINYINT(1)       NOT NULL DEFAULT 0      COMMENT '新着フラグ',
  `status`       ENUM('available','reserved','sold') NOT NULL DEFAULT 'available' COMMENT 'ステータス',
  `created_at`   DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`   DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_breed`  (`breed`),
  INDEX `idx_gender` (`gender`),
  INDEX `idx_status` (`status`),
  INDEX `idx_age`    (`age_months`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='猫情報';

-- ─────────────────────────────────────────────────────────
-- テーブル: contacts（お問い合わせ）
-- ─────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `contacts` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'お問い合わせID',
  `name`       VARCHAR(100) NOT NULL                COMMENT '氏名',
  `email`      VARCHAR(255) NOT NULL                COMMENT 'メールアドレス',
  `tel`        VARCHAR(20)  NOT NULL DEFAULT ''     COMMENT '電話番号',
  `type`       ENUM('visit','question','other') NOT NULL COMMENT '種別',
  `date1`      DATETIME     NULL                    COMMENT '希望日時（第1希望）',
  `date2`      DATETIME     NULL                    COMMENT '希望日時（第2希望）',
  `cat_id`     INT UNSIGNED NOT NULL DEFAULT 0      COMMENT '気になる猫ID',
  `cat_name`   VARCHAR(100) NOT NULL DEFAULT ''     COMMENT '気になる猫名',
  `message`    TEXT         NOT NULL                COMMENT 'メッセージ',
  `status`     ENUM('new','replied','closed') NOT NULL DEFAULT 'new' COMMENT '対応状況',
  `ip_address` VARCHAR(45)  NOT NULL DEFAULT ''     COMMENT 'IPアドレス',
  `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_status`     (`status`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='お問い合わせ';

-- ─────────────────────────────────────────────────────────
-- テーブル: voices（お客様の声）
-- ─────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `voices` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(100) NOT NULL                COMMENT '投稿者名',
  `cat_name`   VARCHAR(100) NOT NULL DEFAULT ''     COMMENT 'お迎えした猫',
  `comment`    TEXT         NOT NULL                COMMENT 'コメント',
  `rating`     TINYINT      NOT NULL DEFAULT 5      COMMENT '評価（1-5）',
  `image`      VARCHAR(255) NOT NULL DEFAULT ''     COMMENT '画像ファイル名',
  `date_label` VARCHAR(20)  NOT NULL DEFAULT ''     COMMENT '表示用日付（例：2026年4月）',
  `is_visible` TINYINT(1)   NOT NULL DEFAULT 1      COMMENT '表示フラグ',
  `sort_order` INT          NOT NULL DEFAULT 0      COMMENT '表示順',
  `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_visible` (`is_visible`, `sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='お客様の声';

-- ─────────────────────────────────────────────────────────
-- テーブル: gallery（ギャラリー画像）
-- ─────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `gallery` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `filename`   VARCHAR(255) NOT NULL                COMMENT '画像ファイル名',
  `alt_text`   VARCHAR(200) NOT NULL DEFAULT ''     COMMENT 'alt属性テキスト',
  `caption`    VARCHAR(300) NOT NULL DEFAULT ''     COMMENT 'キャプション',
  `is_visible` TINYINT(1)   NOT NULL DEFAULT 1      COMMENT '表示フラグ',
  `sort_order` INT          NOT NULL DEFAULT 0      COMMENT '表示順',
  `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ギャラリー';
