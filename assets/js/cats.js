/**
 * cats.js
 * 猫一覧ページ専用JavaScript
 * フィルタータブ・モーダル詳細・AJAX取得
 */

$(function () {
  'use strict';

  let modalSwiper = null;

  /* ─────────────────────────────────────────────────────────
   * フィルタータブ（種類別絞り込み）
   * ───────────────────────────────────────────────────────── */
  $(document).on('click', '.filter-tabs__btn', function () {
    const $btn   = $(this);
    const filter = $btn.data('filter');

    // アクティブ切り替え
    $('.filter-tabs__btn').removeClass('is-active').attr('aria-selected', 'false');
    $btn.addClass('is-active').attr('aria-selected', 'true');

    const $cards = $('#js-cats-grid .cat-card');
    let visibleCount = 0;

    $cards.each(function () {
      const $card   = $(this);
      const category = $card.data('category');

      if (filter === 'all' || category === filter) {
        $card.fadeInUp(300);
        visibleCount++;
      } else {
        $card.fadeOut(200);
      }
    });

    // 0件メッセージ
    setTimeout(function () {
      if (visibleCount === 0) {
        $('#js-cats-empty').fadeInUp(300);
      } else {
        $('#js-cats-empty').hide();
      }
    }, 250);
  });

  /* ─────────────────────────────────────────────────────────
   * 猫カードクリック → モーダル表示
   * ───────────────────────────────────────────────────────── */
  $(document).on('click keypress', '.cat-card', function (e) {
    if (e.type === 'keypress' && e.key !== 'Enter') return;

    const catId = $(this).data('cat-id');
    if (!catId) return;

    openCatModal(catId);
  });

  /* ─────────────────────────────────────────────────────────
   * モーダル：猫詳細データを AJAX で取得して表示
   * ───────────────────────────────────────────────────────── */
  function openCatModal(catId) {
    const $modal = $('#js-cat-modal');

    // ローディング表示
    showModalLoading($modal);
    $modal.addClass('is-open');
    $('body').css('overflow', 'hidden');

    $.ajax({
      url:      'cats.php',
      method:   'GET',
      data:     { ajax: 'cat_detail', id: catId },
      dataType: 'json',
    })
    .done(function (data) {
      if (data && !data.error) {
        renderModal(data);
      } else {
        showModalError($modal);
      }
    })
    .fail(function () {
      // AJAX失敗時はカードのデータを使用
      const $card = $('[data-cat-id="' + catId + '"]').first();
      const fallbackData = {
        id:          catId,
        name:        $card.find('.cat-card__name').text(),
        breed:       $card.find('.cat-card__breed').text(),
        gender:      $card.find('.cat-card__meta-item').first().text().trim() === 'メス' ? 'female' : 'male',
        age_months:  parseInt($card.find('.cat-card__meta-item').last().text()),
        price:       $card.find('.cat-card__price').text().replace(/[¥,]/g, ''),
        personality: $card.find('.cat-card__desc').text(),
        description: $card.find('.cat-card__desc').text(),
        image_main:  $card.find('.cat-card__image').attr('src').split('/').pop(),
        image_sub1:  '',
        image_sub2:  '',
      };
      renderModal(fallbackData);
    });
  }

  function showModalLoading($modal) {
    $('#js-modal-images').html(
      '<div class="swiper-slide" style="display:flex;align-items:center;justify-content:center;background:#f5f3f0;">' +
      '<i class="fa-solid fa-spinner fa-spin" style="font-size:2rem;color:var(--color-primary-light);"></i>' +
      '</div>'
    );
  }

  function showModalError($modal) {
    $('#js-modal-images').html(
      '<div class="swiper-slide" style="display:flex;align-items:center;justify-content:center;background:#f5f3f0;">' +
      '<p style="color:var(--color-text-secondary);">データを取得できませんでした。</p>' +
      '</div>'
    );
  }

  function renderModal(data) {
    const siteUrl = document.querySelector('link[rel="canonical"]')?.href || window.location.origin;

    // 画像スライダー構築
    const images = [data.image_main, data.image_sub1, data.image_sub2].filter(Boolean);
    const slidesHtml = images.map(function (img) {
      const src = img.startsWith('http') ? img : (siteUrl + '/assets/images/cats/' + img);
      return '<div class="swiper-slide"><img src="' + src + '" alt="' + escapeHtml(data.name) + '" style="width:100%;height:100%;object-fit:cover;"></div>';
    }).join('');

    $('#js-modal-images').html(slidesHtml);

    // Swiper 初期化（再初期化）
    if (modalSwiper) {
      modalSwiper.destroy(true, true);
    }
    modalSwiper = new Swiper('#js-modal-swiper', {
      loop:     images.length > 1,
      pagination: { el: '.modal__swiper .swiper-pagination', clickable: true },
      navigation: {
        nextEl: '.modal__swiper .swiper-button-next',
        prevEl: '.modal__swiper .swiper-button-prev',
      },
    });

    // テキスト情報
    $('#js-modal-breed').text(data.breed);
    $('#modal-cat-name').text(data.name);
    $('#js-modal-gender').text(data.gender === 'female' ? 'メス' : 'オス');
    $('#js-modal-age').text(data.age_months + 'ヶ月');
    $('#js-modal-price').text('¥' + Number(data.price).toLocaleString());
    $('#js-modal-desc').text(data.description || data.personality);

    // 問い合わせリンクに猫IDを付加
    $('.modal__actions a').each(function () {
      const href = $(this).attr('href');
      if (href && href.includes('contact')) {
        $(this).attr('href', href + '?cat_id=' + data.id + '&cat_name=' + encodeURIComponent(data.name));
      }
    });
  }

  /* ─────────────────────────────────────────────────────────
   * ユーティリティ
   * ───────────────────────────────────────────────────────── */
  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

});
