<?php

/**
 * column/index.php
 * 豆知識・コラムページ（アコーディオン形式）
 */


// コラムデータ（WordPress連携 or 静的データ）
$columns = [
  [
    'category' => '初めての猫飼い',
    'icon'     => 'fa-house-chimney-heart',
    'items'    => [
      [
        'q' => '初めて猫を飼う方へ：準備するものリスト',
        'a' => '<p>猫をお迎えする前に、以下のものを準備しておきましょう。</p>
                        <ul>
                          <li><strong>トイレ・猫砂</strong>：猫の数＋1個が目安。砂は鉱物系・木製系など種類があります。</li>
                          <li><strong>フードボウル・水入れ</strong>：陶器やステンレス製がおすすめ。水は毎日交換を。</li>
                          <li><strong>キャリーバッグ</strong>：病院や移動時に必須。慣れさせておくと安心です。</li>
                          <li><strong>爪とぎ</strong>：家具を守るためにも必ず用意を。段ボール・麻・カーペット素材など。</li>
                          <li><strong>キャットタワー・おもちゃ</strong>：運動不足解消と精神的充足のために。</li>
                          <li><strong>ケージ（任意）</strong>：最初の慣らし期間や夜間の安全確保に役立ちます。</li>
                        </ul>
                        <p>スタッフがお迎え前に詳しくご説明しますので、お気軽にご相談ください。</p>',
      ],
      [
        'q' => '猫を迎えた初日はどう過ごせばいいですか？',
        'a' => '<p>新しい環境に来た猫は緊張しています。最初の数日間はそっと見守ることが大切です。</p>
                        <ul>
                          <li>まずはケージやキャリーの中で落ち着かせましょう。</li>
                          <li>無理に抱っこしたり、大きな声を出したりしないようにしましょう。</li>
                          <li>フード・水・トイレを近くに置いて、自分から出てくるのを待ちます。</li>
                          <li>2〜3日で環境に慣れてくる子が多いですが、個体差があります。</li>
                        </ul>',
      ],
      [
        'q' => '室内飼いで気をつけることは？',
        'a' => '<p>完全室内飼いは猫の寿命を延ばし、感染症・事故のリスクを大幅に減らします。</p>
                        <ul>
                          <li><strong>脱走防止</strong>：玄関・窓に対策を。一度外に出た猫は帰れなくなることも。</li>
                          <li><strong>危険な植物</strong>：ユリ・ポインセチアなど猫に有毒な植物は置かない。</li>
                          <li><strong>誤飲防止</strong>：輪ゴム・ひも・小物は猫の届かない場所に。</li>
                          <li><strong>運動スペース</strong>：キャットタワーや棚を活用して立体的な空間を作りましょう。</li>
                        </ul>',
      ],
    ],
  ],
  [
    'category' => '猫の食事・健康',
    'icon'     => 'fa-bowl-food',
    'items'    => [
      [
        'q' => '猫のごはんQ&A：何を食べさせればいいですか？',
        'a' => '<p>猫は「絶対肉食動物」です。タンパク質を主体とした食事が必要です。</p>
                        <ul>
                          <li><strong>総合栄養食</strong>のキャットフードを選びましょう。「総合栄養食」と表示されているものが基本です。</li>
                          <li><strong>ドライフード</strong>は歯石予防に、<strong>ウェットフード</strong>は水分補給に有効です。</li>
                          <li>人間の食べ物（ネギ類・チョコレート・ぶどうなど）は絶対に与えないでください。</li>
                          <li>年齢（子猫・成猫・シニア）に合ったフードを選ぶことが大切です。</li>
                        </ul>
                        <p>フード選びについてはスタッフにご相談ください。</p>',
      ],
      [
        'q' => '猫に必要なワクチンは何ですか？',
        'a' => '<p>室内飼いの猫でも、以下のワクチン接種が推奨されています。</p>
                        <ul>
                          <li><strong>3種混合ワクチン</strong>（猫ウイルス性鼻気管炎・猫カリシウイルス感染症・猫汎白血球減少症）：毎年接種推奨</li>
                          <li><strong>猫白血病ウイルス感染症ワクチン</strong>：外出する猫や多頭飼育の場合に推奨</li>
                        </ul>
                        <p>当店でお迎えした子猫は初回ワクチン接種済みです。2回目以降は提携獣医師をご紹介します。</p>',
      ],
      [
        'q' => '猫の水分補給が大切な理由は？',
        'a' => '<p>猫はもともと砂漠出身の動物で、水をあまり飲まない傾向があります。水分不足は泌尿器系の病気（膀胱炎・尿路結石）につながります。</p>
                        <ul>
                          <li>水は常に新鮮なものを複数箇所に置く。</li>
                          <li>流れる水を好む猫には「猫用自動給水器」が効果的。</li>
                          <li>ウェットフードを取り入れることで水分摂取量を増やせます。</li>
                        </ul>',
      ],
    ],
  ],
  [
    'category' => 'トイレ・グルーミング',
    'icon'     => 'fa-shower',
    'items'    => [
      [
        'q' => '正しい猫トイレの選び方',
        'a' => '<p>猫はトイレにこだわりがあります。適切なトイレ環境を整えることが大切です。</p>
                        <ul>
                          <li><strong>サイズ</strong>：猫の体長の1.5倍以上が目安。大きめが◎。</li>
                          <li><strong>数</strong>：猫の頭数＋1個が理想。</li>
                          <li><strong>砂の深さ</strong>：5〜7cm程度。浅すぎると使わないことも。</li>
                          <li><strong>場所</strong>：静かで落ち着ける場所に。フードや水の近くは避ける。</li>
                          <li><strong>掃除</strong>：毎日1回以上の掃除が基本。猫は清潔なトイレを好みます。</li>
                        </ul>',
      ],
      [
        'q' => 'ブラッシングはどのくらいの頻度でしますか？',
        'a' => '<p>ブラッシングは毛玉予防・皮膚の健康維持・コミュニケーションに役立ちます。</p>
                        <ul>
                          <li><strong>短毛種</strong>（アメリカンショートヘアなど）：週1〜2回</li>
                          <li><strong>長毛種</strong>（ペルシャ・ノルウェージャンなど）：毎日〜週3回</li>
                        </ul>
                        <p>子猫のうちからブラッシングに慣れさせると、大人になってからも嫌がりにくくなります。</p>',
      ],
    ],
  ],
  [
    'category' => '猫の行動・心理',
    'icon'     => 'fa-brain',
    'items'    => [
      [
        'q' => '猫がゴロゴロ言うのはなぜですか？',
        'a' => '<p>「ゴロゴロ音（パーリング）」は猫のコミュニケーション手段のひとつです。</p>
                        <ul>
                          <li><strong>嬉しい・満足している</strong>：撫でられているとき、くつろいでいるとき</li>
                          <li><strong>不安・緊張しているとき</strong>：病院や慣れない環境でも出ることがあります</li>
                          <li><strong>自己治癒</strong>：ゴロゴロ音の周波数（25〜150Hz）は骨の修復を促す効果があるとも言われています</li>
                        </ul>',
      ],
      [
        'q' => '猫が噛んだり引っ掻いたりするのはなぜですか？',
        'a' => '<p>猫の噛みつきや引っ掻きには必ず理由があります。</p>
                        <ul>
                          <li><strong>遊びの延長</strong>：特に子猫に多い。おもちゃで遊ぶ習慣をつけましょう。</li>
                          <li><strong>撫でられすぎ</strong>：「もう十分」のサイン。尻尾の動きや耳の向きを観察して。</li>
                          <li><strong>恐怖・ストレス</strong>：無理に触ろうとしたとき。猫のペースを尊重しましょう。</li>
                        </ul>
                        <p>スタッフが猫の性格に合ったコミュニケーション方法をアドバイスします。</p>',
      ],
    ],
  ],
];

$page_title       = '豆知識・コラム | ' . get_bloginfo('name');
$page_description = '猫の飼い方・食事・健康・行動についての豆知識コラム。初めて猫を飼う方にも役立つ情報をお届けします。';
$body_class       = 'page-column';
$page_css         = ['column.css'];

require_once dirname(__DIR__) . '/includes/header.php';
?>

<!-- ─── ページヘッダー ──────────────────────────────────── -->
<div class="page-header">
  <div class="page-header__inner container">
    <p class="page-header__label">Knowledge & Column</p>
    <h1 class="page-header__title">豆知識・コラム</h1>
    <p class="page-header__lead">猫との暮らしに役立つ情報をお届けします。<br>初めて猫を飼う方もぜひご覧ください。</p>
    <nav class="breadcrumb" aria-label="パンくずリスト">
      <span class="breadcrumb__item"><a href="<?php echo esc_url(home_url('/store/')); ?>" class="breadcrumb__link">TOP</a></span>
      <span class="breadcrumb__item">豆知識・コラム</span>
    </nav>
  </div>
</div>

<!-- ─── コラム本文 ───────────────────────────────────────── -->
<section class="section column-section">
  <div class="container container--narrow">

    <?php foreach ($columns as $i => $col): ?>
      <div class="column-category js-scroll-reveal" data-delay="<?= $i * 100 ?>">
        <h2 class="column-category__title">
          <i class="fa-solid <?= $col['icon'] ?>" aria-hidden="true"></i>
          <?= htmlspecialchars($col['category'], ENT_QUOTES, 'UTF-8') ?>
        </h2>

        <div class="accordion" role="list">
          <?php foreach ($col['items'] as $j => $item): ?>
            <div class="accordion__item" role="listitem">
              <button
                class="accordion__header"
                aria-expanded="false"
                id="accordion-btn-<?= $i ?>-<?= $j ?>"
                aria-controls="accordion-body-<?= $i ?>-<?= $j ?>">
                <span class="accordion__question">
                  <span class="accordion__q-mark">Q.</span>
                  <?= htmlspecialchars($item['q'], ENT_QUOTES, 'UTF-8') ?>
                </span>
                <span class="accordion__icon" aria-hidden="true">
                  <i class="fa-solid fa-chevron-down"></i>
                </span>
              </button>
              <div
                class="accordion__body"
                id="accordion-body-<?= $i ?>-<?= $j ?>"
                role="region"
                aria-labelledby="accordion-btn-<?= $i ?>-<?= $j ?>">
                <div class="accordion__answer">
                  <?= $item['a'] ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>

    <!-- 相談誘導 -->
    <div class="column-cta js-scroll-reveal">
      <p class="column-cta__text">
        <i class="fa-solid fa-comment-dots" aria-hidden="true"></i>
        もっと詳しく知りたい方、飼育のご相談はお気軽にどうぞ
      </p>
      <div class="column-cta__actions">
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--primary">
          <i class="fa-regular fa-envelope" aria-hidden="true"></i>
          スタッフに相談する
        </a>
        <a href="<?php echo esc_url(home_url('/pages/store/')); ?>" class="btn btn--secondary">
          <i class="fa-solid fa-store" aria-hidden="true"></i>
          店舗に来店する
        </a>
      </div>
    </div>

  </div>
</section>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>