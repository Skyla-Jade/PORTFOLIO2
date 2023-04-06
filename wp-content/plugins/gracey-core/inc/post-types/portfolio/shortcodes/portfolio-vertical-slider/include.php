<?php

include_once GRACEY_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-vertical-slider/class-graceycore-portfolio-vertical-slider-shortcode.php';
include_once GRACEY_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-vertical-slider/helper.php';

foreach ( glob( GRACEY_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-vertical-slider/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}