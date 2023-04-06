<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/counter/class-graceycore-counter-shortcode.php';

foreach ( glob( GRACEY_CORE_SHORTCODES_PATH . '/counter/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
