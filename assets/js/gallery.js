/**
 * gallery.js
 * ギャラリーページ専用JavaScript
 * ライトボックス（画像拡大表示）
 */

$(function () {
  'use strict';

  const $lightbox = $('#js-lightbox');
  const $lbImage  = $('#js-lightbox-image');
  const $lbCaption = $('#js-lightbox-caption');

  let currentIndex = 0;
  let galleryItems = [];

  // ギャラリーアイテムを収集
  function collectGalleryItems() {
    galleryItems = [];
    $('#js-gallery-grid .gallery-grid__item').each(function () {
      const $img = $(this).find('.gallery-grid__image');
      galleryItems.push({
        src: $img.attr('src'),
        alt: $img.attr('alt'),
      });
    });
  }

  // ライトボックスを開く
  function openLightbox(index) {
    if (galleryItems.length === 0) collectGalleryItems();
    currentIndex = index;
    showImage(currentIndex);
    $lightbox.addClass('is-open');
    $('body').css('overflow', 'hidden');
    $lightbox.find('.lightbox__close').focus();
  }

  // 画像を表示
  function showImage(index) {
    const item = galleryItems[index];
    if (!item) return;
    $lbImage.attr({ src: item.src, alt: item.alt });
    $lbCaption.text(item.alt);
  }

  // ライトボックスを閉じる
  function closeLightbox() {
    $lightbox.removeClass('is-open');
    $('body').css('overflow', '');
  }

  // 前の画像
  function prevImage() {
    currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
    showImage(currentIndex);
  }

  // 次の画像
  function nextImage() {
    currentIndex = (currentIndex + 1) % galleryItems.length;
    showImage(currentIndex);
  }

  /* ─── イベントバインド ─────────────────────────────────── */
  // ギャラリーアイテムクリック
  $(document).on('click keypress', '.gallery-grid__item', function (e) {
    if (e.type === 'keypress' && e.key !== 'Enter') return;
    const index = parseInt($(this).data('index'), 10);
    openLightbox(index);
  });

  // 閉じるボタン
  $(document).on('click', '.lightbox__close', closeLightbox);

  // オーバーレイクリック
  $(document).on('click', '.lightbox__overlay', closeLightbox);

  // 前へ・次へ
  $(document).on('click', '.lightbox__prev', prevImage);
  $(document).on('click', '.lightbox__next', nextImage);

  // キーボード操作
  $(document).on('keydown', function (e) {
    if (!$lightbox.hasClass('is-open')) return;
    switch (e.key) {
      case 'Escape':    closeLightbox(); break;
      case 'ArrowLeft': prevImage();     break;
      case 'ArrowRight': nextImage();    break;
    }
  });

  // スワイプ対応（タッチデバイス）
  let touchStartX = 0;
  $lightbox[0].addEventListener('touchstart', function (e) {
    touchStartX = e.touches[0].clientX;
  }, { passive: true });

  $lightbox[0].addEventListener('touchend', function (e) {
    const diff = touchStartX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 50) {
      if (diff > 0) nextImage();
      else prevImage();
    }
  }, { passive: true });

  // 初期化
  collectGalleryItems();
});
