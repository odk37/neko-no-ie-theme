<?php
$label = get_field('label');
$heading = get_field('heading');
$lead = get_field('lead');
?>

<div class="page-header">

    <div class="page-header__inner container">

        <?php if (!empty($label)): ?>
            <p class="page-header__label u-fade-in-up">
                <?= esc_html($label); ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($heading)): ?>
            <h1 class="page-header__heading u-fade-in-up">
                <?= esc_html($heading); ?>
            </h1>
        <?php endif; ?>

        <?php if (!empty($lead)): ?>
            <p class="page-header__lead u-fade-in-up">
                <?= nl2br(esc_html($lead)); ?>
            </p>
        <?php endif; ?>

    </div>

</div>