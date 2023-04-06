<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/banner/class-graceycore-banner-shortcode.php';

foreach ( glob( GRACEY_CORE_INC_PATH . '/shortcodes/banner/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
