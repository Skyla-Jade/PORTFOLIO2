<?php

include_once GRACEY_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-category-list/class-graceycore-portfolio-category-list-shortcode.php';

foreach ( glob( GRACEY_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-category-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
