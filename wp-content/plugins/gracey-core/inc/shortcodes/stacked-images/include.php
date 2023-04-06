<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/stacked-images/class-graceycore-stacked-images-shortcode.php';

foreach ( glob( GRACEY_CORE_SHORTCODES_PATH . '/stacked-images/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
