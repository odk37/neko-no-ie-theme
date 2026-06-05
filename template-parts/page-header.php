<?php
$page_header_content = get_field('page_header_content');
?>

<div class="page-header">
    <div class="page-header__inner container">
        <?php if (!empty($page_header_content)): ?>
            <div class="page-header__content">
                <?php if (!empty($page_header_content["label"])): ?>
                    <p class="page-header__content-label u-fade-in-up">
                        <?= esc_html($page_header_content["label"]); ?>
                    </p>
                <?php endif; ?>
                <?php if (!empty($page_header_content["heading"])): ?>
                    <h1 class="page-header__content-heading u-fade-in-up">
                        <?= esc_html($page_header_content["heading"]); ?>
                    </h1>
                <?php endif; ?>
                <?php if (!empty($page_header_content["lead"])): ?>
                    <p class="page-header__content-lead u-fade-in-up">
                        <?= nl2br(esc_html($page_header_content["lead"])); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>