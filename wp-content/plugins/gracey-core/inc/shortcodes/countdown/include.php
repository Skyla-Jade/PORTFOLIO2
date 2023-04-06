<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/countdown/class-graceycore-countdown-shortcode.php';

foreach ( glob( GRACEY_CORE_SHORTCODES_PATH . '/countdown/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
