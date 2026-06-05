/**
 * top.js
 * トップページ専用JavaScript
 */

jQuery(function ($) {
  'use strict';

  /* ─────────────────────────────────────────────────────────
   * ヒーロースライダー（Swiper）
   * ───────────────────────────────────────────────────────── */
  if (document.getElementById('js-hero-swiper')) {
    new Swiper('#js-hero-swiper', {
      loop:           true,
      speed:          1200,
      autoplay: {
        delay:        5000,
        disableOnInteraction: false,
      },
      effect:         'fade',
      fadeEffect: {
        crossFade:    true,
      },
      pagination: {
        el:           '.hero .swiper-pagination',
        clickable:    true,
      },
      a11y: {
        prevSlideMessage: '前のスライド',
        nextSlideMessage: '次のスライド',
      },
    });
  }

  /* ─────────────────────────────────────────────────────────
   * 猫カードスライダー（Swiper）
   * ───────────────────────────────────────────────────────── */
  if (document.getElementById('js-cats-swiper')) {
    new Swiper('#js-cats-swiper', {
      loop:         false,
      speed:        600,
      spaceBetween: 24,
      autoplay: {
        delay:      4000,
        disableOnInteraction: true,
      },
      pagination: {
        el:         '.featured-cats__swiper .swiper-pagination',
        clickable:  true,
      },
      breakpoints: {
        0:    { slidesPerView: 1.2, centeredSlides: true },
        480:  { slidesPerView: 1.5, centeredSlides: false },
        768:  { slidesPerView: 2.5, centeredSlides: false },
        1024: { slidesPerView: 3,   centeredSlides: false },
        1200: { slidesPerView: 4,   centeredSlides: false },
      },
      a11y: {
        prevSlideMessage: '前の猫',
        nextSlideMessage: '次の猫',
      },
    });
  }

  /* ─────────────────────────────────────────────────────────
   * 猫カードクリック → 詳細ページへ遷移
   * ───────────────────────────────────────────────────────── */
  $(document).on('click keypress', '.cat-card', function (e) {
    if (e.type === 'keypress' && e.key !== 'Enter') return;
    const catId = $(this).data('cat-id');
    if (catId && catId !== 0) {
      window.location.href = 'pages/cats.php?id=' + catId;
    }
  });

});
