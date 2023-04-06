<?php
$number = $counter < 10 ? '0' . intval($counter + 1) : intval($counter + 1);
?>

<div class="qodef-sp-text-item" data-index="<?php echo esc_attr($counter); ?>">
    <div class="qodef-e-number"><?php echo esc_html($number); ?></div>
    <?php gracey_core_list_sc_template_part( 'post-types/portfolio/shortcodes/stacked-portfolio', 'post-info/title', '', $params ); ?>
    <?php gracey_core_list_sc_template_part( 'post-types/portfolio/shortcodes/stacked-portfolio', 'post-info/category', '', $params ); ?>
</div>