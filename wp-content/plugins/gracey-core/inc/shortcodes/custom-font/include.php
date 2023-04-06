<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/custom-font/class-graceycore-custom-font-shortcode.php';

foreach ( glob( GRACEY_CORE_SHORTCODES_PATH . '/custom-font/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
