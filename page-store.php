<?php

/**
 * pages/store.php
 * 店舗紹介ページ
 */

$page_title       = '店舗案内 | ' . get_bloginfo('name');
$page_description = 'ねこのいえの店舗情報。アクセス・営業時間・スタッフ紹介。見学だけでも大歓迎です。';
$body_class       = 'page-store';
$page_css         = ['store.css'];

get_header();
get_template_part('template-parts/page-header');
?>

<!-- ─── 店舗概要 ─────────────────────────────────────────── -->
<section class="section store-overview">
  <div class="container">
    <div class="store-overview__inner">

      <!-- 外観・内装写真 -->
      <div class="store-overview__gallery js-scroll-reveal js-scroll-reveal--left">
        <div class="store-overview__gallery-main">
          <img
            src="<?= get_template_directory_uri(); ?>/assets/images/store/store-exterior.jpg"
            alt="ねこのいえ外観"
            class="store-overview__gallery-img"
            loading="lazy"
            width="700" height="500">
        </div>
        <div class="store-overview__gallery-sub">
          <img
            src="<?= get_template_directory_uri(); ?>/assets/images/store/store-interior-01.jpg"
            alt="店内の様子1"
            class="store-overview__gallery-img"
            loading="lazy"
            width="340" height="240">
          <img
            src="<?= get_template_directory_uri(); ?>/assets/images/store/store-interior-02.jpg"
            alt="店内の様子2"
            class="store-overview__gallery-img"
            loading="lazy"
            width="340" height="240">
        </div>
      </div>

      <!-- 店舗情報テキスト -->
      <div class="store-overview__info js-scroll-reveal js-scroll-reveal--right">
        <p class="store-overview__catch-copy catch-copy">
          <span class="store-overview__catch-copy-label catch-copy__label">About Our Store</span>
          <span class="store-overview__catch-copy-heading catch-copy__heading">猫と人が出会う<br>温かな空間</span>
        </p>
        <p class="store-overview__lead">
          「ねこのいえ」は、猫を愛するスタッフが一頭一頭丁寧に育てた猫たちをご紹介する専門店です。
          清潔で落ち着いた空間で、猫たちがのびのびと過ごせる環境を整えています。
        </p>
        <p class="store-overview__lead">
          「見学だけでも歓迎です！」予約なしでお気軽にお越しいただけます。
          スタッフが猫の性格や飼育方法について丁寧にご説明します。
        </p>

        <!-- 営業情報テーブル -->
        <table class="store-overview__table">
          <tbody>
            <tr class="store-overview__table-row">
              <th class="store-overview__table-head">
                <i class="fa-regular fa-clock" aria-hidden="true"></i>
                営業時間
              </th>
              <td class="store-overview__table-data">10:00〜19:00</td>
            </tr>
            <tr class="store-overview__table-row">
              <th class="store-overview__table-head">
                <i class="fa-regular fa-calendar-xmark" aria-hidden="true"></i>
                定休日
              </th>
              <td class="store-overview__table-data">毎週水曜日（祝日の場合は翌木曜日）</td>
            </tr>
            <tr class="store-overview__table-row">
              <th class="store-overview__table-head">
                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                電話番号
              </th>
              <td class="store-overview__table-data">
                <a href="tel:0120-000-000" class="store-overview__table-tel">0120-000-000</a>
                <span class="store-overview__table-note">（10:00〜18:00 受付）</span>
              </td>
            </tr>
            <tr class="store-overview__table-row">
              <th class="store-overview__table-head">
                <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                住所
              </th>
              <td class="store-overview__table-data">〒000-0000 東京都〇〇区〇〇町1-2-3</td>
            </tr>
            <tr class="store-overview__table-row">
              <th class="store-overview__table-head">
                <i class="fa-solid fa-train" aria-hidden="true"></i>
                アクセス
              </th>
              <td class="store-overview__table-data">
                〇〇線「〇〇駅」北口より徒歩5分<br>
                〇〇線「〇〇駅」南口より徒歩8分
              </td>
            </tr>
            <tr class="store-overview__table-row">
              <th class="store-overview__table-head">
                <i class="fa-solid fa-square-parking" aria-hidden="true"></i>
                駐車場
              </th>
              <td class="store-overview__table-data">店舗前に3台分あり（無料）</td>
            </tr>
          </tbody>
        </table>

        <div class="store-overview__actions">
          <a href="<?= esc_url(home_url('/contact/')) ?>" class="btn btn--primary">
            <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
            見学予約をする
          </a>
          <a href="tel:0120-000-000" class="btn btn--secondary">
            <i class="fa-solid fa-phone" aria-hidden="true"></i>
            電話で問い合わせ
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ─── Google Maps ──────────────────────────────────────── -->
<section class="access-map section--sm" aria-labelledby="access-map-title">
  <div class="container">
    <h2 id="access-map-title" class="access-map__title section-title js-scroll-reveal">
      <span class="access-map__title-label section-title__label">Access Map</span>
      <span class="access-map__title-heading section-title__heading">アクセスマップ</span>
    </h2>
    <div class="access-map__wrapper js-scroll-reveal">
      <!--
        Google Maps Embed API
        本番環境では src の YOUR_API_KEY を実際の APIキーに置き換えてください
        また、q= の住所を実際の住所に変更してください
      -->
      <iframe
        class="access-map__iframe"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3240.827853357464!2d139.74454831525882!3d35.68948498019488!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188bfbd89f700b%3A0x277c49ba34ed38!2z5p2x5Lqs6aeF!5e0!3m2!1sja!2sjp!4v1620000000000!5m2!1sja!2sjp"
        width="100%"
        height="450"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        title="ねこのいえ 店舗地図"></iframe>
    </div>
    <p class="access-map__note js-scroll-reveal">
      <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
      地図は参考表示です。実際の住所は上記の店舗情報をご確認ください。
    </p>
  </div>
</section>

<!-- ─── スタッフ紹介 ─────────────────────────────────────── -->
<section class="section section--bg-secondary access-staff" aria-labelledby="staff-title">
  <div class="container">
    <h2 id="staff-title" class="section-title js-scroll-reveal">
      <span class="section-title__label">Our Staff</span>
      <span class="section-title__heading">スタッフ紹介</span>
    </h2>
    <p class="section-lead js-scroll-reveal">
      猫を心から愛するスタッフが、あなたと猫の出会いをサポートします。
    </p>

    <div class="grid grid--3 access-staff__grid">

      <div class="staff-card js-scroll-reveal" data-delay="0">
        <div class="staff-card__avatar-wrapper">
          <img
            src="<?= get_template_directory_uri(); ?>/assets/images/staff/staff-01.jpg"
            alt="店長 田中さとみ"
            class="staff-card__avatar"
            loading="lazy"
            width="120" height="120">
        </div>
        <h3 class="staff-card__name">田中 さとみ</h3>
        <p class="staff-card__role">店長 / 愛玩動物飼養管理士</p>
        <p class="staff-card__bio">
          猫歴20年。自宅でも3匹の猫と暮らしています。
          「猫と人が幸せに暮らせる出会い」を大切に、
          一頭一頭の個性を丁寧にお伝えします。
          猫の健康管理と飼育相談が得意です。
        </p>
      </div>

      <div class="staff-card js-scroll-reveal" data-delay="150">
        <div class="staff-card__avatar-wrapper">
          <img
            src="<?= get_template_directory_uri(); ?>/assets/images/staff/staff-02.jpg"
            alt="スタッフ 鈴木はるか"
            class="staff-card__avatar"
            loading="lazy"
            width="120" height="120">
        </div>
        <h3 class="staff-card__name">鈴木 はるか</h3>
        <p class="staff-card__role">スタッフ / トリマー資格保有</p>
        <p class="staff-card__bio">
          猫のグルーミングが得意。猫の毛並みや体調の
          変化にいち早く気づけるよう、毎日丁寧に
          お世話しています。初めての方の不安を
          和らげるサポートを心がけています。
        </p>
      </div>

      <div class="staff-card js-scroll-reveal" data-delay="300">
        <div class="staff-card__avatar-wrapper">
          <img
            src="<?= get_template_directory_uri(); ?>/assets/images/staff/staff-03.jpg"
            alt="スタッフ 山本けんじ"
            class="staff-card__avatar"
            loading="lazy"
            width="120" height="120">
        </div>
        <h3 class="staff-card__name">山本 けんじ</h3>
        <p class="staff-card__role">スタッフ / 動物看護師</p>
        <p class="staff-card__bio">
          動物看護師として猫の健康管理を担当。
          ワクチン接種・健康診断の管理から、
          お迎え後の飼育相談まで幅広くサポート。
          猫の病気や予防についての相談も歓迎です。
        </p>
      </div>

    </div>
  </div>
</section>

<!-- ─── よくある質問（店舗向け） ────────────────────────── -->
<section class="section access-faq" aria-labelledby="access-faq-title">
  <div class="container container--narrow">
    <h2 id="access-faq-title" class="section-title js-scroll-reveal">
      <span class="section-title__label">FAQ</span>
      <span class="section-title__heading">よくあるご質問</span>
    </h2>

    <div class="accordion js-scroll-reveal" role="list">

      <div class="accordion__item" role="listitem">
        <button class="accordion__header" aria-expanded="false">
          <span>予約なしで見学できますか？</span>
          <span class="accordion__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
        </button>
        <div class="accordion__body">
          はい、予約不要でご来店いただけます。営業時間内（10:00〜19:00）であれば、いつでも見学可能です。
          ただし、混雑時はお待ちいただく場合がございます。ご予約いただくとスムーズにご案内できます。
        </div>
      </div>

      <div class="accordion__item" role="listitem">
        <button class="accordion__header" aria-expanded="false">
          <span>子供連れでも来店できますか？</span>
          <span class="accordion__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
        </button>
        <div class="accordion__body">
          もちろん大歓迎です。ただし、猫が驚いてしまうことがありますので、
          小さなお子様が猫に触れる際はスタッフが同席してご案内します。
          猫とお子様の安全のため、ご協力をお願いします。
        </div>
      </div>

      <div class="accordion__item" role="listitem">
        <button class="accordion__header" aria-expanded="false">
          <span>猫を迎えるまでの流れを教えてください。</span>
          <span class="accordion__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
        </button>
        <div class="accordion__body">
          ①ご来店・見学 → ②猫との対面・スタッフによる説明 → ③お申し込み・必要書類のご確認 →
          ④お支払い → ⑤お迎えの日程調整 → ⑥お迎え・アフターフォロー開始、という流れになります。
          初めての方も安心してお任せください。
        </div>
      </div>

      <div class="accordion__item" role="listitem">
        <button class="accordion__header" aria-expanded="false">
          <span>ローン・分割払いはできますか？</span>
          <span class="accordion__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
        </button>
        <div class="accordion__body">
          はい、各種クレジットカードおよびショッピングローンに対応しています。
          分割払いについては店頭でご相談ください。
          無理のないお迎えをサポートします。
        </div>
      </div>

      <div class="accordion__item" role="listitem">
        <button class="accordion__header" aria-expanded="false">
          <span>お迎え後のサポートはありますか？</span>
          <span class="accordion__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
        </button>
        <div class="accordion__body">
          はい、お迎え後も生涯にわたってサポートします。
          飼育に関するご相談はいつでも電話・メールで受け付けています。
          また、提携獣医師のご紹介も行っています。
        </div>
      </div>

    </div>

    <div class="text-center" style="margin-top: var(--space-10);">
      <a href="<?= esc_url(home_url('/contact/')) ?>" class="btn btn--primary btn--lg js-scroll-reveal">
        <i class="fa-regular fa-envelope" aria-hidden="true"></i>
        その他のご質問はこちら
      </a>
    </div>
  </div>
</section>
<?php get_footer(); ?>