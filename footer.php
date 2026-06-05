</main>

<footer class="footer">
  <div class="footer__inner">
    <div class="footer__content">
      <div class="footer__info">
        <div class="footer__logo">
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo-white.svg" alt="<?php bloginfo('name'); ?>">
        </div>
        <p class="footer__address">
          〒123-4567<br>
          東京都〇〇区△△町 1-2-3<br>
          TEL: 03-1234-5678
        </p>
        <p class="footer__hours">
          営業時間: 11:00 〜 19:00<br>
          定休日: 水曜日
        </p>
      </div>

      <nav class="footer__nav">
        <ul class="footer__nav-list">
          <li class="footer__nav-item"><a href="<?php echo esc_url(home_url('/')); ?>">TOP</a></li>
          <li class="footer__nav-item"><a href="<?php echo esc_url(home_url('/cats/')); ?>">猫ちゃん一覧</a></li>
          <li class="footer__nav-item"><a href="<?php echo esc_url(home_url('/store/')); ?>">店舗案内</a></li>
          <li class="footer__nav-item"><a href="<?php echo esc_url(home_url('/news/')); ?>">お知らせ</a></li>
          <li class="footer__nav-item"><a href="<?php echo esc_url(home_url('/column/')); ?>">猫の豆知識</a></li>
          <li class="footer__nav-item"><a href="<?php echo esc_url(home_url('/gallery/')); ?>">お客様の声</a></li>
          <li class="footer__nav-item"><a href="<?php echo esc_url(home_url('/contact/')); ?>">お問い合わせ</a></li>
        </ul>
      </nav>

      <div class="footer__sns">
        <p class="footer__sns-title">Follow Us</p>
        <div class="footer__sns-links">
          <a href="#" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" target="_blank" rel="noopener" aria-label="X (Twitter)"><i class="fab fa-x-twitter"></i></a>
        </div>
      </div>
    </div>
    <p class="footer__copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> All Rights Reserved.</p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
