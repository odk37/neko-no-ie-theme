/**
 * common.js
 * サイト全体で使用する共通JavaScript（jQuery使用）
 * BEM記法のクラス名と連携
 */

jQuery(function ($) {
  'use strict';

  /* ─────────────────────────────────────────────────────────
   * ヘッダー：スクロール時のスタイル変更
   * ───────────────────────────────────────────────────────── */
  const $header = $('#site-header');
  const SCROLL_THRESHOLD = 80;

  function handleHeaderScroll() {
    if ($(window).scrollTop() > SCROLL_THRESHOLD) {
      $header.addClass('is-scrolled');
    } else {
      $header.removeClass('is-scrolled');
    }
  }

  $(window).on('scroll.header', handleHeaderScroll);
  handleHeaderScroll(); // 初期実行

  /* ─────────────────────────────────────────────────────────
   * ハンバーガーメニュー（SP用）
   * ───────────────────────────────────────────────────────── */
  const $hamburger = $('#js-hamburger');
  const $nav       = $('#site-nav');
  const $overlay   = $('#js-overlay');

  function openMenu() {
    $hamburger.addClass('is-open').attr('aria-expanded', 'true');
    $nav.addClass('is-open');
    $overlay.addClass('is-visible').attr('aria-hidden', 'false');
    $('body').css('overflow', 'hidden');
  }

  function closeMenu() {
    $hamburger.removeClass('is-open').attr('aria-expanded', 'false');
    $nav.removeClass('is-open');
    $overlay.removeClass('is-visible').attr('aria-hidden', 'true');
    $('body').css('overflow', '');
  }

  $hamburger.on('click', function () {
    if ($hamburger.hasClass('is-open')) {
      closeMenu();
    } else {
      openMenu();
    }
  });

  $overlay.on('click', closeMenu);

  // ESCキーで閉じる
  $(document).on('keydown', function (e) {
    if (e.key === 'Escape') {
      closeMenu();
      closeAllModals();
    }
  });

  // ウィンドウリサイズ時にSPメニューを閉じる
  $(window).on('resize', function () {
    if ($(window).width() > 768) {
      closeMenu();
    }
  });

  /* ─────────────────────────────────────────────────────────
   * スムーズスクロール（アンカーリンク）
   * ───────────────────────────────────────────────────────── */
  const HEADER_OFFSET = parseInt(getComputedStyle(document.documentElement)
    .getPropertyValue('--header-height')) || 80;

  $(document).on('click', 'a[href^="#"]', function (e) {
    const href   = $(this).attr('href');
    const $target = $(href === '#' ? 'html' : href);

    if ($target.length === 0) return;

    e.preventDefault();
    closeMenu();

    const targetTop = $target.offset().top - HEADER_OFFSET - 16;

    $('html, body').animate({ scrollTop: targetTop }, 600, 'swing');
  });

  /* ─────────────────────────────────────────────────────────
   * スクロールアニメーション（Intersection Observer）
   * ───────────────────────────────────────────────────────── */
  const animations = document.querySelectorAll('.u-fade-in-up');
  const lastAnimation = animations[animations.length - 1];

  if (lastAnimation) {
    lastAnimation.addEventListener('animationend', function () {
      initScrollReveal();
    });
  } else {
    initScrollReveal();
  }

  function initScrollReveal() {
    if ('IntersectionObserver' in window) {
      const animObserver = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              // 遅延クラスに対応
              const delay = entry.target.dataset.delay || 0;
              setTimeout(function () {
                entry.target.classList.add('is-visible');
              }, delay);
              animObserver.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
      );

      document.querySelectorAll('.js-scroll-reveal').forEach(function (el) {
        animObserver.observe(el);
      });
    } else {
      // フォールバック：全要素を即座に表示
      document.querySelectorAll('.js-scroll-reveal').forEach(function (el) {
        el.classList.add('is-visible');
      });
    }
  }

  /* ─────────────────────────────────────────────────────────
   * アコーディオン
   * ───────────────────────────────────────────────────────── */
  $(document).on('click', '.accordion__header', function () {
    const $header = $(this);
    const $body   = $header.next('.accordion__body');
    const isOpen  = $header.hasClass('is-open');

    // 同一アコーディオン内の他を閉じる
    const $accordion = $header.closest('.accordion');
    $accordion.find('.accordion__header.is-open').not($header)
      .removeClass('is-open')
      .next('.accordion__body')
      .removeClass('is-open')
      .slideUp(300);

    if (isOpen) {
      $header.removeClass('is-open');
      $body.removeClass('is-open').slideUp(300);
      $header.attr('aria-expanded', 'false');
    } else {
      $header.addClass('is-open');
      $body.addClass('is-open').slideDown(300);
      $header.attr('aria-expanded', 'true');
    }
  });

  /* ─────────────────────────────────────────────────────────
   * モーダル
   * ───────────────────────────────────────────────────────── */
  function openModal($modal) {
    $modal.addClass('is-open');
    $('body').css('overflow', 'hidden');
    $modal.find('.modal__close').focus();
  }

  function closeModal($modal) {
    $modal.removeClass('is-open');
    $('body').css('overflow', '');
  }

  function closeAllModals() {
    $('.modal.is-open').each(function () {
      closeModal($(this));
    });
  }

  // モーダルを開くトリガー（data-modal-target属性）
  $(document).on('click', '[data-modal-target]', function () {
    const targetId = $(this).data('modal-target');
    const $modal   = $('#' + targetId);
    if ($modal.length) {
      openModal($modal);
    }
  });

  // 閉じるボタン
  $(document).on('click', '.modal__close', function () {
    closeModal($(this).closest('.modal'));
  });

  // オーバーレイクリックで閉じる
  $(document).on('click', '.modal__overlay', function () {
    closeModal($(this).closest('.modal'));
  });

  /* ─────────────────────────────────────────────────────────
   * フィルタータブ
   * ───────────────────────────────────────────────────────── */
  $(document).on('click', '.filter-tabs__btn', function () {
    const $btn    = $(this);
    const filter  = $btn.data('filter');
    const $parent = $btn.closest('.js-filter-section');

    $btn.siblings('.filter-tabs__btn').removeClass('is-active');
    $btn.addClass('is-active');

    const $items = $parent.find('[data-category]');

    if (filter === 'all') {
      $items.fadeInUp(300);
    } else {
      $items.each(function () {
        const categories = $(this).data('category').split(' ');
        if (categories.includes(filter)) {
          $(this).fadeInUp(300);
        } else {
          $(this).fadeOut(200);
        }
      });
    }
  });

  /* ─────────────────────────────────────────────────────────
   * トースト通知
   * ───────────────────────────────────────────────────────── */
  window.showToast = function (message, type, duration) {
    type     = type     || 'default';
    duration = duration || 3000;

    const $toast = $('<div class="toast toast--' + type + '">' +
      '<i class="fa-solid ' + (type === 'success' ? 'fa-circle-check' : type === 'error' ? 'fa-circle-xmark' : 'fa-circle-info') + '"></i>' +
      '<span>' + message + '</span>' +
      '</div>');

    $('body').append($toast);

    setTimeout(function () {
      $toast.addClass('is-visible');
    }, 10);

    setTimeout(function () {
      $toast.removeClass('is-visible');
      setTimeout(function () { $toast.remove(); }, 400);
    }, duration);
  };

  /* ─────────────────────────────────────────────────────────
   * ページトップへ戻るボタン
   * ───────────────────────────────────────────────────────── */
  const $pagetop = $('<button class="pagetop" id="js-pagetop" aria-label="ページトップへ戻る"><i class="fa-solid fa-chevron-up"></i></button>');
  $('body').append($pagetop);

  $(window).on('scroll.pagetop', function () {
    if ($(window).scrollTop() > 400) {
      $pagetop.addClass('is-visible');
    } else {
      $pagetop.removeClass('is-visible');
    }
  });

  $pagetop.on('click', function () {
    $('html, body').animate({ scrollTop: 0 }, 600);
  });

  /* ─────────────────────────────────────────────────────────
   * 画像遅延読み込み（Intersection Observer）
   * ───────────────────────────────────────────────────────── */
  if ('IntersectionObserver' in window) {
    const imgObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            const img = entry.target;
            if (img.dataset.src) {
              img.src = img.dataset.src;
              img.removeAttribute('data-src');
              img.classList.add('is-loaded');
            }
            imgObserver.unobserve(img);
          }
        });
      },
      { rootMargin: '200px 0px' }
    );

    document.querySelectorAll('img[data-src]').forEach(function (img) {
      imgObserver.observe(img);
    });
  }

});

/* ─────────────────────────────────────────────────────────
 * ページトップボタン CSS（動的追加）
 * ───────────────────────────────────────────────────────── */
(function () {
  const style = document.createElement('style');
  style.textContent = `
    .pagetop {
      position: fixed;
      bottom: 2rem;
      right: 2rem;
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background-color: var(--color-primary);
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      box-shadow: var(--shadow-lg);
      z-index: var(--z-raised);
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.3s ease, transform 0.3s ease, background-color 0.2s ease;
      pointer-events: none;
    }
    .pagetop.is-visible {
      opacity: 1;
      transform: translateY(0);
      pointer-events: auto;
    }
    .pagetop:hover {
      background-color: var(--color-primary-dark);
    }
    @media (max-width: 768px) {
      .pagetop { bottom: 1rem; right: 1rem; width: 40px; height: 40px; }
    }
  `;
  document.head.appendChild(style);
})();
