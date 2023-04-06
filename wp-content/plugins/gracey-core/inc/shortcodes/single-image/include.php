<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/single-image/class-graceycore-single-image-shortcode.php';

foreach ( glob( GRACEY_CORE_SHORTCODES_PATH . '/single-image/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
