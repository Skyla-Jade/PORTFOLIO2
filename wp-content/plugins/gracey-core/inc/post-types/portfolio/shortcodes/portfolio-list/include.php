<?php

include_once GRACEY_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-list/class-graceycore-portfolio-list-shortcode.php';

foreach ( glob( GRACEY_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
