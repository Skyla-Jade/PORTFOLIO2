<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/image-marquee/class-graceycore-image-marquee-shortcode.php';

foreach ( glob( GRACEY_CORE_INC_PATH . '/shortcodes/image-marquee/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
