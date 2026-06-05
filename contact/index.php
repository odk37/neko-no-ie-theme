<?php

/**
 * contact/index.php
 * お問い合わせ・見学予約フォームページ（PHP処理）
 */

// ─── 送信処理 ─────────────────────────────────────────────
$errors     = [];
$success    = false;
$form_data  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // CSRF トークン検証
  if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
    $errors['csrf'] = '不正なリクエストです。ページを再読み込みしてください。';
  } else {

    // 入力値取得・サニタイズ
    $form_data = [
      'name'      => trim($_POST['name']      ?? ''),
      'email'     => trim($_POST['email']     ?? ''),
      'tel'       => trim($_POST['tel']        ?? ''),
      'type'      => trim($_POST['type']       ?? ''),
      'date1'     => trim($_POST['date1']      ?? ''),
      'date2'     => trim($_POST['date2']      ?? ''),
      'cat_id'    => (int)($_POST['cat_id']    ?? 0),
      'cat_name'  => trim($_POST['cat_name']   ?? ''),
      'message'   => trim($_POST['message']    ?? ''),
      'privacy'   => isset($_POST['privacy']),
    ];

    // バリデーション
    if (empty($form_data['name'])) {
      $errors['name'] = 'お名前を入力してください。';
    } elseif (mb_strlen($form_data['name']) > 50) {
      $errors['name'] = 'お名前は50文字以内で入力してください。';
    }

    if (empty($form_data['email'])) {
      $errors['email'] = 'メールアドレスを入力してください。';
    } elseif (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = '正しいメールアドレスを入力してください。';
    }

    if (!empty($form_data['tel']) && !preg_match('/^[0-9\-\+\(\)\s]{10,15}$/', $form_data['tel'])) {
      $errors['tel'] = '正しい電話番号を入力してください。';
    }

    if (empty($form_data['type'])) {
      $errors['type'] = 'お問い合わせ種別を選択してください。';
    }

    if (!$form_data['privacy']) {
      $errors['privacy'] = 'プライバシーポリシーへの同意が必要です。';
    }

    if (empty($errors)) {
      // メール送信
      $to      = MAIL_TO;
      $subject = '【ねこのいえ】お問い合わせ：' . $form_data['name'] . '様';
      $body    = build_mail_body($form_data);
      $headers = "From: " . MAIL_FROM . "\r\n"
        . "Reply-To: " . $form_data['email'] . "\r\n"
        . "Content-Type: text/plain; charset=UTF-8\r\n"
        . "Content-Transfer-Encoding: base64\r\n";

      // 本番環境では mail() を有効化
      // $sent = mail($to, mb_encode_mimeheader($subject), base64_encode($body), $headers);
      $sent = true; // 開発環境用

      // 自動返信メール
      $auto_subject = '【ねこのいえ】お問い合わせを受け付けました';
      $auto_body    = build_auto_reply_body($form_data);
      // mail($form_data['email'], mb_encode_mimeheader($auto_subject), base64_encode($auto_body), ...);

      if ($sent) {
        $success = true;
        // CSRF トークン再生成
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $form_data = [];
      } else {
        $errors['send'] = '送信に失敗しました。お手数ですが、お電話にてご連絡ください。';
      }
    }
  }
}

// CSRF トークン生成
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// URLパラメータから猫情報を取得（猫一覧ページからの遷移）
$pre_cat_id   = (int)($_GET['cat_id']   ?? 0);
$pre_cat_name = htmlspecialchars($_GET['cat_name'] ?? '', ENT_QUOTES, 'UTF-8');

/**
 * メール本文生成
 */
function build_mail_body(array $d): string
{
  $type_labels = [
    'visit'    => '見学予約',
    'question' => '飼育・猫についての質問',
    'other'    => 'その他のお問い合わせ',
  ];
  $type_label = $type_labels[$d['type']] ?? $d['type'];

  return <<<MAIL
━━━━━━━━━━━━━━━━━━━━━━━━━━━
ねこのいえ　お問い合わせ受信
━━━━━━━━━━━━━━━━━━━━━━━━━━━

■ お名前：{$d['name']}
■ メールアドレス：{$d['email']}
■ 電話番号：{$d['tel']}
■ 種別：{$type_label}
■ 希望日時（第1希望）：{$d['date1']}
■ 希望日時（第2希望）：{$d['date2']}
■ 気になる猫：{$d['cat_name']}（ID: {$d['cat_id']}）

■ メッセージ：
{$d['message']}

━━━━━━━━━━━━━━━━━━━━━━━━━━━
MAIL;
}

/**
 * 自動返信メール本文生成
 */
function build_auto_reply_body(array $d): string
{
  return <<<MAIL
{$d['name']} 様

この度はねこのいえへお問い合わせいただき、誠にありがとうございます。
以下の内容でお問い合わせを受け付けました。

━━━━━━━━━━━━━━━━━━━━━━━━━━━
■ お名前：{$d['name']}
■ メールアドレス：{$d['email']}
■ メッセージ：
{$d['message']}
━━━━━━━━━━━━━━━━━━━━━━━━━━━

通常2営業日以内にご連絡いたします。
お急ぎの場合はお電話（0120-000-000）にてご連絡ください。

ねこのいえ
〒000-0000 東京都〇〇区〇〇町1-2-3
TEL: 0120-000-000
営業時間: 10:00〜19:00（水曜定休）
MAIL;
}

$page_title       = 'お問い合わせ・見学予約 | ' . get_bloginfo('name');;
$page_description = 'ねこのいえへのお問い合わせ・見学予約フォーム。猫の見学・飼育相談・キャンペーンについてお気軽にどうぞ。';
$body_class       = 'page-contact';
$page_css         = ['contact.css'];
$page_js          = ['contact.js'];

require_once dirname(__DIR__) . '/includes/header.php';
?>

<!-- ─── ページヘッダー ──────────────────────────────────── -->
<div class="page-header">
  <div class="page-header__inner container">
    <p class="page-header__label">Contact & Reservation</p>
    <h1 class="page-header__title">お問い合わせ・見学予約</h1>
    <p class="page-header__lead">見学予約・飼育相談・その他のご質問はこちらから。<br>お気軽にお問い合わせください。</p>
    <nav class="breadcrumb" aria-label="パンくずリスト">
      <span class="breadcrumb__item"><a href="<?php echo esc_url(home_url('/')); ?>" class="breadcrumb__link">TOP</a></span>
      <span class="breadcrumb__item">お問い合わせ</span>
    </nav>
  </div>
</div>

<!-- ─── フォーム + サイドバー ────────────────────────────── -->
<section class="section contact-section">
  <div class="container">
    <div class="contact-layout">

      <!-- フォーム本体 -->
      <main class="contact-form-wrapper">

        <?php if ($success): ?>
          <!-- 送信完了メッセージ -->
          <div class="contact-success" role="alert">
            <div class="contact-success__icon">
              <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
            </div>
            <h2 class="contact-success__title">送信が完了しました</h2>
            <p class="contact-success__text">
              お問い合わせありがとうございます。<br>
              通常2営業日以内にご連絡いたします。<br>
              自動返信メールをお送りしましたのでご確認ください。
            </p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">
              <i class="fa-solid fa-house" aria-hidden="true"></i>
              トップページへ戻る
            </a>
          </div>

        <?php else: ?>

          <?php if (!empty($errors)): ?>
            <div class="form-errors" role="alert" aria-live="assertive">
              <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
              <ul>
                <?php foreach ($errors as $err): ?>
                  <li><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form
            class="form contact-form"
            method="POST"
            action=""
            id="js-contact-form"
            novalidate>
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="cat_id" value="<?= $pre_cat_id ?>">
            <input type="hidden" name="cat_name" value="<?= $pre_cat_name ?>">

            <!-- お名前 -->
            <div class="form__group <?= isset($errors['name']) ? 'has-error' : '' ?>">
              <label class="form__label" for="name">
                お名前
                <span class="form__required">必須</span>
              </label>
              <input
                type="text"
                class="form__input"
                id="name"
                name="name"
                value="<?= htmlspecialchars($form_data['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                placeholder="例：田中 さとみ"
                autocomplete="name"
                required>
              <?php if (isset($errors['name'])): ?>
                <span class="form__error-msg"><?= htmlspecialchars($errors['name'], ENT_QUOTES, 'UTF-8') ?></span>
              <?php endif; ?>
            </div>

            <!-- メールアドレス -->
            <div class="form__group <?= isset($errors['email']) ? 'has-error' : '' ?>">
              <label class="form__label" for="email">
                メールアドレス
                <span class="form__required">必須</span>
              </label>
              <input
                type="email"
                class="form__input"
                id="email"
                name="email"
                value="<?= htmlspecialchars($form_data['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                placeholder="example@email.com"
                autocomplete="email"
                required>
              <?php if (isset($errors['email'])): ?>
                <span class="form__error-msg"><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?></span>
              <?php endif; ?>
            </div>

            <!-- 電話番号 -->
            <div class="form__group <?= isset($errors['tel']) ? 'has-error' : '' ?>">
              <label class="form__label" for="tel">
                電話番号
                <span class="form__optional">任意</span>
              </label>
              <input
                type="tel"
                class="form__input"
                id="tel"
                name="tel"
                value="<?= htmlspecialchars($form_data['tel'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                placeholder="例：090-0000-0000"
                autocomplete="tel">
              <?php if (isset($errors['tel'])): ?>
                <span class="form__error-msg"><?= htmlspecialchars($errors['tel'], ENT_QUOTES, 'UTF-8') ?></span>
              <?php endif; ?>
            </div>

            <!-- お問い合わせ種別 -->
            <div class="form__group <?= isset($errors['type']) ? 'has-error' : '' ?>">
              <label class="form__label" for="type">
                お問い合わせ種別
                <span class="form__required">必須</span>
              </label>
              <select class="form__select" id="type" name="type" required>
                <option value="">選択してください</option>
                <option value="visit" <?= ($form_data['type'] ?? '') === 'visit'    ? 'selected' : '' ?>>見学予約</option>
                <option value="question" <?= ($form_data['type'] ?? '') === 'question' ? 'selected' : '' ?>>飼育・猫についての質問</option>
                <option value="other" <?= ($form_data['type'] ?? '') === 'other'    ? 'selected' : '' ?>>その他のお問い合わせ</option>
              </select>
              <?php if (isset($errors['type'])): ?>
                <span class="form__error-msg"><?= htmlspecialchars($errors['type'], ENT_QUOTES, 'UTF-8') ?></span>
              <?php endif; ?>
            </div>

            <!-- 見学希望日時（見学予約時のみ表示） -->
            <div class="form__group js-visit-fields" style="display: none;">
              <label class="form__label" for="date1">
                希望日時（第1希望）
                <span class="form__optional">任意</span>
              </label>
              <input
                type="datetime-local"
                class="form__input"
                id="date1"
                name="date1"
                value="<?= htmlspecialchars($form_data['date1'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="form__group js-visit-fields" style="display: none;">
              <label class="form__label" for="date2">
                希望日時（第2希望）
                <span class="form__optional">任意</span>
              </label>
              <input
                type="datetime-local"
                class="form__input"
                id="date2"
                name="date2"
                value="<?= htmlspecialchars($form_data['date2'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <!-- 気になる猫 -->
            <?php if ($pre_cat_name): ?>
              <div class="form__group">
                <label class="form__label">気になる猫</label>
                <div class="form__cat-badge">
                  <i class="fa-solid fa-paw" aria-hidden="true"></i>
                  <?= $pre_cat_name ?> （ID: <?= $pre_cat_id ?>）
                </div>
              </div>
            <?php else: ?>
              <div class="form__group">
                <label class="form__label" for="cat_name_input">
                  気になる猫の名前・種類
                  <span class="form__optional">任意</span>
                </label>
                <input
                  type="text"
                  class="form__input"
                  id="cat_name_input"
                  name="cat_name"
                  value="<?= htmlspecialchars($form_data['cat_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                  placeholder="例：マンチカンのミルクちゃん">
              </div>
            <?php endif; ?>

            <!-- メッセージ -->
            <div class="form__group">
              <label class="form__label" for="message">
                メッセージ・ご質問
                <span class="form__optional">任意</span>
              </label>
              <textarea
                class="form__textarea"
                id="message"
                name="message"
                rows="6"
                placeholder="ご質問・ご要望などをご自由にお書きください。"><?= htmlspecialchars($form_data['message'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <!-- プライバシーポリシー同意 -->
            <div class="form__group <?= isset($errors['privacy']) ? 'has-error' : '' ?>">
              <label class="form__checkbox-label">
                <input
                  type="checkbox"
                  name="privacy"
                  class="form__checkbox-input"
                  value="1"
                  required
                  <?= !empty($form_data['privacy']) ? 'checked' : '' ?>>
                <span class="form__checkbox-custom" aria-hidden="true"></span>
                <a href="<?php echo esc_url(home_url('/privacy/')); ?>" target="_blank" class="form__link">プライバシーポリシー</a>
                に同意します
              </label>
              <?php if (isset($errors['privacy'])): ?>
                <span class="form__error-msg"><?= htmlspecialchars($errors['privacy'], ENT_QUOTES, 'UTF-8') ?></span>
              <?php endif; ?>
            </div>

            <button type="submit" class="btn btn--primary btn--lg btn--full" id="js-submit-btn">
              <i class="fa-regular fa-paper-plane" aria-hidden="true"></i>
              送信する
            </button>

          </form>
        <?php endif; ?>

      </main>

      <!-- サイドバー -->
      <aside class="contact-sidebar">
        <div class="contact-info-card">
          <h2 class="contact-info-card__title">
            <i class="fa-solid fa-store" aria-hidden="true"></i>
            店舗情報
          </h2>
          <dl class="contact-info-list">
            <dt><i class="fa-solid fa-phone" aria-hidden="true"></i> 電話</dt>
            <dd><a href="tel:0120-000-000" class="contact-info-list__tel">0120-000-000</a></dd>
            <dt><i class="fa-regular fa-clock" aria-hidden="true"></i> 受付時間</dt>
            <dd>10:00〜18:00</dd>
            <dt><i class="fa-regular fa-calendar-xmark" aria-hidden="true"></i> 定休日</dt>
            <dd>毎週水曜日</dd>
            <dt><i class="fa-solid fa-location-dot" aria-hidden="true"></i> 住所</dt>
            <dd>〒000-0000<br>東京都〇〇区〇〇町1-2-3</dd>
          </dl>
        </div>

        <div class="contact-info-card contact-info-card--note">
          <h3 class="contact-info-card__title">
            <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
            ご来店について
          </h3>
          <p>予約なしでもお気軽にお越しいただけます。混雑時はお待ちいただく場合があります。</p>
          <a href="<?php echo esc_url(home_url('/pages/store/')); ?>" class="btn btn--secondary btn--sm" style="margin-top: var(--space-4);">
            <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i>
            アクセスマップ
          </a>
        </div>
      </aside>

    </div>
  </div>
</section>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>