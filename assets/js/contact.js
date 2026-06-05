/**
 * contact.js
 * お問い合わせページ専用JavaScript
 * クライアントサイドバリデーション・条件表示
 */

$(function () {
  'use strict';

  /* ─────────────────────────────────────────────────────────
   * 種別変更で見学日時フィールドを表示/非表示
   * ───────────────────────────────────────────────────────── */
  $('#type').on('change', function () {
    if ($(this).val() === 'visit') {
      $('.js-visit-fields').slideDown(300);
    } else {
      $('.js-visit-fields').slideUp(300);
    }
  });

  // 初期状態（エラー後の再表示対応）
  if ($('#type').val() === 'visit') {
    $('.js-visit-fields').show();
  }

  /* ─────────────────────────────────────────────────────────
   * クライアントサイドバリデーション
   * ───────────────────────────────────────────────────────── */
  $('#js-contact-form').on('submit', function (e) {
    let isValid = true;
    const $form = $(this);

    // エラーをリセット
    $form.find('.form__error-msg').remove();
    $form.find('.has-error').removeClass('has-error');

    // お名前
    const $name = $('#name');
    if (!$name.val().trim()) {
      showError($name, 'お名前を入力してください。');
      isValid = false;
    }

    // メールアドレス
    const $email = $('#email');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!$email.val().trim()) {
      showError($email, 'メールアドレスを入力してください。');
      isValid = false;
    } else if (!emailRegex.test($email.val().trim())) {
      showError($email, '正しいメールアドレスを入力してください。');
      isValid = false;
    }

    // 種別
    const $type = $('#type');
    if (!$type.val()) {
      showError($type, 'お問い合わせ種別を選択してください。');
      isValid = false;
    }

    // プライバシーポリシー
    const $privacy = $('[name="privacy"]');
    if (!$privacy.is(':checked')) {
      const $group = $privacy.closest('.form__group');
      $group.addClass('has-error');
      $group.append('<span class="form__error-msg">プライバシーポリシーへの同意が必要です。</span>');
      isValid = false;
    }

    if (!isValid) {
      e.preventDefault();
      // 最初のエラーにスクロール
      const $firstError = $form.find('.has-error').first();
      if ($firstError.length) {
        $('html, body').animate({
          scrollTop: $firstError.offset().top - 120,
        }, 400);
      }
    } else {
      // 送信中表示
      const $btn = $('#js-submit-btn');
      $btn.prop('disabled', true).html(
        '<i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i> 送信中...'
      );
    }
  });

  function showError($input, message) {
    const $group = $input.closest('.form__group');
    $group.addClass('has-error');
    $group.append('<span class="form__error-msg">' + message + '</span>');
  }

  /* ─────────────────────────────────────────────────────────
   * リアルタイムバリデーション（フォーカスアウト時）
   * ───────────────────────────────────────────────────────── */
  $('#name').on('blur', function () {
    clearError($(this));
    if (!$(this).val().trim()) {
      showError($(this), 'お名前を入力してください。');
    }
  });

  $('#email').on('blur', function () {
    clearError($(this));
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!$(this).val().trim()) {
      showError($(this), 'メールアドレスを入力してください。');
    } else if (!emailRegex.test($(this).val().trim())) {
      showError($(this), '正しいメールアドレスを入力してください。');
    }
  });

  function clearError($input) {
    const $group = $input.closest('.form__group');
    $group.removeClass('has-error');
    $group.find('.form__error-msg').remove();
  }

});
