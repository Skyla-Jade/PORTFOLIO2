<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/text-marquee/class-graceycore-text-marquee-shortcode.php';

foreach ( glob( GRACEY_CORE_INC_PATH . '/shortcodes/text-marquee/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
