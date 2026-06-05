<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <header class="header js-header">
    <div class="header__inner">
      <h1 class="header__logo">
        <a href="<?php echo esc_url(home_url('/')); ?>">
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.svg" alt="<?php bloginfo('name'); ?>">
        </a>
      </h1>

      <?php
      wp_nav_menu([
        'theme_location'  => 'global-menu',
        'container'       => 'nav',
        'container_class' => 'header__nav',
        'menu_class'      => 'header__nav-list',
        'li_class'        => 'header__nav-item',
        'link_class'      => 'header__nav-link',
      ]);
      ?>
      <p>テストテキスト</p>

      <button class="header__hamburger js-hamburger" aria-label="メニューを開く">
        <span></span><span></span><span></span>
      </button>
    </div>
  </header>
  <main>