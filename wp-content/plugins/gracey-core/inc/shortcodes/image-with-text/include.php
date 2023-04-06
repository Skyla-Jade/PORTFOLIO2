<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/image-with-text/class-graceycore-image-with-text-shortcode.php';

foreach ( glob( GRACEY_CORE_SHORTCODES_PATH . '/image-with-text/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
