<?php

include_once GRACEY_CORE_CPT_PATH . '/testimonials/shortcodes/testimonials-list/class-graceycore-testimonials-list-shortcode.php';

foreach ( glob( GRACEY_CORE_CPT_PATH . '/testimonials/shortcodes/testimonials-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
