<?php

include_once GRACEY_CORE_CPT_PATH . '/portfolio/shortcodes/stacked-portfolio/class-graceycore-stacked-portfolio-shortcode.php';
include_once GRACEY_CORE_CPT_PATH . '/portfolio/shortcodes/stacked-portfolio/helper.php';

foreach ( glob( GRACEY_CORE_CPT_PATH . '/portfolio/shortcodes/stacked-portfolio/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}