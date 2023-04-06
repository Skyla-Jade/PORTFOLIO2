<?php
if ( $query_result->have_posts() ) {
    $params['counter'] = 0;
	while ( $query_result->have_posts() ) : $query_result->the_post();
        gracey_core_template_part( 'post-types/portfolio/shortcodes/stacked-portfolio', 'templates/parts/stacked-portfolio-item', '', $params);
        $params['counter']++;
	endwhile; // End of the loop.
} else {
	// Include global posts not found
	gracey_core_theme_template_part( 'content', 'templates/parts/posts-not-found' );
}

wp_reset_postdata();
?>

<div class="qodef-sp-text-items">
    <?php
    if ( $query_result->have_posts() ) {
    $params['counter'] = 0;
        while ( $query_result->have_posts() ) : $query_result->the_post();
            gracey_core_template_part( 'post-types/portfolio/shortcodes/stacked-portfolio', 'templates/parts/stacked-portfolio-item-text', '', $params);
            $params['counter']++;
        endwhile; // End of the loop.
    }
    wp_reset_postdata();
    ?>
</div>
